<?php

	class Usuario{
		private $nombre;
		private $apellido;
		private $email;
		private $usu;
		private $pass;

		function __construct($n,$a,$e,$u,$p){
			$this->nombre = $n;
			$this->apellido = $a;
			$this->email = $e;
			$this->usu = $u;
			$this->pass = $p;
		}

		function inserta(){
			$cript = password_hash($this->pass, PASSWORD_DEFAULT);
			
			$sal = "INSERT INTO usuarios(nombre,apellido,user,pass,correo) VALUES('".$this->nombre."','".$this->apellido."','".$this->usu."','".$cript."','".$this->email."')";
			return $sal;
		}

		function getUsu(){
			return $this->usu;
		}
	}