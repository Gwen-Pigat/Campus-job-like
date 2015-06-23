<meta charset="utf-8">

<title>inscription au site</title>

<?php 

include "include/connexion.php";

//Formulaire d'envoi d'une offre

if (isset($_GET["employeur"])) {

	if (isset($_POST) && isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["entreprise"]) && isset($_POST["email"]) && isset($_POST["telephone"]) && isset($_POST["password"])) {
		if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['entreprise']) && !empty($_POST['email']) && !empty($_POST['telephone']) && !empty($_POST['password'])) {
			
			$row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Entreprise WHERE Entreprise='$_POST[entreprise]' OR Telephone='$_POST[telephone]' OR Email='$_POST[email]'"));

			if ($row) {
			echo "<h1 class='text-center'>L'adresse e-mail, le téléphone ou le nom de l'entreprise est déja utilisée !!</h1>";
			header('Refresh: 5; url=index.php?Employeur');
			}

			else{

			include "include/pre-formulaire.php";

			$_SESSION['entreprise'] = $_POST['entreprise'];
			header('Location: php/job_submit.php');
			}	
		}
	}
}

else{

	if (isset($_POST) && isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["email"]) && isset($_POST["password"])) {
		if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['password'])) {

		header('Location: php/student.php');

		}
	}
}

?>