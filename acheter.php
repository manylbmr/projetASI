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
  <title>Acheter | FahemBooks</title>
</head>
<body>
  <?php 
    session_start();
    include('nav.php');
  ?>
  
  <main>
    <section>
      <h2>Comment acheter un livre ?</h2>
      <p>Pour acheter un livre sur FahemBooks, suivez ces étapes :</p>
      <ol>
        <li>le livre que vous souhaitez acheter</li>
        <li>Contactez le vendeur pour négocier le prix et le lieu d'échange</li>
        <li>Rencontrez le vendeur pour échanger de l'argent contre le livre</li>
      </ol>
    </section>
  </main>
  
  <footer>
    <p>FahemBooks &copy; 2023 - Tous droits réservés</p>
  </footer>
</body>
</html>
