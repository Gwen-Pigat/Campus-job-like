<?php 

extract($_POST);

if (empty($_SESSION['etudiant'])) {
        header("Location: index.php?Employeur");
    }
    

if (!isset($_GET['postuler']) && !isset($_GET['validation_offre']) && !isset($_GET['summary_offre']) && !isset($_GET['liste_offres'])) {

    $link->query("DELETE FROM Offre WHERE Statut='En attente'");

$query = $link->query("SELECT * FROM Etudiant WHERE id_crypt='$_SESSION[etudiant]'");
$row = $query->fetch_object();


?>

<div class="container">
<h1 class="text-center" style="margin-top: 5%">Profil de <strong><?php echo $row->Prenom; ?></strong></h1>

<form method="POST" action="" class="creation_etudiant col-md-8 col-md-offset-2">

<p>Je m'appelle <input name="prenom" placeholder="Votre prénom" value="<?php echo $row->Prenom; ?>" required>
    <input name="nom" placeholder="Nom" value="<?php echo $row->Nom; ?>" required>
</p>

<?php 

switch($row->Sexe){
    case "Homme";
        $switch_1 = "Selected";
        break;
    case "Femme";
        $switch_2 = "Selected";
        break;
}
switch ($row->Recherche) {
    case 'Un job':
        $switch_3 = "selected";
        break;
    case 'Un stage':
        $switch_4 = "selected";
        break;
}
switch ($row->Recherche_sup) {
    case 'Non':
        $switch_5 = "selected";
        break;
    case 'Un job':
        $switch_6 = "selected";
        break;
    case 'Un stage':
        $switch_7 = "selected";
        break;
}
switch ($row->Lieu_importance) {
    case 'Oui':
        $switch_8 = "selected";
        break;
    case 'Non':
        $switch_9 = "selected";
        break;
}
 ?>

<p>Je suis 
    <select name="sexe" required>
        <option value="Homme" <?php echo $switch_2; ?> >un homme</option>
        <option value="Femme" <?php echo $switch_2; ?> >une femme</option>
    </select>
</p>

<p>Mon Niveau d'étude est <input name="etudes" placeholder="Bac +1 , +2 etc..."  value="<?php echo $row->Etudes; ?>"required></p>

<p>Je suis ma scolarité dans l'école <input name="ecole" placeholder="Ecole"  value="<?php echo $row->Ecole; ?>"required></p>

<p>Ma spécialisation est <input name="specialisation" placeholder="la science..."  value="<?php echo $row->Specialisation; ?>"required></p>

<p>Je parle <input name="langues" placeholder="le francais"  value="<?php echo $row->Langues; ?>"required>, Autre : <input name="langues_sup" placeholder="précisez" value="<?php echo $row->Langues_sup; ?>"></p>

<p>Je cherche un 
    <select name="recherche" required>
        <option value="Un job" <?php echo $switch_3; ?> >un job</option>
        <option value="Un stage" <?php echo $switch_4; ?> >un stage</option>
    </select>, cherchez vous autre chose (en plus)
    <select name="recherche_sup">
        <option value="Non" <?php echo $switch_5; ?> >Non</option>
        <option value="Un job" <?php echo $switch_6; ?> >Un job</option>
        <option value="Un stage" <?php echo $switch_7; ?> >Un stage</option>
    </select>
</p>

<p>Le lieu du poste est-il important ? 
    <select name="lieu" required>
        <option value="Oui" <?php echo $switch_8; ?> >Oui</option>
        <option value="Non" <?php echo $switch_9; ?> >Non</option>
    </select>
</p>
    <p>Si oui, précisez la distance idéale : <input name="distance" placeholder="20km ou 100km max..." value="<?php echo $row->Distance; ?>">
</p>

<center>
<button class="btn btn-custom"><i class='fa fa-check fa'></i> Valider</button>
</center>

</form>

<?php } 

// Mise à jour du profil

if (isset($_POST) && isset($prenom) && isset($nom) && isset($sexe) && isset($etudes) && isset($ecole) && isset($specialisation) && isset($langues) && isset($recherche) && isset($lieu) && !empty($prenom) && !empty($nom) && !empty($sexe) && !empty($etudes) && !empty($ecole) && !empty($specialisation) && !empty($langues) && !empty($recherche) && !empty($lieu)) {
    
    $link->query("UPDATE Etudiant SET Prenom='$prenom', Nom='$nom', Sexe='$sexe', Etudes='$etudes', Ecole='$ecole', Specialisation='$specialisation', Langues='$langues', Langues_sup='$langues_sup', Recherche='$recherche', Recherche_sup='$recherche_sup', Lieu_importance='$lieu', Distance='$distance', Statut_Profil='Oui' WHERE id_crypt='$_SESSION[etudiant]'")or die("Erreur SQL");

    echo "<script>alert(\"Votre profil à bien été mis à jour\")</script>";
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL='>";
}


