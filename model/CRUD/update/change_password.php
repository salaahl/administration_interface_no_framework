<?php

if (isset($_POST['change_password']) && isset($_POST['mail'])) {

    $mail = mysqli_real_escape_string($db, $_POST['mail']);
    $password = $_POST['change_password'];
    $new_password = password_hash($_POST['change_password'], PASSWORD_DEFAULT);

    // Vérifie dans quelle base de données se trouve le mail :
    $partner = $db->prepare(
        "SELECT mail, password FROM partner WHERE mail = ?"
    );
    $partner->bind_param("s", $mail);
    $partner->execute();
    $partner->store_result();
    $partner->bind_result($is_partner, $partner_password);
    $partner->fetch();
    $partner->close();

    $structure = $db->prepare(
        "SELECT mail, password FROM structure WHERE mail = ?"
    );
    $structure->bind_param("s", $mail);
    $structure->execute();
    $structure->store_result();
    $structure->bind_result($is_structure, $structure_password);
    $structure->fetch();
    $structure->close();

    if (isset($is_partner)) {
        if ($password === $partner_password) {
            echo 'Vous ne pouvez pas réutiliser le même mot de passe';
            die();
        } else {
            // Met la colonne 1è connexion sur "1" si ce n'est pas déjà fait et change le mot de passe :
            $update = $db->prepare(
                "UPDATE partner
                SET password = ?
                WHERE mail = ?"
            );

            $update->bind_param("ss", $new_password, $mail);
            $update->execute();
            $update->close();
        }
    }

    if (isset($is_structure)) {
        if ($password === $structure_password) {
            echo 'Vous ne pouvez pas réutiliser le même mot de passe';
            die();
        } else {
            $update = $db->prepare(
                "UPDATE structure
                SET password = ?
                WHERE mail = ?"
            );

            $update->bind_param("ss", $new_password, $mail);
            $update->execute();
            $update->close();
        }
    }

    session_start();
    session_unset();
    session_destroy();
}
