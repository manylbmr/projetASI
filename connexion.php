<!DOCTYPE html>
<html lang="en">
  <head>
   <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="site de vente de livres">
  <meta name="keywords" content="vente de livres">
  <link rel="shortcut icon" href="images/livre1.jpg" type="image/x-icon">
  <title>Connexion | FahemBooks</title>
    <link
      href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap"
      rel="stylesheet"
    />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/nav.css" />
    <link rel="stylesheet" href="css/footer.css" />

    <title>Login #4</title>
  </head>
  <body>
    <?php 
       //Cette fonction ini_set() est utilisée pour modifier la configuration des sessions PHP.

      ini_set('session.gc_maxlifetime', 3600); //Définit la durée de vie maximale de la session en secondes (3600 secondes = 1 heure). 

      ini_set('session.cookie_lifetime', 0); // Définit la durée de vie du cookie de session. Une valeur de 0 signifie que le cookie expire à la fin de la session du navigateur.

      ini_set('session.use_only_cookies', 1); //Configure PHP pour utiliser uniquement les cookies pour stocker les identifiants de session.

      ini_set('session.cookie_secure', 1); //Configure le cookie de session pour être envoyé uniquement sur une connexion sécurisée (HTTPS).

      ini_set('session.cookie_httponly', 1); // Configure le cookie de session pour être accessible uniquement via le protocole HTTP.
      session_start(); // Démarre la session PHP. Cela permet d'utiliser les fonctionnalités de session, telles que le stockage des données utilisateur entre les pages.

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
                  <h3>Connexion <strong></strong></h3>
                </div>
                <form action="" method="POST">
                  <div class="form-group first">
                    <label for="email">Email</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="email@gmail.com"
                      name="email"
                      id="email"
                    />
                  </div>
                  <div class="form-group last mb-3">
                    <label for="motdepasse">Mot de passe</label>
                    <input
                      type="password"
                      class="form-control"
                      placeholder="********"
                      id="motdepasse"
                      name="motdepasse"
                    />
                  </div>

                  <div class="d-sm-flex mb-5 align-items-center">
                    <span class="ml-auto"
                      ><a href="inscription.php" class="forgot-pass"
                        >Vous n'avez pas de compte ? Inscrivez vous ici</a
                      ></span
                    >
                  </div>

                  <input
                    type="submit"
                    value="Connexion"
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
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $motdepasse = isset($_POST['motdepasse']) ? $_POST['motdepasse'] : '';

    // Paramètres de connexion à la base de données
    $servername = "localhost";  // Remplacez localhost par l'adresse du serveur MySQL
    $username = "root";  // Remplacez votre_nom_d'utilisateur par votre nom d'utilisateur MySQL
    $password = "";  // Remplacez votre_mot_de_passe par votre mot de passe MySQL
    $dbname = "projet_web";  // Remplacez nom_de_votre_base_de_données par le nom de votre base de données

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

        if (!$user) {
            echo "L'adresse e-mail n'existe pas.";
            exit;
        }

        // Vérifier le mot de passe
        if (password_verify($motdepasse, $user['motdepasse'])) {
            // Authentification réussie, enregistrer les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            // Rediriger l'utilisateur vers la page de profil ou toute autre page souhaitée
            header("Location: index.php");
            exit;
        } else {
            echo "Mot de passe incorrect.";
            exit;
        }
    } catch(PDOException $e) {
        echo "Erreur lors de l'authentification : " . $e->getMessage();
    }

    // Fermer la connexion à la base de données
    $conn = null;
}
?>
//Gestion de sessions : Les cookies sont souvent utilisés pour gérer les sessions des utilisateurs sur un site web. 
//Un identifiant de session unique est stocké dans un cookie, permettant au site de reconnaître l'utilisateur lorsqu'il accède à différentes pages. 
//Cela permet de maintenir l'état de connexion de l'utilisateur et de stocker des informations spécifiques à sa session.