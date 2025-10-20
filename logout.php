<?php
session_start();
session_regenerate_id(true);
// $_SESSION['logged'] = "0";
// $_SESSION['role'] = "";
session_destroy();
header("location:./");
?>