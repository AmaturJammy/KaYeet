<?php
require_once 'config.php';
$user = new User();
$user->logout();
header( 'Location: homePage.php' );
?>