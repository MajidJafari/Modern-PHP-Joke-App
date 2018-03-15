<form action="" method="post">
    <input type="hidden" name="joke[id]" value="<?php if(isset($joke)) echo $joke['id']; ?>">
    <label for="joketext">Type your joke here:</label>
    <textarea id="joketext" name="joke[jokeText]" rows="3" cols="40"><?php if(isset($joke)) echo $joke['jokeText']; ?></textarea>
    <input type="submit" name="submit" value="Save">
</form>