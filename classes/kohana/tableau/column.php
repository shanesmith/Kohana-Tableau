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

	/***************************
	 **  Setters and Getters  **
	 ***************************/

	/**
	 * Get the reference back to Tableau
	 *
	 * @return Tableau
	 */
	public function getTable() {
		return $this->table;
	}

	/**
	 * Set the column's title
	 *
	 * @param string $title
	 * @return Kohana_Tableau_Column
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	/**
	 * Get the column's title
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Set whether the columns should be automatically htmlspecialchars() escaped
	 *
	 * @param boolean $escaped
	 * @return Kohana_Tableau_Column
	 */
	public function setEscaped($escaped) {
		$this->escape = (bool)$escaped;
		return $this;
	}

	/**
	 * Whether the columns is automatically htmlspecialchars() escaped
	 *
	 * @return bool
	 */
	public function isEscaped() {
		return (bool)$this->escape;
	}

	/**
	 * Set the key for this column
	 *
	 * @param string $key
	 * @return Kohana_Tableau_Column
	 */
	public function setKey($key) {
		$this->key = $key;
		return $this;
	}

	/**
	 * Get the key for this column
	 *
	 * @return string
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * Set an attribute for this columns
	 *
	 * @param string $key
	 * @param string $value
	 * @return Kohana_Tableau_Column
	 */
	public function setAttribute($key, $value) {
		$this->attributes[$key] = $value;
		return $this;
	}

	/**
	 * Set attributes by using an array
	 *
	 * @param array $array
	 * @return Kohana_Tableau_Column
	 */
	public function setAttributesArray(array $array) {
		$this->attributes = array_merge($this->attributes, $array);
		return $this;
	}

	/**
	 * Get a specific attribute
	 *
	 * @param string $key
	 * @return string
	 */
	public function getAttribute($key) {
		return $this->attributes[$key];
	}

	/**
	 * Get the full array of attributes
	 *
	 * @return array
	 */
	public function getAllAttributes() {
		return $this->attributes;
	}

	/**
	 * Append a class
	 *
	 * @param string $class
	 * @return Kohana_Tableau_Column
	 */
	public function addClass($class) {
		$this->setAttribute('class', $this->getAttribute('class') . " " . $class);
		return $this;
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
