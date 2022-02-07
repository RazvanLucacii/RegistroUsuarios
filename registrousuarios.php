	<?php

	//ficheros con la clase usuario y la clase listausuarios
	require 'usuario.php';
	require 'ListaUsuarios.php';

	$persona = json_decode($_POST['x']);

	var_dump($persona);

	//comprobar que se recibe el usuario y la contraseña
	//son datos obligatorios
	if ($persona->usu !="" && $persona->contra !="") {
		//se han recibido los datos obligatorios
		registrarUsuario($persona);
	}else{
		//no se ha recibido alguno de los datos obligatorios y se manda un mensaje de error
		$resp = false;
		echo json_encode($resp);		
	}

	//funcion para registrar un usuario en el sistema
	function registrarUsuario($p){

		//datos de entrada para registrar un usuario
		$nom = $p->nom;
		$ape = $p->ape;
		$cor = $p->cor;
		$usu = $p->usu;
		$pass = $p->contra;

		//se crea el objeto reg que contiene los datos del usuario
		$reg = new Usuario($nom, $ape, $cor, $usu, $pass);

		//leer el fichero de configuracion

		$dirConf="conf/";
		$fichConf="conf.dat";

		$fc = fopen($dirConf.$fichConf,"r"); 

		$conexBD = [];

		while(!feof($fc)){    //feof -> File - End of File
			$linea = fgets($fc);  //fgets -> File - Get String
			$datosLinea = explode("=",$linea);
			$conexBD[$datosLinea[0]]=trim($datosLinea[1]);
		}

		fclose($fc);

		//insertar en base de datos

		try{
			//construir un objeto de la clase PDO para conectar a la base de datos
			$conn = new PDO("mysql:host=".$conexBD["servidor"].";dbname=".$conexBD["basededatos"], $conexBD["usuario"], $conexBD["pass"]);

			// fijar el atributo MODO de ERROR en el valor EXCEPTION
  			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  			$sql = $reg->inserta();

  			$conn->exec($sql);

  			//cerrar la base de datos
  			$conn = null;

  			$resp=true;
			echo json_encode($resp);

		}catch(PDOException $e){

			error_log("Error en la inserción: " . $e->getMessage());

			$resp=false;
			echo json_encode($resp);
		}

	}
