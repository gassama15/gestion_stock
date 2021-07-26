<?php
// category_action.php

include_once 'database_connection.php';

if (isset($_POST['btn_action'])) {
    if ($_POST['btn_action'] == 'Ajouter') {
        $query = "
        INSERT INTO category (category_name) VALUES (:category_name)
        ";
        $statement = $connect->prepare($query);
        $statement->execute([
            'category_name' => $_POST['category_name'],
        ]);
        $statement->fetchAll();

        $result = $statement->fetchAll();
        if (isset($result)) {
            echo 'Catégorie ajoutée avec succés';
        }
    }
}

?>