<?php
// user.php
include_once 'database_connection.php';

if (!isset($_SESSION['type'])) {
    header('Location:login.php');
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
                        <h3 class="panel-title">Liste Utilisateurs</h3>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <div class="row">
                        <div class="text-right">

                        </div>
                    </div>
                </div>
            </div>
            <div class="pnael-body">
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table id="user_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Nom</th>
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
    var userdataTable = $('#user_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "user_fetch.php",
            type: "POST"
        },
        "columnDefs": [{
            "target": [
                4,
                5
            ],
            "orderable": false
        }],
        "pageLength": 25
    });
});
</script>