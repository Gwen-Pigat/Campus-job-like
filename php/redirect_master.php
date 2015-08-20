<?php include "../include/connexion.php";

$random = (sha1($_SERVER['REMOTE_ADDR']).sha1(str_shuffle(0123456789)));

extract($_POST);


// Connexion employeur
if (!isset($_GET['inscription']) && !isset($_GET['password_request']) && isset($_POST) && isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
		
	$query = $link->query("SELECT * FROM EntrepriseProfil WHERE Email='$_POST[email]' AND Password='$_POST[password]'");
	$row = $query->fetch_object();

	if ($row){
		$_SESSION['employeur'] = $row->id_crypt;
		header("Location: ../index.php?Profil_employeur");
	}
	else{ 
		header("Location: ../index.php?Employeur&erreur_connexion=$random");	
	}
}

// Connexion étudiant
elseif (!isset($_GET['inscription']) && !isset($_GET['password_request']) && isset($_POST) && isset($_POST['email_e']) && isset($_POST['password_e']) && !empty($_POST['email_e']) && !empty($_POST['password_e'])) {
		
	$query = $link->query("SELECT * FROM Etudiant WHERE Email='$_POST[email_e]' AND Password='$_POST[password_e]'");
	$row = $query->fetch_object();

	if ($row){
		$_SESSION['etudiant'] = $row->id_crypt;
		header("Location: ../index.php?Profil_etudiant");
	}
	else{ 
		header("Location: ../index.php?Etudiant&erreur_connexion=$random");	
	}
}


// Inscription Employeur
elseif (isset($_GET["inscription"]) && !isset($_GET['password_request']) && isset($nom) && isset($prenom) && isset($entreprise) && isset($telephone) && isset($email) && isset($password) && !empty($nom) && !empty($prenom) && !empty($entreprise) && !empty($telephone) && !empty($email) && !empty($password)) {
		
	// On vérifie que l'adresse e-mail ou le téléphone n'est pas déja utilisé
	$query = $link->query("SELECT * FROM EntrepriseProfil WHERE Telephone='$telephone' || Email='$email'"); $row = $query->fetch_object();
	$query = $link->query("SELECT * FROM Etudiant WHERE Email='$email'"); $row_etudiant = $query->fetch_object();

	if ($row == 0 && $row_etudiant == 0){

		// On insère les données du formulaire en BDD
		$link->query("INSERT INTO EntrepriseProfil(Nom,Prenom,Entreprise,Telephone,Email,Password,id_crypt,Statut_profil) VALUES ('$nom','$prenom','$entreprise','$telephone','$email','$password','$random','En attente')")or die("Erreur du query");

		// On selectionne les valeurs que l'on vient d'inscrire afin de créer une session à partir de l'objet id_crypt
		$query = $link->query("SELECT * FROM EntrepriseProfil WHERE Nom='$nom' AND Prenom='$prenom' AND Entreprise='$entreprise' AND Telephone='$telephone' AND Email='$email' AND Password='$password'");
		$row = $query->fetch_object();
		$_SESSION['employeur'] = $row->id_crypt;
		header("Location: ../index.php?Profil_employeur");
	}
	else{ 
		header("Location: ../index.php?Employeur&erreur_inscription=$random");	
	}
}


// Inscription Etudiant
elseif (isset($_GET["inscription"]) && !isset($_GET['password_request']) && isset($nom) && isset($prenom) && isset($email_e) && isset($password_e) && !empty($nom) && !empty($prenom) && !empty($email_e) && !empty($password_e)) {
		
	// On vérifie que l'adresse e-mail n'est pas déja utilisée
	$query = $link->query("SELECT * FROM Etudiant WHERE Email='$email_e'"); $row = $query->fetch_object();
	$query = $link->query("SELECT * FROM EntrepriseProfil WHERE Email='$email_e'"); $row_employeur = $query->fetch_object();

	if ($row == 0 && $row_employeur == 0){

		// On insère les données du formulaire en BDD
		$link->query("INSERT INTO Etudiant(Nom,Prenom,Email,Password,id_crypt,Statut_profil) VALUES ('$nom','$prenom','$email_e','$password_e','$random','En attente')")or die("Erreur du query");

		// On selectionne les valeurs que l'on vient d'inscrire afin de créer une session à partir de l'objet id_crypt
		$query = $link->query("SELECT * FROM Etudiant WHERE Nom='$nom' AND Prenom='$prenom' AND Email='$email_e' AND Password='$password_e'");
		$row = $query->fetch_object();
		$_SESSION['etudiant'] = $row->id_crypt;
		header("Location: ../index.php?Profil_etudiant");

	}
	else{ 
		header("Location: ../index.php?Etudiant&erreur_inscription=$random");	
	}
}



// Demande d'envoi de mot de passse




else{
	// echo "FALSE";
	header("Location: ../include/logout.php");
}



 ?>