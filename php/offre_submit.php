<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link href='http://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/slider.js"></script>

<?php 

include "lateral.php"; include "../include/connexion.php"; 


if (isset($_GET) && isset($_GET['poste_offre'])) { 
	$date = date("d/m/Y_H:i:s");
	
	?>

	<div class="container">

	<h1 class="text-center"><span><strong><?php echo $_SESSION['email']; ?></strong></span><br>- Poster une offre -</h1>

	<form class="profil_entreprise col-md-12" action=<?php echo "offre_submit.php?offre=$_SESSION[email]&date=$date" ?> method="POST">
	<label class="col-md-5 text-right" for="offre_name">Titre de l'offre <span>*</span></label>
	<input class="col-md-5" type="text" name="offre_name" required>

	<label class="col-md-5 text-right" for="remuneration">Cette offre est-elle rémunerée ? <span>*</span></label>
	<select class="col-md-5" type="text" name="remuneration" required>
	<option value="" label="Default"></option>	
	<option value="Oui" label="Alternative Medicine">Oui</option>
	<option value="Non" label="Animation">Non</option>
	</select>

	<label class="col-md-5 text-right" for="date">Date de début </label>
	<input class="col-md-5 fa fa-calendar" type="date" name="date" style="height: 41px">

	<label class="col-md-5 text-right" for="tasks">Tâches à effectuées</label>
	<input class="col-md-5" type="text" name="tasks">

	<label class="col-md-5 text-right" for="qualifications">Qualifications exigées <span>*</span></label>
	<textarea rows="3" class="col-md-5" name="qualifications" required></textarea>

	<label class="col-md-5 text-right" for="competences">Compétences désirées <span>*</span></label>
	<textarea rows="10" class="col-md-5" name="competences" required></textarea>

	<div class="col-md-5"></div>
	<button class="col-md-2 send" type="submit"><i class="fa fa-envelope fa-2x"></i> Sauvegarder</button>

	</form>

	</div>

<?php } ?>
<?php


//Ajout d'une offre

extract($_POST);

if (isset($_GET) && isset($_GET['offre'])) {

	$ajout = date("Y-m-d H:i:s");

	mysqli_query($link, "INSERT INTO Offre(Employeur,Titre,Remunere,Debut,Taches,Qualifications,Competences, Ajout) VALUES ('$_SESSION[email]','$offre_name','$remuneration','$date','$tasks','$qualifications','$competences', '$ajout')");
	echo "<div class='offer_submit container'>
	<img class='col-md-5' src=../img/ProfilPicture/img-profil-$row[id]-$_SESSION[email].jpg style='width: 50%'>
			<h1><span class='user'>$_SESSION[email]</span></h1>
			<p>Résumé de votre anonce :</p><br>
			<p><span class='user'>Nom : </span>$offre_name<p>
			<p><span class='user'>Rémunération : </span>$remuneration<p>
			<p><span class='user'>Les tâches : </span>$tasks<p>
			<p><span class='user'>Qualifications : </span>$qualifications<p>
			<p><span class='user'>Compétences : </span>$competences<p>
		  </div>
		  <br>";

		  $row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Offre WHERE Employeur='$_SESSION[email]' AND Titre='$offre_name' AND Ajout='$ajout'"));

		  echo "<center><a href='offre_submit.php?validation_offre=$row[id]&employeur=$_SESSION[email]'><button class='btn btn-custom'><i class='fa fa-check'></i> Valider</button></a></center>";
} 


// Validation de l'offre

if (isset($_GET) && isset($_GET['validation_offre']) && isset($_GET['employeur'])) {
	if (!empty($_GET['validation_offre']) && !empty($_GET['employeur']))
		mysqli_query($link, "UPDATE Offre SET Statut='Validé' WHERE Employeur='$_SESSION[email]' AND id='$_GET[validation_offre]'");

		$row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM EntrepriseProfil WHERE Entreprise='$_SESSION[email]'"));

		$add = $row['Offres'] + 1;
		mysqli_query($link, "UPDATE EntrepriseProfil SET Offres='$add' WHERE Entreprise='$_SESSION[email]'");

	echo "<div class='container'>
	<img class='col-md-5' src=../img/ProfilPicture/img-profil-$row[id]-$_SESSION[email].jpg style='width: 25%'><br>
	<h1 class='user'>$_SESSION[email]</h1>
	<h3>Votre offre à bien été validé, cliquez <a class='user' href='offre_submit.php?liste_offres=$_SESSION[email]'>ici</a> pour y accèder</h3>
	</div>";

}


// Liste de mes offres

if (isset($_GET) && isset($_GET['liste_offres'])) {
	$result = mysqli_query($link, "SELECT * FROM Offre WHERE Employeur='$_SESSION[email]' AND Statut='Validé'");  ?>

	<div class="container">
	<?php echo "<span class='poster text-center'><a href='offre_submit.php?poste_offre=$_SESSION[email]'>Poster une offre</a></span>"; ?>
	<h1 class="text-center" style="margin-top: 5%; font-family: Inconsolata"><strong><?php echo $_SESSION['email']; ?></strong><br>Liste de vos offres</h1> 

<?php

//Boucle qui liste les offres disponibles sur le profil (seulement celles au statut 'Accepté')

	while ($row = mysqli_fetch_assoc($result)) {
		echo "<div class='col-md-4 offer_list'>
			<a href='offre_submit.php?remove=$row[id]'><span class='remove btn btn-info'><i class='fa fa-times'></i></span></a>
			<p><span class='user'>Titre de l'offre</span> : $row[Titre]<p>
			<p><span class='user'>Boulot payant</span> : $row[Remunere]<p>
			<p><span class='user'>Date d'ajout</span> : $row[Ajout]<p>
			<p><span class='user'>Tâches à effectuer</span> : $row[Taches]<p>
			<p><span class='user'>Qualifications requises</span> : $row[Qualifications]<p>
			<p><span class='user'>Compétences</span> : $row[Competences]<p>
			</div>";
	}
}

//Retirer une offre

if (isset($_GET) && isset($_GET['remove'])) {
	mysqli_query($link, "DELETE FROM Offre WHERE id='$_GET[remove]'");

	$row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM EntrepriseProfil WHERE Entreprise='$_SESSION[email]'"));
	$remove = $row['Offres'] - 1;

	mysqli_query($link, "UPDATE EntrepriseProfil SET Offres='$remove' WHERE Entreprise='$_SESSION[email]'");

	header("Location: offre_submit.php?liste_offres=$_SESSION[email]");
}

?>
</div>
<section class="contact_us text-center col-md-12" style="margin-top: 15%">
 <h1>Des questions ? <a href="contact.php">Contactez-nous</a></h1>

 <div class="social">
        <ul class="social-list">
            <li>
                <a href="https://www.linkedin.com/company/5304501?trk=prof-0-ovw-curr_pos" target="_blank">
                    <i class="fa fa-linkedin-square fa-5x"></i>
                </a>
            </li>
            <li>
                <a href="https://facebook.com/thecampusjob" target="_blank">
                    <i class="fa fa-facebook-square fa-5x"></i>
                </a>
            </li>
            <li>
                <a href="https://twitter.com/thecampusjob" target="_blank">
                    <i class="fa  fa-twitter-square fa-5x"></i>
                </a>
            </li>
            <li>
                <a target="_blank" href="https://www.youtube.com/user/thecampusjob">
                    <i class="fa fa-youtube-square fa-5x"></i>
                </a>
            </li>
        </ul>
    </div>

</section>