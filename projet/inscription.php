<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inscrire'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $num_tel = $_POST['num_tel'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $animal_prefere = $_POST['animal_prefere'];
    $ami_enfance = $_POST['ami_enfance'];
    $pays_prefere = $_POST['pays_prefere'];
    $sexe = $_POST['sexe'];

    // Vérification si les mots de passe correspondent
    if ($password != $confirm_password) {
        echo '<script>
                alert("Les mots de passe ne correspondent pas.");
                window.location.href = "inscription.php";
              </script>';
        exit();
    }
    

    // Hachage du mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

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
    
    // Insérer les données dans la table utilisateur
    $stmt = $conn->prepare("INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, date_creation_compte, statut_compte, role) VALUES (:n, :p, :e, :hp, NOW(), 1, 'utilisateur')");
    $stmt->bindParam(':n', $nom);
    $stmt->bindParam(':p', $prenom);
    $stmt->bindParam(':e', $email);
    $stmt->bindParam(':hp', $hashed_password);
    $stmt->execute();
    $user_id = $conn->lastInsertId(); // Récupérer l'ID de l'utilisateur inséré

    // Insérer les données de sécurité
    $stmt = $conn->prepare("INSERT INTO securite (ID_IDENTIFIANT, quest_securite) VALUES (:id, :q)");
    $questions = "Animal préféré: " . $animal_prefere . "; Ami d'enfance: " . $ami_enfance . "; Pays préféré: " . $pays_prefere;
    $stmt->bindParam(':id', $user_id);
    $stmt->bindParam(':q', $questions);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO profil (ID_IDENTIFIANT, num_tel , genre) VALUES (:id, :num_tel, :genre)");
    $stmt->bindParam(':id', $user_id);
    $stmt->bindParam(':num_tel', $num_tel);
    $stmt->bindParam(':genre', $genre);

    // Fermeture de la connexion
    $conn = null;

    // Redirection vers la page de connexion
    header("Location: connexion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'inscription</title>
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
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        select {
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
        <h1>Inscription</h1>
        <form action="inscription.php" method="post">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="email" name="email" placeholder="Adresse e-mail" required>
            <input type="number" name="num_tel" id="num_tel" placeholder="numero de telephone" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required>
            <input type="text" name="animal_prefere" placeholder="Quel est votre animal préféré">
            <input type="text" name="ami_enfance" placeholder="Quel est votre ami d'enfance">
            <input type="text" name="pays_prefere" placeholder="Quel est votre pays préféré">
            <select name="sexe">
                <option value="homme">homme</option>
                <option value="femme">Femme</option>
            </select>
            <input type="submit" name="inscrire">
        </form>
        <p>Déjà inscrit ? <a href="connexion.php"><span>Se connecter</span></a></p>
    </div>
</body>
</html>
