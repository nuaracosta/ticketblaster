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

	//We only want to delete from students if they have more then one course
	//So, we first query the # of courses they have
	$deleteStudent = false;
	$sql = sprintf("
		SELECT cid
		FROM grades
		WHERE sid='%d'",
		$db->real_escape_string($_POST['sid'])
	);
	if ( $result = $db->query($sql) ) {
		if ( $result->num_rows == 1 )
			$deleteStudent = true;
		elseif ( $result->num_rows == 0 )
			outputDBError($db);
	} else {
		outputDBError($db);
		exit(1);
	}
	
	//going to do something semi-advanced, going to do a transaction, which will rollback if someting happens
	$db->autocommit(FALSE);
	
	$sql = sprintf("
		DELETE
		FROM grades 
		WHERE sid='%d' AND cid='%d'",
		$db->real_escape_string($_POST['sid']),$db->real_escape_string($_POST['cid'])
	);
	
	if ( $db->query($sql) && $deleteStudent ) {
		//Success updating students, now update grades table
		
		$sql = sprintf("
			DELETE
			FROM students 
			WHERE sid='%d'",
			$db->real_escape_string($_POST['sid'])
		);
		
		if ( $db->query($sql) ) {
			$db->commit(); //commit transaction
			redirect('/web214/db/db_view.php');
		}
	} elseif ( $db->query($sql) ) {
		$db->commit(); //commit transaction
		redirect('/web214/db/db_view.php');
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

<h1>Are you sure you want to delete this student?</h1>
<form method="post">
	<p>
		First name: <?php echo $_POST['first_name'];?>
	</p>
	<p>
		Last name: <?php echo $_POST['last_name']; ?>
	</label>
	<p>
		Grade: <?php echo $_POST['grade']; ?>
	</p>
	<p>
		<input name="cid" type="hidden" value="<?php echo $_POST['cid'];?>">
		<input name="sid" type="hidden" value="<?php echo $_POST['sid'];?>">
		<input type="submit" value="Delete Record">
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
