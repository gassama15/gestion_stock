<?php
// category.php

include_once 'database_connection.php';

if (!isset($_SESSION['type'])) {
    header('Location:loging.php');
}

if ($_SESSION['type'] != 'master') {
    header('Location:index.php');
}

include_once 'header.php';
?>

<span id="alert_action"></span>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                    <div class="row">
                        <div class="panel-title">
                            Liste Catégories
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <div class="row text-right">

                    </div>
                </div>
                <div style="clear:both"></div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table id="category_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom Catégorie</th>
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
    </div>
</div>
<script>
$(document).ready(function() {
    var categorydataTable = $('#category_data').DataTable({
        'processing': true,
        'serverSide': true,
        'order': [],
        'ajax': {
            url: 'category_fetch.php',
            method: "POST",
        },
        'columnDefs': [{
            'target': [3, 4],
            'orderable': false
        }],
        "pageLength": 25
    });
})
</script>

<?php include_once 'footer.php';
?>