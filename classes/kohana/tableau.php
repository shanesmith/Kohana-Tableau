<?php

/**
 * Tableau
 *
 * A Kohana 3.1 module for quick table making.
 *
 *
 * @package Tableau
 * @author  Shane Smith
 */
class Kohana_Tableau {

	/**
	 * Holds a list of column definitions
	 *
	 * @var array
	 */
	protected $columns = array();

	/**
	 * The data to make rows with
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * An array of callbacks to be called on each row
	 *
	 * @var array
	 */
	protected $row_callbacks = array();

	/**
	 * An array of titles for rows
	 *
	 * @var array
	 */
	protected $row_titles = array();

	/**
	 * Should thead be rendered?
	 *
	 * @var bool
	 */
	protected $render_thead = true;

	/**
	 * Should tfoot be rendered?
	 *
	 * @var bool
	 */
	protected $render_tfoot = true;


	/*******************
	 **  Constructor  **
	 *******************/

	/**
	 * Create a new table with the (optional) given data and columns list.
	 *
	 * For the format of the columns array, see {@see addColumnsArray()}
	 *
	 * @param array|Database_Result $data
	 * @param array $columns
	 */
	public function __construct($data = array(), array $columns=array()) {
		$this->setData($data);
		$this->addColumnsArray($columns);
	}

	/**
	 * Factory that returns a new Tableau
	 *
	 * @see __construct()
	 * @param array|Database_Result $data
	 * @param array $columns
	 * @return Tableau
	 */
	public static function factory($data = array(), array $columns = array()) {
		return new Tableau($data, $columns);
	}


	/***************
	 **  Columns  **
	 ***************/

	/**
	 * Add a column to the end of the list.
	 *
	 * The key parameter relates to the value to be used in the data array.
	 *
	 * If the title or class is not set (ie: is null), they will
	 * be automatically filled in by the given key.
	 *
	 * An object of Tableau_Column is returned for further modifications (ex: adding callbacks)
	 *
	 * @param string $key
	 * @param string $title
	 * @param string $class
	 * @return Tableau_Column
	 */
	public function addColumn($key, $title=null, $class=null) {
		$column = new Tableau_Column($this, $key, $title, $class);
		$this->columns[$key] = $column;
		return $column;
	}

	/**
	 * Quickly add a handful of columns by passing in an array.
	 *
	 * Each entry in the array can either be a string, representing
	 * the columns key (with automatic title and class), or an array
	 * mimicking the arguments for {@see addColumn()}
	 *
	 * ex:
	 *  array(
	 *    'id',   // specify the key only, same as array('id')
	 *    array('user_name', 'name'),   // specify the key and title, class is still automatic
	 *    array('actions', ''),   // a column without a title
	 *    array('25', null, 'col_25')   // title remains automatic, however a class is specified
	 *  )
	 *
	 * @param array $columns
	 * @return Kohana_Tableau
	 */
	public function addColumnsArray(array $columns) {
		foreach ($columns as $col) {
			call_user_func_array(array($this, 'addColumn'), (array)$col);
		}
		return $this;
	}

	/**
	 * Simply removes the column of the given key and returns it
	 *
	 * @param $key
	 * @return Tableau_Column
	 */
	public function removeColumn($key) {
		$column = $this->columns[$key];
		unset($this->columns[$key]);
		return $column;
	}

	/**
	 * Returns the column of the given key
	 *
	 * @param $key
	 * @return Tableau_Column
	 */
	public function getColumn($key) {
		return $this->columns[$key];
	}


	/************
	 **  Rows  **
	 ************/

	/**
	 * Add callback which will be called on each row rendering, with optional
	 * arguments passed along.
	 *
	 * The callback should return an object of type Tableau_HTML_Tr
	 * and will be called in the following manner:
	 *
	 *  callback_func(Tableau_HTML_Tr $tr, $arguments[0], $arguments[1], etc...)
	 *
	 * @param callable $callback
	 * @param array $arguments
	 * @return Kohana_Tableau
	 */
	public function addRowCallback($callback, array $arguments = array( )) {
		$this->row_callbacks[] = array( $callback, $arguments );
		return $this;
	}

	/**
	 * Set the first column to be the given titles, rendered as THs
	 *
	 * @param array $titles
	 * @return Kohana_Tableau
	 */
	public function setRowTitles(array $titles) {
		$this->row_titles = $titles;
		return $this;
	}


	/************
	 **  Data  **
	 ************/

	/**
	 * Set the data to fill the table with.
	 *
	 * Either an array of arrays (with the inner array keyed by column)
	 * or an object of the type Database_Result.
	 *
	 * ex:
	 *  array(
	 *
	 *    // first row
	 *    array(
	 *      'id' => 1,
	 *      'name' => "Joe Shmoe",
	 *      'fav_color' => "blue"
	 *    ),
	 *
	 *    // second row
	 *    array(
	 *      'id' => 2,
	 *      'name' => "Jane Shmane",
	 *      'fav_color' => "green"
	 *    ),
	 *
	 *    // etc...
	 *  )
	 *
	 * @param array|Database_Result $data
	 * @return Kohana_Tableau
	 */
	public function setData($data) {
		if ($data instanceof Database_Result) {
			$data = $data->as_array();
		}
		$this->data = $data;
		return $this;
	}

