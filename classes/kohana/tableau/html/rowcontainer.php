<?php

/**
 * Kohana_Tableau_HTML_RowContainer
 *
 *
 */
abstract class Kohana_Tableau_HTML_RowContainer extends Tableau_HTML_Element {

	/**
	 * Array of TRs
	 *
	 * @var array
	 */
	public $rows;

	/**
	 * Constructor
	 *
	 * @param Tableau $table
	 * @param array $rows
	 */
	public function __construct($table, $rows) {
		parent::__construct($table, 0, array());
		$this->rows = $rows;
	}

}
