<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/css/jokes.css">
	<title><?=$title?></title>
</head>
<body>
<header>
	<h1>Internet Joke Database</h1>
</header>
<nav>
	<ul>
		<li><a href="/">Home</a></li>
		<li><a href="/joke/list">Jokes List</a></li>
		<li><a href="/joke/save">Add a new Joke</a></li>
		<li><a href="/author/register">Register</a></li>
        <li><?php if($isLoggedIn): ?><a href="/logout">Logout</a>
            <?php else: ?><a href="/login">Login</a>
            <?php endif; ?></li>
            
	</ul>
</nav>
<main>
	<?=$output?>
</main>
<footer>
	&copy; Internet Jokes Database 2018 | By Majid Jafari
</footer>
</body>
</html>