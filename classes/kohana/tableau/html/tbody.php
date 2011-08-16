<?php

/**
 * Kohana_Tableau_HTML_TBody
 *
 *
 */
class Kohana_Tableau_HTML_TBody extends Tableau_HTML_RowContainer {

	/**
	 * Render this tbody
	 *
	 * @return string
	 */
	public function render() {
		$tbody = "<tbody>";

		foreach ($this->rows as $row) {
			$tbody .= $row->render();
		}

		$tbody .= "</tbody>";

		return $tbody;
	}

}
