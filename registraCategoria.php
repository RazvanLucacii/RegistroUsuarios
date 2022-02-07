<?php

require "dentro.php";
	
if (isset($_GET["nombre"],$_GET["descrip"])) {
	registramosCategoria();
}else{
	echo "-1";
}

function registramosCategoria(){
	
	$nombre = $_GET['nombre'];
	$descri = $_GET['descrip'];

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

  		//preparamos la consulta
  		$stmt = $conn->prepare("SELECT COUNT(*) as N FROM categorias WHERE nombre='$nombre'");

		//ejecutamos la consulta
	  	$stmt->execute();

	  	$stmt->setFetchMode(PDO::FETCH_ASSOC);

		//los resultados
	  	$salida = $stmt->fetchAll();

		// si no existe la categoria se inserta

	  	if($salida[0]["N"] == 0){

  			//INSERT INTO categorias (nombre,descripcion,id_usuario) 
			//				VALUES($nombre,$descri,$SESSION["id"])
			//si existe se devuelve -1
  			$stmt = $conn->prepare("INSERT INTO categorias (nombre,descripcion,id_usuario) VALUES('$nombre','$descri',".$_SESSION["id"].")");
			//ejecutamos la consulta
	  		$stmt->execute();
	  		$stmt->setFetchMode(PDO::FETCH_ASSOC);

	  		// se consulta el id de la nueva cat y esto es lo que se devuelve
  			//SELECT id FROM categorias WHERE nombre=$nombre
  			//return de ese id
  	  		$stmt = $conn->prepare("SELECT id FROM categorias WHERE nombre='$nombre'");
			//ejecutamos la consulta
	  	  	$stmt->execute();

	  	  	$stmt->setFetchMode(PDO::FETCH_ASSOC);

	  	  	//los resultados
	  	  	$salida = $stmt->fetchAll();

	  	  	echo $salida[0]["id"];
	  	}else{
  	  		echo "-1";
	  	}

  		


	} catch(PDOException $e) {

		error_log("Error en la insercion: " . $e->getMessage());

		echo "-1";
	}
}

	

	



 /*
	//insertar en base de datos
	try {
	    //construir un objeto de la clase PDO para conectar a la base de datos		
	    $conn = new PDO("mysql:host=".$_SESSION["servidor"].";dbname=".$_SESSION["basededatos"], $_SESSION["usuario"], $_SESSION["pass"]);

 		//fijar el atributo MODO de ERROR en el valor EXCEPTION
  		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  		$sql = "INSERT INTO categorias(nombre,descripcion,id_usuario) VALUES('".$cat[0]."','".$cat[1]."',".$_SESSION["id"].") ";

  		$conn->exec($sql);

  		//recuperar el id de la categoria creada

  		$stmt = $conn->prepare('SELECT id FROM categorias WHERE nombre="'.$cat[0].'"');
  		//ejecutamos la consulta
  		$stmt->execute();
  		//modo de resultados en array asociativo
  		$stmt->setFetchMode(PDO::FETCH_ASSOC);
  		//los resultados
  		$salida = $stmt->fetchAll();
  		$salida[0]["id"];

  		$conn = null;

		$resp=$salida[0]["id"];
		echo json_encode($resp);


	} catch(PDOException $e) {

		error_log("Error en la insercion: " . $e->getMessage());

		$resp=-1;
		echo json_encode($resp);
	}
	*/