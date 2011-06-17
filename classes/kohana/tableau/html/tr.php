<?php

/**
 * Tableau_HTML_Tr
 *
 * Represents a TR element
 *
 * @package Tableau
 * @author  Shane Smith
 */
class Kohana_Tableau_HTML_Tr extends Tableau_HTML_Element {

	/**
	 * Array of Tableau_HTML_Cell in this row
	 *
	 * @var array
	 */
	public $cells;

	/**
	 * Construct the Tableau_HTML_Tr
	 *
	 * @param $table
	 * @param $index
	 * @param $cells
	 */
	public function __construct($table, $index, $cells) {
		parent::__construct($table, $index, array());
		$this->cells = $cells;
	}

	/**
	 * Get the TR View
	 *
	 * @return View
	 */
	public function getView() {
		return View::factory('tableau/tr', array( 'tr' => $this ));
	}



}
