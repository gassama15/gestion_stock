<?php
//header.php
?>
<!DOCTYPE html>
<html>

<head>
    <title>Gestion de Stock</title>
    <script src="js/jquery-1.10.2.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <br />
    <div class="container">
        <h2 class="text-center">Gestion de Stock</h2>

        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="index.php" class="navbar-brand">Accueil</a>
                </div>
                <ul class="nav navbar-nav">
                    <?php if ($_SESSION['type'] == 'master') { ?>
                    <li><a href="user.php">Utilisateur</a></li>
                    <li><a href="category.php">Categorie</a></li>
                    <li><a href="brand.php">Marque</a></li>
                    <li><a href="product.php">Produit</a></li>
                    <?php } ?>
                    <li><a href="order.php">Commande</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                class="label label-pill label-danger count"></span> <?php echo $_SESSION[
                                    'user_name'
                                ]; ?></a>
                        <ul class="dropdown-menu">
                            <li><a href="profile.php">Profi</a></li>
                            <li><a href="logout.php">Déconnexion</a></li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>