<?php
// Récupérer les données du formulaire
$name = !empty($_POST['name']) ? $_POST['name'] : '';
$overlay = !empty($_POST['overlay']) ? $_POST['overlay'] : '';

if ($name !== '' && $overlay !== '') {
    // Chemin vers le fichier JSON
    $cheminFichierJSON = 'data/volumes.json';

    // // Vérifier si le fichier a été téléversé sans erreur
    // if (isset($_FILES["overlay"]) && $_FILES["overlay"]["error"] == 0) {
    //     $allowed_types = array("image/jpeg", "image/png", "image/gif");
    //     $max_size = 5 * 1024 * 1024; // 5 MB (en bytes)

    //     // Vérifier le type et la taille du fichier
    //     if (in_array($_FILES["overlay"]["type"], $allowed_types) && $_FILES["overlay"]["size"] <= $max_size) {
    //         // Déplacer le fichier téléversé vers le dossier de destination sur le serveur
    //         $target_dir = "img/";
    //         $target_file = $target_dir . basename($_FILES["overlay"]["name"]);

    //         if (move_uploaded_file($_FILES["overlay"]["tmp_name"], $target_file)) {
    //             // L'image a été téléversée avec succès, vous pouvez enregistrer le chemin $target_file dans une base de données si nécessaire

                // Lire le contenu actuel du fichier JSON
                $contenuJSON = file_get_contents($cheminFichierJSON);

                // Décoder le JSON en tableau associatif
                $donnees = json_decode($contenuJSON, true);

                // Ajouter une nouvelle collection au tableau de données
                $nouvelleCollection = array(
                    'id' => strtolower($name), // Génère un identifiant basé sur le nom de la collection
                    'overlay' => $overlay,
                    'link' => strtolower(str_replace(' ', '-', $name)), // Génère un lien basé sur le nom de la collection
                    'volumes' => array()
                );

                // Ajouter les nouvelles données au tableau existant
                $donnees[] = $nouvelleCollection;

                // Encoder le tableau en format JSON
                $nouveauContenuJSON = json_encode($donnees, JSON_PRETTY_PRINT);

                // Écrire le contenu dans le fichier JSON
                file_put_contents($cheminFichierJSON, $nouveauContenuJSON);

                // Redirection vers listeCollections.html
                header('Location: listeCollections.html');
                exit();
//             } else {
//                 echo "Désolé, une erreur s'est produite lors du téléversement de l'image.";
//             }
//         } else {
//             echo "Le type de fichier n'est pas autorisé ou le fichier est trop volumineux.";
//         }
//     } else {
//         echo "Aucune image téléversée ou une erreur s'est produite.";
//     }
// } else {
}

?>
