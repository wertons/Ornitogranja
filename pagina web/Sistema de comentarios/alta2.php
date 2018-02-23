<!DOCTYPE html>
<html lang=’es’> 
	<head>
		<meta charset="UTF-8">
		<title> Sistema de comentarios</title>	
		 
		<!--bootstrap-->
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	</head>
	
	<body>	
		

<!-- estructura inicial -->
<form action='alta3.php' method="POST">
<div class="container">

  <div class="row">
    <div class="col-md-2">
     
    </div>
    <div class="col-md-8">
					 <h1>Comentarios</h1>
      <div class="row">
        <div class="col-sm-6 form-group"> 
			<input class="form-control" type='text' name='nombre' size='30' maxlength='30' placeholder="Nombre" data-error="Escriba nombre" required >
        </div>
        
      </div>   
	<div class="row">
	<div class="col-sm-11 form-group"> 
      <textarea class="form-control" type='text'name='comentario' size='28' maxlength='100' placeholder="comentario" rows="3" required></textarea> 
		</div>
		  </div> 
      <br>
      <div class="row">
        <div class="col-md-12 form-group">
			<button type="submit" value='enviar'class="btn">Enviar</button>
      
        </div>
      </div>
    </div>
  </div>
</div>
	</form>	

<!--sacar por pantalla-->
<?php
$link=mysqli_connect('localhost','mili','1234','basededatos1')  or die("Error" . mysqli_error());
$datos = $link->query("SELECT * FROM sistema");
		?>
	
<?php while($user = mysqli_fetch_array($datos)){?>
<!--estilo de comentarios-->
	<div class="container">
  
  <div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-7"> <div class="panel panel-default">
    <div class="panel-heading"><?php echo $user['nombre'];?></div>
    <div class="panel-body ">	<?php echo $user['comentario'];?></div>
  </div> </div>
  </div>
</div>
	
<?php	}?>


	</body>
</html> 



	