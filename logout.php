<?php
session_start();

//Remove session variables
session_unset();

//Kill the session
session_destroy();

//Send back to index page
header("Location: index.php");
exit();
?>