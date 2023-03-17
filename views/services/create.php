<h1 class="page-name">New Service</h1>
<p class="page-description">Fill all the fields to add a new service</p>

<?php
    include_once __DIR__ . "/../templates/bar.php";
    include_once __DIR__ . "/../templates/alerts.php";
?>

<form action="/services/create" method="POST" class="form">
    <?php include_once __DIR__ . "/form.php"; ?>

    <input type="submit" class="button" value="Create Service">
</form>