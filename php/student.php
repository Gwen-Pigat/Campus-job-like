<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link href='http://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/slider.js"></script>

<?php include "../include/connexion_etudiant.php"; include "lateral_etudiant.php";  ?>

<?php $row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Etudiant WHERE Email='$_SESSION[email_e]'")); ?>


<div class="container slide-profil">

<?php

// Création du compte + actualisation du statut

if (isset($_GET['maj_profil'])) { 
	if (empty($row['Sexe']) && empty($row['Etudes']) && empty($row['Ecole']) && empty($row['Specialisation']) && empty($row['Langues']) && empty($row['Recherche']) && empty($row['Lieu_importance']) && empty($row['Distance'])) { ?>

<title>Etudiant | Création d'un compte</title>

<h1 class="text-center"><strong><?php echo $row['Prenom']; ?></strong> ,création du compte</h1>

<form method="POST" action="student.php" class="creation_etudiant col-md-8 col-md-offset-2">

<p>Je m'appelle <input name="prenom" placeholder="Votre prénom" value=<?php echo $row['Prenom']; ?> required>
	<input name="nom" placeholder="Nom" value=<?php echo $row['Nom']; ?> required>
</p>

<p>Je suis 
	<select name="sexe" required>
		<option value="Homme">un homme</option>
		<option value="Femme">une femme</option>
	</select>
</p>

<p>Mon Niveau d'étude est <input name="etudes" placeholder="Bac +1 , +2 etc..." required></p>

<p>Je suis ma scolarité dans l'école <input name="ecole" placeholder="Ecole" required></p>

<p>Ma spécialisation est <input name="specialisation" placeholder="la science..." required></p>

<p>Je parle <input name="langues" placeholder="le francais" required>, Autre : <input name="langues_sup" placeholder="précisez"></p>

<p>Je cherche un 
	<select name="recherche" required>
		<option value="Un job">un job</option>
		<option value="Un stage">un stage</option>
	</select>, cherchez vous autre chose (en plus)
	<select name="recherche">
		<option value="Non">Non</option>
		<option value="Un job">Un job</option>
		<option value="Un stage">Un stage</option>
	</select>
</p>

<p>Le lieu du poste est-il important ? 
	<select name="lieu" required>
		<option value="Oui">Oui</option>
		<option value="Non">Non</option>
	</select>
</p>
	<p>Si oui, précisez la distance idéale : <input name="distance" placeholder="20km ou 100km max...">
</p>

<center>
<button class="btn btn-custom"><i class='fa fa-check fa-2x'></i></button>
</center>

</form>

<?php }


// La fiche du profil + la barre latérale seulement tout les champs ont été remplis

	else{ ?>

		<title>Etudiant | Votre profil</title>

		<h1 class="text-center"><strong><?php echo $row['Prenom']; ?></strong></h1>

<?php 

$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );


if (isset($_POST['upload'])){

	mkdir("../img/ProfilPicture/$row[id]-$row[id_crypt]", 0777, true);
	chmod("../img", 0777);
    
    $image_name = $_FILES['image']['name'];
    $image_type = $_FILES['image']['type'];
    $image_size = $_FILES['image']['size'];
    $image_tmp = $_FILES['image']['tmp_name'];

    $random = "img-profil-$row[id]-$row[id_crypt]";

    if ($image_name == "") {
        echo "<script>alert('Vous devez sélectionner une image !')</script>";
    }

    else{
        move_uploaded_file($image_tmp, "../img/ProfilPicture/$row[id]-$row[id_crypt]/$random.jpg");
        echo "<script>alert('Image mise à jour')</script>";
    }
}

 ?>

		<form class="profil_entreprise_logo col-md-12" action="" method="POST" enctype="multipart/form-data">
		    <label class="col-md-5 text-right">Votre logo :</label>
		    <?php echo "<img class='col-md-5' src=../img/ProfilPicture/$row[id]-$row[id_crypt]/img-profil-$row[id]-$row[id_crypt].jpg style='width: 25%'>"; ?><br>
		    <div class="col-md-5"></div>
		    <input class="btn col-md-5" type="file" name="image" size="25" value="test">
		     <div class="col-md-5"></div>
		    <input class="col-md-5" type="submit" name="upload" value="Envoyer">
		</form>

		<form method="POST" action="student.php" class="creation_etudiant col-md-8 col-md-offset-2">

		<p>Je m'appelle <input name="prenom" placeholder="Votre prénom" value="<?php echo $row[Prenom]; ?>" required>
			<input name="nom" placeholder="Nom" value="<?php echo $row[Nom]; ?>" required>
		</p>

		<p>Je suis 
			<select name="sexe" required>
				<option value="Homme">un homme</option>
				<option value="Femme">une femme</option>
			</select>
		</p>

		<p>Mon Niveau d'étude est <input name="etudes" placeholder="Bac +1 , +2 etc..." value="<?php echo $row[Etudes]; ?>" required></p>

		<p>Je suis ma scolarité dans l'école <input name="ecole" placeholder="Ecole" value="<?php echo $row[Ecole]; ?>" required></p>

		<p>Ma spécialisation est <input name="specialisation" placeholder="la science..." value="<?php echo $row[Specialisation]; ?>" required></p>

		<p>Je parle <input name="langues" placeholder="le francais" value="<?php echo $row[Langues]; ?>" required>, Autre : <input name="langues_sup" value="<?php echo $row[Langues_sup]; ?>" placeholder="précisez"></p>

		<p>Je cherche un 
			<select name="recherche" required>
				<option value="Un job">un job</option>
				<option value="Un stage">un stage</option>
			</select>, cherchez vous autre chose (en plus)
			<select name="recherche_sup">
				<option value="Non">Non</option>
				<option value="Un job">Un job</option>
				<option value="Un stage">Un stage</option>
			</select>
		</p>

		<p>Le lieu du poste est-il important ? 
			<select name="lieu" required>
				<option value="Oui">Oui</option>
				<option value="Non">Non</option>
			</select>
		</p>
			<p>Si oui, précisez la distance idéale : <input name="distance" placeholder="20km ou 100km max..." value="<?php echo $row[Distance]; ?>" />
		</p>

		<center>
		<button class="btn btn-custom"><i class='fa fa-check fa-2x'></i></button>
		</center>

		</form>

	<?php }
}

