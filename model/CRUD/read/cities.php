<?php

// Va récupérer les partenaires dispo et les injecter dans la page d'ajout d'une structure
if (isset($_POST['cities_list'])) {

    $response = [];

    $cities = $db->query(
        "SELECT city
        FROM partner
        ORDER BY city"
    );

    foreach ($cities as $city) {
        $response[] = $city;
    }

    echo json_encode($response);
}