	/**
	 * Add a single columns-worth of data, appended to the current columns of data, if any.
	 *
	 * ex:
	 *  $table->addDataColumn(array( 25, 76, 12, 90, 100 ), 'fav_number');
	 *
	 * will result in
	 *
	 *  array(
	 *    array(
	 *      ...
	 *      'fav_color' => "blue",
	 *      'fav_number" => 25
	 *    ),
	 *    array(
	 *      ...
	 *      'fav_color' => "green",
	 *      'fav_number' => 76
	 *    ),
	 *    ...
	 *  )
	 *
	 * Mostly useful for horizontal tables with row titles.
	 *
	 * @param array $data_column
	 * @param string $key
	 * @return Kohana_Tableau
	 */
	public function addDataColumn(array $data_column, $key=null) {
		$i = 0;
		foreach ($data_column as $entry) {
			if (isset($key)) {
				$this->data[$i][$key] = $entry;
			} else {
				$this->data[$i][] = $entry;
			}
			$i++;
		}
		return $this;
	}

	/**
	 * Get the set data, optionally drilling down with row number and column key
	 *
	 * @param int $row
	 * @param string $key
	 * @return array|string
	 */
	public function getData($row = null, $key = null) {
		if (!isset($this->data)) return array();

		$data = $this->data;

		if (isset($row)) {
			$data = $data[$row];

			if (isset($key)) {
				$data = $data[$key];
			}
		}

		return $data;
	}


	/*****************
	 **  Rendering  **
	 *****************/

	/**
	 * Get (or set) whether the THead element should be rendered
	 *
	 * @param bool $render
	 * @return bool|Kohana_Tableau
	 */
	public function includeTHead($render=null) {
		if (!isset($render)) {
			return $this->render_thead;
		}

		$this->render_thead = $render;
		return $this;
	}

	/**
	 * Get (or set) whether the TFoot element should be rendered
	 *
	 * @param null $render
	 * @return bool|Kohana_Tableau
	 */
	public function includeTFoot($render = null) {
		if (!isset($render)) {
			return $this->render_tfoot;
		}

		$this->render_tfoot = $render;
		return $this;
	}


	/**
	 * Get an array of rows (Tableau_HTML_Tr) for THead
	 *
	 * @return array
	 */
	public function getTHeadRows() {
		$rows = array();

		$data_cells = array();

		if (!empty($this->row_titles)) {
			$data_cells[] = new Tableau_HTML_Th($this, 0, 0, null, '', array());
		}

		$index = 0;

		foreach ($this->columns as $col) {
			$data_cells[] = $col->th($index++, 0);
		}

		$rows[] = new Tableau_HTML_Tr($this, 0, $data_cells);

		return $rows;
	}

	/**
	 * Get an array of rows (Tableau_HTML_Tr) for TBody
	 *
	 * @return array
	 */
	public function getTBodyRows() {
		if (empty($this->data)) return "";

		$rows = array();

		$row_counter = 0;

		foreach ($this->data as $data_row) {
			$data_cells = array();

			if (!empty($this->row_titles)) {
				$data_cells[] = new Tableau_HTML_Th($this, 0, null, 0, $this->row_titles[$row_counter], array());
			}

			$index = 0;

			foreach ($this->columns as $col) {
				$data_cells[] = $col->td(Arr::get($data_row, $col->key, null), $index++, $row_counter);
			}

			$tr = new Tableau_HTML_Tr($this, $row_counter, $data_cells);

			foreach ($this->row_callbacks as $callback) {
				list($func, $args) = $callback;
				if (is_callable($func)) {
					$args = array_merge(array($tr), $args);
					$tr = call_user_func_array($func, $args);
				}
			}

			if ($tr) {
				$rows[] = $tr;
				$row_counter++;
			}
		}

		return $rows;
	}

	/**
	 * Get an array of rows (Tableau_HTML_Tr) for TFoot
	 *
	 * @return array
	 */
	public function getFooterRows() {
		return array();
	}

	/**
	 * Get the View for THead
	 *
	 * @return View
	 */
	public function getTHeadView() {
		return View::factory('tableau/thead', array(
			'rows' => $this->getTHeadRows()
		));
	}

	/**
	 * Get the View for TFoot
	 *
	 * @return View
	 */
	public function getTBodyView() {
		return View::factory('tableau/tbody', array(
			'rows' => $this->getTBodyRows()
		));
	}

	/**
	 * Get the View for TFoot
	 *
	 * @return View
	 */
	public function getTFootView() {
		return View::factory('tableau/tfoot', array(
			'rows' => $this->getFooterRows()
		));
	}

	/**
	 * Get the full table View
	 *
	 * @return View
	 */
	public function getView() {
		return View::factory('tableau/table', array(
			'thead'  => $this->render_thead ? $this->getTHeadView() : "",
			'tbody'  => $this->getTBodyView(),
			'tfoot'  => $this->render_tfoot ? $this->getTFootView() : ""
		));
	}

	/**
	 * Render the table, returned in a string.
	 *
	 * If no columns are defined they will be automatically
	 * determined by using all keys of the first row of data.
	 *
	 * @return string
	 */
	public function render() {
		if (empty($this->columns)) {
			$this->addColumnsArray(array_keys(current($this->data)));
		}

		$table = $this->getView()->render();

		return $table;
	}

	/**
	 * Magic!
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->render();
	}


}
