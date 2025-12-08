<?php 

//BEGIN - ON EVERY PAGE TOP
$access_controlled = false;
require_once("auth_check.php");
$page_title = "Welcome";
require_once("header.php");
//END - ON EVERY PAGE TOP

echo "Include a really inspirational quote here";

//BEGIN - ON EVERY PAGE BOTTOM
require_once("footer.php");
//END - ON EVERY PAGE BOTTOM

