<?php

/**
 * Tableau_Column
 *
 * Represents a column in the table
 *
 * @package Tableau
 * @author  Shane Smith
 */
class Kohana_Tableau_Column {

	/**
	 * A reference back to the Tableau
	 *
	 * @var Tableau
	 */
	public $table;

	/**
	 * Whether the content should be automatically escaped with htmlspecialchars()
	 *
	 * @var bool
	 */
	public $escape = true;

	/**
	 * The data key
	 *
	 * @var string
	 */
	public $key;

	/**
	 * The column's title
	 *
	 * @var string
	 */
	public $title;

	/**
	 * Set of attributes to be set for each rendered cell (ie: td and th)
	 *
	 * @var array
	 */
	public $attributes;

	/**
	 * List of callbacks to apply to tbody cells, each entry is array($callback, $arguments)
	 *
	 * @var array
	 */
	protected $callbacks = array();

	/**
	 * List of callbacks to apply to thead cells, each entry is array($callback, $arguments)
	 *
	 * @var array
	 */
	protected $title_callbacks = array();


	/*******************
	 **  Constructor  **
	 *******************/

	/**
	 * Construct a column.
	 *
	 * If title or class are not set they are automatically
	 * determines based on the given key
	 *
	 * @param Tableau $table
	 * @param string $key
	 * @param string $title
	 * @param string $class
	 */
	public function __construct($table, $key, $title=null, $class=null) {
		$this->table = $table;
		$this->key = $key;
		$this->title = isset($title) ? $title : str_replace('_', ' ', $key);
		$this->attributes = array( 'class' => (isset($class) ? $class : $key) );
	}


	/****************
	 **  Callback  **
	 ****************/

	/**
	 * Add a callback to be used in tbody cells, with optional arguments to be passed to the callback
	 *
	 * ex: $column->addCallback('MyClass::maxlength', 300);
	 *
	 * @param callable $callback
	 * @param mixed $argument,...
	 * @return Tableau_Column
	 */
	public function addCallback($callback, $argument=null) {
		$arguments = func_get_args();
		array_shift($arguments);

		$this->callbacks[] = array($callback, $arguments);
		return $this;
	}

	/**
	 * Add a callback to be used in thead cells, with optional arguments to be passed to the callback
	 *
	 * ex: $column->addCallback('MyClass::maxlength', 300);
	 *
	 * @param callable $callback
	 * @param mixed $argument,...
	 * @return Tableau_Column
	 */
	public function addTitleCallback($callback, $argument=null) {
		$arguments = func_get_args();
		array_shift($arguments);

		$this->title_callbacks[] = array( $callback, $arguments );
		return $this;
	}

	/**
	 * Apply the given list of callbacks to the given cell
	 *
	 * @param Tableau_HTML_Cell $cell
	 * @param array $callback_list
	 * @return Tableau_HTML_Cell
	 */
	public function applyCallbacks($cell, $callback_list) {
		foreach ($callback_list as $callback) {
			list($func, $args) = $callback;
			if (is_callable($func)) {
				$args = array_merge(array( $cell ), (array)$args);
				$cell = call_user_func_array($func, $args);
			}
		}
		return $cell;
	}

	/*************
	 **  Cells  **
	 *************/

	/**
	 * Return a TD cell with the given information
	 *
	 * @param string $content
	 * @param int $index
	 * @param int $row
	 * @return Tableau_HTML_Td
	 */
	public function td($content, $index, $row) {

		$td = new Tableau_HTML_Td($this->table, $index, $this->key, $row, $content, $this->attributes);

		$this->applyCallbacks($td, $this->callbacks);

		if ($this->escape) {
			$td->content = htmlspecialchars($td->content);
		}

		return $td;
	}

	/**
	 * Return a TH cell with the given information
	 *
	 * @param int $index
	 * @param int $row
	 * @return Tableau_HTML_Th
	 */
	public function th($index, $row) {

		$th = new Tableau_HTML_Th($this->table, $index,$this->key, $row, $this->title, $this->attributes);

		$this->applyCallbacks($th, $this->title_callbacks);

		if ($this->escape) {
			$th->content = htmlspecialchars($th->content);
		}

		return $th;

	}

}
