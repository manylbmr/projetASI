    <header>
   
      <h1>MoussaInc</h1>
      <nav>
        <ul>
          <li>
            <a href="index.php" >Accueil</a>
          </li>
          <li class="dropDown-menu">
            Categorie
            <ul>
              <li><a href="table.php" >table</a></li>
              <li><a href="armoire.php" >armoire</a></li>
              <li><a href="lit.php" >lit</a></li>
            </ul>
          </li>
          


          <li>
            <a href="connexion.php" >Connexion</a>
          </li>
          <li>
            <a href="inscription.php" >Inscription</a>
          </li>
                    <li class="dropDown-menu">
            Mon compte
            <ul>
              <li><a href="profil.php" >Modifier profile</a></li>
              <li><a href="favori.php" >Mon panier</a></li>
              <?php
if (isset($_SESSION['email'])) {

$email=$_SESSION['email'];

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

     // Vérifier si l'e-mail existe dans la base de données
     $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
     $stmt->bindParam(':email', $email);
     $stmt->execute();
     $user = $stmt->fetch(PDO::FETCH_ASSOC);

     // Vérifier le mot de passe
     if (1== $user['etat']) {

  ?>
              <li>
                <a href="annonce.php" >Publier un meuble</a>
              </li>
              <?php

               }
              } catch(PDOException $e) {
                  echo "Erreur lors de l'authentification : " . $e->getMessage();
              }
             
}
?>
            </ul>
          </li>
        </ul>
      </nav>
    </header>