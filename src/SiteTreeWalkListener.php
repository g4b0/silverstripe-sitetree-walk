<?php

namespace g4b0\SiteTreeWalk;

use SilverStripe\CMS\Model\SiteTree;

/**
 * Listener interface to implement in order to been hocked during SiteTreeWalk
 */
interface SiteTreeWalkListener {

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
