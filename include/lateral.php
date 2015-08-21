<?php


// Barre latérale de l'employeur

if (isset($_GET) && isset($_GET['Profil_employeur']) && !isset($_GET['Profil_etudiant'])) {

$query = $link->query("SELECT * FROM EntrepriseProfil WHERE id_crypt='$_SESSION[employeur]'");
$row = $query->fetch_object();

if ($row->Statut_profil != "En attente") { ?>
<nav class="lateral">
	<div class="logo text-center">
		<?php $query = $link->query("SELECT * FROM EntrepriseProfil WHERE id_crypt='$_SESSION[employeur]'");
		$row = $query->fetch_object(); ?>
 <?php 

if(file_exists("Profil/Employeur/$row->id-$row->id_crypt/Img/img-profil-$row->id-$row->id_crypt.jpg")) {
 echo "<img src=Profil/Employeur/$row->id-$row->id_crypt/Img/img-profil-$row->id-$row->id_crypt.jpg>"; 
}
else{
 echo "<img src=img/user_default.png>"; 
}
 ?>
 <form class="profil_logo col-md-12" action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="image" size="25" value="test" accept=".jpg,.JPG,.jpeg,.JPEG">
        <input type="submit" name="upload" value="Envoyer">
    </form>

    <?php 

     if (isset($_POST['upload'])){
        
        mkdir("Profil/Employeur/$row->id-$row->id_crypt/Img", 0777, true);
        chmod("Profil", 0777);
        chmod("Profil/Employeur", 0777);
        chmod("Profil/Employeur/$row->id-$row->id_crypt", 0777);
        chmod("Profil/Employeur/$row->id-$row->id_crypt/Img", 0777);

        $image_name = $_FILES['image']['name'];
        $image_type = $_FILES['image']['type'];
        $image_size = $_FILES['image']['size'];
        $image_tmp = $_FILES['image']['tmp_name'];

        $lien = "Profil/Employeur/$row->id-$row->id_crypt/Img/img-profil-$row->id-$row->id_crypt.jpg";

        if ($image_name == "") {
            echo "<script>alert('Vous devez sélectionner une image !')</script>";
        }
        else{
            move_uploaded_file($image_tmp, $lien);
            echo "<script>alert('Image mise à jour')</script>";
            header("refresh: 0;url=index.php?Profil_employeur");
        }
    }

    ?>
 <br><br>
  </div>
	<ul class="nav nav-stacked span-hide">
		<?php echo "<a href='index.php?Profil_employeur'>" ?><li><i class="fa fa-user fa-2x"></i> <span class="lateral-aside">Mon profil</span></li></a>
		<?php echo "<a href='index.php?Profil_employeur&poster_offre'>" ?><li><i class="fa fa-plus-circle fa-2x"></i> <span class="lateral-aside">Poster une offre</span></li></a>
		<?php if ($row->Offres > 0) {
			  echo "<a href='index.php?Profil_employeur&liste_offres'>" ?><li><i class="fa fa-pencil-square-o fa-2x"></i> <span class="lateral-aside">Liste de mes offres</span></li></a>
		<?php } ?>
		<a href="include/logout.php"><li class="logout"><i class="fa fa-hand-o-left fa-2x"></i> <span class="lateral-aside">Déconnexion</span></li></a>
	</ul>
</nav>

<?php }

}


// Barre latérale étudiant

if (isset($_GET) && isset($_GET['Profil_etudiant']) && !isset($_GET['Profil_employeur'])) {


$query = $link->query("SELECT * FROM Etudiant WHERE id_crypt='$_SESSION[etudiant]'");
$row = $query->fetch_object();

if ($row->Statut_profil != "En attente") { ?>

<nav class="lateral">
	<div class="logo text-center">
		<?php $query = $link->query("SELECT * FROM Etudiant WHERE id_crypt='$_SESSION[etudiant]'");
		$row = $query->fetch_object(); ?>
 <?php 

if(file_exists("Profil/Etudiant/$row->id-$row->id_crypt/Img/img-profil-$row->id-$row->id_crypt.jpg")) {
 echo "<img src=Profil/Etudiant/$row->id-$row->id_crypt/Img/img-profil-$row->id-$row->id_crypt.jpg>"; 
}
else{
 echo "<img src=img/user_default.png>"; 
}
 ?>
 	<form class="profil_logo col-md-12" action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="image" size="25" value="test" accept=".jpg,.JPG,.jpeg,.JPEG">
        <input type="submit" name="upload_image" value="Envoyer">
    </form>

    <?php 

     if (isset($_POST['upload_image'])){
        
        mkdir("Profil/Etudiant/$row->id-$row->id_crypt/Img", 0777, true);
        chmod("Profil", 0777);
        chmod("Profil/Etudiant", 0777);
        chmod("Profil/Etudiant/$row->id-$row->id_crypt", 0777);
        chmod("Profil/Etudiant/$row->id-$row->id_crypt/Img", 0777);

        $image_name = $_FILES['image']['name'];
        $image_type = $_FILES['image']['type'];
        $image_size = $_FILES['image']['size'];
        $image_tmp = $_FILES['image']['tmp_name'];

        $lien = "Profil/Etudiant/$row->id-$row->id_crypt/Img/img-profil-$row->id-$row->id_crypt.jpg";

        if ($image_name == "") {
            echo "<script>alert('Vous devez sélectionner une image !')</script>";
        }

        if( !strstr($image_type, 'jpg') && !strstr($image_type, 'jpeg') && !strstr($image_type, 'bmp') && !strstr($image_type, 'gif')){
        echo "<script>alert(\"L'extension n'est pas valide, votre image doit obligatoirement être un fichier de type 'jpg'\")</script>";
        header("Refresh: 0; url=");
        }

        else{
            move_uploaded_file($image_tmp, $lien);
            echo "<script>alert('Image mise à jour')</script>";
            header("refresh: 0;url=index.php?Profil_etudiant");
        }
    }

    ?>
  </div>
	<ul class="nav nav-stacked span-hide">
		<?php echo "<a href='index.php?Profil_etudiant'>" ?><li><i class="fa fa-user fa-2x"></i> <span class="lateral-aside">Mon profil</span></li></a>
		<?php $query = $link->query("SELECT * FROM EntrepriseProfil");
				$row = $query->fetch_object();
				if ($row->Offres > 0) {
				echo "<a href='index.php?Profil_etudiant&liste_offres'>" ?><li><i class="fa fa-list fa-2x"></i> <span class="lateral-aside">Voir les offres</span></li></a>
				<?php } ?>
 				
					<a href="include/logout.php"><li class="logout"><i class="fa fa-hand-o-left fa-2x"></i> <span class="lateral-aside">Déconnexion</span></li></a>
	</ul>
</nav>

<?php } } ?>