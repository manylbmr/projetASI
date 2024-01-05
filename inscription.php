<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="site de vente de livres" />
    <meta name="keywords" content="vente de livres" />
    <link rel="shortcut icon" href="images/livre1.jpg" type="image/x-icon" />
    <title>inscription | FahemBooks</title>
    <link
      href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap"
      rel="stylesheet"
    />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/nav.css" />

    <title>Insription</title>
  </head>
  <body>
     <?php 
      include('nav.php');
     ?>
    <div class="d-md-flex half">
      <div class="bg" style="background-image: url('images/biblio2.png')"></div>
      <div class="contents">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-12">
              <div class="form-block mx-auto">
                <div class="text-center mb-5">
                  <h3>Insription <strong></strong></h3>
                </div>
                <form action="#" method="post">
                  <div class="form-group first">
                    <label for="nom">Nom</label>
                    <input
                      type="text"
                      class="form-control"
                      name="nom"
                      id="nom"
                    />
                  </div>
                  <div class="form-group first">
                    <label for="prenom">Prénom</label>
                    <input
                      type="text"
                      class="form-control"
                      name="prenom"
                      id="prenom"
                    />
                  </div>
                  <div class="form-group first">
                    <label for="email">Email</label>
                    <input
                      type="text"
                      class="form-control"
                      name="email"
                      id="email"
                    />
                  </div>
                  <div class="form-group first">
                    <label for="numero">Numéro de télephone</label>
                    <input
                      type="text"
                      class="form-control"
                      name="numero"
                      id="numero"
                    />
                  </div>

                  <div class="form-group last mb-3">
                    <label for="motdepasse">Mot de passe</label>
                    <input
                      type="password"
                      class="form-control"
                      name="motdepasse"
                      id="motdepasse"
                    />
                  </div>

                  <div class="d-sm-flex mb-5 align-items-center">
                    <span class="ml-auto"
                      ><a href="connexion.php" class="forgot-pass"
                        >Vous avez déjà un compte ? Connectez vous ici</a
                      ></span
                    >
                  </div>

                  <input
                    type="submit"
                    value="inscription"
                    class="btn btn-block btn-primary"
                  />
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Récupérer les données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$motdepasse = $_POST['motdepasse'];
$numero = $_POST['numero'];

// Vérifier le format de l'e-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo "L'adresse e-mail n'est pas valide.";
  exit;
}

// Vérifier la longueur du mot de passe
if (strlen($motdepasse) < 6) {
  echo "Le mot de passe doit contenir au moins 6 caractères.";
  exit;
}

// Hacher le mot de passe
$motdepasse_hache = password_hash($motdepasse, PASSWORD_DEFAULT);



// Paramètres de connexion à la base de données
$servername = "localhost"; 
$username = "root";  
$password = "";  
$dbname = "projet_web";  

try {
    // Connexion à la base de données 
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Configurer PDO pour afficher les erreurs SQL
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si l'e-mail est déjà utilisé
    $stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {
        echo "L'adresse e-mail est déjà utilisée.";
        exit;
    }

    // Préparer la requête SQL d'insertion
    $stmt = $conn->prepare("INSERT INTO user (nom, prenom, email, motdepasse,numero) VALUES (:nom, :prenom, :email, :motdepasse, :numero)");

    // Attribuer les valeurs aux paramètres de la requête
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':motdepasse', $motdepasse_hache); // Utiliser le mot de passe haché
    $stmt->bindParam(':numero', $numero);
   
    

    // Exécuter la requête
    $stmt->execute();

    echo "utilisateur créé avec succès !";
} catch(PDOException $e) {
    echo "Erreur lors de la création de l'utilisateur : " . $e->getMessage();
}

// Fermer la connexion à la base de données
$conn = null;
}
?>
