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

  <title>armoires | moussaInc</title>
</head>
<body>
  <?php 
    session_start();
    include('nav.php');
  ?>
  
  <main>
    <section>
      <h2>armoires à la une</h2>
      <p>Voici les dernieres armoires ajoutées à notre site :</p>
      <ul>
        <ul>
        <?php
       
        $servername = "localhost";  
        $username = "root"; 
        $password = "";  
        $dbname = "projet_asi"; 

        try {
          // Connexion à la base de données avec PDO
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

          // Configurer PDO pour afficher les erreurs SQL
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          // Récupérer les meubles de la base de données
          $stmt = $conn->query("SELECT * FROM meuble WHERE categorie= 'armoire' ORDER BY id DESC");
          $meuble = $stmt->fetchAll();




          // Afficher les meubles dans la balise <ul><li>
          foreach ($meuble as $meuble) {
              echo '<li>';
              echo '<img src="' . $meuble['image'] . '" height="400" width="310">';
              echo '<p> nom : ' . $meuble['nom'] . '<br>Catégorie : ' . $meuble['categorie'] . '<br>' . $meuble['description'] .  '<br>Prix: ' . $meuble['prix'] .'<br> quantité:'. $meuble['quantité'] .'<br>';
              
              // Vérifier si l'utilisateur est connecté
              if (isset($_SESSION['user_id'])) {
                  // Bouton "Ajouter aux favoris" avec un formulaire pour chaque meuble
                  echo '<form action="index.php" method="POST">';
                  echo '<input type="hidden" name="meuble_id" value="' . $meuble['id'] . '">';
                  echo '<button type="submit" name="ajouter_panier">Ajouter au panier</button>';
                  echo '</form>';

                  // Vérifier si le formulaire a été soumis pour ajouter le meuble aux favoris
                  if (isset($_POST['ajouter_panier']) && $_POST['meuble_id'] == $meuble['id']) {
  $meuble_id = $_POST['meuble_id'];
  $user_id = $_SESSION['user_id'];
  

 
      // Insérer le livre dans la table "panier"
      $insertStmt = $conn->prepare("INSERT INTO panier (id_user, id_meuble) VALUES (:user_id, :meuble_id)");
      $insertStmt->bindParam(':user_id', $user_id);
      $insertStmt->bindParam(':meuble_id', $meuble_id);
      $insertStmt->execute();

      echo '<p>meuble ajouté au panier !</p>';
  
}
              } else {
                  // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
                  echo '<a href="connexion.php">Connectez-vous pour ajouter aux favoris</a>';
              }

              echo '</li>';
          }
      } catch(PDOException $e) {
          echo "Erreur lors de la récupération des livres : " . $e->getMessage();
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
