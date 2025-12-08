<?php

//BEGIN - ON EVERY PAGE TOP
$page_title = "Student Edit";
require_once("auth_check.php");
require_once("db_pwd.php"); //Creates a $db mysqli object and connects to DB
require_once("header.php");
//END - ON EVERY PAGE TOP

if ( isAdmin() ) {

if ( isset($_POST['sid'] ) ) {
	//Form data, so, process form

	//going to do something semi-advanced, going to do a transaction, which will rollback if someting happens
	$db->autocommit(FALSE);
	
	$sql = sprintf("
		UPDATE students 
		SET first_name='%s',last_name='%s' 
		WHERE sid='%d'",
		$db->real_escape_string($_POST['first_name']),$db->real_escape_string($_POST['last_name']),$db->real_escape_string($_POST['sid'])
	);
	
	if ( $db->query($sql) ) {
		//Success updating students, now update grades table
		
		$sql = sprintf("
			UPDATE grades
			SET grade='%f' 
			WHERE sid='%d' AND cid='%d'",
			$db->real_escape_string($_POST['grade']),$db->real_escape_string($_POST['sid']),$db->real_escape_string($_POST['cid'])
		);
		
		if ( $db->query($sql) ) {
			$db->commit(); //commit transaction
			redirect('/web214/db/db_view.php');
		}
	
	} else {
		outputDBError($db);
		$db->rollback(); //ROLLBACK transaction
	}
	
	$db->close();
} 

if ( isset($_GET['sid'] ) && !(isset($_POST['first_name']) && isset($_POST['last_name']) )) {

	$sql = sprintf("
		SELECT students.*,grade,cid
		FROM students 
		INNER JOIN grades ON grades.sid=students.sid
		WHERE students.sid='%d' AND grades.cid='%d'",
		$db->real_escape_string($_GET['sid']),$db->real_escape_string($_GET['cid']));
	
	if ( $result = $db->query($sql) ) {
		
		if ( $result && $result->num_rows == 1 ) {	
			$s = $result->fetch_assoc();
			$_POST['first_name'] = $s['first_name'];
			$_POST['last_name'] = $s['last_name'];
			$_POST['grade'] = $s['grade'];
			$_POST['sid'] = $s['sid'];
			$_POST['cid'] = $s['cid'];
		} else {
		
			throw new Exception("Too many results");    
		  
		}
	} else {
					
		outputDBError($db);
	  
	}
}
?>

<h1>Edit Student</h1>
<form method="post">
	<label>
		First name:
		<input name="first_name" type="text" value="<?php echo $_POST['first_name'];?>">
	</label>
	<p>
	<label>
		Last name:
		<input name="last_name" type="text" value="<?php echo $_POST['last_name'];?>">
	</label>
	<p>
	<label>
		Grade:
		<input name="grade" type="number" min="0" max="100"  value="<?php echo $_POST['grade'];?>" step="0.01">
	</label>
	<p>
		<input name="cid" type="hidden" value="<?php echo $_POST['cid'];?>">
		<input name="sid" type="hidden" value="<?php echo $_POST['sid'];?>">
		<input type="submit" value="Update Student">
	</p>
</form>

<?php
} else {
	echo "Invalid access!";
}
//BEGIN - ON EVERY PAGE BOTTOM
require_once("footer.php");
//END - ON EVERY PAGE BOTTOM

?>
