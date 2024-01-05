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
  <title>vente| FahemBooks</title>
</head>
<body>
    <?php 
    session_start();
    include('nav.php');
  ?>
  
  <main>
    
    <section>
        <h2>Comment vendre un livre ?</h2>
        <p>Pour vendre un livre sur FahemBooks:</p>
        <li>  vous devez d'abord vous inscrire. </li>
        <li> Si vous avez déjà un compte, vous pouvez vous <a href="connexion.php">connecter ici</a> </li>
        <li>Sinon, vous pouvez vous <a href="inscription.php">inscrire ici</a>.</li>
        <li>Publiez une annonce pour votre livre</li>
        <li>Attendez que quelqu'un vous contacte pour acheter votre livre</li>
        <li>Arrangez un rendez-vous avec l'acheteur pour échanger le livre contre de l'argent</li>
      </ol>
    </section>
    
  </main>
  
  <footer>
    <p>FahemBooks &copy; 2023 - Tous droits réservés</p>
  </footer>
</body>
</html>
