<!DOCTYPE html>
<html>
<head>
	<title>Muphonic</title>
	<link rel="stylesheet" type="text/css" href="style/main.css">
	<?php

	switch($_SESSION['current_page']){

		case "forum_main.php":
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style/forum.css\">";
			echo "<script type=\"text/javascript\" src=\"script/jquery-3.3.1.js\"></script>";
			echo "<script type=\"text/javascript\" src=\"script/forum.js\"></script>";

			$pageTitle ="Forum";
			break;

			case "forum_page.php":
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style/forum.css\">";
					echo "<script type=\"text/javascript\" src=\"script/jquery-3.3.1.js\"></script>";
				echo "<script type=\"text/javascript\" src=\"script/forum.js\"></script>";

				$pageTitle ="Forum";
				break;

				case "home_page.php":
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style/home.css\">";
				echo "<script type=\"text/javascript\" src=\"script/jquery-3.3.1.js\"></script>";
				$pageTitle = "Home Page";
				break;

				case "about_home":
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style/about.css\">";
				$pageTitle ="About";
				break;
				case "about_index":
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style/about.css\">";
				$pageTitle ="About";
				break;

				case "index.php":
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style/index.css\">";
				$pageTitle ="Muphonic";
				break;

				case "chat_room.php":
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style/chat.css\">";
				echo "<script type=\"text/javascript\" src=\"script/jquery-3.3.1.js\"></script>";
				echo "<script type=\"text/javascript\" src=\"script/chat.js\"></script>";
				$pageTitle ="Chat";
				break;

				case "chat_main.php":
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style/chat.css\">";
				echo "<script type=\"text/javascript\" src=\"script/jquery-3.3.1.js\"></script>";
				echo "<script type=\"text/javascript\" src=\"script/chat.js\"></script>";
				$pageTitle ="Chat";
				break;

				default:
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style/main.css\">";
				echo "<script type=\"text/javascript\" src=\"script/jquery-3.3.1.js\"></script>";
				$pageTitle ="Undefined";
				break;

			}
			?>
		</head>
		<body>
			<div id="container">
				<header>
					<h1><?php echo $pageTitle?></h1>
					<img src="images/mu.png" id="icon"></img>
					<nav>
						<ul>
							<?php
							if(isset($_SESSION['user_id'])){
								echo "<a ". (($pageTitle == "About")? "id=\"currentpage\"":"")
								. "href=\"about.php\">About</a>
								<a ". (($pageTitle == "Home Page")? "id=\"currentpage\"":"")
								. "href=\"home_page.php\">Home</a>
								<a ". (($pageTitle == "Chat")? "id=\"currentpage\"":"")
								. "href=\"chat_main.php\">Chat</a>
								<a ". (($pageTitle == "Forum")? "id=\"currentpage\"":"")
								. "href=\"forum_main.php\">Forum</a>
								<a href=\"handlers/signoutHandler.php\">Sign Out</a>";
							}
							else if($_SESSION['current_page'] == "about_index"){
								echo "<a href=\"about.php\">About</a>
								<a href=\"index.php\">Login</a>";
							}
							else{
							echo "<a href=\"about.php\">About</a>";
						}

							?>
						</ul>
					</nav>
				</header>
