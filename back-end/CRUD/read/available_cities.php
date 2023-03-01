<?php

// Va récupérer les partenaires dispo et les injecter dans la page d'ajout d'une structure
if (isset($_POST['available_cities'])) {
    $partenairesQ = $db->query(
        "SELECT (city)
        FROM partner
        ORDER BY city"
    );
    $response = array_map('htmlspecialchars', $partenairesQ);
    
    echo json_encode($response);
}
