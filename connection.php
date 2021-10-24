<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "bikeattack";

$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if(!$con)
{
	echo("Wrong!");
	die("failed to connect!");
}
//else echo("Good");