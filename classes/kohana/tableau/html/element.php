<?php

/**
 * Tableau_HTML_Element
 *
 * Represents either elements TR, TD, or TD
 *
 * @package Tableau
 * @author  Shane Smith
 */
abstract class Kohana_Tableau_HTML_Element {

	/**
	 * A reference back to the Tableau
	 *
	 * @var Tableau
	 */
	public $table;

	/**
	 * The position of this element within its parent
	 *
	 * @var int
	 */
	public $index;

	/**
	 * An array of attributes to be set
	 *
	 * @var array
	 */
	public $attributes;

	/**
	 * Construct a Tableau_HTML_Element
	 *
	 * @param Tableau $table
	 * @param int $index
	 * @param array $attributes
	 */
	public function __construct($table, $index,  $attributes) {
		$this->table = $table;
		$this->index = $index;
		$this->attributes = $attributes;
	}

	/**
	 * Get the element's View
	 *
	 * @return View
	 */
	abstract public function getView();

	/**
	 * Add the given class
	 *
	 * @param string $class
	 * @return Kohana_Tableau_HTML_Element
	 */
	public function addClass($class) {
		$this->attributes['class'] .= " {$class}";
		return $this;
	}

	/**
	 * Get the rendered HTML
	 *
	 * @return string
	 */
	public function render() {
		return $this->getView()->render();
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
