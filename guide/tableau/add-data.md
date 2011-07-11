Adding data
===========

Adding data is the only required part of creating a Tableau.

	$table->setData($data)

Each entry in the data array represents a row in the table, and each row should be keyed by the column key:

	$data = array(

		// first row
		array(
			// columns: id, name and fav_color
			'id'        => 1,
			'name'      => "Joe Shmoe",
			'fav_color' => "blue"
		),

		//second row
		array(
			'id'        => 2,
			'name'      => "Jane Shmane",
			'fav_color' => "green"
		),

		// etc...

	)

The $data argument can also be an object of the Kohana `Database_Result` class, in which
case it will be automatically turned into an array.

Note that it's ok if there are values for columns you do not want shown in your rendered table. We will see
that it is possible to choose which columns to show.