<h1>Login</h1>
<?php if (isset($error)) : ?>
    <p style="color: red;"> <?php echo $error; ?></p>
<?php endif; ?>
<form method="post">
    <input type="text" name="login" placeholder="Login" required>
    <input type="password" name="password" placeholder="Hasło" required>
    <button type="submit">Zaloguj</button>
</form>
<a href="/">Powrót do galerii</a>