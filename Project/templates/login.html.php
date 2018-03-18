<?php if(!empty($error)): ?>
	<div class="errors">
		<p><?=$error?></p>
	</div>
<?php endif; ?>
<form action="" method="post">
	<label for="username">Username or Email</label>
	<input type="text" id="username" name="username" value="<?=$_POST['username']??''?>">
	
	<label for="password">Password</label>
	<input type="password" id="password" name="password">
	
	<input type="submit" name="submit" value="Log in">
</form>
