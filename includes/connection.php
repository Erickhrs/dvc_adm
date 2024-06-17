<?php
$user = 'root';
$psw = ''; 
$database = "dvcdb"; 
$host = 'localhost';

$mysqli = new mysqli($host, $user, $psw, $database);

if ($mysqli->error){
    die("Falha ao conectar ao banco de dados: " . $mysqli->error);
}