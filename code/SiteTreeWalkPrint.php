<?php

class SiteTreeWalkPrint implements SiteTreeWalkListener {

	/**
	 * Should this Implementor be called?
	 */
	private $enabled = false;

	/*
	 * Page Type exclusion array
	 */
	private $excludedPageType = array(
			'ErrorPage',
			'RedirectorPage',
	);

	/**
	 * Let the SiteTreeWalker know if it have to execute this 
	 * listenr or not
	 */
	public function isEnabled() {
		return $this->enabled;
	}

	/**
	 * The running function. Do things over the page.
	 * 
	 * @param SiteTree $p page to process
	 * @param Int $l recursion level
	 * @param Boolean $v verbose
	 * @return null
	 */
	public function run(SiteTree $p, $l = 0, $v = false) {

		$retVal = true;
		
		// print the record
		for ($i = 0; $i < $l; $i++) {
			echo "\t";
		}
		echo "$p->Title ";
		if ($v) {
			echo "[$p->class] ";
		}

		if (in_array($p->class, $this->excludedPageType)) {
			echo " *** Excluded from processing";
			$retVal = false;
		} 

		echo "\n";

		return $retVal;
	}

}
