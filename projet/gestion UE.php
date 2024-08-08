<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Unités d'Enseignement</title>
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
        .form-group input, .form-group select {
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
        <h1>Gestion des Unités d'Enseignement</h1>
        <div id="formAjout">
            <div class="form-group">
                <label for="codeUE">Code UE :</label>
                <input type="text" id="codeUE">
            </div>
            <div class="form-group">
                <label for="nomUE">Nom UE :</label>
                <input type="text" id="nomUE">
            </div>
            <div class="form-group">
                <label for="departement">Département :</label>
                <select id="departement">
                    <option value="Informatique">Informatique</option>
                    <option value="Mathématiques">Mathématiques</option>
                    <option value="Biologie">Biologie</option>
                    <!-- Ajoutez ici les autres options dynamiquement -->
                </select>
            </div>
            <div class="form-group">
                <label for="volumeHoraire">Volume horaire :</label>
                <input type="text" id="volumeHoraire">
            </div>
            <div class="form-group">
                <label for="numeroSemestre">Numéro de semestre :</label>
                <select id="numeroSemestre">
                    <option value="1">Semestre 1</option>
                    <option value="2">Semestre 2</option>
                    <option value="3">Semestre 3</option>
                    <!-- Ajoutez ici les autres options dynamiquement -->
                </select>
            </div>
            <div class="form-group">
                <label for="statut">Statut :</label>
                <input type="checkbox" id="statut"> Terminé
            </div>
            <div class="form-group">
                <button id="btnAjouterUE" onclick="ajouterUE()">Ajouter</button>
                <button class="cancel" onclick="annulerAjout()">Annuler</button>
            </div>
            <div id="errorMessages"></div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Code UE</th>
                    <th>Nom UE</th>
                    <th>Département</th>
                    <th>Volume horaire</th>
                    <th>Numéro de semestre</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Lignes des UE ici -->
                <tr>
                    <td>UE001</td>
                    <td>Introduction à l'Informatique</td>
                    <td>Informatique</td>
                    <td>50 heures</td>
                    <td>Semestre 1</td>
                    <td><input type="checkbox" disabled checked></td>
                    <td>
                        <button class="btn-modifier">Modifier</button>
                        <button class="btn-supprimer">Supprimer</button>
                    </td>
                </tr>
                <tr>
                    <td>UE002</td>
                    <td>Mathématiques Avancées</td>
                    <td>Mathématiques</td>
                    <td>60 heures</td>
                    <td>Semestre 2</td>
                    <td><input type="checkbox" disabled></td>
                    <td>
                        <button class="btn-modifier">Modifier</button>
                        <button class="btn-supprimer">Supprimer</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button id="btnAjouterTable" class="btn-modifier">Ajouter une UE</button>
    </div>

    <script>
        const tableBody = document.querySelector('tbody');
        const formAjout = document.getElementById('formAjout');
        const btnAjouterUE = document.getElementById('btnAjouterUE');
        const btnAnnuler = document.querySelector('.cancel');
        const errorMessages = document.getElementById('errorMessages');
        const btnAjouterTable = document.getElementById('btnAjouterTable');
        let modeAjout = true; // Variable pour suivre l'état (ajout ou modification)

        // Afficher le formulaire d'ajout d'UE
        btnAjouterTable.addEventListener('click', () => {
            formAjout.style.display = 'block';
            resetForm();
            modeAjout = true; // Mode ajout lorsqu'on clique sur "Ajouter une UE"
        });

        // Fonction pour ajouter une UE
        function ajouterUE() {
            const codeUE = document.getElementById('codeUE').value;
            const nomUE = document.getElementById('nomUE').value;
            const departement = document.getElementById('departement').value;
            const volumeHoraire = document.getElementById('volumeHoraire').value;
            const numeroSemestre = document.getElementById('numeroSemestre').value;
            const statut = document.getElementById('statut').checked ? 'Terminé' : 'En cours';

            // Réinitialiser les messages d'erreur
            errorMessages.innerHTML = '';

            // Vérifier si tous les champs sont remplis
            if (codeUE.trim() === '' || nomUE.trim() === '' || departement.trim() === '' || volumeHoraire.trim() === '' || numeroSemestre.trim() === '') {
                displayError('Veuillez remplir tous les champs.');
                return; // Arrêter la fonction si les champs ne sont pas tous remplis
            }

            if (modeAjout) {
                // Ajouter l'UE à la table en mode ajout
                ajouterLigneUE(codeUE, nomUE, departement, volumeHoraire, numeroSemestre, statut);
            } else {
                // Mettre à jour la ligne dans le tableau en mode modification
                const row = document.querySelector('.editing'); // Récupère la ligne en cours d'édition
                updateRowUE(row, codeUE, nomUE, departement, volumeHoraire, numeroSemestre, statut);
                row.classList.remove('editing'); // Retire la classe d'édition
            }

            // Réinitialiser le formulaire et cacher le formulaire
            resetForm();
            formAjout.style.display = 'none';
        }

        // Fonction pour annuler l'ajout ou la modification d'UE
        function annulerAjout() {
            resetForm();
            formAjout.style.display = 'none';
        }

        // Réinitialiser les champs du formulaire et les messages d'erreur
        function resetForm() {
            document.getElementById('codeUE').value = '';
            document.getElementById('nomUE').value = '';
            document.getElementById('departement').value = '';
            document.getElementById('volumeHoraire').value = '';
            document.getElementById('numeroSemestre').value = '';
            document.getElementById('statut').checked = false;
            errorMessages.innerHTML = '';
        }

        // Afficher un message d'erreur
        function displayError(message) {
            const errorMessage = `<div class="error-message">${message}</div>`;
            errorMessages.innerHTML = errorMessage;
        }

        // Fonction pour ajouter une ligne d'UE à la table
        function ajouterLigneUE(codeUE, nomUE, departement, volumeHoraire, numeroSemestre, statut) {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${codeUE}</td>
                <td>${nomUE}</td>
                <td>${departement}</td>
                <td>${volumeHoraire}</td>
                <td>${numeroSemestre}</td>
                <td>${statut}</td>
                <td>
                    <button class="btn-modifier">Modifier</button>
                    <button class="btn-supprimer">Supprimer</button>
                </td>
            `;
            tableBody.appendChild(newRow);
        }

        // Fonction pour mettre à jour une ligne d'UE dans le tableau
        function updateRowUE(row, codeUE, nomUE, departement, volumeHoraire, numeroSemestre, statut) {
            const cells = row.cells;
            cells[0].textContent = codeUE;
            cells[1].textContent = nomUE;
            cells[2].textContent = departement;
            cells[3].textContent = volumeHoraire;
            cells[4].textContent = numeroSemestre;
            cells[5].textContent = statut;
        }

        // Écouteur pour le bouton "Modifier"
        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('btn-modifier')) {
                const row = event.target.closest('tr');
                modifierUE(row);
            }
        });

        // Fonction pour modifier une UE
        function modifierUE(row) {
            const cells = row.cells;
            const codeUE = cells[0].textContent;
            const nomUE = cells[1].textContent;
            const departement = cells[2].textContent;
            const volumeHoraire = cells[3].textContent;
            const numeroSemestre = cells[4].textContent;
            const statut = cells[5].textContent === 'Terminé'; // Convertit le texte en booléen pour la case à cocher

            // Remplir le formulaire avec les valeurs actuelles de l'UE
            document.getElementById('codeUE').value = codeUE;
            document.getElementById('nomUE').value = nomUE;
            document.getElementById('departement').value = departement;
            document.getElementById('volumeHoraire').value = volumeHoraire;
            document.getElementById('numeroSemestre').value = numeroSemestre;
            document.getElementById('statut').checked = statut;

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
                const confirmation = confirm('Êtes-vous sûr de vouloir supprimer cette UE ?');
                if (confirmation) {
                    row.remove();
                }
            }
        });
    </script>
</body>
</html>
