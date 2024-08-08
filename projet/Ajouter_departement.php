<?php
$dsn = "mysql:host=localhost;dbname=systeme_vh";
$username = "root";
$password = "";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_department'])) {
    $nom_depart = $_POST['nom_depart'];
    
    $sql = "INSERT INTO departement (nom_depart) VALUES (:nom_depart)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nom_depart', $nom_depart);
    $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_department'])) {
    $code_depart = $_POST['code_depart'];
    $nom_depart = $_POST['nom_depart'];
    
    $sql = "UPDATE departement SET nom_depart = :nom_depart WHERE code_depart = :code_depart";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':code_depart', $code_depart);
    $stmt->bindParam(':nom_depart', $nom_depart);
    $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete'])) {
    $code_depart = $_GET['delete'];
    $sql = "DELETE FROM departement WHERE code_depart = :code_depart";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':code_depart', $code_depart);
    $stmt->execute();
}

$search = '';
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM departement WHERE nom_depart LIKE :search";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();
    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $departments = $conn->query("SELECT * FROM departement")->fetchAll(PDO::FETCH_ASSOC);
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des départements</title>
    <style>
        body {
            background-color: #0074D9;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1200px; /* Agrandir la largeur du cadre */
            margin: 0 auto;
            padding: 20px;
            background-color: #FFFFFF;
            border-radius: 20px; /* Bordures un peu rondes */
            text-align: center; /* Centrer le contenu */
        }
        h1 {
            font-size: 36px; /* Agrandir la taille du titre */
        }
        table {
            width: 100%; /* Agrandir la largeur du tableau */
            border-collapse: collapse;
            margin-top: 20px; /* Espacement du tableau par rapport au titre */
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #3498DB;
            color: #FFFFFF;
        }
        tr:nth-child(even) {
            background-color: #F2F2F2;
        }
        .btn-modifier, .btn-supprimer {
            padding: 5px 10px;
            background-color: #2ECC71;
            color: #FFFFFF;
            border: none;
            cursor: pointer;
            border-radius: 5px; /* Bordures un peu rondes */
        }
        .btn-supprimer {
            background-color: #E74C3C;
        }
        .edit-input {
            width: 100px; /* Ajustez la largeur des champs de texte selon vos besoins */
        }
        .datepicker {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        #btnAjouterTable {
            background-color: #E74C3C;
            font-size: 18px; /* Agrandir la taille du bouton */
            width: 250px; /* Agrandir la largeur du bouton */
            margin: 20px auto; /* Centrer le bouton horizontalement */
            display: block;
            border: none; /* Supprimer la bordure noire */
            color: #FFFFFF; /* Écriture en blanc */
            border-radius: 10px; /* Bordures un peu rondes */
        }
        #formAjout {
            display: none;
            text-align: left;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 10px;
        }
        .form-group label {
            display: inline-block;
            width: 150px;
        }
        .form-group input {
            width: calc(100% - 160px);
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .form-group button {
            margin-left: 10px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            background-color: #2ECC71;
            color: #FFFFFF;
            cursor: pointer;
        }
        .form-group button.cancel {
            background-color: #E74C3C;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestion des départements</h1>
        <div id="formAjout">
            <div class="form-group">
                <label for="codeDepartement">Code département :</label>
                <input type="text" id="codeDepartement">
            </div>
            <div class="form-group">
                <label for="nomDepartement">Nom du département :</label>
                <input type="text" id="nomDepartement">
            </div>
            <div class="form-group">
                <button id="btnAjouterDepartement" onclick="ajouterDepartement()">Ajouter</button>
                <button class="cancel" onclick="annulerAjout()">Annuler</button>
            </div>
            <div id="errorMessages"></div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Code département</th>
                    <th>Nom du département</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Lignes de départements ici -->
                <tr>
                    <td>001</td>
                    <td>Informatique</td>
                    <td>
                        <button class="btn-modifier">Modifier</button>
                        <button class="btn-supprimer">Supprimer</button>
                    </td>
                </tr>
                <tr>
                    <td>002</td>
                    <td>Mathématiques</td>
                    <td>
                        <button class="btn-modifier">Modifier</button>
                        <button class="btn-supprimer">Supprimer</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button id="btnAjouterTable" class="btn-modifier">Ajouter un département</button>
    </div>

    <script>
        const tableBody = document.querySelector('tbody');
        const formAjout = document.getElementById('formAjout');
        const btnAjouterDepartement = document.getElementById('btnAjouterDepartement');
        const btnAnnuler = document.querySelector('.cancel');
        const errorMessages = document.getElementById('errorMessages');
        const btnAjouterTable = document.getElementById('btnAjouterTable');
        let modeAjout = true; // Variable pour suivre l'état (ajout ou modification)

        // Afficher le formulaire d'ajout de département
        btnAjouterTable.addEventListener('click', () => {
            formAjout.style.display = 'block';
            resetForm();
            modeAjout = true; // Mode ajout lorsqu'on clique sur "Ajouter un département"
        });

        // Fonction pour ajouter un département
        function ajouterDepartement() {
            const codeDepartement = document.getElementById('codeDepartement').value;
            const nomDepartement = document.getElementById('nomDepartement').value;

            // Réinitialiser les messages d'erreur
            errorMessages.innerHTML = '';

            // Vérifier si tous les champs sont remplis
            if (codeDepartement.trim() === '' || nomDepartement.trim() === '') {
                displayError('Veuillez remplir tous les champs.');
                return; // Arrêter la fonction si les champs ne sont pas tous remplis
            }

            if (modeAjout) {
                // Ajouter le département à la table en mode ajout
                ajouterLigne(codeDepartement, nomDepartement);
            } else {
                // Mettre à jour la ligne dans le tableau en mode modification
                const row = document.querySelector('.editing'); // Récupère la ligne en cours d'édition
                updateRow(row, codeDepartement, nomDepartement);
                row.classList.remove('editing'); // Retire la classe d'édition
            }

            // Réinitialiser le formulaire et cacher le formulaire
            resetForm();
            formAjout.style.display = 'none';
        }

        // Fonction pour annuler l'ajout ou la modification de département
        function annulerAjout() {
            resetForm();
            formAjout.style.display = 'none';
        }

        // Réinitialiser les champs du formulaire et les messages d'erreur
        function resetForm() {
            document.getElementById('codeDepartement').value = '';
            document.getElementById('nomDepartement').value = '';
            document.getElementById('codeDepartement').style.border = '1px solid #ccc';
            document.getElementById('nomDepartement').style.border = '1px solid #ccc';
            errorMessages.innerHTML = '';
        }

        // Afficher un message d'erreur
        function displayError(message) {
            const errorMessage = `<div class="error-message">${message}</div>`;
            errorMessages.innerHTML = errorMessage;
        }

        // Fonction pour ajouter une ligne à la table
        function ajouterLigne(code, nom) {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${code}</td>
                <td>${nom}</td>
                <td>
                    <button class="btn-modifier">Modifier</button>
                    <button class="btn-supprimer">Supprimer</button>
                </td>
            `;
            tableBody.appendChild(newRow);
        }

        // Fonction pour mettre à jour une ligne dans le tableau
        function updateRow(row, code, nom) {
            const cells = row.cells;
            cells[0].textContent = code;
            cells[1].textContent = nom;
        }

        // Écouteur pour le bouton "Modifier"
        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('btn-modifier')) {
                const row = event.target.closest('tr');
                modifierDepartement(row);
            }
        });

        // Fonction pour modifier le département
        function modifierDepartement(row) {
            const cells = row.cells;
            const codeDepartement = cells[0].textContent;
            const nomDepartement = cells[1].textContent;

            // Remplir le formulaire avec les valeurs actuelles du département
            document.getElementById('codeDepartement').value = codeDepartement;
            document.getElementById('nomDepartement').value = nomDepartement;

            // Passer en mode modification
            modeAjout = false;

            // Marquer la ligne en édition avec une classe CSS
            row.classList.add('editing');

            // Afficher le formulaire d'ajout/modification
            formAjout.style.display = 'block';
        }

        // Écouteur pour le bouton "Supprimer"
        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('btn-supprimer')) {
                const row = event.target.closest('tr');
                const confirmation = confirm('Êtes-vous sûr de vouloir supprimer ce département ?');
                if (confirmation) {
                    row.remove();
                }
            }
        });
    </script>
</body>
</html>
