<?php

// Va gérer la logique de changement de mot de passe lors de la 1è connexion :
if (isset($_POST['change_password']) && isset($_POST['mail'])) {

    $mail = mysqli_real_escape_string($db, $_POST['mail']);
    $password = password_hash($_POST['change_password'], PASSWORD_DEFAULT);

    // Vérifie dans quelle base de données se trouve le mail :
    $partnerQ = $db->prepare(
        "SELECT mail, password FROM partner WHERE mail = ?"
    );
    $partnerQ->bind_param("s", $mail);
    $partnerQ->execute();
    $partnerQ->store_result();
    $partnerQ->bind_result($partner, $passwordHashP);
    $partnerQ->fetch();
    $partnerQ->close();

    $structureQ = $db->prepare(
        "SELECT mail, password FROM structure WHERE mail = ?"
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
                "UPDATE partner
                SET first_connection = 1, password = ?
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
                "UPDATE structure
                SET first_connection = 1, password = ?
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
