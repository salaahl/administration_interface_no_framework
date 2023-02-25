<?php

// Va gérer la logique de changement de mot de passe lors de la 1è connexion :
if (isset($_POST['change_password'])) {

    $mail = mysqli_real_escape_string($db, $_POST['mail']);
    $password = password_hash($_POST['change_password'], PASSWORD_DEFAULT);

    // Vérifie dans quelle base de données se trouve le mail :
    $partnerQ = $db->prepare(
        "SELECT mail, mot_de_passe FROM FitnessP_Partenaire WHERE mail = ?"
    );
    $partnerQ->bind_param("s", $mail);
    $partnerQ->execute();
    $partnerQ->store_result();
    $partnerQ->bind_result($partner, $passwordHashP);
    $partnerQ->fetch();
    $partnerQ->close();

    $structureQ = $db->prepare(
        "SELECT mail, mot_de_passe FROM FitnessP_Structure WHERE mail = ?"
    );
    $structureQ->bind_param("s", $mail);
    $structureQ->execute();
    $structureQ->store_result();
    $structureQ->bind_result($structure, $passwordHashS);
    $structureQ->fetch();
    $structureQ->close();

    if (isset($partner)) {
        if (password_verify($_POST['change_password'], $passwordHashP)) {
            echo 'Vous ne pouvez pas réutiliser le même mot de passe';
            die();
        } else {
            // Met la colonne 1è connexion sur "1" si ce n'est pas déjà fait et change le mot de passe :
            $partnerU = $db->prepare(
                "UPDATE FitnessP_Partenaire
                SET premiere_connexion = 1, mot_de_passe = ?
                WHERE mail = ?"
            );

            $partnerU->bind_param("ss", $password, $mail);
            $partnerU->execute();
            $partnerU->close();
        }
    }
    
    if (isset($structure)) {
        if (password_verify($_POST['change_password'], $passwordHashS)) {
            echo 'Vous ne pouvez pas réutiliser le même mot de passe';
            die();
        } else {
            $structureU = $db->prepare(
                "UPDATE FitnessP_Structure
                SET premiere_connexion = 1, mot_de_passe = ?
                WHERE mail = ?"
            );

            $structureU->bind_param("ss", $password, $mail);
            $structureU->execute();
            $structureU->close();
        }
    }
    
    session_start();
    session_unset();
    session_destroy();
}
