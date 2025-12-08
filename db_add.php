<?php

//BEGIN - ON EVERY PAGE TOP
$page_title = "Student Add";
require_once("auth_check.php");
require_once("db_pwd.php"); //Creates a $db mysqli object and connects to DB
require_once("header.php");
//END - ON EVERY PAGE TOP

if ( isAdmin() ) {

    if ( isset($_POST['first_name'] ) ) {

        //going to do something semi-advanced, going to do a transaction, which will rollback if something happens
        $db->autocommit(FALSE);

        $sql = sprintf("
            INSERT INTO students (first_name,last_name)
            VALUES ('%s','%s') 
        ",$db->real_escape_string($_POST['first_name']),$db->real_escape_string($_POST['last_name']));

        if ( $db->query($sql) ) {
            $sql = sprintf("
                INSERT INTO grades (sid,cid,grade)
                VALUES ('%d','%d','%f') 
            ",$db->insert_id,$db->real_escape_string($_POST['cid']),$db->real_escape_string($_POST['grade']));
            if ( $db->query($sql) ) {
                $db->commit(); //commit transaction
                //New records were added, so redirect user to the view page
                redirect('/web214/db/db_view.php');
            } else {
                outputDBError($db);
                $db->rollback(); //ROLLBACK transaction
            }
        } else {
            outputDBError($db);
        }

        $db->close();
    } else {
        $_POST['first_name'] = "";
        $_POST['last_name'] = "";
        $_POST['grade'] = "";
    }

    ?>

    <h1>Add Student</h1>
    <form method="post">
        <p>
            <label>
                Course:
                <select name="cid" required>
                    <?php
                        $sql = sprintf("
                            SELECT *
                            FROM courses
                            ORDER BY longname
                        ");
                        if ( $result = $db->query($sql) ) {
                            while($row = $result->fetch_assoc()) {
                                printf("<option value=\"%d\">%s</option>",$row['cid'],$row['longname']);
                            }
                        } else {
                            outputDBError($db);
                        }
                    ?>
                </select>
            </label>
        </p>
        <p>
            <label>
                First name:
                <input name="first_name" type="text" value="<?php echo $_POST['first_name'];?>" required>
            </label>
        <p>
            <label>
                Last name:
                <input name="last_name" type="text"  value="<?php echo $_POST['last_name'];?>" required>
            </label>
        </p>
        <p>
            <label>
                Grade:
                <input name="grade" type="number" min="0" max="100"  value="<?php echo $_POST['grade'];?>" step="0.01" required>
            </label>
        </p>
        <p>
            <input type="submit" value="Add Student">
        </p>
    </form>

    <?php
} else {
	echo "Invalid access!";
}
//BEGIN - ON EVERY PAGE BOTTOM
require_once("footer.php");
//END - ON EVERY PAGE BOTTOM