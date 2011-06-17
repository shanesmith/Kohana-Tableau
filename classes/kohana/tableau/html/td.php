<?php

/**
 * Tableau_HTML_Td
 *
 * Represents a TD cell
 *
 * @package Tableau
 * @author  Shane Smith
 */
class Kohana_Tableau_HTML_Td extends Tableau_HTML_Cell {

	/**
	 * Get the TD view
	 *
	 * @return View
	 */
	public function getView() {
		return View::factory('tableau/td', array( 'td' => $this ));
	}

}
