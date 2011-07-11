Tableau Kohana Module
=====================

*Tableau (pronounced Tabloh) is a Kohana 3.1 module for quick html table creation from data arrays.*


Simple Example
--------------

The following example retrieves a list of log entries and displays the 'user_id', 'level', 'code', 'message', and 'timestamp'
values in a table.

	// retrieve all log entries into an array
	$entries = Model::factory('log')->find_all();

	// create a table out of the data array while also specifying the desired columns
	$table = Tableau::factory(
		$entries,
		array('user_id', 'level', 'code', 'message', 'timestamp')
	);

	// render it!
	$this->template->content = $table->render();