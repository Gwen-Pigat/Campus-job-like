<?php

include "include/functions.php";

if (isset($_GET['erreur_connexion']) && !empty($_GET['erreur_connexion'])) { 
    $session->sessionDestroy();
    $session->profilWait();
    echo "<meta charset='utf-8'><script>alert(\"Mauvais mot de passe ou nom d'utilisateur\")</script>";
    if (isset($_GET['Employeur'])) {
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=index.php?Employeur'>";
    }
    elseif (isset($_GET['Etudiant'])) {
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=index.php?Etudiant'>";
    }
}

elseif (isset($_GET['erreur_inscription']) && !empty($_GET['erreur_inscription'])) { 
    $session->sessionDestroy();
    $session->profilWait();
    if (isset($_GET['Employeur'])) {
    echo "<meta charset='utf-8'><script>alert(\"L'adresse e-mail ou le numéro de téléphone est déja utilisé !!\")</script>";
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=index.php?Employeur'>";
    }
    elseif (isset($_GET['Etudiant'])) {
    echo "<meta charset='utf-8'><script>alert(\"L'adresse e-mail est déja utilisé !!\")</script>";
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=index.php?Etudiant'>";
    }
}


//Partie employeur

elseif (isset($_GET) && isset($_GET['Employeur']) && !isset($_GET['password_reset'])) {

  $session->sessionDestroy();
  $session->profilWait();

  $title = "JobFinder | Partie Employeur";

  include "include/header.php";

  echo "<section id='section_employeur'>";
  include "include/section_employeur.php";
  echo "</section>";

  include "include/footer.php";
 
}


// Profil employeur

elseif (isset($_GET) && isset($_GET['Profil_employeur'])) {

  include "include/connexion.php";
  
  $title = "Profil Employeur";

  include "include/header.php";
  include "include/lateral.php";

  echo "<section id='section_profilemployeur'>";
  include "include/section_profilemployeur.php";
  echo "</section>";

  include "include/footer.php";

}


//Partie étudiant

elseif (isset($_GET) && isset($_GET['Etudiant']) && !isset($_GET['password_reset'])) {

  $session->sessionDestroy();
  $session->profilWait();
  
  $title = "JobFinder | Partie Etudiant";
  
  include "include/header.php";
  echo "<section id='section_carousel'>";
  include "include/carousel.php"; 
  echo "</section>
        <section id='section_etudiant'>";
  include "include/section_etudiant.php";
  echo "</section>";

}


// Profil Etudiant

elseif (isset($_GET) && isset($_GET['Profil_etudiant'])) {

  include "include/connexion.php";

  $title = "Profil Etudiant";

  include "include/header.php";
  include "include/lateral.php";

  echo "<section id='section_profiletudiant'>";
  include "include/section_profiletudiant.php";
  echo "</section>";

}


// Reset du password / Etudiant

elseif (isset($_GET) && isset($_GET['Etudiant']) && isset($_GET['password_reset']) && !empty($_GET['password_reset'])) {
  
  include "include/connexion.php"; 
  $title = "Etudiant | Nouveau mot de passe";

  include "include/header.php";

  $query = $link->query("SELECT * FROM Etudiant WHERE token_password='$_GET[password_reset]'");
  $row = $query->fetch_object();

  if ($row == 0) {
  echo "<script>alert(\"Erreur de procédure\")</script>";
  header("Refresh: 0; url=index.php?Etudiant");
  }
  else{
  echo "<section id='section_resetpassword'>";
  include "include/section_resetpassword.php";
  echo "</section>";
  }

}

// Reset du password / Employeur

elseif (isset($_GET) && isset($_GET['Employeur']) && isset($_GET['password_reset']) && !empty($_GET['password_reset'])) {
  
  include "include/connexion.php"; 
  $title = "Employeur | Nouveau mot de passe";

  include "include/header.php";

  $query = $link->query("SELECT * FROM EntrepriseProfil WHERE token_password='$_GET[password_reset]'");
  $row = $query->fetch_object();

  if ($row == 0) {
  echo "<script>alert(\"Erreur de procédure\")</script>";
  header("Refresh: 0; url=index.php?Employeur");
  }
  else{
  echo "<section id='section_resetpassword'>";
  include "include/section_resetpassword.php";
  echo "</section>";
  }

}


// Redirection

elseif (($_GET != "password_reset") || ($_GET != "Etudiant") || ($_GET != "Employeur") || ($_GET != "erreur_connexion" ) || ($_GET != "erreur_inscription" ) || ($_GET != "Profil_etudiant" ) || ($_GET != "Profil_employeur" ) || empty($_GET) || !isset($_GET)) {
  $session->sessionDestroy();
  $session->profilWait();
  echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=index.php?Etudiant'>";
}


 ?>

  </body>
</html>