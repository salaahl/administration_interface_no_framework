<?php

// Va récupérer les partenaires dispo et les injecter dans la page d'ajout d'une structure
if (isset($_POST['part_structure'])) {
    $reponse = [];
    $partenairesQ = $db->query(
        "SELECT (nom)
        FROM FitnessP_Partenaire
        ORDER BY nom"
    );


    foreach ($partenairesQ as $partenaire) {
        $reponse[] = $partenaire['nom'];
    }
    echo json_encode($reponse);
}
