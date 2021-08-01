<?php
// brand.php
include_once 'database_connection.php';
if (!isset($_SESSION['type'])) {
    header('Location: login.php');
}
if ($_SESSION['type'] != 'master') {
    header('Location: index.php');
}

include_once 'header.php';
?>

<span id="alert_action"></span>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-10">
                        <h3 class="panel-title">Liste des marques</h3>
                    </div>
                    <div class="col-md-2 text-right">

                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table id="brand_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Catégorie</th>
                            <th>Marque</th>
                            <th>Statut</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var brandDataTable = $('#brand_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "brand_fetch.php",
            method: "POST"
        },
        "columnDefs": [{
            "target": [4, 5],
            "orderable": false
        }],
        "pageLength": 10
    });
});
</script>

<?php include_once 'footer.php';
?>