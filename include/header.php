<html>
<head>
	<title><?php echo $title; ?></title>
</head>
<body>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link href='http://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link rel="icon" href="img/icon.png" type="image/png" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jssor.slider.mini.js"></script>
<script type="text/javascript" src="js/slider.js"></script>


<?php 

$row_postulant = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Postulant WHERE Envoi='Non'"));
$row_offre = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Offre WHERE id='$row_postulant[id_offre]'"));
$row_etudiant = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Etudiant WHERE Email='$row_postulant[Postulant]'"));

 if ($row_postulant) {

 	echo "Variable du mail activé";

 	require 'PHPMailer/class.phpmailer.php';

     // Instantiate it
     $mail = new phpmailer();
     $mail->AddStringAttachment("../Profil/Etudiant/$row_etudiant[id]-$row_etudiant[id_crypt]/CV/CV-profil-$row_etudiant[id]-$row_etudiant[id_crypt]");
     $mail->AddStringAttachment("../Profil/Etudiant/$row_etudiant[id]-$row_etudiant[id_crypt]/Lettre_motivation/lettre-profil-$row_etudiant[id]-$row_etudiant[id_crypt]");

     // Define who the message is from
     $mail->FromName = "Postulant - Offre "."$row_offre[Titre]";

     // Set the subject of the message
     $mail->Subject = "L'étudiant $row_etudiant[Nom] $row_etudiant[Prenom] a postulé à une de vos offres ($row_offre[Titre]).\n
     Vous trouverez ci-desous, en pièce jointe, son CV asinsi que sa lettre de motivation.";

     //  the body of the message
     $body = "";
     // Add a recipient address
     $mail->AddAddress("$row[Employeur]");

     if(!$mail->Send())
         echo ('');
     else
         echo ('');
}



 ?>