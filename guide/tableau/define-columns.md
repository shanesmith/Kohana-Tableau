Defining columns
==============

Defining columns is actually optional. If no columns are defined at the time of rendering, Tableau will automatically
set its columns according to the keys of the first row of supplied data (and thereby including all data).

## Defining a Column

To define a column:

	// returns an object of type Tableau_Column
	$table->addColumn($key, $title=null, $class=null)

The `$key` argument relates to the column keys in your data array. You can also
supply a key that is not found in the data array to be used solely with callbacks, which we will cover later.

The `$title` argument is the title of the column, rendered in the &lt;thead&gt; section of your table. If the title
is not provided it will be automatically set to `$key` (with underscores replaced by spaces). To not render
a title for a column simply set it to an empty string.

The `$class` argument is a class name that will be set during rendering to all cells (both td and th) found in
this column. If the class is not provided it will also be automatically set to `$key`. Again, if you would
rather not have a class set, supply the empty string.

Here are a few examples:

	// key='user_id', title='user id' (no underscore), class='user_id'
	$table->addColumn('user_id');

	// key='fav_color', title='favorite color', class='fav_color'
	$table->addColumn('fav_color', 'favorite color');

	// key='25', title='', class='col_25'
	$table->addColumn('25', '', 'col_25');

## Defining Multiple Columns

To help with adding multiple columns you may use:

	$table->addColumnsArray($columns);

This method basically calls `addColumn()` for each entry of the given array.

Each entry can either be a string, in which case it is the key, title and class, or an array mimicking the parameters of `addColumn()`.

	$table->addColumnsArray(array(

		// key='user_id', title='user id' (no underscore), class='user_id'
		'user_id',

		// key='fav_color', title='favorite color', class='fav_color'
		array('fav_color', 'favorite color'),

		// key='25', title='', class='col_25'
		array('25', '', 'col_25);

	));