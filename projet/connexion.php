<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connexion à la base de données
    $dsn = "mysql:host=localhost;dbname=systeme_vh";
    $username = "root";
    $db_password = ""; // Renommez cette variable pour éviter la confusion avec le mot de passe d'utilisateur

    try {
        $conn = new PDO($dsn, $username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    // Préparation et exécution de la requête SQL
    $stmt = $conn->prepare("SELECT ID_IDENTIFIANT, mot_de_passe FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]); // Utilisation de execute() avec un tableau de valeurs

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['ID_IDENTIFIANT'];
        $hashed_password = $row['mot_de_passe'];

        // Vérification du mot de passe
        if (password_verify($password, $hashed_password)) {
            // Connexion réussie
            $_SESSION['user_id'] = $user_id;
            header("Location: Accueil.php"); // Rediriger vers la page d'accueil
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Adresse e-mail non trouvée.";
    }

    $conn = null; // Fermeture de la connexion
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #0056b3; /* Bleu */
            color: #ffffff; /* Blanc */
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 100%;
            max-width: 600px; /* Ajustez la largeur selon vos préférences */
            padding: 20px;
            background-color: #ffffff; /* Gris clair */
            border-radius: 10px;
        }
        h1 {
            color: #0056b3; /* Bleu */
        }
        input[type="email"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #beb9b9;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 90%;
            padding: 10px;
            background-color: #ff0000; /* Rouge */
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        a {
            color: #ff0000; /* Rouge */
            text-decoration: none;
        }
        .logo {
            max-width: 100px; /* Ajustez la taille du logo */
            margin: 0 auto; /* Centrer le logo horizontalement */
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="logo sapience.jpg" alt="Logo" class="logo">
        <h1>Bienvenue</h1>
        <form action="connexion.php" method="post">
            <input type="email" name="email" placeholder="Adresse e-mail" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="submit" value="Se connecter">
        </form>
        <p><a href="inscription.php">Pas encore inscrit ?</a></p>
        <p><a href="mot-de-passe-oublie.php">Mot de passe oublié ?</a></p> <!-- Lien vers la page de réinitialisation du mot de passe -->
    </div>
</body>
</html>
