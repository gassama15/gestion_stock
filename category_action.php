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

    if ($_POST['btn_action'] == 'fetch_single') {
        $query = "
            SELECT * FROM category WHERE category_id = :category_id
        ";
        $statement = $connect->prepare($query);
        $statement->execute([
            'category_id' => $_POST['category_id'],
        ]);
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['category_name'] = $row['category_name'];
        }
        echo json_encode($output);
    }

    if ($_POST['btn_action'] == 'Modifier') {
        $query = "
        UPDATE category SET category_name = :category_name WHERE category_id = :category_id
        ";
        $statement = $connect->prepare($query);
        $statement->execute([
            'category_name' => $_POST['category_name'],
            'category_id' => $_POST['category_id'],
        ]);
        $result = $statement->fetchAll();

        if (isset($result)) {
            echo 'Catégorie modifiée avec succés';
        }
    }

    if ($_POST['btn_action'] == 'Supprimer') {
        $status = 'active';
        if ($_POST['status'] == 'active') {
            $status = 'inactive';
        }
        $query = "
        UPDATE category SET category_status = :category_status WHERE category_id = :category_id
        ";
        $statement = $connect->prepare($query);
        $statement->execute([
            'category_status' => $status,
            'category_id' => $_POST['category_id'],
        ]);

        $result = $statement->fetchAll();
        if (isset($result)) {
            echo 'Status de la catégorie est maintenant ' .
                ($status == 'active' ? 'Actif' : 'Inactif');
        }
    }
}

?>