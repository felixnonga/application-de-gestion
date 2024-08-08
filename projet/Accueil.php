<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Suivi des Volumes Horaires</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .header {
            background-color: #0056b3;
            color: #ffffff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            flex-wrap: wrap;
        }
        .logo {
            max-width: 100px;
            margin-left: 20px;
            max-height: 60px;
        }
        .title {
            font-size: 1.5em;
            font-weight: bold;
            color: #fff;
            text-align: center;
            flex: 1;
            margin: 10px 0;
        }
        .profile-icon {
            width: 80px;
            height: 80px;
            background-color: #fff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #0056b3;
            font-size: 24px;
            margin-left: 18px;
            order: 2;
        }
        .nav {
            background-color: #ffffff;
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            flex-wrap: wrap;
        }
        .nav a {
            text-decoration: none;
            color: #0056b3;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            display: inline-block;
        }
        .nav a:hover {
            background-color: #0056b3;
            color: #ffffff;
        }
        .sub-menu {
            position: relative;
            display: inline-block;
        }
        .sub-menu-content {
            display: none;
            position: absolute;
            background-color: #ffffff;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            z-index: 1;
        }
        .sub-menu:hover .sub-menu-content {
            display: block;
        }
        .sub-menu-content a {
            color: #0056b3;
            padding: 10px;
            text-decoration: none;
            display: block;
        }
        .sub-menu-content a:hover {
            background-color: #0056b3;
            color: #ffffff;
        }
        .container {
            max-width: 80%;
            margin: 10px auto;
            padding: 20px;
            background-color: #c0c0c0;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            flex: 1;
        }
        h2 {
            color: #0056b3;
            text-align: center;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: #0056b3;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #ff4d4d;
        }
        .button:hover + .sub-menu-content {
            display: block;
        }
        .logout-button {
            background-color: #ff4d4d;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .logout-button:hover {
            background-color: #e60000;
        }
        .footer {
            background-color: #0056b3;
            color: #ffffff;
            text-align: center;
            padding: 5px 0;
            position: relative;
            width: 100%;
            max-width: 100%;
            margin-top: auto;
        }

        @media only screen and (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .logo {
                margin: 10px 0;
            }
            .title {
                margin: 10px 0;
            }
            .profile-icon {
                margin-left: 0;
            }
            .nav {
                flex-wrap: wrap;
                justify-content: center;
            }
            .nav a {
                padding: 10px;
                margin: 5px;
            }
            .sub-menu-content {
                position: static;
                display: none;
                box-shadow: none;
            }
            .sub-menu:hover .sub-menu-content {
                display: block;
                position: static;
            }
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="logo T.png" alt="Logo" class="logo">
        <div class="title">GESTION DES ENSEIGNEMENTS</div>
        <div class="icon-container">
            <div class="profile-icon">👤</div>
            <div class="upload-buttons">
                <a href="upload.php" class="upload-button" onclick="openFilePicker('add')">ajouter</a>
                <button class="upload-button" onclick="openFilePicker('modify')">Modifier</button>
            </div>
        </div>
    </div>

    <div class="nav">
        <a href="accueil.php">Accueil</a>
        <div class="sub-menu">
            <a href="#">DEP/UE</a>
            <div class="sub-menu-content">
                <a href="Ajouter_departement.php">Département</a>
                <a href="gestion UE.php">Unité d'enseignement</a>
            </div>
        </div>
        <div class="sub-menu">
            <a href="#">CLASSE/FIL/SEM</a>
            <div class="sub-menu-content">
                <a href="gestion classes.php">Classe</a>
                <a href="filière.php">Filière</a>
                <a href="gestion des semestres.php">Semestre</a>
            </div>
        </div>
        <a href="#">À propos de nous</a>
        <button class="logout-button" onclick="confirmLogout()">Déconnexion</button>
    </div>

    <div class="container">
        <h2>Bienvenue à l'ISST LA SAPIENCE</h2>
        <p>Cette application vous permet de gérer et de suivre les volumes horaires des étudiants et des enseignants.</p>
        <p>Choisissez une action :</p>
        <div class="sub-menu">
            <a href="#" class="button"> Rapports</a>
            <div class="sub-menu-content">
                <a href="#">Rapport</a>
                <a href="#">VTH</a>
                <a href="#">Récap</a>
            </div>
        </div>
        <a href="#" class="button">Dispense </a>
        <a href="gestion des enseignant.php" class="button"> Enseignants</a> 
    </div>

    <div class="footer">
        <p>&copy; 2024 ISST LA SAPIENCE. Tous droits réservés.</p>
    </div>

    <script>
        function openFilePicker(action) {
            console.log(`Action: ${action}`);
        }

        function confirmLogout() {
           
            if (confirm("Voulez-vous vraiment vous déconnecter ?")) {
                alert("Vous êtes déconnecté.");
                header ("connexion.php");
            }
        }
    </script>
</body>
</html>
