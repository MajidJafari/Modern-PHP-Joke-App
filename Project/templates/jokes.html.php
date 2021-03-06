
<p><?=$totalJokes?> jokes have been submitted to the Internet Joke Database.</p>
<?php foreach($jokes as $joke): ?>
<blockquote>
  <p>
  <?=htmlspecialchars($joke['jokeText'], ENT_QUOTES, 'UTF-8')?>

    (by <a href="mailto:<?=htmlspecialchars($joke['email'], ENT_QUOTES,
                    'UTF-8'); ?>">
                <?=htmlspecialchars($joke['name'], ENT_QUOTES,
                    'UTF-8'); ?></a> on 
<?php
$date = new DateTime($joke['jokeDate']);

echo $date->format('jS F Y');
?>)
  <?php if($userId == $joke['authorId']): ?>
  <a href="/joke/save?id=<?=$joke['id']?>">Edit</a>
  <form action="/joke/delete" method="post">
    <input type="hidden" name="id" value="<?=$joke['id']?>">
    <input type="submit" value="Delete">
  </form>
  <?php endif; ?>
  </p>
</blockquote>
<?php endforeach; ?>