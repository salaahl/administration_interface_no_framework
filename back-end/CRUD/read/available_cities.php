<?php

// Va récupérer les partenaires dispo et les injecter dans la page d'ajout d'une structure
if (isset($_POST['available_cities'])) {
    $reponse = [];
    $partenairesQ = $db->query(
        "SELECT (nom)
        FROM FitnessP_Partenaire
        ORDER BY nom"
    );

    foreach ($partenairesQ as $partenaire) {
        $reponse[] = htmlspecialchars($partenaire['nom']);
    }
    echo json_encode($reponse);
}
