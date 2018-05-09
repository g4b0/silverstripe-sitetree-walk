<?php

use SilverStripe\CMS\Model\SiteTree;

/**
 * Listener interface to implement in order to been hocked during SiteTreeWalk
 */
interface SiteTreeWalkListener {

	/**
	 * Let the SiteTreeWalker know if it have to execute this 
	 * listenr or not
	 */
	public function isEnabled();

	/**
	 * The running function. Do things over the page.
	 * 
	 * @param SiteTree $p page to process
	 * @param Int $l recursion level
	 * @param Boolean $v verbose
	 * @return Boolean TRUE if the page was processed
	 */
	public function run(SiteTree $page, $l, $v);
}
