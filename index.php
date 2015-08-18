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
    echo "<meta charset='utf-8'><script>alert(\"L'adresse e-mail ou le numéro de téléphone est déja utilisé !!\")</script>";
    if (isset($_GET['Employeur'])) {
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=index.php?Employeur'>";
    }
    elseif (isset($_GET['Etudiant'])) {
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=index.php?Etudiant'>";
    }
}


//Partie employeur

elseif (isset($_GET['Employeur'])) {

  $session->sessionDestroy();
  $session->profilWait();

  $title = "JobFinder | Partie Employeur";

  include "include/header.php"; 
  include "include/section_employeur.php";
  include "include/footer.php";

}


// Profil employeur

elseif (isset($_GET) && isset($_GET['Profil_employeur'])) {

  include "include/connexion.php";
  
  $title = "Profil Employeur";

  include "include/header.php";
  include "include/lateral.php";
  include "include/section_profilemployeur.php";

}


//Partie étudiant

elseif (isset($_GET) && isset($_GET['Etudiant'])) {

  $session->sessionDestroy();
  $session->profilWait();
  
  $title = "JobFinder | Partie Etudiant";
  
  include "include/header.php";
  include "include/carousel.php"; 
  include "include/section_etudiant.php";
  include "include/footer.php";

}


// Profil Etudiant

elseif (isset($_GET) && isset($_GET['Profil_etudiant'])) {

  include "include/connexion.php";
  
  $title = "Profil Etudiant";

  include "include/header.php";
  include "include/lateral.php";
  include "include/section_profiletudiant.php";

}

// Redirection

elseif (($_GET != "Etudiant") || ($_GET != "Employeur") || ($_GET != "erreur_connexion" ) || ($_GET != "erreur_inscription" ) || ($_GET != "Profil_etudiant" ) || ($_GET != "Profil_employeur" ) || empty($_GET) || !isset($_GET)) {
  $session->sessionDestroy();
  $session->profilWait();
  echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=index.php?Etudiant'>";
}


 ?>

  </body>
</html>