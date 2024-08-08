<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des enseignants</title>
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
        <h1>Gestion des enseignants</h1>
        <div id="formAjout">
            <div class="form-group">
                <label for="nomEnseignant">Nom enseignant :</label>
                <input type="text" id="nomEnseignant">
            </div>
            <div class="form-group">
                <label for="dateNaissance">Date de naissance :</label>
                <input type="date" id="dateNaissance">
            </div>
            <div class="form-group">
                <label for="lieuNaissance">Lieu de naissance :</label>
                <input type="text" id="lieuNaissance">
            </div>
            <div class="form-group">
                <label for="sexe">Sexe :</label>
                <select id="sexe">
                    <option value="M">Masculin</option>
                    <option value="F">Féminin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="matricule">Matricule :</label>
                <input type="text" id="matricule">
            </div>
            <div class="form-group">
                <label for="grade">Grade :</label>
                <input type="text" id="grade">
            </div>
            <div class="form-group">
                <label for="diplome">Diplôme :</label>
                <input type="text" id="diplome">
            </div>
            <div class="form-group">
                <button id="btnAjouterEnseignant" onclick="ajouterEnseignant()">Ajouter</button>
                <button class="cancel" onclick="annulerAjout()">Annuler</button>
            </div>
            <div id="errorMessages"></div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nom enseignant</th>
                    <th>Date de naissance</th>
                    <th>Lieu de naissance</th>
                    <th>Sexe</th>
                    <th>Matricule</th>
                    <th>Grade</th>
                    <th>Diplôme</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Lignes des enseignants ici -->
                <tr>
                    <td>Jean Dupont</td>
                    <td>1980-01-15</td>
                    <td>Paris</td>
                    <td>M</td>
                    <td>12345</td>
                    <td>Professeur</td>
                    <td>Doctorat</td>
                    <td>
                        <button class="btn-modifier">Modifier</button>
                        <button class="btn-supprimer">Supprimer</button>
                    </td>
                </tr>
                <tr>
                    <td>Marie Curie</td>
                    <td>1975-03-10</td>
                    <td>Varsovie</td>
                    <td>F</td>
                    <td>67890</td>
                    <td>Professeur</td>
                    <td>Doctorat</td>
                    <td>
                        <button class="btn-modifier">Modifier</button>
                        <button class="btn-supprimer">Supprimer</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button id="btnAjouterTable" class="btn-modifier">Ajouter un enseignant</button>
    </div>

    <script>
        const tableBody = document.querySelector('tbody');
        const formAjout = document.getElementById('formAjout');
        const btnAjouterEnseignant = document.getElementById('btnAjouterEnseignant');
        const btnAnnuler = document.querySelector('.cancel');
        const errorMessages = document.getElementById('errorMessages');
        const btnAjouterTable = document.getElementById('btnAjouterTable');
        let modeAjout = true; // Variable pour suivre l'état (ajout ou modification)

        // Afficher le formulaire d'ajout d'enseignant
        btnAjouterTable.addEventListener('click', () => {
            formAjout.style.display = 'block';
            resetForm();
            modeAjout = true; // Mode ajout lorsqu'on clique sur "Ajouter un enseignant"
        });

        // Fonction pour ajouter un enseignant
        function ajouterEnseignant() {
            const nomEnseignant = document.getElementById('nomEnseignant').value;
            const dateNaissance = document.getElementById('dateNaissance').value;
            const lieuNaissance = document.getElementById('lieuNaissance').value;
            const sexe = document.getElementById('sexe').value;
            const matricule = document.getElementById('matricule').value;
            const grade = document.getElementById('grade').value;
            const diplome = document.getElementById('diplome').value;

            // Réinitialiser les messages d'erreur
            errorMessages.innerHTML = '';

            // Vérifier si tous les champs sont remplis
            if (nomEnseignant.trim() === '' || dateNaissance.trim() === '' || lieuNaissance.trim() === '' || sexe.trim() === '' || matricule.trim() === '' || grade.trim() === '' || diplome.trim() === '') {
                displayError('Veuillez remplir tous les champs.');
                return; // Arrêter la fonction si les champs ne sont pas tous remplis
            }

            if (modeAjout) {
                // Ajouter l'enseignant à la table en mode ajout
                ajouterLigne(nomEnseignant, dateNaissance, lieuNaissance, sexe, matricule, grade, diplome);
            } else {
                // Mettre à jour la ligne dans le tableau en mode modification
                const row = document.querySelector('.editing'); // Récupère la ligne en cours d'édition
                updateRow(row, nomEnseignant, dateNaissance, lieuNaissance, sexe, matricule, grade, diplome);
                row.classList.remove('editing'); // Retire la classe d'édition
            }

            // Réinitialiser le formulaire et cacher le formulaire
            resetForm();
            formAjout.style.display = 'none';
        }

        // Fonction pour annuler l'ajout ou la modification d'enseignant
        function annulerAjout() {
            resetForm();
            formAjout.style.display = 'none';
        }

        // Réinitialiser les champs du formulaire et les messages d'erreur
        function resetForm() {
            document.getElementById('nomEnseignant').value = '';
            document.getElementById('dateNaissance').value = '';
            document.getElementById('lieuNaissance').value = '';
            document.getElementById('sexe').value = '';
            document.getElementById('matricule').value = '';
            document.getElementById('grade').value = '';
            document.getElementById('diplome').value = '';
            document.getElementById('nomEnseignant').style.border = '1px solid #ccc';
            document.getElementById('dateNaissance').style.border = '1px solid #ccc';
            document.getElementById('lieuNaissance').style.border = '1px solid #ccc';
            document.getElementById('sexe').style.border = '1px solid #ccc';
            document.getElementById('matricule').style.border = '1px solid #ccc';
            document.getElementById('grade').style.border = '1px solid #ccc';
            document.getElementById('diplome').style.border = '1px solid #ccc';
            errorMessages.innerHTML = '';
        }

        // Afficher un message d'erreur
        function displayError(message) {
            const errorMessage = `<div class="error-message">${message}</div>`;
            errorMessages.innerHTML = errorMessage;
        }

        // Fonction pour ajouter une ligne à la table
        function ajouterLigne(nom, dateNaissance, lieuNaissance, sexe, matricule, grade, diplome) {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${nom}</td>
                <td>${dateNaissance}</td>
                <td>${lieuNaissance}</td>
                <td>${sexe}</td>
                <td>${matricule}</td>
                <td>${grade}</td>
                <td>${diplome}</td>
                <td>
                    <button class="btn-modifier">Modifier</button>
                    <button class="btn-supprimer">Supprimer</button>
                </td>
            `;
            tableBody.appendChild(newRow);
        }

        // Fonction pour mettre à jour une ligne dans le tableau
        function updateRow(row, nom, dateNaissance, lieuNaissance, sexe, matricule, grade, diplome) {
            const cells = row.cells;
            cells[0].textContent = nom;
            cells[1].textContent = dateNaissance;
            cells[2].textContent = lieuNaissance;
            cells[3].textContent = sexe;
            cells[4].textContent = matricule;
            cells[5].textContent = grade;
            cells[6].textContent = diplome;
        }

        // Écouteur pour le bouton "Modifier"
        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('btn-modifier')) {
                const row = event.target.closest('tr');
                modifierEnseignant(row);
            }
        });

        // Fonction pour modifier l'enseignant
        function modifierEnseignant(row) {
            const cells = row.cells;
            const nomEnseignant = cells[0].textContent;
            const dateNaissance = cells[1].textContent;
            const lieuNaissance = cells[2].textContent;
            const sexe = cells[3].textContent;
            const matricule = cells[4].textContent;
            const grade = cells[5].textContent;
            const diplome = cells[6].textContent;

            // Remplir le formulaire avec les valeurs actuelles de l'enseignant
            document.getElementById('nomEnseignant').value = nomEnseignant;
            document.getElementById('dateNaissance').value = dateNaissance;
            document.getElementById('lieuNaissance').value = lieuNaissance;
            document.getElementById('sexe').value = sexe;
            document.getElementById('matricule').value = matricule;
            document.getElementById('grade').value = grade;
            document.getElementById('diplome').value = diplome;

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
                const confirmation = confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?');
                if (confirmation) {
                    row.remove();
                }
            }
        });
    </script>
</body>
</html>
