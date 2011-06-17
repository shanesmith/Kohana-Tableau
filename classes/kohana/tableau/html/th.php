<?php

/**
 * Tableau_HTML_Th
 *
 * Represents a TH cell
 *
 * @package Tableau
 * @author  Shane Smith
 */
class Kohana_Tableau_HTML_Th extends Tableau_HTML_Cell {

	/**
	 * Get the TH view
	 *
	 * @return View
	 */
	public function getView() {
		return View::factory('tableau/th', array( 'th' => $this ));
	}

}
