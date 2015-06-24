<?php 

session_start();

$link = mysqli_connect("localhost","root","motdepasselocalhostgwen","JobFinder");

if (isset($_POST) && isset($_POST['email_e']) && isset($_POST['password_e'])) {
	if (!empty($_POST['email_e']) && !empty($_POST['password_e'])) {
		
		$row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Etudiant WHERE Email='$_POST[email_e]' AND Password='$_POST[password_e]'")or die("Erreur : ".mysql_error()));

		echo "<h1>$row[Prenom]</h1>";

		if ($row){
			header('Location: ../php/student.php');
		}

		if (empty($_SESSION['email_e'])) {
			header('Location: ../php/logout.php');
		}

		else{ 
			header('Location: ../php/logout.php');	
		}
	}
}

header('Refresh: 600; url=../php/logout.php');

 ?>