<?php include "../include/connexion_etudiant.php";

$row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Etudiant WHERE Email='$_SESSION[email_e]'"));

if ($row["Statut"] == "En attente") {
	echo "";

}

else{ ?>

<nav class="lateral">
	<div class="logo text-center">
		<i class="fa fa-times fa-5x"></i>
  </div>
	<ul class="nav nav-stacked span-hide">
		<?php echo "<a href='job_submit.php'>" ?><li><i class="fa fa-user fa-3x"></i> <span class="lateral-aside">Mon profil</span></li></a>
		<?php echo "<a href='offre_submit.php?poste_offre=$_SESSION[email]'>" ?><li><i class="fa fa-plus-circle fa-3x"></i> <span class="lateral-aside">Poster une offre</span></li></a>
		<?php echo "<a href='offre_submit.php?liste_offres=$_SESSION[email]'>" ?><li><i class="fa fa-pencil-square-o fa-3x"></i> <span class="lateral-aside">Liste de mes offres</span></li></a>
		<a href="logout.php"><li class="logout"><i class="fa fa-hand-o-left fa-3x"></i> <span class="lateral-aside">Déconnexion</span></li></a>
	</ul>
</nav>

<?php } ?>