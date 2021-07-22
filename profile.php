<?php
//profile.php

include_once 'database_connection.php';

if (!isset($_SESSION['type'])) {
    header('Location: login.php');
}

$query =
    "
    SELECT * FROM user_details
    WHERE user_id = '" .
    $_SESSION['user_id'] .
    "'
";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$name = '';
$email = '';
$user_id = '';
foreach ($result as $row) {
    $name = $row['user_name'];
    $email = $row['user_email'];
    $user_id = $row['user_id'];
}

include 'header.php';
?>

<div class="panel panel-default">
    <div class="panel-heading">Modifier Profil</div>
    <div class="panel-body">
        <form method="POST" id="edit_profile_form">
            <span id="message"></span>
            <div class="form-group">
                <label for="">Nom</label>
                <input type="text" name="user_name" id="user_name" class="form-control" value="<?= $name ?>" required>
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="user_email" id="user_email" value="<?= $email ?>" class="form-control"
                    required>
            </div>
            <hr>
            <label for="">Laissez le mot de passe vide si vous ne voulez pas changer</label>
            <div class="form-group">
                <label for="">Nouveau mot de passe</label>
                <input type="password" name="user_new_password" id="user_new_password" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Confirmer votre nouveau mot de passe</label>
                <input type="password" name="user_re_enter_password" id="user_re_enter_password" class="form-control">
                <span id="error_password"></span>
            </div>
            <div class="form-group">
                <input type="submit" name="edit_profile" id="edit_profile" class="btn btn-info" value="Modifier">
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#edit_profile_form').on('submit', function(e) {
        e.preventDefault();
        if ($('#user_new_password').val() != '') {
            if ($('#user_new_password').val() != $('#user_re_enter_password').val()) {
                $('#error_password').html(
                    '<label class="text-danger">Les mot de passe ne correspondent pas</label>');
                return false;
            } else {
                $('#error_password').html('');
            }
        }
        $('#edit_profile').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $('#user_re_enter_password').attr('required', false);
        $.ajax({
            url: "edit_profile.php",
            method: "POST",
            data: form_data,
            success: function(data) {
                $('#edit_profile').attr('disabled', false);
                $('#user_new_password').val('');
                $('#user_re_enter_password').val('');
                $('#message').html(data);
                $('#error_password').html('<label class="text-danger"></label>');
            }
        })
    });
});
</script>