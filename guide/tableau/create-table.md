Creating a table
================

Use Tableau's factory method to create a table.

	Tableau::factory($data=array(), $columns=array())

Providing the optional parameters is a shortcut for:

	Tableau::factory()->setData($data)->addColumnsArray($columns)

Keep reading to learn more about data and columns.
