<?php

//BEGIN - ON EVERY PAGE TOP
$page_title = "View";
require_once("auth_check.php");
require_once("db_pwd.php"); //Creates a $db mysqli object and connects to DB
require_once("header.php");
//END - ON EVERY PAGE TOP


/* Select queries return a resultset */

$sql = sprintf("
	SELECT students.*,grade,letter,grades.cid,courses.longname
	FROM students 
	INNER JOIN grades ON grades.sid=students.sid
	INNER JOIN courses ON courses.cid=grades.cid
	INNER JOIN lettergrade ON lettergrade.start <= floor(grades.grade) AND lettergrade.end >= floor(grades.grade)
	ORDER BY %s
",isset($_GET['o']) ? $db->real_escape_string($_GET['o']) : 'last_name');

if ($result = $db->query($sql)) {
    if ( $result->num_rows > 0 ) {
        ?>
        <table>
            <thead>
            <th>Name</th>
            <th>Course</th>
            <th>Grade</th>
            <th>Letter</th>
            <?php if ( isAdmin() ) { ?>
                <th><a class="add" href="/web214/db/db_add.php">add</a></th>
            <?php } ?>
            </thead>
            <tbody>
            <?php
            while($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?=$row['first_name'];?> <?=$row['last_name'];?></td>
                    <td><?=$row['longname'];?></td>
                    <td><?=$row['grade'];?></td>
                    <td><?=$row['letter'];?></td>
                    <?php if ( isAdmin() ) { ?>
                        <td>
                            <a class="edit" href="/web214/db/db_edit.php?sid=<?=$row['sid'];?>&cid=<?=$row['cid'];?>">edit</a>
                            <a class="trash" href="/web214/db/db_delete.php?sid=<?=$row['sid'];?>&cid=<?=$row['cid'];?>">delete</a>
                        </td>
                    <?php } ?>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <?php
    } else { ?>
        No records yet
        <a class="add" href="/web214/db/db_add.php">add</a>
        <?php
    }
    /* free result set */
    mysqli_free_result($result);
} else {
    outputDBError($db);
}
$db->close();

//BEGIN - ON EVERY PAGE BOTTOM
require_once("footer.php");
//END - ON EVERY PAGE BOTTOM
?>
