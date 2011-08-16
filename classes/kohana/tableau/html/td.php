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
	 * Get the rendered HTML TD
	 *
	 * @return string
	 */
	public function render() {
		return "<td " . HTML::attributes($this->attributes) . ">" . $this->content . "</td>";
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
