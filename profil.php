<!DOCTYPE html>
<html lang="fr">
<head>
  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="site de vente de livres">
  <meta name="keywords" content="vente de livres">
  <link rel="shortcut icon" href="assets/livre1.jpg" type="image/x-icon">
  <link rel="stylesheet" href="css/nav.css" />
  <title>Profil | FahemBooks</title>
</head>
<body>
  <?php 
    session_start();
    include('nav.php');
  ?>
  
  <main>
    <h2>Mettre à jour mon profil</h2>
    <form method="POST" action="">
        <fieldset>
            <label for="prenom" >Prénom</label><br >
            <input type="text" placeholder="prenom" name="prenom" id="prenom"/><br >
            <label for="nom">Nom</label><br >
            <input type="text" placeholder="nom" name="nom" id="nom" /><br >
            <label for="numero">Numéro de téléphone</label><br >
            <input type="number" placeholder="numero" name="numero" id="numero" /><br ><br>
            <input type="submit" value="Envoyer"name="updateProfile" />
        </fieldset>
    </form>
    
    <h2>Modifier mon mot de passe</h2>
    <form method="POST" action="">
        <fieldset>

            <label for="ancienMotdepasse">Ancien mot de passe</label><br >
            <input type="password" placeholder="Mot de passe" name="ancienMotdepasse" id="ancienMotdepasse" /><br >
            <label>Nouveau mot de passe</label><br >
            <input type="nouveauMotdepasse" placeholder="Mot de passe" name="nouveauMotdepasse" id="nouveauMotdepasse" /><br ><br>
            <input type="submit" value="Envoyer" name="updatePassword" />
        </fieldset>
     </form><br>

     <form method="POST" action="">
    <button type="submit" name="logout">Se déconnecter</button>
    </form>

  </main>
  
  <footer>
    <p>FahemBooks &copy; 2023 - Tous droits réservés</p>
  </footer>
</body>
</html>
<?php
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
  // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
  header("Location: connexion.php");
  exit;
}

// Informations de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projet_web";

try {
  // Connexion à la base de données en utilisant PDO
  $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);

  // Configurer PDO pour générer des exceptions lorsqu'il y a des erreurs
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Vérifier si le formulaire de mise à jour du profil a été soumis
  if (isset($_POST['updateProfile'])) {
    // Récupérer les données du formulaire
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $numero = $_POST['numero'];

    // Mettre à jour les informations de l'utilisateur dans la base de données
    $email = $_SESSION['email'];
    $sql = "UPDATE user SET prenom=?, nom=?, numero=? WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$prenom, $nom, $numero, $email]);

    echo "Informations mises à jour avec succès.";
  }

  // Vérifier si le formulaire de modification du mot de passe a été soumis
  if (isset($_POST['updatePassword'])) {
    // Récupérer les données du formulaire
    $ancienMotdepasse = $_POST['ancienMotdepasse'];
    $nouveauMotdepasse = $_POST['nouveauMotdepasse'];

    // Vérifier si le mot de passe actuel est correct
    $email = $_SESSION['email'];
    $sql = "SELECT motdepasse FROM user WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    $row = $stmt->fetch();

    if ($row) {
      $motdepasse_actuel = $row['motdepasse'];

      if (password_verify($ancienMotdepasse, $motdepasse_actuel)) {
        // Hacher et mettre à jour le nouveau mot de passe dans la base de données
        $nouveauMotdepasse_hache = password_hash($nouveauMotdepasse, PASSWORD_DEFAULT);

        $sql = "UPDATE user SET motdepasse=? WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nouveauMotdepasse_hache, $email]);

        echo "Mot de passe mis à jour avec succès.";
      } else {
        echo "Le mot de passe actuel est incorrect.";
      }
    } else {
      echo "Erreur lors de la récupération des informations de l'utilisateur.";
    }
  }
} catch (PDOException $e) {
  echo "Erreur de connexion à la base de données: " . $e->getMessage();
}

if (isset($_POST['logout'])) {
  // Détruire la session
  session_destroy();

  // Rediriger vers la page de connexion ou une autre page de votre choix
  header("Location: connexion.php");
  exit;
}

// Fermer la connexion à la base de données
$conn = null;
?>
