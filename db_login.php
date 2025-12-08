<?php

require_once("db_pwd.php"); //Creates a $db mysqli object and connects to DB

//From is used to send the user to the page that they tried to access before logging in
$from = $_POST['from'] ?? ($_SERVER['HTTP_REFERER'] ?? "/web214/db/db_view.php");

//Starts session/cookie management
session_start();

$msg = "Login to access this area";

if ( isset($_SESSION['user_num']) && isset($_SESSION['user_id']) && isset($_SESSION['level']) ) {
	//already logged in
	redirect($from);
} elseif ( isset($_POST['user_id']) && isset($_POST['password']) && isset($_POST['from']) ) {
	
	$sql = sprintf("
		SELECT user_num, user_id, level, password
		FROM users
		WHERE user_id='%s'
	", $db->real_escape_string($_POST['user_id']));
    
	if ( $result = $db->query($sql) ) {
	
		if ($result && $result->num_rows == 1 ) {
			$u = $result->fetch_assoc();
			//Compare the password hash stored in the database to the supplied password by the user
			if ( password_verify($_POST['password'], $u['password']) ) {
			
			    if ( $u['level'] > 0 ) {
	                $_SESSION['user_num'] = $u['user_num'];
	                $_SESSION['user_id'] = $u['user_id'];
	                $_SESSION['level'] = $u['level'];
	                
	                //Update users last_login
	                $db->query("UPDATE users SET last_login=NOW() WHERE user_num = '". $u['user_num']  ."'");
	                
	                redirect($_POST['from']);
		        } else {
		                $msg = "Access denied.";
		        }
			} else {
    			$msg = "Incorrect user id and/or password.";
			}
		} else {
			$msg = "Incorrect user id and/or password.";
		}
	} else {
		outputDBError($db);
	}
}

?>
<!DOCTYPE html>
<!-- First HTML5 example. -->
<html>
   <head>
      <meta charset = "utf-8">
      <title>Login</title>
	  <link href="/web214/common.css" rel="stylesheet" type="text/css">
   </head>
	
	<body class="loginform">
		
		<div class="loginform centered">
		<form method="post">
			
			<div class="key"></div>
			<h3><?php echo $msg; ?></h3>
			<label for="user_id">
				Username:
				<input id="user_id" name="user_id" type="text" value="">
			</label>
			<p>
			<label for="password">
				Password:
				<input id="password" name="password" type="password" value="">
			</label>
			<p style="text-align: center;">
				<input name="from" type="hidden" value="<?php echo $from; ?>">
				<input id="loginbutton" type="submit" value="login">
			</p>
		</form>
		</div>
   </body>
</html>
