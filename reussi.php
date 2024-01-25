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

    <style>
        .center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
 session_start();
 include('nav.php');
  // Vérifier si le formulaire a été soumis
  


    $user_id = $_SESSION['user_id'];
   
    // Supprimer l'entrée correspondante dans la table "panier"
    $stmt = $conn->prepare("DELETE FROM panier WHERE id_user = :user_id ");
    $stmt->bindParam(':user_id', $user_id);
    
    $stmt->execute();


?>
   
    <div class="center">
        <h1>commande passée</h1>
        <img src="https://th.bing.com/th/id/OIP.9OKbuxw7W_O6qyfyHouu7gHaHa?w=167&h=180&c=7&r=0&o=5&dpr=1.3&pid=1.7" alt="ok" style="width: 35%;">
        <form method="POST" action="index.php">
            <input type="submit" value="retour à l'accueil" name="infoachat" style="font-size: 50px;" >
        </form>
    </div>
</body>
</html>
    
    
</body>
</html>