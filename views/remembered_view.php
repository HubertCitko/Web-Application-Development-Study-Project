<h1>Zapamiętane zdjęcia</h1>
<form method="post" action="/forget">
    <div>
        <?php if (!empty($images)): ?>
        {
            <?php foreach ($images as $image): ?>
                <div style="display: inline-block; text-align: center; margin: 10px;">
                    <input type="checkbox" name="forget[]" value="<?php echo $image['_id']; ?>">
                    <a href="/images/<?php echo $image['watermarked']; ?>">
                        <img src="/images/<?php echo $image['thumbnail']; ?>" alt="Miniatura" style="width: 125px; height: 200px;">
                    </a>
                    <p><strong><?php echo htmlspecialchars($image['title']); ?></strong></p>
                    <p><?php echo htmlspecialchars($image['author']); ?></p>
                </div>
            <?php endforeach; ?>
        }
        <?php endif; ?>
        <?php if (empty($images)): ?>
        {
            <h2 style="color: blue">Brak zapamiętanych zdjęć</h2>
        }
        <?php endif; ?>
    </div>
    <button type="submit">Usuń zaznaczone z zapamiętanych</button>
</form>
<a href="/">Powrót do galerii</a>