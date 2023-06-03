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
  <title>Favori | FahemBooks</title>
</head>
<body>
  <?php 
    session_start();
    include('nav.php');
  ?>
  
  <main>
    <section>
      <h2>Liste de mes livres favoris</h2>
      <p>Voici la liste de mes livres favoris :</p>
      <ul>
        <?php
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['email'])) {
          // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
          header("Location: connexion.php");
          exit;
        }
        
        // Paramètres de connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "projet_web";

        try {
          // Connexion à la base de données avec PDO
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          // Vérifier si le formulaire a été soumis
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer l'ID du livre à supprimer
            $livre_id = $_POST['livre_id'];
            $user_id = $_SESSION['user_id'];

            // Supprimer l'entrée correspondante dans la table "favoris"
            $stmt = $conn->prepare("DELETE FROM favoris WHERE user_id = :user_id AND livre_id = :livre_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':livre_id', $livre_id);
            $stmt->execute();
          }

          // Récupérer les livres favoris de l'utilisateur connecté
          $user_id = $_SESSION['user_id'];
          $stmt = $conn->prepare("SELECT livre2.* FROM livre2 INNER JOIN favoris ON livre2.id = favoris.livre_id WHERE favoris.user_id = :user_id");
          $stmt->bindParam(':user_id', $user_id);
          $stmt->execute();
          $livres = $stmt->fetchAll();

          // Afficher les livres dans la balise <ul><li>
          foreach ($livres as $livre) {
            echo '<li>';
            echo '<img src="' . $livre['photo'] . '" height="400" width="310">';
            echo '<p>' . $livre['titre'] . ' publié par ' . $livre['auteur'] . ' dans la catégorie : ' . $livre['categorie'] . '<br>Prix: ' . $livre['prix'] . ' DA</p>';
            echo '<form action="favori.php" method="POST">';
            echo '<input type="hidden" name="livre_id" value="' . $livre['id'] . '">';
            echo '<button type="submit">Supprimer des favoris</button>';
            echo '</form>';
            echo '</li>';
          }
        } catch(PDOException $e) {
          echo "Erreur lors de la récupération des livres favoris : " . $e->getMessage();
        }

        // Fermer la connexion à la base de données
        $conn = null;
        ?>
      </ul>
    </section>
  </main>
  
  <footer>
    <p>FahemBooks &copy; 2023 - Tous droits réservés</p>
  </footer>
</body>
</html>
