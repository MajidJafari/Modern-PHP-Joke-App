<?php if (empty($joke) || $userId == $joke['authorId']): ?>
    <form action="" method="post">
        <input type="hidden" name="joke[id]" value="<?=$joke['id'] ?? ''?>">
        <label for="joketext">Type your joke here:</label>
        <textarea id="joketext" name="joke[jokeText]" rows="3" cols="40"><?=$joke['jokeText'] ?? ''?></textarea>
        <input type="submit" name="submit" value="Save">
    </form>
<?php else: ?>
    <p>You may only edit jokes that you posted.</p>
<?php endif; ?>
