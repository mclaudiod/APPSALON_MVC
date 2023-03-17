<h1 class="page-name">Administration Panel</h1>

<?php
    include_once __DIR__ . "/../templates/bar.php";
?>

<h2>Search Appointments</h2>

<div class="search">
    <form class="form">
        <div class="field">
            <label for="date">Date</label>
            <input type="date" id="date" name="date" value="<?php echo $date; ?>">
        </div>
    </form>
</div>

<?php
    if(count($appointments) === 0) {
        echo "<h2>There is no appointments on this date</h2>";
    };
?>

<div id="admin-appointments">
    <ul class="appointments">
        <?php $appointmentId = 0;
        foreach($appointments as $key => $appointment) {
            if($appointmentId !== $appointment->id) {
                $appointmentId = $appointment->id;
                $total =  0; ?>

                <li>
                    <p>ID: <span><?php echo $appointment->id; ?></span></p>
                    <p>Time: <span><?php echo $appointment->time; ?></span></p>
                    <p>Client: <span><?php echo $appointment->client; ?></span></p>
                    <p>Email: <span><?php echo $appointment->email; ?></span></p>
                    <p>Phone: <span><?php echo $appointment->phone; ?></span></p>

                    <h3>Services</h3>
            <?php } ?>

            <p class="service"><?php echo $appointment->service . " " . $appointment->price . " $"; ?></p>

            <?php
                $total += $appointment->price;
                $present = $appointment->id;
                $next = $appointments[$key + 1]->id ?? 0;

                if(isLast($present, $next)) { ?>
                    <p class="total">Total: <span><?php echo $total; ?> $</span></p>

                    <form action="/api/delete" method="POST">
                        <input type="hidden" name="id" value="<?php echo $appointment->id; ?>">
                        <input type="submit" class="delete-button" value="Delete">
                    </form>
                <?php }
            ?>
        <?php } ?>
    </ul>
</div>

<?php
    $script = "<script src='build/js/searcher.js'></script>";
?>