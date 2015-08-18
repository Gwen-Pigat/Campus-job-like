<?php 

extract($_POST);

if (!isset($_GET['poster_offre']) && !isset($_GET['validation_offre'])) {

    if (empty($_SESSION)) {
        header("Location: index.php?Employeur");
    }

$query = $link->query("SELECT * FROM EntrepriseProfil WHERE id_crypt='$_SESSION[id]'"); 
$row = $query->fetch_object(); 

?>

<div class="container">

<h1 class="text-center" style="margin-top: 5%; font-family: Inconsolata">Profil de <strong><?php echo $row->Entreprise; ?></strong></h1>

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
        }
    }

     ?>

    <form class="profil_entreprise_logo col-md-12" action="" method="POST" enctype="multipart/form-data">
        <label class="col-md-5 text-right">Votre logo :</label>
        <?php echo "<img class='col-md-5' src=Profil/Employeur/$row->id-$row->id_crypt/Img/img-profil-$row->id-$row->id_crypt.jpg style='width: 25%'>"; ?><br>
        <div class="col-md-5"></div>
        <input class="btn col-md-5" type="file" name="image" size="25" value="test">
         <div class="col-md-5"></div>
        <input class="col-md-5" type="submit" name="upload" value="Envoyer">
    </form>

    <form class="profil_entreprise col-md-12" action="index.php?Profil_employeur" method="POST">

    <label class="col-md-5 text-right" for="entreprise_name">Nom de l'entreprise <span>*</span></label>
    <input class="col-md-5" type="varchar" name="entreprise_name" value="<?php echo $row->Entreprise ?>" />

    <label class="col-md-5 text-right" for="secteur">Secteur d'activité <span>*</span></label>
    <input class="col-md-5" type="varchar" name="secteur" value="<?php echo $row->Secteur ?>" />

    <label class="col-md-5 text-right" for="entreprise_site">Site de l'entreprise</label>
    <input class="col-md-5" type="text" name="entreprise_site" value="<?php echo $row->Site ?>" />

    <label class="col-md-5 text-right" for="qui_sommes_nous">Qui sommes-nous ? <span>*</span></label>
    <textarea rows="10" class="col-md-5" name="qui_sommes_nous"><?php echo $row->Description; ?></textarea>

    <label class="col-md-5 text-right" for="nombre_employers">Nombre d'employers <span>*</span></label>
    <input class="col-md-5" type="number" name="nombre_employers" value="<?php echo $row->Employers; ?>" />

    <div class="col-md-5"></div>
    <button class="col-md-2 send" type="submit"><i class="fa fa-envelope fa-2x"></i> Sauvegarder</button>

    </form>

    </div>

<?php

}

if (empty($_POST) && isset($_GET) && isset($_GET['poster_offre'])) { ?>

    <div class="container slide-profil">
    <h1 class="text-center"><span><strong><?php echo $row->Entreprise; ?></strong></span><br>- Poster une offre -</h1>
        <form class="profil_entreprise col-md-12" action=<?php echo "index.php?Profil_employeur&poster_offre" ?> method="POST">
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

<?php }

// Résumé de lo'ffre qui vient d'être proposé (pré-validation)

if (isset($_POST) && isset($_POST['offre_name']) && isset($_POST['remuneration']) && isset($_POST['date']) && isset($_POST['tasks']) && isset($_POST['qualifications']) && isset($_POST['competences']) && !empty($_POST['offre_name']) && !empty($_POST['remuneration']) && !empty($_POST['date']) && !empty($_POST['tasks']) && !empty($_POST['qualifications']) && !empty($_POST['competences'])) {

    $day = date("d/m/Y");
    $hour = date("H:i:s");
    $ajout = "Le $day à $hour";

    $random = str_shuffle("azertyuiop0123456789");
    $random_string = sha1($_SERVER['REMOTE_ADDR']).sha1($random);

    $link->query("INSERT INTO Offre(Employeur,Titre,Remunere,Debut,Taches,Qualifications,Competences, Ajout, id_crypt) VALUES ('$row->Entreprise','$offre_name','$remuneration','$date','$tasks','$qualifications','$competences', '$ajout','$random_string')");

    echo "<div class='offer_submit container'>
            <img class='col-md-5' src=Profil/Employeur/$row->id-$row->id_crypt/Img/img-profil-$row->id-$row->id_crypt.jpg style='width: 50%'>
            <h1><span class='user'>$row->Entreprise</span></h1>
            <p>Résumé de votre anonce :</p><br>
            <p><span class='user'>Nom : </span>$offre_name<p>
            <p><span class='user'>Rémunération : </span>$remuneration<p>
            <p><span class='user'>Les tâches : </span>$tasks<p>
            <p><span class='user'>Qualifications : </span>$qualifications<p>
            <p><span class='user'>Compétences : </span>$competences<p>
          </div>
          <br>";

    $query = $link->query("SELECT * FROM Offre WHERE Employeur='$row->Entreprise' AND Titre='$offre_name' AND Ajout='$ajout'");
    $row = $query->fetch_object();

    echo "<center><a href='index.php?Profil_employeur&validation_offre=$row->id_crypt'><button class='btn btn-custom'><i class='fa fa-check'></i> Valider</button></a></center>";
} 


    // Validation de l'offre

if (isset($_GET['Profil_employeur']) && isset($_GET['validation_offre']) && !empty($_GET['validation_offre'])){

    echo "TRUE";

    $query = $link->query("SELECT * FROM EntrepriseProfil WHERE id_crypt='$_SESSION[id]'");
    $row = $query->fetch_object();

    $query = $link->query("SELECT * FROM Offre WHERE Employeur='$row->Entreprise' AND id_crypt='$_GET[validation_offre]'");
    $row_1 = $query->fetch_object();

    if ($row == 0 || $row_1 == 0) {
    echo "<script>alert(\"Une erreur de procédure à eut lieue\")</script>";
    header("Refresh: 0; url=index.php?Profil_employeur?poster_offre");
    }

    $link->query("UPDATE Offre SET Statut='Validé' WHERE Employeur='$row->Entreprise' AND id_crypt='$_GET[validation_offre]'");

    $add = $row->Offres + 1;
    $link->query("UPDATE EntrepriseProfil SET Offres='$add' WHERE Email='$row->Email'");

    echo "<div class='container'>
    <img class='col-md-5' src=Profil/Employeur/$row->id-$row->id_crypt/Img/img-profil-$row->id-$row->id_crypt.jpg style='width: 25%'><br>
    <h1 class='user'>$row->Entreprise</h1>
    <h3>Votre offre à bien été validée, cliquez <a class='user' href='offre_submit.php?liste_offres=$row->Entreprise'>ici</a> pour y accèder</h3>
    </div>";

}


//Mise a jour du profil

// require "PHPMailer/class.phpmailer.php";

if (isset($_POST['entreprise_name']) || isset($_POST['entreprise_site']) || isset($_POST['secteur']) || isset($_POST['qui_sommes_nous']) || isset($_POST['nombre_employers'])) {

		extract($_POST);

        echo "TRUE";

		$link->query("UPDATE EntrepriseProfil SET Entreprise='$entreprise_name', Secteur='$secteur', Site='$entreprise_site', Description='$qui_sommes_nous', Employers='$nombre_employers', Statut_Profil='Oui' WHERE id_crypt='$_SESSION[id]'")or die("Erreur SQL");
        $link->query("UPDATE Offre SET Employeur='$entreprise_name' WHERE Entreprise='$row->Entreprise'");

		echo "<script>alert(\"Votre profil à bien été mis à jour\")</script>";
		header('Refresh: 0 ;index.php?Profil_employeur');

}