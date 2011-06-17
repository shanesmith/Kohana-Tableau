<?php
	echo "<tr " . HTML::attributes($tr->attributes) . ">";

	foreach ($tr->cells as $cell) echo $cell;

	echo "</tr>";