<?php
// Récupérer les données du formulaire
$num = !empty($_POST['num']) ? $_POST['num'] : '';
$sortie = !empty($_POST['sortie']) ? $_POST['sortie'] : '';
$date = !empty($_POST['date']) ? $_POST['date'] : '';
$overlay = !empty($_POST['overlay']) ? $_POST['overlay'] : '';
$id = $_POST['id'];
// Chemin vers le fichier JSON
$cheminFichierJSON = 'data/volumes.json';
if($num !== ''){
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
    //             echo "L'image a été téléversée avec succès.";
    //             // Vous pouvez enregistrer le chemin $target_file dans une base de données si nécessaire
    //             $overlay = $target_file;
    //         } else {
    //             echo "Désolé, une erreur s'est produite lors du téléversement de l'image.";
    //         }
    //     } else {
    //         echo "Le type de fichier n'est pas autorisé ou le fichier est trop volumineux.";
    //     }
    // } else {
    //     echo "Aucune image téléversée ou une erreur s'est produite.";
    // }


    // Lire le contenu actuel du fichier JSON
    $contenuJSON = file_get_contents($cheminFichierJSON);

    // Décoder le JSON en tableau associatif
    $donnees = json_decode($contenuJSON, true);

    // Trouver l'élément dans le tableau avec l'id "spiderman" par exemple
    $element = null;
    foreach ($donnees as $key => $value) {
        if ($value['link'] === $id) {
            $element = &$donnees[$key];
            break;
        }
    }

    if ($element !== null) {
        // Ajouter le nouveau volume à la liste existante
        $nouveauVolume = array(
            'num' => $num,
            'sortie' => $sortie,
            'overlay' => $overlay,
            'date' => $date
        );

        if (!isset($element['volumes'])) {
            $element['volumes'] = array();
        }

        $element['volumes'][] = $nouveauVolume;

        // Encoder le tableau en format JSON
        $nouveauContenuJSON = json_encode($donnees, JSON_PRETTY_PRINT);

        // Écrire le contenu dans le fichier JSON
        file_put_contents($cheminFichierJSON, $nouveauContenuJSON);

        echo "Nouveau volume ajouté avec succès à la liste existante !";
    } else {
        echo "Élément non trouvé dans le fichier JSON.";
    }
}
header('Location: volumes.html?' . urlencode($id));
?>
