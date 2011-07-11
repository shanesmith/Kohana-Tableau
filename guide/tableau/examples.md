Examples
========

Code:

	// our data...
	$data = array(
		array( 'id' => 1, 'user_name' => 'John',
			'image_file' => '/pic/john.jpg' ),

		array( 'id' => 2, 'user_name' => 'Jacob',
			'image_file' => '/pic/jacob.jpg' ),

		array( 'id' => 3, 'user_name' => 'Joseph',
			'image_file' => '/pic/joseph.jpg' ),
	);

	// note the edit and image_file columns
	$table = Tableau::factory(
		$data,
		array(
			array('edit', ''),
			'user_name',
			array('image_file', 'picture', 'picture')
		)
	);

	// first a row callback for zebra stripes
	$table->addRowCallback(Tableau_Callbacks::$zebra);

	// callback to display an edit link
	$table
		->getColumn('edit')
			->addCallback('link', 'edit', 'edit person');

	// note the two callbacks, which are called in order
	$table
		->getColumn('image_file')
			->addCallback('picture_tag')
			->addCallback('link', 'view');

Callbacks:

	// convert the content to a link
	function link($td, $type, $content=null) {
		$id = $td->getTable()->getData($td->index, 'id');
		if (is_null($content)) {
			$content = $td->content;
		}
		$td->content = HTML::anchor($content, "{$type}/{$id}");
		return $td;
	}

	// convert the content to an img tag
	function picture_tag() {
		$td->content = "<img src='{$td->content} />';
		return $td;
	}


Result:

	<table>

		<thead>

			<tr>
				<th class='edit'></th>
				<th class='user_name'>user name</th>
				<th class='picture'>picture</th>
			</tr>

		</thead>

		<tbody>

			<tr class='even'>
				<td class='edit'> <a href='edit/1'>edit</a> </td>
				<td class='user_name'> John </td>
				<td class='picture'>
					<a href='view/1'><img src='/pic/john.jpg' /></a>
				</td>
			</tr>

			<tr class='odd'>
				<td class='edit'> <a href='edit/2'>edit</a> </td>
				<td class='user_name'> Jacob </td>
				<td class='picture'>
					<a href='view/2'><img src='/pic/jacob.jpg' /></a>
				</td>
			</tr>

			<tr class='even'>
				<td class='edit'> <a href='edit/3'>edit</a> </td>
				<td class='user_name'> Joseph </td>
				<td class='picture'>
					<a href='view/3'><img src='/pic/joseph.jpg' /></a>
				</td>
			</tr>

		</tbody>

	</table>