if (isset($_GET) && isset($_GET['liste_offres']) && !isset($_GET['postuler']) && !isset($_GET['confirmation'])) { ?>

    <div class="container">
    <?php
    $query = $link->query("SELECT * FROM EntrepriseProfil"); $row_1 = $query->fetch_object();

    if ($row_1->Offres == 0) {
    echo "<script>alert(\"Aucune offre n'est disponible pour le moment\")</script>";
    header("refresh: 0; url=index.php?Profil_etudiant");
    }

    ?>
    <h1 class="text-center" style="margin-top: 5%; font-family: Caviar Dreams">Liste des offres</h1> 

<?php

//Boucle qui liste les offres disponibles sur le profil (seulement celles au statut 'Accepté')
    $query = $link->query("SELECT * FROM Etudiant WHERE id_crypt='$_SESSION[etudiant]'"); $row_etudiant = $query->fetch_object();
    $sql = $link->query("SELECT * FROM Offre WHERE Statut='Validé'");

    while ($row = $sql->fetch_object()) {
        echo "<div class='col-md-4 offer_list'>
            <p><span class='user'>Titre de l'offre</span> : $row->Titre<p>
            <p><span class='user'>Boulot payant</span> : $row->Remunere<p>
            <p><span class='user'>Date d'ajout</span> : $row->Ajout<p>
            <p><span class='user'>Tâches à effectuer</span> : $row->Taches<p>
            <p><span class='user'>Qualifications requises</span> : $row->Qualifications<p>
            <p><span class='user'>Compétences</span> : $row->Competences<p>
            <p><span class='user'>Nombre de postulants</span> : $row->nbr_postulant<p>";
            $query = $link->query("SELECT * FROM Postulant WHERE Postulant='$row_etudiant->Email' AND id_offre='$row->id'"); $row_postulant = $query->fetch_object();
            if ($row_postulant == 0) {
            echo "<a href='index.php?Profil_etudiant&liste_offres&postuler=$row->id_crypt'><button class='btn btn-success'>Postuler</button></a>
            </div>";    
            }
            else{
            echo "<button class='btn btn-danger'>Déjà postulé</button>
            </div>";
            }
    }
}

