<?php
    foreach($alerts as $key => $value) {
        foreach($value as $alert) {
        ?>
            <div class="alert <?php echo $key; ?>">
                <?php echo $alert; ?>
            </div>
        <?php
        }
    }
?>