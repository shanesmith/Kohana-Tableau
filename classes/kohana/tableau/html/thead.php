<?php

/**
 * Kohana_Tableau_HTML_THead
 *
 *
 */
class Kohana_Tableau_HTML_THead extends Tableau_HTML_RowContainer {

	/**
	 * Render this thead
	 *
	 * @return string
	 */
	public function render() {
		$thead = "<thead>";

		foreach ($this->rows as $row) {
			$thead .= $row->render();
		}

		$thead .= "</thead>";

		return $thead;
	}

}
