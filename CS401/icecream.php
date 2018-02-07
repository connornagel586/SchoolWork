<?php
	$data = file_get_contents()
	$lines = explode("\n", $data)
	
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="EX1.css">
</head>
<body>
	<h1>Templating Example</h1>
	<ul>
		<li><a href="snacks.php">Favorite Snacks</a></li>
		<li><a href="Icecream.php">Favorite Icecream</a></li>
	</ul>
	<div id='content'>
		<table>
			<tr><th>Alias</th>
				<th>Flavor</th>
			</tr>
			<tr>
				<th>All Your Base</th>
				<th></th>
			</tr>
			<tr>
				<?php
				foreach ($lines as #line){
				$items = explode("|", $line)
			}

			</tr>
		</table>
	</div>
</body>
</html>
