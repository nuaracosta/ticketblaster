<?php

session_start();

function isLoggedIn(): bool
{
	if ( isset($_SESSION['user_num']) && isset($_SESSION['user_id']) && isset($_SESSION['level']) && $_SESSION['level'] > 0 )
		return true;
	return false;
}

function isAdmin(): bool
{
	if ( isLoggedIn() && $_SESSION['level'] == 10 ) 
		return true;
	return false;
}

if ( (!isset($access_controlled) || $access_controlled) && !isLoggedIn() )
	header('Location: /web214/db/db_login.php', true, 302);
