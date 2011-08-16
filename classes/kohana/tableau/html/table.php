<?php

/**
 * Kohana_Tableau_HTML_Table
 *
 *
 */
class Kohana_Tableau_HTML_Table extends Tableau_HTML_Element {

	/**
	 * Table's THead
	 *
	 * @var Tableau_HTML_THead
	 */
	public $thead;

	/**
	 * Table's TBody
	 *
	 * @var Tableau_HTML_TBody
	 */
	public $tbody;

	/**
	 * Table's TFoot
	 *
	 * @var Tableau_HTML_TFoot
	 */
	public $tfoot;

	/**
	 * Constructor.
	 *
	 * @param Tableau $table
	 * @param array $attributes
	 * @param Tableau_HTML_THead $thead
	 * @param Tableau_HTML_TBody $tbody
	 * @param Tableau_HTML_TFoot $tfoot
	 */
	public function __construct($table, $attributes, $thead, $tbody, $tfoot) {
		parent::__construct($table, 0, $attributes);
		$this->thead = $thead;
		$this->tbody = $tbody;
		$this->tfoot = $tfoot;
	}

	/**
	 * Render the Table
	 *
	 * @return string
	 */
	public function render() {
		$table = "<table" . HTML::attributes($this->attributes) . ">";

		if ($this->table->includeTHead()) {
			$table .= $this->thead->render();
		}

		$table .= $this->tbody->render();

		if ($this->table->includeTFoot()) {
			$table .= $this->tfoot->render();
		}

		$table .= "</table>";

		return $table;
	}

}
