<?php
session_start();
$_SESSION['username'] = 'testuser';
echo "Session set!";
?>