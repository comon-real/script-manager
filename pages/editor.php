<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Script editor</title>

		<link href="../assets/css/bootstrap.min.css" rel="stylesheet">

	</head>
	<body>
		<div class="container">
		
		
			<?php			
			if(isset($_POST['newFilename'])){
				$filename = $_POST['newFilename'];
			}
			else if(isset($_GET['newFilename'])){
				$filename = $_GET['newFilename'];
			}
			else
				$filename = "error_log";
			if(isset($_POST['textDisplay'])){
				$textDisplay = 	$_POST['textDisplay'];
			}
			else if(isset($_GET['textDisplay'])){
				$textDisplay = $_GET['textDisplay'];
			}
			else
				$textDisplay = "";
				
			$footer = '<hr><p>Update 07/11/17 Version 0.4.1<br>Design by Nicolas Bechelot - <a class="buttonBlue" href="https://www.comon-real.fr/script-manager/pages/editor?textDisplay='.$textDisplay.'&action=history&newFilename='.$filename.'">Update History</a></p>';
			
			echo '<h1 style="text-align: center; margin-bottom: 60px;"><a href="https://www.comon-real.fr/script-manager/pages/editor?newFilename=">Script Editor !</a></h1>';
			echo '<form action="https://www.comon-real.fr/script-manager/pages/editor" method="post">Script: ';
			$dir = "scripts/";
			$exclude = array( ".","..","error_log","_notes" );
			echo '<select>';
			if (is_dir($dir)) {
				if ($dh = opendir($dir)) {
					while (($file = readdir($dh)) !== false) {
						if(!in_array($file,$exclude))
							 echo '<option value="'.$dir.$file.'">'.$file.'</option>';
					}
					closedir($dh);
				}
			}
			echo '</select>';
			echo '<input style="text-align: center; margin-left: 20px;" class="buttonBlue" name="change" type="submit" value="show file" /></form>';
			if(isset($_GET['action']) == "history"){
				$updateHistory = "<hr>
				By Nicolas Bechelot, Project build on 07/11/2017 00:21
				";
				echo '<div>'.nl2br(str_replace('	','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$updateHistory)).'</div>';
			}
			if(isset($_POST['Submit'])){
				if($_POST['Submit']){
					$open = fopen($dir.$file,"w+");
					$text = $_POST['update'];
					fwrite($open, $text);
					fclose($open);
					echo '<font color="blue">File updated!</font> '; 
					echo '<button onclick="window.location.href=\'https://www.comon-real.fr/script-manager/pages/editor?textDisplay='.$textDisplay.'&edit=yes&newFilename='.$filename.'\'">Edit</button>';
					
					$file = file($filename);
					echo '<hr><p>';
					foreach($file as $text) {
						if($textDisplay != "html")
							$text = htmlspecialchars($text);
						echo nl2br(str_replace('	','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$text));
					}
					echo '</p>';
				}
			}
			else if(isset($_GET['edit'])=="yes"){
				$file = file("$filename");
				echo '<form action="https://www.comon-real.fr/script-manager/pages/editor?textDisplay='.$textDisplay.'&newFilename='.$filename.'" method="post">';
				echo '<textarea Name="update" cols="80" rows="10">';
				foreach($file as $text) {
					echo $text;
				} 
				echo '</textarea><br>';
				echo '<input class="buttonBlue" name="Submit" type="submit" value="Update" /></form>';
			} else {
				if($filename=="")
					exit($footer);
				if(!file_exists($filename))
					exit('<hr><font color="blue">File not exist!</font>'.$footer);
				echo '<button onclick="window.location.href=\'https://www.comon-real.fr/script-manager/pages/editor?textDisplay='.$textDisplay.'&edit=yes&newFilename='.$filename.'\'">Edit</button>';
				$file = file("$filename");
				echo '<hr><p>';
				foreach($file as $text) {
					if($textDisplay != "html")
						$text = htmlspecialchars($text);
					echo nl2br(str_replace('	','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$text));
				}
				echo '</p>';
					
			}
			echo $footer;
			?>
		
		</div>
		
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
	</body>
</html>