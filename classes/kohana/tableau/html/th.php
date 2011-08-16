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
	 * Get the rendered HTML TH
	 *
	 * @return string
	 */
	public function render() {
		return "<th " . HTML::attributes($this->attributes) . ">" . $this->content . "</th>";
	}

}
