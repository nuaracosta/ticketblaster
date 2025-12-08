<?php

require_once("db_pwd.php");

?>
Tables
<ul>
<?php
	$res =$db->query("SHOW TABLES");
	while( $cRow = $res->fetch_array() )
	{
	    echo "<li>" . $cRow[0] . "</li>";
	}
	?>
</ul>
