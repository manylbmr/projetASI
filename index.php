<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="site de vente de livres">
  <meta name="keywords" content="vente de livres">
  <link rel="shortcut icon" href="images/livre1.jpg" type="image/x-icon">
  <title>Accueil | FahemBooks</title>
  <link rel="stylesheet" href="css/nav.css" />
  <link rel="stylesheet" href="css/footer.css" />
</head>

<body>
  <?php 
    session_start();
    include('nav.php');
  ?>
  <main>
    <section>
      <h2>Meubles à la une</h2>
      <p>Voici les derniers livres ajoutés à notre site :</p>
      <ul class="amazon">
        <?php
       
        $servername = "localhost";  
        $username = "root"; 
        $password = "";  
        $dbname = "projet_web"; 

        try {
            // Connexion à la base de données avec PDO
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

            // Configurer PDO pour afficher les erreurs SQL
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Récupérer les livres de la base de données
            $stmt = $conn->query("SELECT * FROM livre2 ORDER BY id DESC");
            $livres = $stmt->fetchAll();




            // Afficher les livres dans la balise <ul><li>
            foreach ($livres as $livre) {
                echo '<li>';
                echo '<img src="' . $livre['photo'] . '" height="400" width="310">';
                echo '<p> Titre : ' . $livre['titre'] . '<br> Publié par ' . $livre['auteur'] . '<br>Catégorie : ' . $livre['categorie'] . '<br>' . $livre['description'] .  '<br>Prix: ' . $livre['prix'] . ' DA <br> Vendu par Amel, numéro : 0655102821</p>';
                
                // Vérifier si l'utilisateur est connecté
                if (isset($_SESSION['user_id'])) {
                    // Bouton "Ajouter aux favoris" avec un formulaire pour chaque livre
                    echo '<form action="index.php" method="POST">';
                    echo '<input type="hidden" name="livre_id" value="' . $livre['id'] . '">';
                    echo '<button type="submit" name="ajouter_favori">Ajouter aux favoris</button>';
                    echo '</form>';

                    // Vérifier si le formulaire a été soumis pour ajouter le livre aux favoris
                    if (isset($_POST['ajouter_favori']) && $_POST['livre_id'] == $livre['id']) {
    $livre_id = $_POST['livre_id'];
    $user_id = $_SESSION['user_id'];

    // Vérifier si le livre n'est pas déjà ajouté aux favoris par cet utilisateur
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM favoris WHERE user_id = :user_id AND livre_id = :livre_id");
    $checkStmt->bindParam(':user_id', $user_id);
    $checkStmt->bindParam(':livre_id', $livre_id);
    $checkStmt->execute();
    $count = $checkStmt->fetchColumn();

    if ($count == 0) {
        // Insérer le livre dans la table "favoris"
        $insertStmt = $conn->prepare("INSERT INTO favoris (user_id, livre_id) VALUES (:user_id, :livre_id)");
        $insertStmt->bindParam(':user_id', $user_id);
        $insertStmt->bindParam(':livre_id', $livre_id);
        $insertStmt->execute();

        echo '<p>Livre ajouté aux favoris !</p>';
    } else {
        echo '<p>Ce livre est déjà dans vos favoris.</p>';
    }
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

  
  <?php 
    include('footer.php');
  ?>
</body>
</html>
