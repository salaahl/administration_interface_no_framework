<?php


// Va gérer la logique de changement de mot de passe lors de la 1è connexion :
if (isset($_POST['nouveau_mdp'])) {

    $mail = mysqli_real_escape_string($db, $_POST['mail']);
    $password = password_hash($_POST['nouveau_mdp'], PASSWORD_DEFAULT);

    // Vérifie dans quelle base de données se trouve le mail :
    $partenaireQ = $db->prepare(
        "SELECT mail FROM FitnessP_Partenaire WHERE mail = ?"
    );
    $partenaireQ->bind_param("s", $mail);
    $partenaireQ->execute();
    $partenaireQ->close();

    $structureQ = $db->prepare(
        "SELECT mail FROM FitnessP_Structure WHERE mail = ?"
    );
    $structureQ->bind_param("s", $mail);
    $structureQ->execute();
    $structureQ->close();

    // Met la colonne 1è connexion sur "1" si ce n'est pas déjà fait et change le mot de passe :
    if (isset($partenaireQ)) {
        $partenaireU = $db->prepare(
            "UPDATE FitnessP_Partenaire
            SET premiere_connexion = 1, mot_de_passe = ?
            WHERE mail = ?"
        );

        $partenaireU->bind_param("ss", $password, $mail);
        $partenaireU->execute();
        $partenaireU->close();
    }
    if (isset($structureQ)) {
        $structureU = $db->prepare(
            "UPDATE FitnessP_Structure
            SET premiere_connexion = 1, mot_de_passe = ?
            WHERE mail = ?"
        );

        $structureU->bind_param("ss", $password, $mail);
        $structureU->execute();
        $structureU->close();
    }

    // On démarre la session
    session_start();
    // On détruit les variables de notre session
    session_unset();
    // On détruit notre session
    session_destroy();
}
