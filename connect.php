<?php

$host = 'localhost';
$user = 'root';
$pass = 'root';
$db = 'leaderboards';



// $host = 'localhost';
// $user = 'simondar_admin';
// $pass = 'NokiaN900$';
// $db = 'simondar_prizepigs';


//live settings, comment out during developemnt
/*
$host = 'mysql2.hosting.digiweb.ie';
$user = 'sidarcy_admin';
$pass = 'dallas81';
$db = 'sidarcy_prizepigs';
*/
//godaddy settings
/*
$host = 'localhost';
$user = 'pp_admin';
$pass = 'dallas81';
$db = 'prizepigs';
*/
$link = new mysqli($host, $user, $pass, $db) or die("Whoops, cannot connect to database");
?>