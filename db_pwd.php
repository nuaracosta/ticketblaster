<?php
/*
By S. Miller

1. Your database userid should be the same as your tophat userid

2. Your database password is NOT the same.  Your password should be saved to a text file in your home directory
called db.txt.  This password is typically four random words seperated by spaces.

3. This script reads the text file and stores it in a variable named DBPWD, connects to the database, then deletes (unsets)
the password variable so that it will not accidently be sent as output to the browser

*/
$DB_SERVER = $_SERVER['SERVER_PORT'] > 500 ? "vesmir.dom" : "localhost"; //Your userid for tophat/database server, this is case sensitive
$DB_USERNAME = "webgroup"; //Your userid for tophat/database server, this is case sensitive
$DB_DATABASE = "webgroup5_defualt"; //Name of your database, the default is yourusername_default, this is case sensitive

$db_pass_path = isset($_SERVER['CONTEXT_DOCUMENT_ROOT']) ? $_SERVER['CONTEXT_DOCUMENT_ROOT'] . "/../db.txt" : "../db.txt";

$db = false; //Mysqli Object 

if ( file_exists($db_pass_path) ) {
    //DBPwd file exists
    $DB_PWD = trim(file_get_contents($db_pass_path));
    $db = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PWD, $DB_DATABASE );

    if ($db->connect_errno) {
        echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    }
    unset($DB_PWD);

} else {
    echo "Users db.txt file missing, unable to use DB";
    //trigger_error("Users db.txt file missing, unable to use DB", E_ERROR);
}

//Global functions

//redirect
//Convenience function to redirect to another page, however, only works if NO output was already sent to browser
function redirect($to): void
{
	header('Location: ' . $to, true, 302);
	exit(1); //To make sure nothing else gets executed, location only works if nothing already sent to browser
}

//Nice function to output a "friendly" mysql error when the query does not execute as you think it should
/**
 * @throws Exception
 */
function outputDBError($db): void
{
	 echo "<pre>";
	 if ($db->error) {
		  try {    
			   throw new Exception("MySQL error $db->error", $db->errno);    
		  } catch(Exception $e ) {
			   printf("Error No: %d<br>%s<br>",$e->getCode(),$e->getMessage());
			   echo nl2br($e->getTraceAsString());
		  }
	 } else {
		  throw new Exception("Unknown db issue");    
	 }
}
