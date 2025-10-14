<?php
$_SESSION['lmc_data']['nom'] = sanitize_text_field($_POST['nom']);
$_SESSION['lmc_data']['email'] = sanitize_email($_POST['email']);
?>