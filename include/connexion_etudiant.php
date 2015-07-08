<?php

session_start();

$random = str_shuffle("azertyuiopmlkjhgfdsqwxcvbn0123456789");
$link = mysqli_connect("localhost","root","motdepasselocalhostgwen","JobFinder");

if (empty($_SESSION['email_e'])) {
			header('Location: ../php/logout.php');	
		}

if (isset($_POST) && isset($_POST['email_e']) && isset($_POST['password_e'])) {
	if (!empty($_POST['email_e']) && !empty($_POST['password_e'])) {
		
		$row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Etudiant WHERE Email='$_POST[email_e]' AND Password='$_POST[password_e]'"));
		$_SESSION['email_e'] = $row['Email'];

		if ($row){
			header('Location: ../php/student.php');
		}

		if (empty($_SESSION['email_e'])) {
			echo "<div class='redirection col-md-4 col-md-offset-4'><h1>Problème d'authentification</h1><br><i class='fa fa-refresh fa-spin fa-5x text-center'></i></div>";
			header("Refresh: 4; url=../php/logout.php");
		}

		else{ 
			echo "<div class='redirection col-md-4 col-md-offset-4'><h1>Problème d'authentification</h1><br><i class='fa fa-refresh fa-spin fa-5x text-center'></i></div>";
			header("Refresh: 4; url=../php/logout.php");
		}
	}
}


 ?>