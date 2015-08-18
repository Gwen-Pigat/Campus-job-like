<?php 

extract($_POST);

if (!isset($_GET['poster_offre']) && !isset($_GET['validation_offre']) && !isset($_GET['summary_offre']) && !isset($_GET['liste_offres'])) {

    $link->query("DELETE FROM Offre WHERE Statut='En attente'");

    if (empty($_SESSION)) {
        header("Location: index.php?Employeur");
    }


$query = $link->query("SELECT * FROM Etudiant WHERE id_crypt='$_SESSION[id]'");
$row = $query->fetch_object();


?>

<div class="container">

<h1 class="text-center" style="margin-top: 5%; font-family: Inconsolata">Profil de <strong><?php echo $row->Prenom; ?></strong></h1>

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


<h1 class="text-center"><strong><?php echo $row->Prenom; ?></strong> ,mon compte</h1>

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
<button class="btn btn-custom"><i class='fa fa-check fa-2x'></i></button>
</center>

</form>

<?php } 

if (isset($_POST) && isset($prenom) && isset($nom) && isset($sexe) && isset($etudes) && isset($ecole) && isset($specialisation) && isset($langues) && isset($recherche) && isset($lieu) && isset($distance) && !empty($prenom) && !empty($nom) && !empty($sexe) && !empty($etudes) && !empty($ecole) && !empty($specialisation) && !empty($langues) && !empty($recherche) && !empty($lieu) && !empty($distance)) {
    
    $link->query("UPDATE Etudiant SET Prenom='$prenom', Nom='$nom', Sexe='$sexe', Etudes='$etudes', Ecole='$ecole', Specialisation='$specialisation', Langues='$langues', Langues_sup='$langues_sup', Recherche='$recherche', Recherche_sup='$recherche_sup', Lieu_importance='$lieu', Distance='$distance', Statut_Profil='Oui' WHERE id_crypt='$_SESSION[id]'")or die("Erreur SQL");

    echo "<script>alert(\"Votre profil à bien été mis à jour\")</script>";
    header('Refresh: 0 ;index.php?Profil_etudiant');
}

?>