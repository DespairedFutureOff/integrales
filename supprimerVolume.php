<?php
$volumeIdToDelete = $_POST['date'];
$id = $_POST['id'];
// Chemin vers le fichier JSON
$cheminFichierJSON = 'data/volumes.json';

// Lire le contenu actuel du fichier JSON
$contenuJSON = file_get_contents($cheminFichierJSON);

// Décoder le JSON en tableau associatif
$donnees = json_decode($contenuJSON, true);
if($volumeIdToDelete !== 0){
    // Trouver l'élément dans le tableau avec l'id "spiderman" par exemple
    foreach ($donnees as $key => $element) {
        if ($element['link'] === $id) {
            // Trouver le volume spécifique à supprimer
            foreach ($element['volumes'] as $volumeKey => $volume) {
                if ($volume['date'] === $volumeIdToDelete) {
                    // Supprimer le volume trouvé du tableau
                    unset($element['volumes'][$volumeKey]);
                    // Réindexer le tableau pour éviter les clés manquantes
                    $element['volumes'] = array_values($element['volumes']);
                    break;
                }
            }

            // Mettre à jour l'élément dans le tableau principal
            $donnees[$key] = $element;
            break;
        }
    }
    // Encoder le tableau en format JSON
    $nouveauContenuJSON = json_encode($donnees, JSON_PRETTY_PRINT);

    // Écrire le contenu dans le fichier JSON
    file_put_contents($cheminFichierJSON, $nouveauContenuJSON);
}
// Redirection vers volumes.html
header('Location: volumes.html?' . urlencode($id));
?>
