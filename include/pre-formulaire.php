<?php 

include "header.php";
require "PHPMailer/class.phpmailer.php";

$link = mysqli_connect("localhost","root","motdepasselocalhostgwen","JobFinder") or die("Erreur de connexion à la BDD");


//Etudiant

if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email_e']) && isset($_POST['password_e'])) {
	if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email_e']) && !empty($_POST['password_e'])) {

		$statut = "En attente";
		
		extract($_POST);

		$random = str_shuffle("iampixofheavnandiownyou123456789");

		mysqli_query($link, "INSERT INTO Etudiant (Nom, Prenom, Email, Password, Statut, id_crypt) VALUES ('$nom', '$prenom', '$email_e', '$password_e', '$statut', '$random')") or die("Erreur lors de la requête");

	    
		// Mail envoyé à l'admin

	    $mail = new phpmailer();
	    $mail->FromName = "Inscription d'un étudiant";
	    $mail->Subject = "$nom - $prenom";

	    $body = "Les informations suivantes ont été enregistrées :\n\n\n
	    Nom :           $nom \n
	    Prenom :        $prenom \n
	    Email :         $email_e";

	    $mail->Body = $body;
	    $mail->AddAddress('pixofheaven@gmail.com');

	    if(!$mail->Send())
	        echo ('');
	    else
	        echo ('');


	    // Mail envoyé à l'étudiant

	    $mail = new phpmailer();
	    $mail->FromName = "Inscription sur JobFinder";
	    $mail->Subject = "$nom - $prenom";
	    $body = "Bonjour $prenom ! Merci de votre inscription sur notre site, vous pouvez dès à présent vous connecter avec l'adresse e-mail et le mot de passe que vous avez laissé lors de votre inscription :\n\n\n
	    Nom :           $nom \n
	    Prenom :        $prenom \n
	    Email :         $email_e";

	    $mail->Body = $body;

	    $mail->AddAddress('$email_e');

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

		$random = str_shuffle("iampixofheavnandiownyou123456789");

		mysqli_query($link, "INSERT INTO EntrepriseProfil (Nom, Prenom, Entreprise, Telephone, Email, Password, id_crypt) VALUES ('$nom', '$prenom', '$entreprise', '$telephone', '$email', '$password', '$random')") or die("Erreur lors de la requête");


		// Mail pour l'admin

	    $mail = new phpmailer();
	    $mail->FromName = "Inscription d'une entreprise";
	    $message->Subject = "$nom, $prenom - $entreprise";

	    $body = "Une entreprise s'est inscrite sur le site :\n\n\n
	    Nom :           $nom \n
	    Prenom :        $prenom \n
	    Nom de l'entreprise :        $entreprise \n
	    Numéro de téléphone :        $telephone \n
	    Email :         $email";

	    $mail->Body = $body;

	    $mail->AddAddress('pixofheaven@gmail.com');

	    if(!$mail->Send())
	        echo ('');
	    else
	        echo ('');


	    // Mail envoyé à l'entreprise

	    $mail = new phpmailer();
	    $mail->FromName = "Inscription sur JobFinder";
	    $message->Subject = "$nom, $prenom - $entreprise";

	    $body = "Bonjour $prenom et merci votre inscription sur notre site. Vous pouvez dès à présent vous connecter avec les identifiants que vous avez renseigné lors de votre inscription :\n\n\n
	    Nom :           $nom \n
	    Prenom :        $prenom \n
	    Nom de l'entreprise :        $entreprise \n
	    Numéro de téléphone :        $telephone \n
	    Email :         $email";

	    $mail->Body = $body;

	    $mail->AddAddress('$email');

	    if(!$mail->Send())
	        echo ('');
	    else
	        echo ('');


	}
}

?>