else{

	$row_1 = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM EntrepriseProfil WHERE Email='$row[Employeur]'"));

	$random = str_shuffle("iamrandomizer0123456789");

	if ($row['Statut'] == "En attente") {
		echo "<div class='redirection col-md-6 col-md-offset-3'><h3>Vous allez être redirigé afin de compléter votre profil</h3><br><i class='fa fa-refresh fa-spin fa-5x text-center'></i></div>";

		header("Refresh: 4; url=student.php?maj_profil=$row[id_crypt]");
	}

	elseif (isset($_GET['offer_list'])) {
	echo "<h1 class='text-center'>Liste des offres disponibles</h1>";

	$result = mysqli_query($link, "SELECT * FROM Offre");

		while ($row = mysqli_fetch_assoc($result)) {

			echo "<div class='col-md-4 offer_list'>
				<p><span class='user'>Employeur</span> : $row_1[Entreprise]<p>
				<p><span class='user'>Titre de l'offre</span> : $row[Titre]<p>
				<p><span class='user'>Remunéré</span> : $row[Remunere]<p>
				<p><span class='user'>Tâches</span> : $row[Taches]<p>
				<p><span class='user'>Qualifications requises</span> : $row[Qualifications]<p>
				<p><span class='user'>Compétences</span> : $row[Competences]<p><br>";
				$row_postulant = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Postulant WHERE id_offre='$row[id]' AND Postulant='$_SESSION[email_e]'"));
				if ($row_postulant == 0) {
				echo "<a href='student.php?$random&details=$row[id]'><button class='btn btn-success'>Postuler à cette offre</button></a>
				</div>";
				}
				else{
				echo "<button class='btn btn-danger'>Vous avez déja postulé à cette offre</button>
				</div>";	
				}
		}
	}

	elseif(isset($_GET['details'])){

		$row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Offre"));
		$row_user = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Etudiant"));

		echo "<div class='offer_submit container'>
	<img class='col-md-5' src=../img/user_default.png style='width: 50%'>
			<h1><span class='user'>$_SESSION[email]</span></h1>
			<p>L'annonce :</p><br>
			<p><span class='user'>Nom : </span>$row[Titre]<p>
			<p><span class='user'>Rémunération : </span>$row[Remunere]<p>
			<p><span class='user'>Les tâches : </span>$row[Taches]<p>
			<p><span class='user'>Qualifications : </span>$row[Qualifications]<p>
			<p><span class='user'>Compétences : </span>$row[Competences]<p>
	<form class='profil_entreprise_logo col-md-12' action='' method='POST' enctype='multipart/form-data'>
	    <label>Votre CV :</label><br>
	    <img src='../img/ProfilCV/CV-$row[id]-$row[id_crypt].pdf style='width: 25%'>
	    <input type='file' name='image' size='25' value='test'><br>
	    <input type='hidden' name='numero_offre' value='$_GET[details]'><br>
	    <input class='btn btn-success' type='submit' name='upload_cv' value='Envoyer'>
	</form>
</div>";

		if (isset($_POST['upload_cv']) && isset($_POST['numero_offre'])){

			mkdir("../img/ProfilCV/$row_user[id]-$row_user[id_crypt]", 0777, true);
			chmod("../img", 0777);
    
		    $image_name = $_FILES['image']['name'];
		    $image_type = $_FILES['image']['type'];
		    $image_size = $_FILES['image']['size'];
		    $image_tmp = $_FILES['image']['tmp_name'];

		    $random = "cv-profil-$row_user[id]-$row_user[id_crypt]";

		    if ($image_name == "") {
		        echo "<script>alert('Vous devez sélectionner un fichier valide !')</script>";
		    }

		    else{
		        move_uploaded_file($image_tmp, "../img/ProfilCV/$row_user[id]-$row_user[id_crypt]/$random.pdf");
		        echo "<div class='cv_submit col-md-6 col-md-offset-3'><h3>Envoi de votre CV</h3><br><i class='fa fa-refresh fa-spin fa-5x text-center'></i></div>";
		        header("Refresh: 2; url=student.php?confirmation=$_POST[numero_offre]");
		    }
		}
	}

	elseif (isset($_GET['confirmation'])) {

		$row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Etudiant WHERE Email='$_SESSION[email_e]'"));

		$row_postulant = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Postulant WHERE Postulant='$_SESSION[email_e]' AND id_offre='$_GET[confirmation]'"));
		$row_offre = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Offre WHERE id='$_GET[confirmation]'"));

		if ($row_postulant == 0) {

			$offre = $row['nbr_offre'] + 1;

		mysqli_query($link, "UPDATE Etudiant SET nbr_offre='$offre' WHERE Email='$_SESSION[email_e]'");

			echo "<div class='container'>
		<h1 class='text-center'>CV envoyé</h1>
		<h3>Votre CV à été envoyé et l'employeur le recevra par e-mail</h3><br>
		<i class='fa fa-refresh fa-spin fa-5x text-center'></i>
		</div>"; 
		mysqli_query($link, "INSERT INTO Postulant(Postulant,id_offre,Employeur) VALUES ('$_SESSION[email_e]','$_GET[confirmation]','$row_offre[Employeur]')");
		}

		else{
			echo "<div class='container'>
		<h1 class='text-center'>Erreur ! Il semblerait que votre CV ait déja été envoyé</h1>
		</div>"; 
		header("Refresh: 3; url=student.php");
		}

		
	}

	else{
		echo "<div class='redirection col-md-6 col-md-offset-3'><h3>Mise à jour</h3><br><i class='fa fa-refresh fa-spin fa-5x text-center'></i></div>";

		header("Refresh: 2; url=student.php?maj_profil=$row[id_crypt]");
	}
} 

?>

</div>

<?php

// Insertion des infos en BDD

if (isset($_POST) && isset($_POST['sexe']) && isset($_POST['etudes']) && isset($_POST['ecole'])&& isset($_POST['specialisation']) && isset($_POST['langues']) && isset($_POST['recherche']) && isset($_POST['lieu'])){
	if (!empty($_POST['sexe']) && !empty($_POST['etudes']) && !empty($_POST['ecole']) && !empty($_POST['specialisation']) && !empty($_POST['langues']) && !empty($_POST['recherche']) && !empty($_POST['lieu'])){

		extract($_POST);

		mysqli_query($link, "UPDATE Etudiant SET Prenom='$prenom', Nom='$nom', Statut='Validé', Sexe='$sexe', Etudes='$etudes', Ecole='$ecole', Specialisation='$specialisation', Langues='$langues', Langues_sup='$langues_sup', Recherche='$recherche', Recherche_sup='$recherche_sup', Lieu_importance='$lieu', Distance='$distance' WHERE Email='$_SESSION[email_e]'")or die("Erreur : ".mysqli_errno($link));
	}
}

include "../include/footer_profil.php"; ?>