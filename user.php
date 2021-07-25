<?php
// user.php
include_once 'database_connection.php';

if (!isset($_SESSION['type'])) {
    header('Location:login.php');
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
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <h3 class="panel-title">Liste Utilisateurs</h3>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="text-right">
                            <button type="button" name="add" id="add_button" data-toggle="modal"
                                data-target="#userModal" class="btn btn-success btn-xs">Ajouter</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
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
<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                    <h4 class="modal-title"><i class="fas fa-plus"> Ajouter Utilisateur</i></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Entrer le Nom de l'Utilisateur</label>
                        <input type="text" class="form-control" name="user_name" id="user_name" required>
                    </div>
                    <div class="form-group">
                        <label>Entrer l'Email de l'Utilisateur</label>
                        <input type="email" class="form-control" name="user_email" id="user_email" required>
                    </div>
                    <div class="form-group">
                        <label>Entrer le mot de passe de l'Utilisateur</label>
                        <input type="password" class="form-control" name="user_password" id="user_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" id="user_id">
                    <input type="hidden" name="btn_action" id="btn_action">
                    <input type="submit" name="action" id="action" class="btn btn-info" value="Ajouter">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#add_button').click(function() {
        $('#user_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Ajouter Utilisateur");
        $('#action').val("Ajouter");
        $('#btn_action').val("Ajouter");
    });
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
    $(document).on('submit', '#user_form', function(e) {
        e.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url: "user_action.php",
            method: "POST",
            data: form_data,
            success: function(data) {
                $('#user_form')[0].reset();
                $('#userModal').modal('hide');
                $('#alert_action').fadeIn().html(
                    '<div class="alert alert-success">' + data + '</div>'
                );
                $('#action').attr('disabled', false);
                userdataTable.ajax.reload();
            }
        })
    })
    $(document).on('click', '.update', function() {
        var user_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url: "user_action.php",
            method: "POST",
            data: {
                user_id: user_id,
                btn_action: btn_action
            },
            dataType: "json",
            success: function(data) {
                $('#userModal').modal('show');
                $('#user_name').val(data.user_name);
                $('#user_email').val(data.user_email);
                $('.modal-title').html(
                    '<i class="fas fa-pencil-square-o"></i> Modification Utilisateur'
                );
                $('#user_id').val(user_id);
                $('#action').val('Modifier');
                $('#btn_action').val('Modifier');
                $('#user_password').attr('required', false);
            }
        })
    });

    $(document).on('click', '.delete', function() {
        var user_id = $(this).attr("id");
        var status = $(this).data("status");
        var btn_action = "supprimer";
        if (confirm("Êtes vous sûr(e) de vouloir supprimer?")) {
            $.ajax({
                url: "user_action.php",
                method: "POST",
                data: {
                    user_id: user_id,
                    status: status,
                    btn_action: btn_action
                },
                success: function(data) {
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">' +
                        data + '</div>');
                    userdataTable.ajax.reload();
                }
            })
        } else {
            return false;
        }
    });
});
</script>


<?php include_once 'footer.php';

?>