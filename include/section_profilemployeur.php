<?php 

extract($_POST);

if (!isset($_GET['poster_offre']) && !isset($_GET['validation_offre']) && !isset($_GET['summary_offre']) && !isset($_GET['liste_offres']) && !isset($_GET['liste_postulants']) && !isset($_GET['for_offer'])) {

    $link->query("DELETE FROM Offre WHERE Statut='En attente'");

    if (empty($_SESSION['employeur'])) {
        header("Location: index.php?Employeur");
    }

$query = $link->query("SELECT * FROM EntrepriseProfil WHERE id_crypt='$_SESSION[employeur]'"); 
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

if (empty($_POST) && isset($_GET) && isset($_GET['poster_offre'])) { 

$link->query("DELETE FROM Offre WHERE Statut='En attente'");

?>

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

// Formulaire d'envoi de l'offre qui redirige afin d'éviter de submit deux fois le formulaire

if (isset($_POST) && isset($_POST['offre_name']) && isset($_POST['remuneration']) && isset($_POST['date']) && isset($_POST['tasks']) && isset($_POST['qualifications']) && isset($_POST['competences']) && !empty($_POST['offre_name']) && !empty($_POST['remuneration']) && !empty($_POST['date']) && !empty($_POST['tasks']) && !empty($_POST['qualifications']) && !empty($_POST['competences'])) {

    $random = str_shuffle("azertyuiop0123456789");
    $random_string = sha1($_SERVER['REMOTE_ADDR']).sha1($random);

    $day = date("d/m/Y");
    $hour = date("H:i:s");
    $ajout = "Le $day à $hour";

    $link->query("INSERT INTO Offre(Employeur,Titre,Remunere,Debut,Taches,Qualifications,Competences, Ajout, id_crypt) VALUES ('$row->Entreprise','$offre_name','$remuneration','$date','$tasks','$qualifications','$competences', '$ajout','$random_string')");

    header("Location: index.php?Profil_employeur&summary_offre=$random_string");
    exit();   
}


// Résumé de l'offre qui vient d'être proposé (pré-validation)

if (isset($_GET['Profil_employeur']) && isset($_GET['summary_offre']) && !empty($_GET['summary_offre'])) {

    $day = date("d/m/Y");
    $hour = date("H:i:s");
    $ajout = "Le $day à $hour";

    $query = $link->query("SELECT * FROM Offre WHERE id_crypt='$_GET[summary_offre]'");
    $row = $query->fetch_object();



    if ($row->id_crypt != $_GET['summary_offre']) {
    echo "<script>alert(\"Erreur de procédure, cette offre va être supprimé, veuillez recommencer\")</script>";
    $link->query("DELETE FROM Offre WHERE id_crypt='$_GET[summary_offre]'");
    header("Refresh: 0; url=index.php?Profil_employeur&poster_offre");
    }
    else{

    $query = $link->query("SELECT * FROM EntrepriseProfil WHERE id_crypt='$_SESSION[employeur]'");
    $row = $query->fetch_object();

    $query = $link->query("SELECT * FROM Offre WHERE Employeur='$row->Entreprise' AND id_crypt='$_GET[summary_offre]'");
    $row_offre = $query->fetch_object();

    } 

    echo "<div class='offer_submit container'>
            <img class='col-md-5' src=Profil/Employeur/$row->id-$row->id_crypt/Img/img-profil-$row->id-$row->id_crypt.jpg style='width: 50%'>
            <h1><span class='user'>$row->Entreprise</span></h1>
            <p>Résumé de votre anonce :</p><br>
            <p><span class='user'>Nom : </span>$row_offre->Titre<p>
            <p><span class='user'>Rémunération : </span>$row_offre->Remunere<p>
            <p><span class='user'>Les tâches : </span>$row_offre->Taches<p>
            <p><span class='user'>Qualifications : </span>$row_offre->Qualifications<p>
            <p><span class='user'>Compétences : </span>$row_offre->Competences<p>
          </div>
          <br>";

    echo "<center><a href='index.php?Profil_employeur&validation_offre=$row_offre->id_crypt'><button class='btn btn-custom'><i class='fa fa-check'></i> Valider</button></a>
    <a href='index.php?Profil_employeur&poster_offre'><button class='btn btn-custom-red'><i class='fa fa-check'></i> Annuler</button></a></center>";
}   


// Validation de l'offre

if (isset($_GET['Profil_employeur']) && isset($_GET['validation_offre']) && !empty($_GET['validation_offre'])){

    $query = $link->query("SELECT * FROM EntrepriseProfil WHERE id_crypt='$_SESSION[employeur]'");
    $row = $query->fetch_object();

    $query = $link->query("SELECT * FROM Offre WHERE Employeur='$row->Entreprise' AND id_crypt='$_GET[validation_offre]'");
    $row_1 = $query->fetch_object();

    if ($row == 0 || $row_1 == 0) {
    echo "<script>alert(\"Une erreur de procédure à eut lieue\")</script>";
    header("Refresh: 0; url=index.php?Profil_employeur&poster_offre");
    }

    $link->query("UPDATE Offre SET Statut='Validé' WHERE Employeur='$row->Entreprise' AND id_crypt='$_GET[validation_offre]'");

    $add = $row->Offres + 1;
    $link->query("UPDATE EntrepriseProfil SET Offres='$add' WHERE Email='$row->Email'");

    echo "<div class='container validation_offre'>
    <img class='col-md-5' src=Profil/Employeur/$row->id-$row->id_crypt/Img/img-profil-$row->id-$row->id_crypt.jpg style='width: 25%'><br>
    <h1 class='user'>$row->Entreprise</h1>
    <h3>Votre offre à bien été validée, cliquez <a class='user' href='index.php?Profil_employeur&liste_offres'>ici</a> pour y accèder</h3>
    </div>";

}


// Liste des offres

if (isset($_GET['Profil_employeur']) && isset($_GET['liste_offres'])) { ?>

    <div class="container">
    <?php echo "<span class='poster text-center'><a href='index.php?Profil_employeur$poster_offre'>Poster une offre</a></span>";
    $query = $link->query("SELECT * FROM EntrepriseProfil WHERE id_crypt='$_SESSION[employeur]'");
    $row_1 = $query->fetch_object();

    if ($row_1->Offres == 0) {
    echo "<script>alert(\"Vous n'avez aucune offre disponible\")</script>";
    header("refresh: 0; url=index.php?Profil_employeur&poster_offre");
    }

    ?>
    <h1 class="text-center" style="margin-top: 5%; font-family: Inconsolata"><strong><?php echo $row_1->Entreprise; ?></strong><br>Liste de vos offres</h1> 

<?php

//Boucle qui liste les offres disponibles sur le profil (seulement celles au statut 'Accepté')
    $query = $link->query("SELECT * FROM Offre WHERE Employeur='$row_1->Entreprise'");

    while ($row = $query->fetch_object()) {
        echo "<div class='col-md-4 offer_list'>
            <a href='index.php?Profil_employeur&liste_offres&delete=$row->id'><span class='remove btn btn-info'><i class='fa fa-times'></i></span></a>
            <p><span class='user'>Titre de l'offre</span> : $row->Titre<p>
            <p><span class='user'>Boulot payant</span> : $row->Remunere<p>
            <p><span class='user'>Date d'ajout</span> : $row->Ajout<p>
            <p><span class='user'>Tâches à effectuer</span> : $row->Taches<p>
            <p><span class='user'>Qualifications requises</span> : $row->Qualifications<p>
            <p><span class='user'>Compétences</span> : $row->Competences<p>";

            if ($row->nbr_postulant == 0) {
            echo "<p><span class='user'>Nombre de postulants</span> : $row->nbr_postulant<p>
            </div>";
            }
            else{
            echo "<p><span class='user_postulants'>Nombre de postulants</span> : <a href='index.php?Profil_employeur&liste_postulants&for_offer=$row->id&token=$row->id_crypt'>$row->nbr_postulant</a><p>
            </div>";
            }
    }
}


if (isset($_GET['liste_postulants']) && isset($_GET['for_offer']) && isset($_GET['token']) && !empty($_GET['for_offer']) && !empty($_GET['token'])) {

    echo "TRUE";
    $query = $link->query("SELECT * FROM Postulant WHERE id_offre='$_GET[for_offer]'"); $row = $query->fetch_object();
    $query = $link->query("SELECT * FROM Etudiant WHERE Email='$row->Postulant'");

    echo "<h1>Liste des postulants</h1>";

    while ($row = $query->fetch_object()) {
        echo "<div class='container'><div class='col-md-4 offer_list'>";
        if(file_exists("Profil/Etudiant/$row->id-$row->id_crypt/Img/img-profil-$row->id-$row->id_crypt.jpg")) {
         echo "<img src=Profil/Etudiant/$row->id-$row->id_crypt/Img/img-profil-$row->id-$row->id_crypt.jpg>"; 
        }
        else{
         echo "<img src=img/user_default.png>"; 
        }
        echo "<p><span class='user'>Nom</span> : $row->Nom<p>
        <p><span class='user'>Prénom</span> : $row->Prenom<p>
        <p><span class='user'>Email</span> : $row->Email<p>
        <p><span class='user'>Sexe</span> : $row->Sexe<p>
        <p><span class='user'>Etudes</span> : $row->Etudes<p>
        <p><span class='user'>Ecole</span> : $row->Ecole<p>
        <p><span class='user'>Spécialisation</span> : $row->Specialisation<p>
        <p><span class='user'>langues</span> : $row->Langues<p>
        <p><span class='user_postulant'>CV</span> : <span class='download_file'><a target='_blank' href='Profil/Etudiant/$row->id-$row->id_crypt/CV/CV-profil-$row->id-$row->id_crypt.pdf'><button class='btn btn-danger'>Télécharger</button></a></span><p>
        <p><span class='user_postulant'>Lettre de motivation</span> : <span class='download_file'><a target='_blank' href='Profil/Etudiant/$row->id-$row->id_crypt/Lettre_motivation/Lettre-profil-$row->id-$row->id_crypt.pdf'><button class='btn btn-danger'>Télécharger</button></a></span><p>
        </div></div>";        
    }
}


// Supprimer une offre

if (isset($_GET['Profil_employeur']) && isset($_GET['liste_offres']) && isset($_GET['delete']) && !empty($_GET['delete'])) {
    $link->query("DELETE FROM Offre WHERE id='$_GET[delete]'");

    $query = $link->query("SELECT * FROM EntrepriseProfil WHERE id_crypt='$_SESSION[employeur]'");
    $row = $query->fetch_object();

    $update_value = $row->Offres - 1;
    $link->query("UPDATE EntrepriseProfil SET Offres='$update_value'");

    header("Location: index.php?Profil_employeur&liste_offres");
}



//Mise a jour du profil

// require "PHPMailer/class.phpmailer.php";

if (isset($_POST['entreprise_name']) || isset($_POST['entreprise_site']) || isset($_POST['secteur']) || isset($_POST['qui_sommes_nous']) || isset($_POST['nombre_employers'])) {

		extract($_POST);

		$link->query("UPDATE EntrepriseProfil SET Entreprise='$entreprise_name', Secteur='$secteur', Site='$entreprise_site', Description='$qui_sommes_nous', Employers='$nombre_employers', Statut_Profil='Oui' WHERE id_crypt='$_SESSION[employeur]'")or die("Erreur SQL");
        $link->query("UPDATE Offre SET Employeur='$entreprise_name' WHERE Entreprise='$row->Entreprise'");

		echo "<script>alert(\"Votre profil à bien été mis à jour\")</script>";
		header('Refresh: 0 ;index.php?Profil_employeur');

}