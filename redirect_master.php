<meta charset="utf-8">

<title>Inscription au site</title>

<?php 

//Formulaire d'envoi d'une offre

if (isset($_GET["employeur"])) {

	if (isset($_POST) && isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["entreprise"]) && isset($_POST["email"]) && isset($_POST["telephone"]) && isset($_POST["password"])) {
		if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['entreprise']) && !empty($_POST['email']) && !empty($_POST['telephone']) && !empty($_POST['password'])) {
			
			$link = mysqli_connect("localhost","root","motdepasselocalhostgwen","JobFinder");
			$row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM EntrepriseProfil WHERE (Entreprise='$_POST[entreprise]' OR Telephone='$_POST[telephone]' OR Email='$_POST[email]')"));

			if ($row) {
			echo "<h1 class='text-center'>L'adresse e-mail, le téléphone ou le nom de l'entreprise est déja utilisée !!</h1>";
			header('Refresh: 5; url=index.php?Employeur');
			}

			else{

			include "include/pre-formulaire.php";

			session_start();

			$_SESSION['email'] = $_POST['entreprise'];
			header('Location: php/job_submit.php');
			}	
		}
	}
}

else{

	if (isset($_POST) && isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["email"]) && isset($_POST["password"])) {
		if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['password'])) {

		extract($_POST);
		$statut = "En attente";

		$link = mysqli_connect("localhost","root","motdepasselocalhostgwen","JobFinder");
		mysqli_query($link, "INSERT INTO Etudiant(Nom,Prenom,Email,Password,Statut) VALUES ('$nom', '$prenom', '$email', '$password', '$statut')");

		echo "<script>alert('Vous êtes inscrit sur la liste d'attente')</script>";

		header("Refresh: 1; url=index.php");

		}
	}
}

?>