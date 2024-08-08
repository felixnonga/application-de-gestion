<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des semestres</title>
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
        #btnAjouter {
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
        <h1>Gestion des semestres</h1>
        <div id="formAjout">
            <div class="form-group">
                <label for="numeroSemestre">Numéro du semestre :</label>
                <input type="text" id="numeroSemestre">
            </div>
            <div class="form-group">
                <label for="dateDebut">Date de début :</label>
                <input type="date" id="dateDebut">
            </div>
            <div class="form-group">
                <label for="dateFin">Date de fin :</label>
                <input type="date" id="dateFin">
            </div>
            <div class="form-group">
                <button id="btnAjouterSemestre" onclick="ajouterSemestre()">Ajouter</button>
                <button class="cancel" onclick="annulerAjout()">Annuler</button>
            </div>
            <div id="errorMessages"></div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Numéro semestre</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Lignes de semestres ici -->
                <tr>
                    <td>1</td>
                    <td>2024-01-10</td>
                    <td>2024-05-30</td>
                    <td>
                        <button class="btn-modifier">Modifier</button>
                        <button class="btn-supprimer">Supprimer</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>2024-06-10</td>
                    <td>2024-11-30</td>
                    <td>
                        <button class="btn-modifier">Modifier</button>
                        <button class="btn-supprimer">Supprimer</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button id="btnAjouterTable" class="btn-modifier">Ajouter un semestre</button>
    </div>

    <script>
        const tableBody = document.querySelector('tbody');
        const btnAjouter = document.getElementById('btnAjouter');
        const formAjout = document.getElementById('formAjout');
        const btnAjouterSemestre = document.getElementById('btnAjouterSemestre');
        const btnAnnuler = document.querySelector('.cancel');
        const errorMessages = document.getElementById('errorMessages');
        const btnAjouterTable = document.getElementById('btnAjouterTable');

        // Afficher le formulaire d'ajout de semestre
        btnAjouterTable.addEventListener('click', () => {
            formAjout.style.display = 'block';
            resetForm();
        });

        // Fonction pour ajouter un semestre
        function ajouterSemestre() {
            const numeroSemestre = document.getElementById('numeroSemestre').value;
            const dateDebut = document.getElementById('dateDebut').value;
            const dateFin = document.getElementById('dateFin').value;

            // Réinitialiser les messages d'erreur
            errorMessages.innerHTML = '';

            // Vérifier si tous les champs sont remplis
            if (numeroSemestre.trim() === '' || dateDebut === '' || dateFin === '') {
                displayError('Veuillez remplir tous les champs.');
                return; // Arrêter la fonction si les champs ne sont pas tous remplis
            }

            // Vérifier si la date de début est antérieure à la date de fin
            if (new Date(dateDebut) >= new Date(dateFin)) {
                displayError('La date de début doit être antérieure à la date de fin.');
                return; // Arrêter la fonction si la validation de date échoue
            }

            // Ajouter le semestre à la table
            ajouterLigne(numeroSemestre, dateDebut, dateFin);

            // Réinitialiser le formulaire et cacher le formulaire
            resetForm();
            formAjout.style.display = 'none';
        }

        // Annuler l'ajout de semestre
        function annulerAjout() {
            resetForm();
            formAjout.style.display = 'none';
        }

        // Réinitialiser les champs du formulaire et les messages d'erreur
        function resetForm() {
            document.getElementById('numeroSemestre').value = '';
            document.getElementById('dateDebut').value = '';
            document.getElementById('dateFin').value = '';
            document.getElementById('numeroSemestre').style.border = '1px solid #ccc';
            document.getElementById('dateDebut').style.border = '1px solid #ccc';
            document.getElementById('dateFin').style.border = '1px solid #ccc';
            errorMessages.innerHTML = '';
        }

        // Afficher un message d'erreur
        function displayError(message) {
            const errorMessage = `<div class="error-message">${message}</div>`;
            errorMessages.innerHTML = errorMessage;
        }

        // Fonction pour ajouter une ligne à la table
        function ajouterLigne(numero, debut, fin) {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${numero}</td>
                <td>${debut}</td>
                <td>${fin}</td>
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
                modifierSemestre(row);
            }
        });

        // Fonction pour modifier le semestre
        function modifierSemestre(row) {
            const cells = row.cells;
            const numeroSemestre = cells[0].textContent;
            const dateDebut = cells[1].textContent;
            const dateFin = cells[2].textContent;

            cells[0].innerHTML = `<input type="text" class="edit-input" value="${numeroSemestre}" onchange="updateCellValue(this, 'numero')">`;
            cells[1].innerHTML = `<input type="date" class="datepicker" value="${dateDebut}" onchange="updateCellValue(this, 'debut')">`;
            cells[2].innerHTML = `<input type="date" class="datepicker" value="${dateFin}" onchange="updateCellValue(this, 'fin')">`;
        }

        // Fonction pour mettre à jour la valeur de la cellule
        function updateCellValue(input, type) {
            const newValue = input.value.trim();
            const row = input.closest('tr');
            const cells = row.cells;

            if (type === 'numero') {
                cells[0].textContent = newValue;
            } else if (type === 'debut') {
                cells[1].textContent = newValue;
            } else if (type === 'fin') {
                cells[2].textContent = newValue;
            }
        }

        // Écouteur pour le bouton "Supprimer"
        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('btn-supprimer')) {
                const row = event.target.closest('tr');
                const confirmation = confirm('Êtes-vous sûr de vouloir supprimer ce semestre ?');
                if (confirmation) {
                    row.remove();
                }
            }
        });
    </script>
</body>
</html>
