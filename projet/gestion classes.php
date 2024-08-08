<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des classes</title>
    <style>
        body {
            background-color: #0074D9;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #FFFFFF;
            border-radius: 20px;
            text-align: center;
        }
        h1 {
            font-size: 36px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
            border-radius: 5px;
        }
        .btn-supprimer {
            background-color: #E74C3C;
        }
        #btnAjouterTable {
            background-color: #E74C3C;
            font-size: 18px;
            width: 250px;
            margin: 20px auto;
            display: block;
            border: none;
            color: #FFFFFF;
            border-radius: 10px;
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
        <h1>Gestion des classes</h1>
        <div id="formAjout">
            <div class="form-group">
                <label for="codeClasse">Code classe :</label>
                <input type="text" id="codeClasse">
            </div>
            <div class="form-group">
                <label for="libelle">Libellé :</label>
                <input type="text" id="libelle">
            </div>
            <div class="form-group">
                <label for="niveau">Niveau :</label>
                <input type="text" id="niveau">
            </div>
            <div class="form-group">
                <label for="filiere">Filière :</label>
                <select id="filiere">
                    <!-- Options des filières seront ajoutées ici dynamiquement -->
                </select>
            </div>
            <div class="form-group">
                <button id="btnAjouterClasse" onclick="ajouterClasse()">Ajouter</button>
                <button class="cancel" onclick="annulerAjout()">Annuler</button>
            </div>
            <div id="errorMessages"></div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Code classe</th>
                    <th>Libellé</th>
                    <th>Niveau</th>
                    <th>Filière</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Lignes des classes ici -->
                <tr>
                    <td>CS101</td>
                    <td>Introduction à la programmation</td>
                    <td>Licence 1</td>
                    <td>Informatique</td>
                    <td>
                        <button class="btn-modifier">Modifier</button>
                        <button class="btn-supprimer">Supprimer</button>
                    </td>
                </tr>
                <tr>
                    <td>CS102</td>
                    <td>Algorithmes</td>
                    <td>Licence 1</td>
                    <td>Informatique</td>
                    <td>
                        <button class="btn-modifier">Modifier</button>
                        <button class="btn-supprimer">Supprimer</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button id="btnAjouterTable" class="btn-modifier">Ajouter une classe</button>
    </div>

    <script>
        const tableBody = document.querySelector('tbody');
        const formAjout = document.getElementById('formAjout');
        const btnAjouterClasse = document.getElementById('btnAjouterClasse');
        const btnAnnuler = document.querySelector('.cancel');
        const errorMessages = document.getElementById('errorMessages');
        const btnAjouterTable = document.getElementById('btnAjouterTable');
        const filiereSelect = document.getElementById('filiere');
        let modeAjout = true; // Variable pour suivre l'état (ajout ou modification)

        // Exemple de données de filières
        const filieres = [
            { code: 'INF', nom: 'Informatique' },
            { code: 'BIO', nom: 'Biologie' },
            { code: 'CHM', nom: 'Chimie' }
        ];

        // Ajouter les filières à la liste déroulante
        filieres.forEach(filiere => {
            const option = document.createElement('option');
            option.value = filiere.code;
            option.textContent = filiere.nom;
            filiereSelect.appendChild(option);
        });

        // Afficher le formulaire d'ajout de classe
        btnAjouterTable.addEventListener('click', () => {
            formAjout.style.display = 'block';
            resetForm();
            modeAjout = true; // Mode ajout lorsqu'on clique sur "Ajouter une classe"
        });

        // Fonction pour ajouter une classe
        function ajouterClasse() {
            const codeClasse = document.getElementById('codeClasse').value;
            const libelle = document.getElementById('libelle').value;
            const niveau = document.getElementById('niveau').value;
            const filiere = document.getElementById('filiere').value;

            // Réinitialiser les messages d'erreur
            errorMessages.innerHTML = '';

            // Vérifier si tous les champs sont remplis
            if (codeClasse.trim() === '' || libelle.trim() === '' || niveau.trim() === '' || filiere.trim() === '') {
                displayError('Veuillez remplir tous les champs.');
                return; // Arrêter la fonction si les champs ne sont pas tous remplis
            }

            if (modeAjout) {
                // Ajouter la classe à la table en mode ajout
                ajouterLigne(codeClasse, libelle, niveau, filiere);
            } else {
                // Mettre à jour la ligne dans le tableau en mode modification
                const row = document.querySelector('.editing'); // Récupère la ligne en cours d'édition
                updateRow(row, codeClasse, libelle, niveau, filiere);
                row.classList.remove('editing'); // Retire la classe d'édition
            }

            // Réinitialiser le formulaire et cacher le formulaire
            resetForm();
            formAjout.style.display = 'none';
        }

        // Fonction pour annuler l'ajout ou la modification de classe
        function annulerAjout() {
            resetForm();
            formAjout.style.display = 'none';
        }

        // Réinitialiser les champs du formulaire et les messages d'erreur
        function resetForm() {
            document.getElementById('codeClasse').value = '';
            document.getElementById('libelle').value = '';
            document.getElementById('niveau').value = '';
            document.getElementById('filiere').value = '';
            document.getElementById('codeClasse').style.border = '1px solid #ccc';
            document.getElementById('libelle').style.border = '1px solid #ccc';
            document.getElementById('niveau').style.border = '1px solid #ccc';
            document.getElementById('filiere').style.border = '1px solid #ccc';
            errorMessages.innerHTML = '';
        }

        // Afficher un message d'erreur
        function displayError(message) {
            const errorMessage = `<div class="error-message">${message}</div>`;
            errorMessages.innerHTML = errorMessage;
        }

        // Fonction pour ajouter une ligne à la table
        function ajouterLigne(codeClasse, libelle, niveau, filiere) {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${codeClasse}</td>
                <td>${libelle}</td>
                <td>${niveau}</td>
                <td>${filiere}</td>
                <td>
                    <button class="btn-modifier">Modifier</button>
                    <button class="btn-supprimer">Supprimer</button>
                </td>
            `;
            tableBody.appendChild(newRow);
        }

        // Fonction pour mettre à jour une ligne dans le tableau
        function updateRow(row, codeClasse, libelle, niveau, filiere) {
            const cells = row.cells;
            cells[0].textContent = codeClasse;
            cells[1].textContent = libelle;
            cells[2].textContent = niveau;
            cells[3].textContent = filiere;
        }

        // Écouteur pour le bouton "Modifier"
        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('btn-modifier')) {
                const row = event.target.closest('tr');
                modifierClasse(row);
            }
        });

        // Fonction pour modifier la classe
        function modifierClasse(row) {
            const cells = row.cells;
            const codeClasse = cells[0].textContent;
            const libelle = cells[1].textContent;
            const niveau = cells[2].textContent;
            const filiere = cells[3].textContent;

            // Remplir le formulaire avec les valeurs actuelles de la classe
            document.getElementById('codeClasse').value = codeClasse;
            document.getElementById('libelle').value = libelle;
            document.getElementById('niveau').value = niveau;
            document.getElementById('filiere').value = filiere;

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
                const confirmation = confirm('Êtes-vous sûr de vouloir supprimer cette classe ?');
                if (confirmation) {
                    row.remove();
                }
            }
        });
    </script>
</body>
</html>
