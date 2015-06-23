<?php 

session_start();

$link = mysqli_connect("localhost","root","motdepasselocalhostgwen","JobFinder");

if (empty($_SESSION['email'])) {
	header('Location: logout.php');	
}

if (isset($_POST) && isset($_POST['email']) && isset($_POST['password'])) {
	if (!empty($_POST['email']) && !empty($_POST['password'])) {
		
		$row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM EntrepriseProfil WHERE Email='$_POST[email]' AND Password='$_POST[password]'"));

		if ($row){
			$_SESSION['email'] = $row['Entreprise'];
			header('Location: ../php/job_submit.php');
		}

		else{ 
			header('Location: ../index.php?Employeur&erreur_connexion');	
		}
	}
}

 ?>