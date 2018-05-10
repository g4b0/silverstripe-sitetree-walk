<?php

namespace g4b0\SiteTreeWalk;

use g4b0\SiteTreeWalk\SiteTreeWalkListener;
use SilverStripe\CMS\Model\SiteTree;

class SiteTreeWalkPrint implements SiteTreeWalkListener {

	/*
	 * Page Type exclusion array
	 */
	private $excludedPageType = array(
			'ErrorPage',
			'RedirectorPage',
	);

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
			echo "[" . get_class($p) . "] ";
		}

		if (in_array($p->class, $this->excludedPageType)) {
			echo " *** Excluded from processing";
			$retVal = false;
		} 

		echo "\n";

		return $retVal;
	}

}
