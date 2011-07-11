Callbacks
=========

Callbacks are an optional feature that can give you great power over the table's rendering.

## Cell Callbacks

Cell callbacks are defined with:

	// <td> callback
	$column->addCallback($callback, $arguments...)

	// <th> callback
	$column->addTitleCallback($callback, $arguments...)

The given callback is called everytime a cell (&lt;td&gt; or &lt;th&gt;, respectively) is rendered, allowing you to change the cell's content or attributes.

You callback must accept an object of the type `Tableau_HTML_Td` or `Tableau_HTML_Th`, depending, as well as the given arguments, and return
the same type of object.

Here's a simple callback that displays a placeholder text for cells with no content and sets a class of 'empty':

	function empty_placeholder(Tableau_HTML_Td $td, $placeholder='empty') {
		if (empty($td->content)) {
			$td->content = $placeholder;
			$td->addClass("empty");
		}
		return $td;
	}

The preceding callback would be set the following way:

	$table
		->getColumn('fav_color')
			// we decide to change the placeholder text in the second argument!
			->addCallback('empty_placeholder', '--');

Callbacks can also be useful for including content not found in the data set, such as the following which adds an "edit" link based on the row's 'id' column:

	// here's our data
	$data = array(
		array( 'id' => 1, 'name' => 'Joe Shmoe'),
		array( 'id' => 2, 'name' => 'Jane Shmane'),
		array( 'id' => 3, 'name' => 'Bob Marley'),
	);

	// note that we specify the 'edit' column, which isn't in our data array!
	$table = Tableau::factory($data, array('edit', 'name'));

	// we define a function to be used as a callback
	function edit_link($td) {
		$id = $td->getTable()->getData($td->row, 'id');
		$td->content = HTML::anchor("edit/{$id}", "edit");
		return $td;
	}

	// set a callback to the edit column
	$table->getColumn('edit')->addCallback('edit_link');



## Row Callbacks

Callbacks may also be set for when rows are rendered.

	$table->addRowCallback($callback, $arguments...)

The idea is the same as column callbacks, however the callback should expect and return an object of the type `Tableau_HTML_Tr`.

Here's an example that set's the row's class to its 'error_level' column's value:

	function error_class($tr) {
		$class = $tr->getTable()->getData($tr->index, 'error_level');
		$tr->addclass($class);
		return $tr;
	}

## Tableau_Callback

The [Tableau_Callback] class is a collection of common and userful callbacks.

	$table->addRowCallback(
		Tableau_Callback::$zebra
	);

	$column->addCallback(
		Tableau_Callback::$maxlength, 300
	);
