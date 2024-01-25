<!DOCTYPE html>
<html lang="fr">
<head>
  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="site de vente de livres">
  <meta name="keywords" content="vente de livres">
  <link rel="shortcut icon" href="images/livre1.jpg" type="image/x-icon">
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
    <h2>Publier un meuble</h2>
        <form method="POST" action="">
            <fieldset>
                <label for="titre">Nom du meuble</label><br >
                <input type="text" placeholder="text" id="nom" name="nom" /><br >
                <label for="couleur">couleur</label><br >
                <input type="text" placeholder="text" id="couleur" name="couleur" /><br >
                <label for="quantite">quantite</label><br >
                <input type="text" placeholder="text" id="quantite" name="quantite" /><br >
                <label for="description">Description du meuble </label><br >
                <textarea name="description" id="description"></textarea><br>
                <label for="categorie">Catégorie du meuble</label><br>
                <select id="categorie" name="categorie">
                    <option value="Tabel">Table</option>
                    <option value="Lit">Lit</option>
                    <option value="Armoire">Armoire</option>
                    
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
$nom = $_POST['nom'];
$couleur = $_POST['couleur'];
$quantite = $_POST['quantite'];
$description = $_POST['description'];
$categorie = $_POST['categorie'];
$photo = $_POST['photo'];
$prix = $_POST['prix'];
$user_id = $_SESSION['user_id'];


// Paramètres de connexion à la base de données
$servername = "localhost";  // Remplacez localhost par l'adresse du serveur MySQL
$username = "root";  // Remplacez votre_nom_d'utilisateur par votre nom d'utilisateur MySQL
$password = "";  // Remplacez votre_mot_de_passe par votre mot de passe MySQL
$dbname = "projet_asi";  // Remplacez nom_de_votre_base_de_données par le nom de votre base de données

try {
    // Connexion à la base de données avec PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Configurer PDO pour afficher les erreurs SQL
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparer la requête SQL d'insertion
    $stmt = $conn->prepare("INSERT INTO meuble (nom, couleur, description, categorie,image, prix, quantité) VALUES (:nom, :couleur, :Description, :Categorie, :Photo, :Prix, :quantite)");

    // Attribuer les valeurs aux paramètres de la requête
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':couleur', $couleur);
    $stmt->bindParam(':Description', $description);
    $stmt->bindParam(':Categorie', $categorie);
    $stmt->bindParam(':Photo', $photo);
    $stmt->bindParam(':Prix', $prix);
    $stmt->bindParam(':quantite', $quantite);
    

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
