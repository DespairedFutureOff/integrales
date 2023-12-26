<?php
// Récupérer l'ID de la collection à supprimer du formulaire HTML
$idToDelete = !empty($_POST['date']) ? $_POST['date'] : '';
$idToDelete = strtolower($idToDelete);
if ($idToDelete !== '') {
    // Chemin vers le fichier JSON
    $cheminFichierJSON = 'data/volumes.json';

    // Lire le contenu actuel du fichier JSON
    $contenuJSON = file_get_contents($cheminFichierJSON);

    // Décoder le JSON en tableau associatif
    $donnees = json_decode($contenuJSON, true);

    // Vérifier si l'ID à supprimer existe dans le tableau de données
    $indexToDelete = null;
    foreach ($donnees as $key => $element) {
        if ($element['id'] === $idToDelete) {
            // Garder l'index de l'élément à supprimer
            $indexToDelete = $key;
            break;
        }
    }

    // Si l'élément a été trouvé, le supprimer du tableau de données
    if ($indexToDelete !== null) {
        unset($donnees[$indexToDelete]);

        // Encoder le tableau en format JSON
        $nouveauContenuJSON = json_encode(array_values($donnees), JSON_PRETTY_PRINT);

        // Écrire le contenu dans le fichier JSON
        file_put_contents($cheminFichierJSON, $nouveauContenuJSON);

        
    } else {
        echo "ERREUR : L'ID à supprimer n'existe pas dans le fichier JSON.";
    }
}
// Redirection vers la page après la suppression
header('Location: listeCollections.html');
?>
