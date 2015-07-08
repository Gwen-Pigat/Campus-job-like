<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link href='http://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/slider.js"></script>



<?php include "lateral.php"; include "../include/connexion.php"; ?>

<?php $row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM EntrepriseProfil WHERE Email='$_SESSION[email]'")); ?>

<title><?php echo $row['Entreprise']; ?></title>

<div class="container">

<h1 class="text-center" style="margin-top: 5%; font-family: Inconsolata">Profil de <strong><?php echo $row['Entreprise']; ?></strong></h1>

<?php 

if (isset($_POST['upload'])){
    
    mkdir("../Profil/Employeur/$row[id]-$row[id_crypt]/Img", 0777, true);
    chmod("../Profil", 0777);
    
    $image_name = $_FILES['image']['name'];
    $image_type = $_FILES['image']['type'];
    $image_size = $_FILES['image']['size'];
    $image_tmp = $_FILES['image']['tmp_name'];

    $lien = "../Profil/Employeur/$row[id]-$row[id_crypt]/Img/img-profil-$row[id]-$row[id_crypt].jpg";

    if ($image_name == "") {
        echo "<script>alert('Vous devez sélectionner une image !')</script>";
    }

    else{
        move_uploaded_file($image_tmp, $lien);
        echo "<script>alert('Image mise à jour')</script>";
    }
}

 ?>

<form class="profil_entreprise_logo col-md-12" action="" method="POST" enctype="multipart/form-data">
    <label class="col-md-5 text-right">Votre logo :</label>
    <?php echo "<img class='col-md-5' src=../Profil/Employeur/$row[id]-$row[id_crypt]/Img/img-profil-$row[id]-$row[id_crypt].jpg style='width: 25%'>"; ?><br>
    <div class="col-md-5"></div>
    <input class="btn col-md-5" type="file" name="image" size="25" value="test">
     <div class="col-md-5"></div>
    <input class="col-md-5" type="submit" name="upload" value="Envoyer">
</form>

<form class="profil_entreprise col-md-12" action="job_submit.php" method="POST">

<label class="col-md-5 text-right" for="entreprise_name">Nom de l'entreprise <span>*</span></label>
<input class="col-md-5" name="entreprise_name" value="<?php echo $row[Entreprise]; ?>" />

<label class="col-md-5 text-right" for="secteur">Secteur d'activité <span>*</span></label>
<input class="col-md-5" name="secteur" value="<?php echo $row[Secteur]; ?>" />

<label class="col-md-5 text-right" for="entreprise_site">Site de l'entreprise</label>
<input class="col-md-5" type="text" name="entreprise_site" value=<?php echo $row['Site'] ?> />

<label class="col-md-5 text-right" for="qui_sommes_nous">Qui sommes-nous ? <span>*</span></label>
<textarea rows="10" class="col-md-5" name="qui_sommes_nous"><?php echo $row['Description']; ?></textarea>

<label class="col-md-5 text-right" for="nombre_employers">Nombre d'employers <span>*</span></label>
<input class="col-md-5" type="number" name="nombre_employers" value=<?php echo $row['Employers']; ?> />

<div class="col-md-5"></div>
<button class="col-md-2 send" type="submit"><i class="fa fa-envelope fa-2x"></i> Sauvegarder</button>

</form>

</div>

<?php

//Mise a jour du profil

require '../PHPMailer/class.phpmailer.php';

if (isset($_POST['entreprise_name']) || isset($_POST['entreprise_site']) || isset($_POST['secteur']) || isset($_POST['qui_sommes_nous']) || isset($_POST['nombre_employers'])) {
	if(!empty($_POST['entreprise_name']) || !empty($_POST['entreprise_site']) || !empty($_POST['secteur']) || !empty($_POST['qui_sommes_nous']) || !empty($_POST['nombre_employers'])){

		extract($_POST);

		mysqli_query($link, "UPDATE EntrepriseProfil SET Entreprise='$entreprise_name', Secteur='$secteur', Site='$entreprise_site', Description='$qui_sommes_nous', Employers='$nombre_employers' WHERE Email='$_SESSION[email]'");
        mysqli_query($link, "UPDATE Offre SET Employeur='$entreprise_name' WHERE Entreprise='$row[Entreprise]'"); ?>

		<script type="text/javascript">
			$(document).ready(function(){
				alert("Votre profil à bien été mis à jour");
			});
		</script>
<?php 
		header('Refresh: 0 ;job_submit.php');
	}
}

include "../include/footer_profil.php";