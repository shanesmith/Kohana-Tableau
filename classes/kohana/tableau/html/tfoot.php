<?php

/**
 * Kohana_Tableau_HTML_TFoot
 *
 *
 */
class Kohana_Tableau_HTML_TFoot extends Tableau_HTML_RowContainer {

	/**
	 * Render this tfoot
	 *
	 * @return string
	 */
	public function render() {
		$tfoot = "<tfoot>";

		foreach ($this->rows as $row) {
			$tfoot .= $row->render();
		}

		$tfoot .= "</tfoot>";

		return $tfoot;
	}

}
