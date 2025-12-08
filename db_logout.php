<?php

include("db_pwd.php");

session_start();

unset($_SESSION['user_num']);
unset($_SESSION['user_id']);
unset($_SESSION['level']);

header('Location: /web214/db', true, 302);


