<?php
session_start(); // Démarrez la session si ce n'est pas déjà fait

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous que l'utilisateur est authentifié via les questions de sécurité
    if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
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

        // Récupérer l'email depuis la session
        $email = $_SESSION['email'];

        // Récupérer le nouveau mot de passe depuis le formulaire
        $nouveau_mot_de_passe = $_POST['nouveau_mot_de_passe'];
        
        // Hasher le mot de passe
        $hashed_password = password_hash($nouveau_mot_de_passe, PASSWORD_DEFAULT);

        // Mettre à jour le mot de passe dans la base de données
        $stmt = $conn->prepare("UPDATE utilisateur SET mot_de_passe = :mot_de_passe WHERE email = :email");
        $stmt->bindParam(':mot_de_passe', $hashed_password);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            echo "Mot de passe mis à jour avec succès.";
            // Optionnel : Rediriger l'utilisateur vers une autre page après la mise à jour
            // header("Location: autre_page.php");
            // exit();
        } else {
            echo "Erreur lors de la mise à jour du mot de passe.";
        }

        // Fermeture de la connexion
        $conn = null;
    } else {
        echo "Session non authentifiée.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation du mot de passe</title>
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
        input[type="password"] {
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
        <h1>Changement de mot de passe</h1>
        <form action="confirmation.php" method="post">
            <input type="password" name="nouveau_mot_de_passe" placeholder="Nouveau mot de passe" required>
            <input type="password" name="confirm_mot_de_passe" placeholder="Confirmer le mot de passe" required>
            <input type="submit" value="Confirmer">
        </form>
        <p>Retour à la <a href="connexion.php"><span>connexion</span></a></p>
    </div>
</body>
</html>
