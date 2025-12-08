<!doctype html>
<!-- S. Miller -->
<html>
	<head>
		<meta charset = "utf-8">
		<title><?= $page_title ?? '$page_title Undefined' ?></title>
		<link href="/web214/common.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<nav>
			<ul>
				<li><a href="/web214/db">Home</a></li>
				<?php				
				if ( isLoggedIn() ) { ?>
				<li><a href="/web214/db/db_view.php">View</a></li>
				<li><a href="/web214/db/db_logout.php">Logout</a></li>
				<?php } else { ?>
				<li><a href="/web214/db/db_login.php">Login</a></li>
				<?php } ?>
			</ul>
		</nav>
		<section>
