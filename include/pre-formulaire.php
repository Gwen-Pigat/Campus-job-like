<?php 

include "header.php";
require "PHPMailer/class.phpmailer.php";

$link = mysqli_connect("localhost","root","motdepasselocalhostgwen","JobFinder") or die("Erreur de connexion à la BDD");


//Etudiant

if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['password'])) {
	if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['password'])) {

		$statut = "En attente";
		
		extract($_POST);

		mysqli_query($link, "INSERT INTO Etudiant (Nom, Prenom, Email, Password, Statut) VALUES ('$nom', '$prenom', '$email', '$password', '$statut')") or die("Erreur lors de la requête");

	    // Instantiate it
	    $mail = new phpmailer();

	    // Define who the message is from
	    $mail->FromName = "Inscription d'un étudiant";

	    // Set the subject of the message
	    $mail->Subject = "$nom - $prenom";

	    // Add the body of the message
	    $body = "Les informations suivantes ont été enregistrées :\n\n\n
	    Nom :           $nom \n
	    Prenom :        $prenom \n
	    Email :         $email";

	    $mail->Body = $body;

	    // Add a recipient address
	    $mail->AddAddress('pixofheaven@gmail.com');

	    if(!$mail->Send())
	        echo ('');
	    else
	        echo ('');
	}
}



//Employeur

if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['entreprise']) && isset($_POST['telephone']) && isset($_POST['email']) && isset($_POST['password'])) {
	if (!empty($_POST['nom']) && !empty($_POST['prenom']) && isset($_POST['entreprise']) && isset($_POST['telephone']) && !empty($_POST['email']) && !empty($_POST['password'])) {

		extract($_POST);

		mysqli_query($link, "INSERT INTO EntrepriseProfil (Nom, Prenom, Entreprise, Telephone, Email, Password) VALUES ('$nom', '$prenom', '$entreprise', '$telephone', '$email', '$password')") or die("Erreur lors de la requête");

	    // Instantiate it
	    $mail = new phpmailer();

	    // Define who the message is from
	    $mail->FromName = "Inscription d'une entreprise";

	    // Set the subject of the mail
	    $message->Subject = "$nom, $prenom - $entreprise";

	    // Add the body of the message
	    $body = "Une entreprise s'est inscrite sur le site :\n\n\n
	    Nom :           $nom \n
	    Prenom :        $prenom \n
	    Nom de l'entreprise :        $entreprise \n
	    Numéro de téléphone :        $telephone \n
	    Email :         $email";

	    $mail->Body = $body;

	    // Add a recipient address
	    $mail->AddAddress('pixofheaven@gmail.com');

	    if(!$mail->Send())
	        echo ('');
	    else
	        echo ('');

	}
}

?>