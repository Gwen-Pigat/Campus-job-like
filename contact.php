
<?php $title = "JobFinder | Formulaire de contact"; include "include/header.php"; include "include/carousel.php"; ?>

<section class="social-media">
<a href=""><i class="fa fa-facebook-square fa-3x"></i></a>
<a href=""><i class="fa fa-linkedin-square fa-3x"></i></a>
<a href=""><i class="fa fa-twitter-square fa-3x"></i></a>
<a href=""><i class="fa fa-youtube-square fa-3x"></i></a>
</section>

<div class="categorie">
	<a href="index.php?Etudiant"><button class='btn-login'>Accueil</button></a>
</div>

<div class='container text-center'>
	<div class="logo">
	  <img src="img/icon.png"><br>
	  <span class='title'>SpeedJob</span>
  	</div>

<form class="contact col-md-12" method="POST" action="">
	<h1>Formulaire de contact</h1>
	<select name="select" required>
		<option value="Emloyeur">Employeur</option>
		<option value="Etudiant">Etudiant</option>
		<option value="Autre">Autre</option>
	</select>
<input type="text" placeholder="Votre nom *" name="prenom" required>
<input type="email" placeholder="Votre adresse e-mail *" name="email" required><br>
<textarea rows="5" cols="50" name="message" placeholder="Ecrivez votre message ici" name="message" required></textarea>
<br><br>
<button type="submit" class="btn btn-danger"><i class=" fa fa-envelope"></i> Envoyer</button>
</form>
</div>

<?php 


//Enregistrement en BDD

extract($_POST);

if (isset($_POST) && isset($select) && isset($prenom) && isset($email) && isset($message) && !empty($select) && !empty($prenom) && !empty($email) && !empty($message)) {
		
	$link = new mysqli("localhost","root","motdepasselocalhostgwen","JobFinder");

	$link->query("INSERT INTO Contact(Type,Nom,Email,Message) VALUES ('$select' ,'$prenom' ,'$email' ,'$message')")or die(mysqli_errno());

	echo "<script>alert(\"Message envoyé !!\")</script>";
	// header("refresh: 0;url=contact.php");

	require "PHPMailer/class.phpmailer.php";

	//Envoi des données par mail

    // Envoi à l'admin
    $mail = new phpmailer();

    // Define who the message is from
    $mail->From = str_shuffle(0123456789);
    $mail->FromName = 'Question - JobFinder ';

    // Set the subject of the message
    $mail->Subject = "$select $prenom vous pose une question";

    // Add the body of the message
    $body = "Une personne est passé par le formulaire de contact de JobFinder :\n\n\n
    Statut (Etudiant/Employeur ou autre) : $select \n
    Son nom : $prenom \n
    Son Message :\n     $message";

    $mail->Body = $body;

    // Add a recipient address
    $mail->AddAddress('pixofheaven@gmail.com');

    if(!$mail->Send())
        echo ('');
    else
        echo ('');


    // Envoi à l'utilisateur
    $mail = new phpmailer();

    // Define who the message is from
    $mail->From = str_shuffle(0123456789);
    $mail->FromName = 'Question - JobFinder ';

    // Set the subject of the message
    $mail->Subject = "$select $prenom";

    // Add the body of the message
    $body = "Nous avons bien recu votre demande et celle-ci sera traitée dans les plus brefs délais :\n\n\n
    Votre statut (Etudiant/Employeur ou autre) : $select \n
   	Votre nom : $prenom \n
    Votre message :\n     $message";

    $mail->Body = $body;

    // Add a recipient address
    $mail->AddAddress($email);

    if(!$mail->Send())
        echo ('');
    else
        echo ('');
}

else
	{
		echo"<script>alert(\"Erreur lors de l'envoi de votre message !!\")"; 
	}


?>