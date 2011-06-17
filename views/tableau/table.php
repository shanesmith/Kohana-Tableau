<?php
	echo "<table>";

		if ($thead) {
			echo $thead;
		}

		echo $tbody;

		if ($tfoot) {
			echo $tfoot;
		}

	echo "</table>";