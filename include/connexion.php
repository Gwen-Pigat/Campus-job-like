<?php 
session_start();
$link = new mysqli("localhost","root","motdepasselocalhostgwen","JobFinder");

if ($link->connect_errno) {
	print_f("Echec de la connexion: %s\n", $link->connect_error);
}

?>