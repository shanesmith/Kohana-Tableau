Tableau Kohana Module
=====================

*Tableau (pronounced Tabloh) is a Kohana 3.x (and maybe under?) module for quick html table creation from data arrays.*


Simple Example
--------------

The following example retrieves a list of log entries and displays the 'user_id', 'level', 'code', 'message', and 'timestamp'
values in a table.

	$entries = Model::factory('log')->find_all();

	$table = Tableau::factory($entries, array( 'user_id', 'level', 'code', 'message', 'timestamp' ));

	$this->template->content = $table->render();


Documentation
-------------

For more documentation please see the bundled user guide.


License
-------

This module is licensed under the MIT license.

Please see the LICENSE file for the full license.
