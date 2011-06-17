<?php

/**
 * Tableau_HTML_Cell
 *
 * Represents either a TD or a TH cell
 *
 * @package Tableau
 * @author  Shane Smith
 */
abstract class Kohana_Tableau_HTML_Cell extends Tableau_HTML_Element {

	/**
	 * The cell's content
	 *
	 * @var string
	 */
	public $content;

	/**
	 * The cell's data key
	 *
	 * @var string
	 */
	public $key;

	/**
	 * The cell's row index
	 *
	 * @var int
	 */
	public $row;

	/**
	 * Construct the Tableau_HTML_Cell
	 *
	 * @param Tableau $table
	 * @param int $index
	 * @param string $key
	 * @param int $row
	 * @param string $content
	 * @param array $attributes
	 */
	public function __construct($table, $index, $key, $row, $content, $attributes) {
		parent::__construct($table, $index, $attributes);
		$this->content = $content;
		$this->key = $key;
		$this->row = $row;
	}

}
