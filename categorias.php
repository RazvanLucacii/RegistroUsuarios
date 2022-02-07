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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" ></script>
	<script type="text/javascript" src="js/categorias.js"></script>
</head>
<body>

	<div class="container">

		<!--titulo-->
		<div class="row">
			<div class="col-3"></div>
			<div class="col-6">
				<h3 class="display-3 text-center">Categorias</h3>
			</div>
			<div class="col-3">
				<?php
					echo $_SESSION["nombre"];
				?>
				<a href="salir.php" class="text-white">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16" alt="Salir">
	  				<path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
	  				<path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
					</svg>
				</a>
			</div>
		</div>
		<!--cuerpo-->
		<div class="row border border-2">
			<div class="col-3"></div>
			<div class="col-6">
				<table class="table table-bordered table-sm table-striped">
					<tbody id="tabCat">
						<?php

							$dirConf = "conf/";
							$fichConf = "conf.dat";

							$fc = fopen($dirConf.$fichConf,"r");

							$conexBD = [];

							while(!feof($fc)){ //feof => File - End Of File
								$linea = fgets($fc); //fgets => File - Get String
								$datosLinea = explode("=",$linea);
								$conexBD[$datosLinea[0]]=trim($datosLinea[1]);
							}

							fclose($fc);

							try {
							    //construir un objeto de la clase PDO para conectar a la base de datos		
							    $conn = new PDO("mysql:host=".$conexBD["servidor"].";dbname=".$conexBD["basededatos"], $conexBD["usuario"], $conexBD["pass"]);

						 		//fijar el atributo MODO de ERROR en el valor EXCEPTION
						  		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

						  		//contar sobre categorias con el nombre de la categoria
						  		//SELECT COUNT(*) FROM categorias WHERE nombre=$nombre
								$stmt = $conn->prepare("SELECT id,nombre,descripcion FROM categorias");
								//ejecutamos la consulta
						  	  	$stmt->execute();

						  	  	$stmt->setFetchMode(PDO::FETCH_ASSOC);

						  	  	//los resultados
						  	  	$salida = $stmt->fetchAll();

						  	  	for ($i=0; $i < count($salida); $i++) { 
						  	  		echo "<tr>";
						  	  			echo "<td>";
						  	  				echo '<a href="http://basededatos.razvan/registrousuariosajaxBD/temas.php?cate='.$salida[$i]["id"].'">';
							  	  				echo $salida[$i]["nombre"]." - ";
							  	  				echo $salida[$i]["descripcion"];
							  	  			echo '</a>';
							  	  		echo "</td>";
							  	  	echo "</tr>";
						  	  	}
						  	} catch(PDOException $e) {

								error_log("Error en la insercion: " . $e->getMessage());

								echo "-1";
							}
							$conn = null;
						?>
					</tbody>
				</table>
			</div>
			<div class="col-3">
				<button class="btn btn-secondary mb-3" data-bs-toggle="collapse" data-bs-target="#divFormCat">Crear Categoria</button>
				<div class="collapse" id="divFormCat">
					<label for="titulo" class="form-label">Titulo</label><br>
					<input type="text" id="tituloCat" class="form-control"><br>
					<label for="descCat" class="form-label">Descripcion</label><br>
					<input type="text" id="descCat" class="form-control"><br>
					<button type="button" onclick="creaCategoria()" class="btn btn-secondary">Enviar</button>
				</div>
			</div>
		<!-- Fin del div container-->
		</div>
	</div>
</body>
</html>