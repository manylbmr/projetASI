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
      <h2>panier de meubles</h2>
      <p>voici votre panier :</p>
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
        $dbname = "projet_asi";

        try {
          // Connexion à la base de données avec PDO
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          // Vérifier si le formulaire a été soumis
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer l'ID du meuble à supprimer
            $meuble_id = $_POST['meuble_id'];
            $user_id = $_SESSION['user_id'];

            // Supprimer l'entrée correspondante dans la table "panier"
            $stmt = $conn->prepare("DELETE FROM panier WHERE id_user = :user_id AND id_meuble = :meuble_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':meuble_id', $meuble_id);
            $stmt->execute();
          }

          // Récupérer les livres favoris de l'utilisateur connecté
          $user_id = $_SESSION['user_id'];
          $stmt = $conn->prepare("SELECT meuble.* FROM meuble INNER JOIN panier ON meuble.id = panier.id_meuble WHERE panier.id_user = :user_id");
          $stmt->bindParam(':user_id', $user_id);
          $stmt->execute();
          $meubles = $stmt->fetchAll();

          // Afficher les livres dans la balise <ul><li>
          foreach ($meubles as $meuble) {
            echo '<li>';
            echo '<img src="' . $meuble['image'] . '" height="400" width="310">';
            echo '<p>' . $meuble['nom'] . '<br>catégorie : ' . $meuble['categorie'] . '<br>description: '.$meuble['description'] .  '<br>Prix: ' . $meuble['prix'] .'<br> quantité:'. $meuble['quantité'] .'<br>';
            echo '<form action="favori.php" method="POST">';
            echo '<input type="hidden" name="meuble_id" value="' . $meuble['id'] . '">';
            echo '<button type="submit">retirer du panier</button>';
            echo '</form>';
            echo '</li>';

          }

            


          echo '<form action="commande.php" method="POST">';
          echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
          echo '<button type="submit">valider le panier</button>';
          echo '</form>';






          
        } catch(PDOException $e) {
          echo "Erreur lors de la récupération des meubles du panier : " . $e->getMessage();
        }

        // Fermer la connexion à la base de données
        $conn = null;
        ?>
      </ul>
    </section>
  </main>
  
  <footer>
    <p>MoussaInc &copy; 2023 - Tous droits réservés</p>
  </footer>
</body>
</html>
