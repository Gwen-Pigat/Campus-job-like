<?php include "../include/connexion_etudiant.php";

$row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Etudiant WHERE Email='$_SESSION[email_e]'"));

if ($row["Statut"] == "En attente") {
	echo "";
}

else{ ?>

<nav class="lateral">
	<div class="logo text-center">
		<?php $row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Etudiant WHERE Email='$_SESSION[email_e]'")); ?>
 <?php echo "<img src=../Profil/Etudiant/$row[id]-$row[id_crypt]/Img/img-profil-$row[id]-$row[id_crypt].jpg>"; ?><br><br>
  </div>
	<ul class="nav nav-stacked span-hide">
		<?php echo "<a href='student.php?maj_profil=$_SESSION[email_e]'><li><i class='fa fa-user fa-3x'></i> <span class='lateral-aside'>Mon profil</span></li></a>"; ?>
		<a href='student.php?offer_list'><li><i class="fa fa-list fa-3x"></i> <span class="lateral-aside">Offres disponibles</span></li></a>
		<a href="logout.php"><li class="logout"><i class="fa fa-hand-o-left fa-3x"></i> <span class="lateral-aside">Déconnexion</span></li></a>
	</ul>
</nav>

<?php } ?>