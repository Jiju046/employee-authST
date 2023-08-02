<?php 

$hostName= "localhost";
$userName= "root";
$password= "root";
$dbName= "employee_auth";

$connection= new mysqli($hostName,$userName,$password,$dbName);

if ($mysqli -> connect_errno){
    die ("Failed to connect to database: $mysqli -> connect_error");
}