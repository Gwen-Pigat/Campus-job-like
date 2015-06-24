<meta charset="utf-8">

<title>Inscription au site</title>

<?php 

session_start();

$_SESSION['email'] = $_POST['entreprise'];

// Inscription employeur

	if (isset($_POST) && isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["entreprise"]) && isset($_POST["email"]) && isset($_POST["telephone"]) && isset($_POST["password"])) {
		if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['entreprise']) && !empty($_POST['email']) && !empty($_POST['telephone']) && !empty($_POST['password'])) {
			
			$link = mysqli_connect("localhost","root","motdepasselocalhostgwen","JobFinder");
			$row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM EntrepriseProfil WHERE (Entreprise='$_POST[entreprise]' OR Telephone='$_POST[telephone]' OR Email='$_POST[email]')"));

			if ($row) {
			echo "<h1 class='text-center'>L'adresse e-mail, le téléphone ou le nom de l'entreprise est déja utilisée !!</h1>";
			header('Refresh: 2; url=index.php?Employeur');
			}

			else{

			include "include/pre-formulaire.php";

			header('Location: php/job_submit.php');
			}	
		}
	}



$_SESSION['email_e'] = $_POST['prenom'];

// Inscription étudiant

	if (isset($_POST) && isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["email_e"]) && isset($_POST["password_e"])) {
		if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email_e']) && !empty($_POST['password_e'])) {

		extract($_POST);
		$statut = "En attente";

		$link = mysqli_connect("localhost","root","motdepasselocalhostgwen","JobFinder");
		$row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Etudiant WHERE Email='$_POST[email_e]'"));

			if ($row){
				echo "<h1>L'adresse e-mail est déja utilisée !!</h1>";
				header('Refresh: 2; url=index.php');
			}	
			else{

			include "include/pre-formulaire.php";

			header("Location: php/student.php");
			}
		}
	}

?>