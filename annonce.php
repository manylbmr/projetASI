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
  <title> Annonce | FahemBooks</title>

      <link
      href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap"
      rel="stylesheet"
    />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/nav.css" />

</head>
<body>
  <?php 
    session_start();
    include('nav.php');
  ?>
  
  <main>
    <h2>Publier une annonce</h2>
        <form method="POST" action="">
            <fieldset>
                <label for="titre">Titre du livre</label><br >
                <input type="text" placeholder="text" id="titre" name="titre" /><br >
                <label for="auteur">Auteur</label><br >
                <input type="text" placeholder="text" id="auteur" name="auteur" /><br >
                <label for="description">Description du livre </label><br >
                <textarea name="description" id="description"></textarea><br>
                <label for="categorie">Catégorie du livre</label><br>
                <select id="categorie" name="categorie">
                    <option value="Romans">Romans</option>
                    <option value="Livres de cuisine">Livres de cuisine</option>
                    <option value="Mangas">Mangas</option>
                    
                </select><br><br>
                <label for="photo">Choisir une photo</label><br>
                <input type="text" id="photo" name="photo"><br><br>
                
                
                <label for="prix">Donner un prix</label><br>
                <input type="number" id="prix" name="prix"><br><br>
                <input type="submit" value="Send" />
            </fieldset>
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

// Récupérer les données du formulaire
$titre = $_POST['titre'];
$auteur = $_POST['auteur'];
$description = $_POST['description'];
$categorie = $_POST['categorie'];
$photo = $_POST['photo'];
$prix = $_POST['prix'];
$user_id = $_SESSION['user_id'];


// Paramètres de connexion à la base de données
$servername = "localhost";  // Remplacez localhost par l'adresse du serveur MySQL
$username = "root";  // Remplacez votre_nom_d'utilisateur par votre nom d'utilisateur MySQL
$password = "";  // Remplacez votre_mot_de_passe par votre mot de passe MySQL
$dbname = "projet_web";  // Remplacez nom_de_votre_base_de_données par le nom de votre base de données

try {
    // Connexion à la base de données avec PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Configurer PDO pour afficher les erreurs SQL
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparer la requête SQL d'insertion
    $stmt = $conn->prepare("INSERT INTO livre2 (titre, auteur, description, categorie,photo, prix, user_id) VALUES (:Titre, :Auteur, :Description, :Categorie, :Photo, :Prix, :UserID)");

    // Attribuer les valeurs aux paramètres de la requête
    $stmt->bindParam(':Titre', $titre);
    $stmt->bindParam(':Auteur', $auteur);
    $stmt->bindParam(':Description', $description);
    $stmt->bindParam(':Categorie', $categorie);
    $stmt->bindParam(':Photo', $photo);
    $stmt->bindParam(':Prix', $prix);
    $stmt->bindParam(':UserID', $user_id);
    

    // Exécuter la requête
    $stmt->execute();

    echo "Annonce publiée avec succès !";
} catch(PDOException $e) {
    echo "Erreur lors de la publication de l'annonce : " . $e->getMessage();
}

// Fermer la connexion à la base de données
$conn = null;
}
?>
