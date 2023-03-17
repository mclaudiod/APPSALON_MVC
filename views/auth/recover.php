<h1 class="page-name">Password Recovery</h1>
<p class="page-description">Write your new password down below</p>

<?php include_once __DIR__ . "/../templates/alerts.php"; ?>

<?php if($error) return; ?>

<form class="form" method="POST">
    <div class="field">
        <label for="password">New Password</label>
        <input type="password" id="password" placeholder="Your New Password" name="password">
    </div>

    <input type="submit" class="button" value="Save New Password">
</form>

<div class="actions">
    <a href="/">Ended here by mistake? Sign In</a>
</div>