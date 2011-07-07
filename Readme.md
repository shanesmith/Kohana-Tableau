Tableau Kohana Module
=====================

*Tableau (pronounced Tabloh) is a Kohana 3.1 module for quick html table creation from data arrays.*


Simple Example
--------------

The following example retrieves a list of log entries and displays the 'user_id', 'level', 'code', 'message', and 'timestamp'
values in a table.

	$entries = Model::factory('log')->find_all();

	$table = Tableau::factory($entries, array( 'user_id', 'level', 'code', 'message', 'timestamp' ));

	$this->template->content = $table->render();


Documentation
-------------

### Creating a table

#### Tableau::factory($data=array(), $columns=array())

The factory creates a new table for you. That's about it.

Providing the optional parameters is a shortcut for `Tableau::factory()->setData($data)->addColumnsArray($columns)`.

To read more about the structure of `$data` and `$columns` see the `setData()` and `addColumnsArray()` entries below.


### Adding data

Adding data is the only required part of creating a Tableau.

#### $table->setData($data)

Simply sets the given data to be used in rendering.

Each entry in the data array represents a row in the table, and each row-array should be keyed by the column key.

ex:

	$data = array(

		// first row
		array(
			// columns id, name and fav_color
			'id' => 1,
			'name' => "Joe Shmoe",
			'fav_color' => "blue"
		),

		//second row
		array(
			'id' => 2,
			'name' => "Jane Shmane",
			'fav_color' => "green"
		),

		// etc...

	)

The $data argument can also be an object of the Kohana class Database_Result, in which
case it will be automatically turned into an array.

Note that it's ok if there are values for columns you do not want shown in your rendered table.


### Adding columns

Defining columns is actually optional. If no columns are defined at the time of rendering, Tableau will automatically
set its columns according to the keys of the first row of supplied data, thereby including all data.

#### $table->addColumn($key, $title=null, $class=null)

Add a column to the table.

The `$key` argument relates to the column keys in your data array. You can also
supply a key that is not found in the data array to be used solely with callbacks, which we will cover later.

The `$title` argument is the title of the column, rendered in the thead section of your table. If the title
is not provided it will be automatically set to `$key` (with underscores '_' replaced by spaces ' '). To not render
a title for a column simply set it to an empty string ''.

The `$class` argument is a class name that will be set during rendering to all cells (both td and th) found in
this column. If the class is not provided it will also be automatically set to `$key`. Again, if you would
rather not have a class set, supply the empty string ''.

ex:

	addColumn('user_id'); // key='user_id', title='user id' (no underscore), class='user_id'

	addColumn('fav_color', 'favorite color'); // key='fav_color', title='favorite color', class='fav_color'

	addColumn('25', '', 'col_25); // key='25', title='', class='col_25'


#### $table->addColumnsArray($columns)

Add multiple columns with the help of an array.

This method basically calls `addColumn()` for each entry of the given array.

Each entry can either be a string, in which case it is the key of the column and the title and class are automatically
determined, or an array mimicking the parameters of `addColumn()`.

ex:

	addColumnsArray(array(

		'user_id', // key='user_id', title='user id' (no underscore), class='user_id'

		array('fav_color', 'favorite color'), // key='fav_color', title='favorite color', class='fav_color'

		array('25', '', 'col_25); // key='25', title='', class='col_25'

	))


### Tableau_Column

A column definition is held in a Tableau_Column object, which is return by either `addColumn()` or `getColumn()`.


### Callbacks

Another optional feature that can however give you great rendering power.

#### $column->addCallback($callback, $arguments...)
#### $column->addTitleCallback($callback, $arguments...)

The given callback is called everytime a cell (td or th, respectively) is rendered, allowing you to change the cell's content or even attributes.

You callback must accept an object of the type `Tableau_HTML_Td` or `Tableau_HTML_Th`, depending, as well as the given list of arguments, and return
the same type of object.

Here's a simple callback that includes a placeholder text for cells with no content and sets a class of 'empty':

	function empty_placeholder($td, $placeholder='empty') {
		if (empty($td->content)) {
			$td->content = $placeholder;
			$td->addClass("empty");
		}
		return $td;
	}

The preceding callback would be set the following way:

	$table->getColumn('fav_color')->addCallback('empty_placeholder', '--'); // we decide to change the placeholder text in the second argument!

Callbacks can also be useful for including content not found in the data set, such as the following which adds an "edit" link based on the row's 'id' column:

	function edit_link($td) {
		$id = $td->table->getData($td->row, 'id');
		$td->content = HTML::anchor("edit/{$id}", "edit");
		return $td;
	}

#### $table->addRowCallback($callback, $arguments...)

Callbacks may also be set for when rows are rendered.

The idea is the same as column callbacks, however the callback should expect and return an object of the type `Tableau_HTML_Tr`.

Here's an example that set's the row's class to its 'error_level' column's value:

	function error_class($tr) {
		$class = $tr->table->getData($tr->index, 'error_level');
		$tr->addclass($class);
		return $tr;
	}

#### Tableau_Callback

The `Tableau_Callback` class is a collection of common and userful callbacks.

ex:

	$table->addRowCallback(
		Tableau_Callback::$zebra
	);

	$column->addCallback(
		Tableau_Callback::$maxlength, 300
	);