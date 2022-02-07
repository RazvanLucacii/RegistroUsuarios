<?php
	require "dentro.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<script type="text/javascript" src="js/temas.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
	<div class="container pb-3 pt-3">
		<!--cabecera -->
		<div class ="row">
			<div class="col-3"></div>
			<div class="col-5 bg-primary text-white">
				<p>Pagina  de temas</p>
			</div>
			<div class="col-1 bg-primary text-white">
				<?php
					echo $_SESSION["nombre"];
				?>

				<a href="salir.php" class="text-white"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
				  <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
				  <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
				</svg></a>
			</div>
			<div class="col-3"></div>
		</div>

		<!--formulario -->
		<div class="row">
			<div class="col-3">
			</div>
			<div class="col-6">
				<form>
					<input type="hidden" id="cate" value="<?php echo $_GET["cate"] ?>">
					<div class ="mt-2">
					<input type="text" class ="form-control mb-2" id="titulo" placeholder="Titulo">
					<textarea class="form-control" id="texto"placeholder="Texto"></textarea>
					<button type="button" class="btn btn-primary mt-2" onclick="registraTema()">Enviar tema</button>
					</div>
				</form>
			</div>
			<div class="col-3">
			</div>
		</div>
		<div class="row">
			<div class="col-3">
			</div>		
			<div id="contenedorTemas" class="col-6">	
				<?php
					try{
					  //construir un objeto de la clase PDO para conectar a la base de datos	
					  $conn = new PDO("mysql:host=".$_SESSION["servidor"].";dbname=".$_SESSION["basededatos"], $_SESSION["usuario"], $_SESSION["pass"]);
					  
					  //fijar el atributo MODO de ERROR en el valor EXCEPTION
					  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					  //Pasos para hacer un SELECT de la base de datos
					  //preparamos la consulta
					  $stmt = $conn->prepare("SELECT * FROM temas WHERE id_categoria=".$_GET["cate"]);
				  
				  	  //ejecutamos la consulta
				  	  $stmt->execute();


				  	  //modo de resultados en array asociativo
				  	  $stmt->setFetchMode(PDO::FETCH_ASSOC);

				  	  //los resultados
				  	  $salida = $stmt->fetchAll();

						foreach ($salida as $tema) {
					  	  	//cards
					  	  echo '<div class="mt-3 card">';
					  	  echo '<img src="DAWC.png">';
					  	  	echo '<div class="card-header">';
					  	  	echo $tema["titulo"];
					  	  	echo '</div>';
							echo '<div class="card-body">';
					  	  	echo $tema["texto"];
					  	  	echo '</div>';
						  	  	if($tema["id_usuario"]==$_SESSION["id"]){
						  	  		echo'<a href="borraTema.php?id='.$tema["id"].'&cate='.$_GET["cate"].'" class="btn btn-primary">Borrar</a>';
						  		}
					    	echo '</div>';
							
					  	}


					} catch(PDOException $e) {
					  error_log("Error en la conexion: " . $e->getMessage());
					}

					//deconectar de la BD
					$conn = null;

				?>	
			</div>
			<div class="col-3">
			</div>
		</div>
	</div>
</body>
</html>
