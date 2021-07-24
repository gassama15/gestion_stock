<?php
// user_action.php

include_once 'database_connection.php';

if (isset($_POST['btn_action'])) {
    if ($_POST['btn_action'] == 'Ajouter') {
        $query = "
            INSERT INTO user_details (user_email, user_password, user_name, user_type, user_status) VALUES (:user_email, :user_password, :user_name, :user_type, :user_status)
        ";

        $statement = $connect->prepare($query);
        $statement->execute([
            'user_email' => $_POST['user_email'],
            'user_password' => password_hash(
                $_POST['user_password'],
                PASSWORD_DEFAULT
            ),
            'user_name' => $_POST['user_name'],
            'user_type' => 'user',
            'user_status' => 'active',
        ]);

        $result = $statement->fetchAll();

        if (isset($result)) {
            echo 'Nouvel Utilisateur ajouté';
        }
    }
}

?>