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
                        <button type="button" name="add" id="add_button" data-toggle="modal"
                            data-target="#categoryModal" class="btn btn-success btn-xs">Ajouter</button>
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
<div id="categoryModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="category_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fas fa-plus"></i> Ajouter Catégorie</h4>
                </div>
                <div class="modal-body">
                    <label>Entrer le nom de catégorie</label>
                    <input type="text" name="category_name" id="category_name" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="category_id" id="category_id">
                    <input type="hidden" name="btn_action" id="btn_action">
                    <input type="submit" name="action" id="action" class="btn btn-info">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function() {

    $('#add_button').click(function() {
        $('#category_form')[0].reset();
        $('.modal-title').html("<i class='fas fa-plus'></i> Ajout Catégorie");
        $('#action').val('Ajouter');
        $('#btn_action').val('Ajouter');
    });

    $(document).on('submit', '#category_form', function(e) {
        e.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url: "category_action.php",
            method: "POST",
            data: form_data,
            success: function(data) {
                $('#category_form')[0].reset();
                $('#categoryModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">' +
                    data + '</div>');
                $('#action').attr('disabled', false);
                categorydataTable.ajax.reload();
            }
        });
    });

    $(document).on('click', '.update', function() {
        var category_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url: "category_action.php",
            method: "POST",
            data: {
                category_id: category_id,
                btn_action: btn_action
            },
            dataType: "json",
            success: function(data) {
                $('#categoryModal').modal('show');
                $('#category_name').val(data.category_name);
                $('.modal-title').html(
                    '<i class="fas fa-pencil-square-o"></i> Modification Catégorie'
                );
                $('#category_id').val(category_id);
                $('#action').val('Modifier');
                $('#btn_action').val('Modifier');
            }
        });
    });

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

    $(document).on('click', '.delete', function() {
        var category_id = $(this).attr('id');
        var status = $(this).data("status");
        var btn_action = 'Supprimer';
        if (confirm("Êtes vous sûr(e) de vouloir supprimer?")) {
            $.ajax({
                url: "category_action.php",
                method: "POST",
                data: {
                    category_id: category_id,
                    status: status,
                    btn_action: btn_action
                },
                success: function(data) {
                    $('#alert_action').fadeIn().html(
                        '<div class="alert alert-info">' +
                        data + '</div>'
                    );
                    categorydataTable.ajax.reload();
                }
            });
        } else {
            return false;
        }
    });
});
</script>

<?php include_once 'footer.php';
?>