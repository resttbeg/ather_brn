<?php
session_start();
$_SESSION = [];
session_destroy();
header("Location: admin des messages-commandes.php");
exit;
?>
