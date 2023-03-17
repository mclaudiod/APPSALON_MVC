<h1 class="page-name">Password Recovery</h1>
<p class="page-description">Recover your account by writting your E-mail below</p>

<?php include_once __DIR__ . "/../templates/alerts.php"; ?>

<form class="form" method="POST" action="/forgot">
    <div class="field">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Your E-mail">
    </div>

    <input type="submit" class="button" value="Send Instructions">
</form>

<div class="actions">
    <a href="/">You already have an account? Sign In</a>
    <a href="/create-account">Don't have an account yet? Sign Up</a>
</div>