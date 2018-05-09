<?php

namespace g4b0\SiteTreeWalk\Tasks;

use SilverStripe\Dev\BuildTask;
use SilverStripe\Core\ClassInfo;
use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;

class SiteTreeWalk extends BuildTask {
	
	/*
	 * If verbose == true the report will be more complete
	 */
	private $verbose = true;

	/*
	 * Traversed page number
	 */
	private $traversed;

	/*
	 * Array of processed page number
	 */
	private $processed;

	/*
	 * Array of traversed page types
	 */
	private $traversedPageType;

	/*
	 * Array of processed page types
	 */
	private $processedPageType;

	/*
	 * Array of implementors
	 */
	private $implementors;

	function run($request) {

		$this->traversed = 0;
		$this->processed = array();
		$this->traversedPageType = array();
		$this->processedPageType = array();
		$this->implementors = array();

		/*
		 * Implementors inizialization
		 */
		$implementros = ClassInfo::implementorsOf('SiteTreeWalkListener');
		foreach ($implementros as $implementor) {
			$this->implementors[$implementor] = new $implementor;
			if ($this->implementors[$implementor]->isEnabled()) {
				$this->processed[$implementor] = 0;
				$this->processedPageType[$implementor] = array();
			} else {
				unset($this->implementors[$implementor]);
			}
		}

		echo "Following SiteTreeWalkListener Implementors will be executed: ";
		foreach ($this->implementors as $implementor => $controller) {
			echo "\n\t* $implementor";
		}
		echo "\n\nContinue? [y|n]";
		$confirmation = trim(fgets(STDIN));
		if ($confirmation !== 'y') {
			// The user did not say 'y'.
			exit(0);
		}
		echo "\n";

		//$rootPages = DataObject::get('SiteTree', 'ParentID=0', 'Sort ASC');
		$rootPages = SiteTree::get()->filter(['ParentID' => 0]);
		foreach ($rootPages as $rp) {
			/* var $rp SiteTree */
			$this->processChildren($rp);
		}

		echo "\n################################################\n";
		echo "Traversed Pages: $this->traversed";

		if ($this->verbose) {
			echo "\n\nTraversed Page Types: ";
			foreach ($this->traversedPageType as $class) {
				echo "\n\t* $class";
			}
		}

		echo "\n\nProcessed Pages: ";
		foreach ($this->processed as $implementor => $num) {
			echo "\n\t$implementor: $num";
		}

		if ($this->verbose) {
			echo "\n\nProcessed Page Types: ";
			foreach ($this->processedPageType as $implementor => $classes) {
				echo "\n\t$implementor:";
				foreach ($classes as $class) {
					echo "\n\t\t* $class";
				}
			}
		}

		echo "\n################################################\n";
	}

	/**
	 * Recursively process all childrens of a page
	 * 
	 * @param SiteTree $p page to process
	 * @param Int $l recursion level
	 * @return null
	 */
	private function processChildren($p, $l = 0) {

		// #################################
		//  Record processing
		// #################################
		$this->traversed++;

		// Travered class array population
		$class = get_class($p);
		if (!in_array($class, $this->traversedPageType)) {
			array_push($this->traversedPageType, $class);
		}

		foreach ($this->implementors as $implementor => $controller) {
			if ($controller->run($p, $l, $this->verbose)) {
				$this->processed[$implementor] += 1;
				if (!in_array($class, $this->processedPageType[$implementor])) {
					array_push($this->processedPageType[$implementor], $class);
				}
			}
		}

		// ####################################
		// Continue recursion with childrens
		// ####################################
		if ($p->AllChildren()->count() > 0) {
			$liv = $l + 1;
			foreach ($p->AllChildren() as $c) {
				$this->processChildren($c, $liv);
			}
		}

		return null;
	}

}
