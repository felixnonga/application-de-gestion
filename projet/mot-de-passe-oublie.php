<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $ami_enfance = $_POST['ami_enfance'];
    $pays_prefere = $_POST['pays_prefere'];
    $animal_prefere = $_POST['animal_prefere'];

    // Connexion à la base de données
    $dsn = "mysql:host=localhost;dbname=systeme_vh";
    $username = "root";
    $password_db = ""; // Renommé pour éviter le conflit avec le champ du formulaire

    try {
        $conn = new PDO($dsn, $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    // Rechercher l'utilisateur par email
    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Récupérer les questions de sécurité
        $user_id = $user['ID_IDENTIFIANT'];
        $stmt = $conn->prepare("SELECT * FROM securite WHERE ID_IDENTIFIANT = :id");
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        $securite = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($securite) {
            // Vérifier les réponses aux questions de sécurité
            $questions = "Animal préféré: " . $animal_prefere . "; Ami d'enfance: " . $ami_enfance . "; Pays préféré: " . $pays_prefere;
            if ($questions == $securite['quest_securite']) {
                // Démarrer la session et enregistrer l'email pour l'authentification
                session_start();
                $_SESSION['authenticated'] = true;
                $_SESSION['email'] = $email;
            
                // Redirection vers la page de confirmation
                header("Location: confirmation.php");
                exit();
            
            } else {
                echo "Les réponses aux questions de sécurité sont incorrectes.";
            }
        } else {
            echo "Aucune question de sécurité trouvée pour cet utilisateur.";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet email.";
    }

    // Fermeture de la connexion
    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
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
            background-color: #0056b3; /* Bleu */
            border-radius: 10px;
        }
        h1 {
            color: #ffffff; /* Blanc */
        }
        input[type="email"],
        input[type="text"] {
            width: 100%;
            padding: 15px; /* Agrandir la taille des champs */
            margin-bottom: 10px;
            border: 1px solid #ffffff;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: red; /* Rouge */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        a {
            color: #ffffff; /* Blanc */
            text-decoration: none;
        }
        .logo {
            max-width: 100px; /* Ajustez la taille du logo */
            margin: 20px auto; /* Centrer le logo verticalement */
            display: block;
        }
        span{
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="logo T.png" alt="Logo" class="logo">
        <h1>Mot de passe oublié</h1>
        <form action="mot-de-passe-oublie.php" method="post">
            <input type="email" name="email" placeholder="Adresse e-mail" required>
            <input type="text" name="ami_enfance" placeholder="Quel est votre ami d'enfance?" required>
            <input type="text" name="pays_prefere" placeholder="Quel est votre pays préféré?" required>
            <input type="text" name="animal_prefere" placeholder="Quel est votre animal préféré?" required>
            <input type="submit" value="Réinitialiser le mot de passe">
        </form>
        <p>Retour à la <a href="connexion.php"><span>connexion</span></a></p>
    </div>
</body>
</html>
