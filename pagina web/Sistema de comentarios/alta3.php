<!DOCTYPE html>
<html> 
	<head>
		<title> Sistema de comentarios</title>
		<link href="style2.css" type="text/css" rel ="stylesheet"> 
			<!--bootstrap-->
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	</head>
	<body>
<!--código de envio-->
		<?php
		$f_nombre = $_POST ['nombre'];
		$f_comentario = $_POST ['comentario'];
		$linea1="INSERT INTO sistema (nombre, comentario )";
		$linea2= "VALUES ('$f_nombre', '$f_comentario')";
		$orden=$linea1.$linea2;
		
		$link=mysqli_connect('localhost','mili','1234')  or die("Error" . mysqli_error());
		$base= mysqli_select_db($link, "basededatos1") or die("Error" . mysqli_error());
		$result=mysqli_query($link,$orden) or die("Error" . mysqli_error());
	
		mysqli_close($link);
		?>
<div class="leer"> 
<a href="alta2.php"> Actualizar</a>
</div>
			<img src="https://github.com/wertons/Ornitogranja/blob/master/pagina%20web/img/logo1.png?raw=true">

	</body>
</html> 