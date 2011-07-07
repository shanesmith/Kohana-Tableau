<?php

/**
 * Tableau_Callback
 *
 * Useful methods to be used in callbacks.
 *
 * ex:
 *
 *  $table->addColumn('message')->addCallback(
 *    Tableau_Callback::$maxlength, array( 300 )
 *  );
 *
 * @package Tableau
 * @author  Shane Smith
 */
class Kohana_Tableau_Callback {

	/**
	 * Tableau CELL callbacks
	 */
	public static $strtoupper     = array( "Tableau_Callback", "_strtoupper" );
	public static $strtolower     = array( "Tableau_Callback", "_strtolower" );
	public static $ucfirst        = array( "Tableau_Callback", "_ucfirst" );
	public static $ucwords        = array( "Tableau_Callback", "_ucwords" );
	public static $trim           = array( "Tableau_Callback", "_trim" );
	public static $wordwrap       = array( "Tableau_Callback", "_wordwrap" );
	public static $nl2br          = array( "Tableau_Callback", "_nl2br" );
	public static $number_format  = array( "Tableau_Callback", "_number_format" );
	public static $date           = array( "Tableau_Callback", "_date" );
	public static $maxlength      = array( "Tableau_Callback", "_maxlength" );
	public static $is_empty       = array( "Tableau_Callback", "_is_empty");
	public static $str_replace    = array( "Tableau_Callback", "_str_replace");
	public static $implode        = array( "Tableau_Callback", "_implode");

	/**
	 * Tableau HTML ELEMENT callbacks
	 */
	public static $altern_class = array( "Tableau_Callback", "_altern_class");
	public static $zebra        = array( "Tableau_Callback", "_zebra" );


	/**
	 * Uppercase the content
	 *
	 * @param Tableau_HTML_Cell $cell
	 * @return Tableau_HTML_Cell
	 */
	public static function _strtoupper($cell) {
		$cell->content = strtoupper($cell->content);
		return $cell;
	}

	/**
	 * Lowercase the content
	 *
	 * @param Tableau_HTML_Cell $cell
	 * @return Tableau_HTML_Cell
	 */
	public static function _strtolower($cell) {
		$cell->content = strtolower($cell->content);
		return $cell;
	}

	/**
	 * Uppercase the first letter, the rest becomes lowercase
	 *
	 * @param Tableau_HTML_Cell $cell
	 * @return Tableau_HTML_Cell
	 */
	public static function _ucfirst($cell) {
		$cell->content = ucfirst($cell->content);
		return $cell;
	}

	/**
	 * Uppercase the first letter of each word
	 *
	 * @param Tableau_HTML_Cell $cell
	 * @return Tableau_HTML_Cell
	 */
	public static function _ucwords($cell) {
		$cell->content = ucwords($cell->content);
		return $cell;
	}

	/**
	 * Trim the content
	 *
	 * @param Tableau_HTML_Cell $cell
	 * @param string $charlist
	 * @return Tableau_HTML_Cell
	 */
	public static function _trim($cell, $charlist=null) {
		$cell->content = trim($cell->content, $charlist);
		return $cell;
	}

	/**
	 * Wordwrap the content
	 *
	 * @param Tableau_HTML_Cell $cell
	 * @param int $width
	 * @param string $break
	 * @param bool $cut
	 * @return Tableau_HTML_Cell
	 */
	public static function _wordwrap($cell, $width=75, $break="\n", $cut=false) {
		$cell->content = wordwrap($cell->content, $width, $break, $cut);
		return $cell;
	}

	/**
	 * Convert newlines to html br tags
	 *
	 * @param Tableau_HTML_Cell $cell
	 * @return Tableau_HTML_Cell
	 */
	public static function _nl2br($cell) {
		$cell->content = nl2br($cell->content);
		return $cell;
	}

	/**
	 * Number formats the content
	 *
	 * @param Tableau_HTML_Cell $cell
	 * @param int $decimals
	 * @param string $dec_point
	 * @param string $thousands_sep
	 * @return Tableau_HTML_Cell
	 */
	public static function _number_format($cell, $decimals=0, $dec_point='.', $thousands_sep=',') {
		$cell->content = number_format($cell->content, $decimals, $dec_point, $thousands_sep);
		return $cell;
	}

	/**
	 * Convert a unix timestamp to a date string
	 *
	 * @param Tableau_HTML_Cell $cell
	 * @param string $format
	 * @return Tableau_HTML_Cell
	 */
	public static function _date($cell, $format='d/m/Y H:i') {
		$cell->content = date($format, $cell->content);
		return $cell;
	}

	/**
	 * Truncates the content if over the given maximum length.
	 *
	 * If desired, the cutoff can be moved to break on a word boundary only,
	 * along with a maximum padding allowed passed the maximum length.
	 *
	 * If truncated, the given ellipsis is added to the end.
	 *
	 * @param Tableau_HTML_Cell $cell
	 * @param int $max
	 * @param bool $break_on_words
	 * @param int $padding
	 * @param string $ellipsis
	 * @return Tableau_HTML_Cell
	 */
	public static function _maxlength($cell, $max, $break_on_words=true, $padding=20, $ellipsis=' ...') {
		if (strlen($cell->content) > $max) {

			if ($break_on_words) {
				$cell->content = substr($cell->content, 0, $max + strcspn($cell->content, " \n\t\r", $max));

				if (strlen($cell->content) > $max + $padding) {
					$cell->content = substr($cell->content, 0, $max + $padding);
				}
			} else {
				$cell->content = substr($cell->content, 0, $max);
			}

			$cell->content .= $ellipsis;

		}

		return $cell;
	}

	/**
	 * If the cell's content is empty, the placeholder is displayed and the given class is set
	 *
	 * @param Tableau_HTML_Cell $cell
	 * @param string $placeholder
	 * @param string $class
	 * @return Tableau_HTML_Cell
	 */
	public static function _is_empty($cell, $placeholder="&nbsp;", $class='empty') {
		if (empty($cell->content)) {
			$cell->content = $placeholder;
			if ($class) $cell->addClass("empty");
		}
		return $cell;
	}

	/**
	 * Runs the str_replace() php method on the cell content
	 *
	 * @param Tableau_HTML_Cell $cell
	 * @param mixed $search
	 * @param mixed $replace
	 * @return Tableau_HTML_Cell
	 */
	public static function _str_replace($cell, $search, $replace) {
		$cell->content = str_replace($search, $replace, $cell->content);
		return $cell;
	}

	/**
	 * Runs the implode() php method on the cell content
	 *
	 * @param Tableau_HTML_Cell $cell
	 * @param string $glue
	 * @return Tableau_HTML_Cell
	 */
	public static function _implode($cell, $glue="") {
		$cell->content = implode($glue, $cell->content);
		return $cell;
	}

	/**
	 * Alternates setting the given classes according to the element's index
	 *
	 * @param Tableau_HTML_Element $elem
	 * @param array $classes
	 * @return Tableau_HTML_Element
	 */
	public static function _altern_class($elem, $classes) {
		$pos = $elem->index % count($classes);
		$elem->addClass($classes[$pos]);
		return $elem;
	}

	/**
	 * Alternates setting odd and even classes according to the element's index
	 *
	 * @param Tableau_HTML_Element $elem
	 * @return Tableau_HTML_Element
	 */
	public static function _zebra($elem) {
		return Tableau_Callback::_altern_class($elem, array('even', 'odd'));
	}

}
