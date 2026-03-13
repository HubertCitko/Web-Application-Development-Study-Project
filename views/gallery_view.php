<h1>Galeria</h1>
<?php if (isLoggedIn()): ?>
    <p>Witaj, <?php echo $_SESSION['login'] ?>! <a href="/logout">Wyloguj</a></p>
<?php else: ?>
    <a href="/login">Zaloguj</a>
    <a> | </a>
    <a href="/register"> Zarejestruj</a>
<?php endif; ?>
<?php if (isLoggedIn() && $_SESSION['login'] === 'admin'): ?>
    <p><a href="/clearGallery">Clear gallery</a></p>
<?php endif; ?>
<form method="post" action="/remember">
    <div>
        <?php foreach ($images as $image): ?>
            <?php if ($image['visibility'] === 'public' || ($image['visibility'] === 'private' && isset($_SESSION['user_id']) && $image['author'] === $_SESSION['login'])): ?>
                <div style="display: inline-block; text-align: center; margin: 10px;">
                    <input type="checkbox" name="remember[]" 
                        value="<?php echo $image['_id']; ?>"
                        <?php if (isset($_SESSION['remembered']) && in_array((string)$image['_id'], $_SESSION['remembered'])) echo 'checked'; ?>>
                        <a href="/images/<?php echo $image['watermarked']; ?>">
                            <img src="/images/<?php echo $image['thumbnail']; ?>" alt="Miniatura" style="width: 125px; height: 200px;">
                        </a>
                    <p><strong><?php echo htmlspecialchars($image['title']); ?> <?php echo (isset($_SESSION['user_id']) && $image['visibility'] === 'private') ? '(private) ' : '' ?></strong></p>
                    <p><?php echo htmlspecialchars($image['author']); ?></p>
                    
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <button type="submit">Zapamiętaj wybrane</button>
</form>
<a href="/remembered">Pokaż zapamiętane</a>
<a href="/upload">Dodaj zdjęcia</a>
