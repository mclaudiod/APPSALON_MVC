<h1 class="page-name">Create New Appointment</h1>
<p class="page-description">Choose your services and fill in your details</p>

<?php
    include_once __DIR__ . "/../templates/bar.php";
?>

<div class="app">
    <nav class="tabs">
        <button class="current" type="button" data-step="1">Services</button>
        <button type="button" data-step="2">Appointment Details</button>
        <button type="button" data-step="3">Summary</button>
    </nav>

    <div id="step-1" class="section">
        <h2>Services</h2>
        <p class="text-center">Choose your services down below</p>

        <div id="services" class="services-list">

        </div>
    </div>

    <div id="step-2" class="section">
        <h2>Your Details and Appointment</h2>
        <p class="text-center">Fill in your details and appointment time</p>

        <form class="form">
            <div class="field">
                <label for="name">Name</label>
                <input id="name" type="text" placeholder="Your Name" value="<?php echo $name; ?>" disabled>
            </div>

            <div class="field">
                <label for="date">Date</label>
                <input id="date" type="date" min="<?php echo date("Y-m-d", strtotime("+1 day")); ?>">
            </div>

            <div class="field">
                <label for="time">Time</label>
                <input id="time" type="time">
            </div>

            <input type="hidden" id="id" value="<?php echo $id; ?>">
        </form>
    </div>

    <div id="step-3" class="section summary-content">
        <h2>Summary</h2>
        <p class="text-center">Verify your appointment information</p>
    </div>

    <div class="pagination">
        <button id="previous" class="button">&laquo; Previous</button>
        <button id="next" class="button">Next &raquo;</button>
    </div>
</div>

<?php 
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";
?>