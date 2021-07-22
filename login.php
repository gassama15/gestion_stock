<?php
// login.php
include_once 'database_connection.php';

if (isset($_SESSION['type'])) {
    header('Location: index.php');
}

$message = '';

if (isset($_POST['login'])) {
    $query = "
        SELECT * FROM user_details
        WHERE user_email = :user_email
    ";

    $statement = $connect->prepare($query);
    $statement->execute([
        'user_email' => $_POST['user_email'],
    ]);

    $count = $statement->rowCount();
    if ($count > 0) {
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            if (
                password_verify($_POST['user_password'], $row['user_password'])
            ) {
                if ($row['user_status'] == 'Active') {
                    $_SESSION['type'] = $row['user_type'];
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['user_name'] = $row['user_name'];
                    header('Location: index.php');
                } else {
                    $message =
                        "<label>Votre compte n'est pas actif, contactez votre administateur</label>";
                }
            } else {
                $message = '<label>Mot de passe incorrect</label>';
            }
        }
    } else {
        $message = '<label>Email invalide </label>';
    }
}

//
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Stock</title>
    <script src="js/jquery-1.10.2.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <br>
    <div class="container">
        <h2 class="text-center">
            Gestion de Stock
        </h2>
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">Connexion</div>
            <div class="panel-body">
                <form method="POST">
                    <?= $message ?>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="user_email" required>
                    </div>
                    <div class="form-group">
                        <label for="">Mot de passe</label>
                        <input type="password" class="form-control" name="user_password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" value="Connexion" class="btn btn-info">
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>