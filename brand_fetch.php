<?php
// brand_fetch.php
include_once 'database_connection.php';

$query = '';

$output = [];
$query .= "
SELECT * 
FROM brand INNER JOIN category ON category.category_id = brand.category_id ";

if (isset($_POST['search']['value'])) {
    $query .=
        'WHERE brand.brand_name LIKE "%' . $_POST['search']['value'] . '%" ';
    $query .=
        'OR category.category_name LIKE "%' . $_POST['search']['value'] . '%" ';
    $query .=
        'OR brand.brand_status LIKE "%' . $_POST['search']['value'] . '%" ';
}

if (isset($_POST['order'])) {
    $query .=
        'ORDER BY ' .
        $_POST['order']['0']['column'] .
        ' ' .
        $_POST['order']['0']['dir'] .
        ' ';
} else {
    $query .= 'ORDER BY brand.brand_id DESC ';
}

if ($_POST['length'] != -1) {
    $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$data = [];

$filtered_rows = $statement->rowCount();

foreach ($result as $row) {
    $status = '';
    if ($row['brand_status'] == 'active') {
        $status = '<span class="label label-success">Actif</span>';
    } else {
        $status = '<span class="label label-danger">Inactif</span>';
    }

    $sub_array = [];
    $sub_array[] = $row['brand_id'];
    $sub_array[] = $row['category_name'];
    $sub_array[] = $row['brand_name'];
    $sub_array[] = $status;
    $sub_array[] =
        '<button type="button" name="update" id="' .
        $row['brand_id'] .
        '" class="btn btn-warning btn-xs update">Modifier</button>';
    $sub_array[] =
        '<button type="button" name="delete" id="' .
        $row['brand_id'] .
        '" class="btn btn-danger btn-xs delete" data-status="' .
        $row['brand_status'] .
        '">Supprimer</button>';
    $data[] = $sub_array;
}

$output = [
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $filtered_rows,
    'recordsFiltered' => get_total_all_records($connect),
    'data' => $data,
];

function get_total_all_records($connect)
{
    $statement = $connect->prepare('SELECT * FROM brand');

    $statement->execute();

    return $statement->rowCount();
}

echo json_encode($output);

?>