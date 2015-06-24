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

<?php $row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Etudiant WHERE Prenom='$_SESSION[email_e]'")); ?>



<div class="container">

<?php

// Création du compte + actualisation du statut

if (isset($_GET['creation_profil'])) { ?>

<title>Etudiant | Création d'un compte</title>

<h1 class="text-center"><strong><?php echo $_SESSION['email_e']; ?></strong> ,création du compte</h1>


<form method="POST" action="student.php" class="creation_etudiant col-md-8 col-md-offset-2">

<p>Je m'appelle <input name="prenom" placeholder="Votre prénom" value=<?php echo $_SESSION['email_e']; ?> required>
	<input name="nom" placeholder="Nom" value=<?php echo $row['Nom']; ?> required>
</p>

<p>Je suis 
	<select name="sexe" required>
		<option value="Homme">Un homme</option>
		<option value="Femme">Une femme</option>
	</select>
</p>

<p>Mon Niveau d'étude est <input name="etudes" placeholder="Bac +1 , +2 etc..." required></p>

<p>Je suis ma scolarité dans l'école <input name="ecole" placeholder="Ecole" required></p>

<p>Ma spécialisation est <input name="specialisation" placeholder="la science, la physique appliquée..." required></p>

<p>Je parle <input name="langues" placeholder="le francais" required>, Autre : <input name="langues" placeholder="précisez"></p>

<p>Je cherche un 
	<select name="recherche" required>
		<option value="Un job">Un job</option>
		<option value="Un stage">Un stage</option>
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

else{

	if ($row['Statut'] == "En attente") {
		echo "<div class='redirection'><h3>Vous allez être redirigé afin de compléter votre profil</h3><br><i class='fa fa-refresh fa-spin fa-5x text-center'></i></div>";

		header("Refresh: 5; url=student.php?creation_profil=$_SESSION[email_e]");
	}

	else{

		echo "<h1 class='text-center'><strong>$_SESSION[email_e]</strong></h1><h3 class='text-center'>Votre profil</h3>"; ?>

		<p>Je m'appelle <input name="prenom" placeholder="Votre prénom" value=<?php if (empty($row['Prenom'])) { echo "Prénom"; } else{ echo $row['Prenom']; } ?> />
		<input name="nom" placeholder="Nom" value=<?php if (empty($row['Nom'])) { echo "Nom"; } else {echo $row['Nom']; } ?> /></p>

		<p>Je suis de sexe <select name="select"><option value="Homme">Masculin</option><option value="Femme">Feminin</option></select></p> 

		<p>Mon niveau d'étude est <input name="niveau" placeholder="Bac + 1, + 2 etc..." value=<?php if (empty($row['Etudes'])) { echo "Bac + 1, + 2 etc..."; } else{ echo $row['Etudes']; } ?> /></p>

		<p>Je suis ma scolarité dans l'école <input name="ecole" placeholder="nom de l'école" value=<?php if (empty($row['Ecole'])) { echo "Nom de l'école"; } else{ echo $row['Ecole']; } ?> /></p>

		<p>Ma spécialisation est <input name="specialisation" placeholder="Math, commerce..." value=<?php if (empty($row['Specialisation'])) { echo "ex : Commerce, science"; } else{ echo $row['Specialisation']; } ?> /></p>

		<p>Ma spécialisation est <input name="specialisation" placeholder="Math, commerce..." value=<?php if (empty($row['Specialisation'])) { echo "ex : Commerce, science"; } else{ echo $row['Specialisation']; } ?> /></p>


	

<?php } 

} 

?>

</div>


<?php

// Insertion des infos en BDD

if (isset ($_POST) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['sexe']) && isset($_POST['etudes']) && isset($_POST['ecole'])&& isset($_POST['specialisation']) && isset($_POST['langues']) && isset($_POST['recherche']) && isset($_POST['lieu'])){
	if (!empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['sexe']) && !empty($_POST['etudes']) && !empty($_POST['ecole']) && !empty($_POST['specialisation']) && !empty($_POST['langues']) && !empty($_POST['recherche']) && !empty($_POST['lieu'])){

		extract($_POST);

		$sql = "INSERT INTO Etudiant (Prenom,Nom,Statut) VALUES ('$prenom','$nom','En attente') WHERE Prenom='$_SESSION[email_e]'";

		mysqli_query($link, $sql) or die("Erreur");
	}
}

include "../include/footer_profil.php"; ?>