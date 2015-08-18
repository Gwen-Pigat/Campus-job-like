<?php include '../include/connexion.php'; 

$query = $link->query("SELECT * FROM EntrepriseProfil WHERE id_crypt='$_SESSION[id]'");
$row = $query->fetch_object();

if ($row->Statut_profil != "En attente") { ?>
<nav class="lateral">
	<div class="logo text-center">
		<?php $query = $link->query("SELECT * FROM EntrepriseProfil WHERE id_crypt='$_SESSION[id]'");
		$row = $query->fetch_object(); ?>
 <?php 

if(file_exists("Profil/Employeur/$row->id-$row->id_crypt/Img/img-profil-$row->id-$row->id_crypt.jpg")) {
 echo "<img src=Profil/Employeur/$row->id-$row->id_crypt/Img/img-profil-$row->id-$row->id_crypt.jpg>"; 
}
else{
 echo "<img src=img/user_default.png>"; 
}
 ?>
 <br><br>
  </div>
	<ul class="nav nav-stacked span-hide">
		<?php echo "<a href='index.php?Profil_employeur'>" ?><li><i class="fa fa-user fa-3x"></i> <span class="lateral-aside">Mon profil</span></li></a>
		<?php echo "<a href='index.php?Profil_employeur&poster_offre'>" ?><li><i class="fa fa-plus-circle fa-3x"></i> <span class="lateral-aside">Poster une offre</span></li></a>
		<?php if ($row->Offres > 0) {
			  echo "<a href='index.php?Profil_employeur&liste_offres'>" ?><li><i class="fa fa-pencil-square-o fa-3x"></i> <span class="lateral-aside">Liste de mes offres</span></li></a>
		<?php } ?>
		<a href="include/logout.php"><li class="logout"><i class="fa fa-hand-o-left fa-3x"></i> <span class="lateral-aside">Déconnexion</span></li></a>
	</ul>
</nav>

<?php } ?>