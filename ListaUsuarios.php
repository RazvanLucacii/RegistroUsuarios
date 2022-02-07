<?php
	
	class ListaUsuarios{

		//path y nombre del fichero de usuarios
		private $path;
		private $fichUsu;

		//array asociativo con la informacion de cada usuario
		private $listaUsu;

		function __construct($p,$f){
			//rellenar los atributos con parametros
			$this->path=$p;
			$this->fichUsu=$f;

			//comprobar que el fichero existe
			if (file_exists($p.$f)) {

				//abre el fichero
				$fu = fopen($p.$f, "r");

				//lee el contenido hasta el final del fichero
				while (!feof($fu)) {

					//lee una linea del fichero
					$linea = fgets($fu);

					$linea = substr($linea,0, strlen($linea)-1);

					//si la linea esta vacia no se hace nada
					if (strlen($linea) != 0) {

						//se divide la linea por el ";" y se genera un array indexado
						$datosUsu = explode(";",$linea);
						//se añade el usuario el array asociativo
						//la clave el usu y el valor de toda la linea de datos
						$this->listaUsu[$datosUsu[3]] = $datosUsu;
					}
				}

				//cierra el archivo
				fclose($fu);
			}
		}

		function noExisteUsuario($usu){
				return !(isset($this->listaUsu[$usu]));
		}

		function login($u,$p){

			//Se comprueba si el usuario esta en el array asociativo
			//que se ha creado desde el fichero
			if (isset($this->listaUsu[$u])) {

				//el usuario existe
				//comprobamos la contraseña
				if ($this->listaUsu[$u][4]==$p) {
					return true;
				}else{
					return false;
				}
			}else{
				//el usuario no existe se devuelve false
				return false;
			}
		}
	}
