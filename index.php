<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect . $id);
    exit();
}

$page = htmlentities($_GET['url']);
$pages = scandir('pages');

if(!empty($page) && in_array($_GET['url'].".php",$pages)) {
	$content = 'pages/'.$_GET['url'].".php";
} else {
	header("Location:index.php?url=accueil");
}


try{
    $pdo = new PDO('sqlite:'.dirname(__FILE__).'/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {
    echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
    die();
}

$pdo->query("CREATE TABLE IF NOT EXISTS script ( 
    id            INTEGER         PRIMARY KEY AUTOINCREMENT,
    titre         VARCHAR( 250 ),
    created       DATETIME,
	contenu       VARCHAR( 250 )
);");
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Script Manager</title>

		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/css/font-awesome.min.css" rel="stylesheet">
		<link href="assets/css/base.css" rel="stylesheet">

	</head>
	<body>
		<div class="container">
			<div class="header clearfix">
				<nav>
					<ul class="nav nav-pills pull-right">
						<li role="presentation" <?php if($_GET['url']=='accueil'){echo'class="active"';} ?>><a href="index.php?url=accueil">Projet en cours</a></li>
						<li role="presentation" <?php if($_GET['url']=='n_pro'){echo'class="active"';} ?>><a href="index.php?url=n_pro">Créer un nouveau projet</a></li>
					</ul>
				</nav>
				<h3 class="text-muted">Script Manager</h3>
			</div>
			
			<?php include $content; ?>
		
			<footer class="footer">
				<p>© 2017 Com'on Real, Inc.</p>
			</footer>

		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script>
		var name_ok = Cookies.get('name_ok');

		function coName () {
			var person = prompt("merci d'entrer votre nom");
			Cookies.set('name', person, { expires: 7 });
			Cookies.set('name_ok', "1", { expires: 7 });
		}
		
		if (name_ok == "0") {
			coName();
		}
		</script>
<h1> salut petit nico </h1>
	</body>
</html>