elseif (isset($_GET) && isset($_GET['liste_offres']) && isset($_GET['postuler']) && !empty($_GET['postuler'])) {

    $query = $link->query("SELECT * FROM Offre WHERE id_crypt='$_GET[postuler]'"); $row_offre = $query->fetch_object();

    if ($_GET['postuler'] != $row_offre->id_crypt) {
    echo "<script>alert(\"Erreur de procédure\")</script>";
    header("Refresh: 0;url=index.php?Profil_etudiant");
    }

    $query = $link->query("SELECT * FROM EntrepriseProfil WHERE Entreprise='$row_offre->Employeur'"); $row_entreprise = $query->fetch_object();
    $query = $link->query("SELECT * FROM Etudiant WHERE id_crypt='$_SESSION[etudiant]'"); $row_user = $query->fetch_object();

    echo "<h1 class='text-center'>L'annonce</h1><div class='offer_submit container'>
    <img class='col-md-5' src=Profil/Employeur/$row_entreprise->id-$row_entreprise->id_crypt/Img/img-profil-$row_entreprise->id-$row_entreprise->id_crypt.jpg style='width: 50%'>
            <p><span class='user'>l'entreprise :</span> $row_entreprise->Entreprise<p>
            <p><span class='user'>Nom :</span> $row_offre->Titre<p>
            <p><span class='user'>Rémunération :</span> $row_offre->Remunere<p>
            <p><span class='user'>Les tâches :</span> $row_offre->Taches<p>
            <p><span class='user'>Qualifications :</span> $row_offre->Qualifications<p>
            <p><span class='user'>Compétences :</span> $row_offre->Competences<p>
    <form class='profil_entreprise_logo col-md-12' action='' method='POST' enctype='multipart/form-data'>
        <label>Votre CV :<span class='red'> PDF obligatoire</span></label><br>
        <input type='file' name='upload_cv' size='25' value='Upload CV' required><br>
        <label>Votre lettre de motivation :<span class='red'> PDF obligatoire</span></label><br>
        <input type='file' name='lettre_motivation' size='25' value='Upload lettre de motivation' required><br>
        <input type='hidden' name='numero_offre' value='$_GET[postuler]'><br>
        <input class='btn btn-success' type='submit' name='submit' value='Envoyer'>
    </form>
    </div>";

    if (isset($_POST['submit']) && isset($_POST['numero_offre'])) {

        // Numero_offre correspond à l'input caché faisant référence a l'id de l'offre

        mkdir("Profil/Etudiant/$row_user->id-$row_user->id_crypt/CV", 0777, true);
        mkdir("Profil/Etudiant/$row_user->id-$row_user->id_crypt/Lettre_motivation", 0777, true);
        
        chmod("Profil", 0777);
        chmod("Profil/Etudiant", 0777);
        chmod("Profil/Etudiant/$row_user->id-$row_user->id_crypt", 0777);


        // Propriétés du CV
        $cv_name = $_FILES['upload_cv']['name'];
        $cv_type = $_FILES['upload_cv']['type'];
        $cv_size = $_FILES['upload_cv']['size'];
        $cv_tmp = $_FILES['upload_cv']['tmp_name'];


        // Propriétés de la lettre de motivation
        $lettre_name = $_FILES['lettre_motivation']['name'];
        $lettre_type = $_FILES['lettre_motivation']['type'];
        $lettre_size = $_FILES['lettre_motivation']['size'];
        $lettre_tmp = $_FILES['lettre_motivation']['tmp_name'];


        $random_cv = "CV-profil-$row_user->id-$row_user->id_crypt.pdf";
        $random_lettre = "Lettre-profil-$row_user->id-$row_user->id_crypt.pdf";

        if ($lettre_name == "" || $cv_name == "") {
            echo "<script>alert('Vous devez sélectionner un fichier valide !')</script>";
        }

        else{
            move_uploaded_file($cv_tmp, "Profil/Etudiant/$row_user->id-$row_user->id_crypt/CV/$random_cv");
            move_uploaded_file($lettre_tmp, "Profil/Etudiant/$row_user->id-$row_user->id_crypt/Lettre_motivation/$random_lettre");
            echo "<div class='cv_lettre_submit col-md-6 col-md-offset-3'><h3>Préparation à l'envoi</h3><br><i class='fa fa-refresh fa-spin fa-5x text-center'></i></div>";
            header("Refresh: 2; url=index.php?Profil_etudiant&liste_offres&confirmation=$_POST[numero_offre]");
        }
    }
}


elseif (isset($_GET) && isset($_GET['confirmation']) && !empty($_GET['confirmation'])) {

        $query = $link->query("SELECT * FROM Etudiant WHERE id_crypt='$_SESSION[etudiant]'");$row_etudiant = $query->fetch_object();
        $query = $link->query("SELECT * FROM Postulant WHERE Postulant='$row_etudiant->email' AND id_offre='$_GET[confirmation]'"); $row_postulant = $query->fetch_object();
        $query = $link->query("SELECT * FROM Offre WHERE id_crypt='$_GET[confirmation]'"); $row_offre = $query->fetch_object();

        if ($row_postulant == 0) {

            $ajout_etudiant = $row_etudiant->nbr_offre + 1;
            $ajout_offre = $row_offre->nbr_postulant + 1;

        $link->query("UPDATE Etudiant SET nbr_offre='$ajout_etudiant' WHERE id_crypt='$_SESSION[etudiant]'");
        $link->query("UPDATE Offre SET nbr_postulant='$ajout_offre' WHERE id_crypt='$_GET[confirmation]'");

            echo "<div class='container text-center'>
        <h1 class='text-center'>CV et lettre de motivation envoyés</h1>
        <i class='fa fa-refresh fa-spin fa-5x text-center' style='color: #ff0000'></i>
        </div>"; 
        $link->query("INSERT INTO Postulant(Postulant,id_offre,Employeur, Envoi) VALUES ('$row_etudiant->Email','$row_offre->id','$row_offre->Employeur', 'Oui')");
        header("Refresh: 2; url=index.php?Profil_etudiant");
        }
        else{
            echo "<div class='container'>
        <h1 class='text-center'>Erreur ! Il semblerait que votre CV ait déja été envoyé</h1>
        </div>"; 
        header("Refresh: 2; url=index.php?Profil_etudiant");
        }   
    }

?>