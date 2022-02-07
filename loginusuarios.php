<?php

	session_start();

	$per = json_decode($_POST['usuario']);

	if($per->usu != "" && $per->pas != ""){

		login($per);

	}else{
		//remover las variables y destruir la sesion
		session_unset();
		session_destroy();

		$resp=false;
		echo json_encode($resp);		
	}

	function login($p){

		//leer la configuracion del fichero de conf.dat
		$dirConf="conf/";
		$fichConf="conf.dat";

		$fc = fopen($dirConf.$fichConf,"r");

		$conexBD = [];

		while(!feof($fc)){ //feof => File - End Of File
			$linea = fgets($fc); //fgets => File - Get String
			$datosLinea = explode("=",$linea);
			$conexBD[$datosLinea[0]]=trim($datosLinea[1]);
		}

		fclose($fc);

		//buscar el usuario en la base

		try {
		    //construir un objeto de la clase PDO para conectar a la base de datos		
		    $conn = new PDO("mysql:host=".$conexBD["servidor"].";dbname=".$conexBD["basededatos"], $conexBD["usuario"], $conexBD["pass"]);

	 		//fijar el atributo MODO de ERROR en el valor EXCEPTION
	  		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	  		//preparamos la consulta
	  		$stmt = $conn->prepare("SELECT COUNT(*) as num FROM usuarios where user='".$p->usu."'");
  
			//ejecutamos la consulta
  	  		$stmt->execute();

  	  		$stmt->setFetchMode(PDO::FETCH_ASSOC);

  	  		//los resultados
  	  		$salida = $stmt->fetchAll();

  	  		if($salida[0]["num"] == "0"){


  	  			//remover las variables y destruir la sesion
				session_unset();
				session_destroy();

				$resp=false;
				echo json_encode($resp);
  	  		}else{

		  		//preparamos la consulta
		  		$stmt = $conn->prepare("SELECT nombre,id,pass FROM usuarios where user='".$p->usu."'");
	  
				//ejecutamos la consulta
	  	  		$stmt->execute();

	  	  		$stmt->setFetchMode(PDO::FETCH_ASSOC);

	  	  		//los resultados
	  	  		$salida = $stmt->fetchAll();

	  	  		if(password_verify($p->pas,$salida[0]["pass"])){

		  	  		$_SESSION["dentro"] = true;
	  	  			$_SESSION["servidor"] = $conexBD["servidor"];
	  	  			$_SESSION["basededatos"] = $conexBD["basededatos"];
	  	  			$_SESSION["usuario"] = $conexBD["usuario"];
	  	  			$_SESSION["pass"] = $conexBD["pass"];
	  	  			$_SESSION["id"] = $salida[0]["id"];
	  	  			$_SESSION["nombre"] = $salida[0]["nombre"];

					$resp=true;
					echo json_encode($resp);
				}else{
					//remover las variables y destruir la sesion
					session_unset();
					session_destroy();

					$resp=false;
					echo json_encode($resp);					
				}
  	  		}

	  		$conn = null;

		} catch(PDOException $e) {

			error_log("Error en la insercion: " . $e->getMessage());

			//remover las variables y destruir la sesion
			session_unset();
			session_destroy();

			$resp=false;
			echo json_encode($resp);
		}		

		//comprobar la password


	}
