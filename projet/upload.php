<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profilePicture'])) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . systeme_vh($_FILES["photo_profil"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Vérifier si le fichier est une image réelle
    $check = getimagesize($_FILES["photo_profil"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "Le fichier n'est pas une image.";
        $uploadOk = 0;
    }

    // Vérifier si le fichier existe déjà
    if (file_exists($targetFile)) {
        echo "Désolé, le fichier existe déjà.";
        $uploadOk = 0;
    }

    // Vérifier la taille du fichier
    if ($_FILES["profilePicture"]["size"] > 5000000) {
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }

    // Autoriser certains formats de fichier
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
        $uploadOk = 0;
    }

    // Vérifier si $uploadOk est à 0 à cause d'une erreur
    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été téléchargé.";
    } else {
        // Si tout est correct, essayer de télécharger le fichier
        if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFile)) {
            $_SESSION['profile_picture'] = $targetFile;
            echo "Le fichier " . htmlspecialchars(systeme_vh($_FILES["profilePicture"]["name"])) . " a été téléchargé.";
            header("Location: index.php");
        } else {
            echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>
<body>
    <div class="container">
        <h1>Bienvenue sur votre profil</h1>
        
        <!-- Formulaire de téléchargement de photo de profil -->
        <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
            <label for="profilePicture">Choisissez une photo de profil :</label>
            <input type="file" name="profilePicture" id="profilePicture" accept="image/*">
            <button type="submit">Télécharger</button>
        </form>
        
        <!-- Affichage de la photo de profil -->
        <div id="profilePictureDisplay">
            <!-- L'image sera affichée ici -->
            <?php
            session_start();
            if (isset($_SESSION['profile_picture'])) {
                echo '<img src="' . $_SESSION['profile_picture'] . '" alt="Photo de profil" style="max-width:200px; border-radius:50%;">';
            } else {
                echo '<p>Pas de photo de profil.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>
