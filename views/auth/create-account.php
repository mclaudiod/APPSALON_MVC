<h1 class="page-name">Create Account</h1>
<p class="page-description">Fill the form to create an account</p>

<?php 
    include_once __DIR__ . "/../templates/alerts.php";
?>

<form class="form" method="POST" action="/create-account">
    <div class="field">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Your Name" value="<?php echo esc($user->name); ?>">
    </div>

    <div class="field">
        <label for="surname">Surname</label>
        <input type="text" id="surname" name="surname" placeholder="Your Surname" value="<?php echo esc($user->surname); ?>">
    </div>

    <div class="field">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" placeholder="Your Phone Number" value="<?php echo esc($user->phone); ?>">
    </div>

    <div class="field">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Your E-mail" value="<?php echo esc($user->email); ?>">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Your Password">
    </div>

    <input type="submit" value="Create Account" class="button">
</form>

<div class="actions">
    <a href="/">You already have an account? Sign In</a>
    <a href="/forgot">Forgot your password?</a>
</div>