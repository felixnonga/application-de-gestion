<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des filières</title>
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
            background-color: red; /* Fond du bouton Ajouter une filière en rouge */
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
        <h1>Gestion des filières</h1>
        <div id="formAjout">
            <div class="form-group">
                <label for="codeFiliere">Code de la filière :</label>
                <input type="text" id="codeFiliere">
            </div>
            <div class="form-group">
                <label for="nomFiliere">Nom de la filière :</label>
                <input type="text" id="nomFiliere">
            </div>
            <div class="form-group">
                <button id="btnAjouterFiliere" onclick="ajouterFiliere()">Ajouter</button>
                <button class="cancel" onclick="annulerAjout()">Annuler</button>
            </div>
            <div id="errorMessages"></div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Code filière</th>
                    <th>Nom filière</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Lignes de filières ici -->
                <tr>
                    <td>INF</td>
                    <td>Informatique</td>
                    <td>
                        <button class="btn-modifier">Modifier</button>
                        <button class="btn-supprimer">Supprimer</button>
                    </td>
                </tr>
                <tr>
                    <td>MATH</td>
                    <td>Mathématiques</td>
                    <td>
                        <button class="btn-modifier">Modifier</button>
                        <button class="btn-supprimer">Supprimer</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button id="btnAjouterTable" class="btn-modifier">Ajouter une filière</button>
    </div>

    <script>
        const tableBody = document.querySelector('tbody');
        const btnAjouter = document.getElementById('btnAjouter');
        const formAjout = document.getElementById('formAjout');
        const btnAjouterFiliere = document.getElementById('btnAjouterFiliere');
        const btnAnnuler = document.querySelector('.cancel');
        const errorMessages = document.getElementById('errorMessages');
        const btnAjouterTable = document.getElementById('btnAjouterTable');

        // Afficher le formulaire d'ajout de filière
        btnAjouterTable.addEventListener('click', () => {
            formAjout.style.display = 'block';
            resetForm();
        });

        // Fonction pour ajouter une filière
        function ajouterFiliere() {
            const codeFiliere = document.getElementById('codeFiliere').value;
            const nomFiliere = document.getElementById('nomFiliere').value;

            // Réinitialiser les messages d'erreur
            errorMessages.innerHTML = '';

            // Vérifier si tous les champs sont remplis
            if (codeFiliere.trim() === '' || nomFiliere.trim() === '') {
                displayError('Veuillez remplir tous les champs.');
                return; // Arrêter la fonction si les champs ne sont pas tous remplis
            }

            // Ajouter la filière à la table
            ajouterLigne(codeFiliere, nomFiliere);

            // Réinitialiser le formulaire et cacher le formulaire
            resetForm();
            formAjout.style.display = 'none';
        }

        // Annuler l'ajout de filière
        function annulerAjout() {
            resetForm();
            formAjout.style.display = 'none';
        }

        // Réinitialiser les champs du formulaire et les messages d'erreur
        function resetForm() {
            document.getElementById('codeFiliere').value = '';
            document.getElementById('nomFiliere').value = '';
            document.getElementById('codeFiliere').style.border = '1px solid #ccc';
            document.getElementById('nomFiliere').style.border = '1px solid #ccc';
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

        // Écouteur pour le bouton "Modifier"
        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('btn-modifier')) {
                const row = event.target.closest('tr');
                modifierFiliere(row);
            }
        });

        // Fonction pour modifier la filière
        function modifierFiliere(row) {
            const cells = row.cells;
            const codeFiliere = cells[0].textContent;
            const nomFiliere = cells[1].textContent;

            cells[0].innerHTML = `<input type="text" class="edit-input" value="${codeFiliere}" onchange="updateCellValue(this, 'code')">`;
            cells[1].innerHTML = `<input type="text" class="edit-input" value="${nomFiliere}" onchange="updateCellValue(this, 'nom')">`;
        }

        // Fonction pour mettre à jour la valeur de la cellule
        function updateCellValue(input, type) {
            const newValue = input.value.trim();
            const row = input.closest('tr');
            const cells = row.cells;

            if (type === 'code') {
                cells[0].textContent = newValue;
            } else if (type === 'nom') {
                cells[1].textContent = newValue;
            }
        }

        // Écouteur pour le bouton "Supprimer"
        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('btn-supprimer')) {
                const row = event.target.closest('tr');
                const confirmation = confirm('Êtes-vous sûr de vouloir supprimer cette filière ?');
                if (confirmation) {
                    row.remove();
                }
            }
        });
    </script>
</body>
</html>
