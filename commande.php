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
  
  
 

// Vérifier si l'utilisateur est connecté   
if (!isset($_SESSION['email'])) {
  // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
  header("Location: connexion.php");
  exit;
}



?>


<main>
    <h2>Entrez vos informations d'achat</h2>
    <form method="POST" action="reussi.php">
        <fieldset>
            <label for="prenom" >Prénom</label><br >
            <input type="text" placeholder="prenom" name="prenom" id="prenom"/><br >
            <label for="nom">Nom</label><br >
            <input type="text" placeholder="nom" name="nom" id="nom" /><br >
            <label for="numero">Numéro de téléphone</label><br >
            <input type="number" placeholder="numero" name="numero" id="numero" /><br ><br>
            <label for="Adresse">Adresse</label><br >
            <input type="text" placeholder="Adresse" name="Adresse" id="Adresse" /><br ><br>

            <label for="paiement">Paiement</label><br>
                <select id="paiement" name="paiement">
                    <option value="liv">a la livraison</option>
                    <option value="carte">carte</option>
                   
                </select><br><br>


            <input type="submit" value="Envoyer"name="infoachat" />
        </fieldset>
    </form>
    
  <br>

     <form method="POST" action="favori.php">
    <button type="submit" name="logout">annuler</button>
    </form>

  </main>
  

<footer>
<p>MoussaInc &copy; 2023 - Tous droits réservés</p>
</footer>
</body>
</html>
