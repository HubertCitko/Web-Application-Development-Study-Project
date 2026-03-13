<h1>Prześlij zdjęcie</h1>
<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>
<a href="/">Galeria</a>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Tytuł" required>
    <input type="text" name="author" placeholder="Autor" 
           value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['login'] : ''; ?>" required>
    <input type="text" name="watermark" placeholder="Znak wodny" required>
    <input type="file" name="photo" required>
    <?php if (isset($_SESSION['user_id'])): ?>
        <div>
            <label>
                <input type="radio" name="visibility" value="public" checked> Publiczne
            </label>
            <label>
                <input type="radio" name="visibility" value="private"> Prywatne
            </label>
        </div>
    <?php endif; ?>

    <button type="submit">Wyślij</button>
</form>