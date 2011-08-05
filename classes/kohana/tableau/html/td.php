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
	
	/**
	 * Get data found on the same row as this TD
	 *
	 * @param string $column
	 * @return string|array
	 */
	public function getRowData($column=null) {
		return $this->table->getData($this->row, $column);
	}

}
