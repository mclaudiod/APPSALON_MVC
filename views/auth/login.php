<h1 class="page-name">Login</h1>
<p class="page-description">Sign in with your credentials</p>

<?php include_once __DIR__ . "/../templates/alerts.php"; ?>

<form class="form" method="POST" action="/">
    <div class="field">
        <label for="email">E-mail</label>
        <input type="email" id="email" placeholder="Your E-mail" name="email">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Your Password" name="password">
    </div>

    <input type="submit" class="button" value="Sign In">
</form>

<div class="actions">
    <a href="/create-account">Don't have an account yet? Sign Up</a>
    <a href="/forgot">Forgot your password?</a>
</div>