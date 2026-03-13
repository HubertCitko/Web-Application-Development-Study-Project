<h1>Register</h1>
<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>
<form method="post">
    <input type="text" name="email" placeholder="Adres e-mail" required>
    <input type="text" name="login" placeholder="Login" required>
    <input type="password" name="password" placeholder="Hasło" required>
    <input type="password" name="repeat_password" placeholder="Powtórz hasło" required>
    <button type="submit">Zarejestruj</button>
</form>