<?php

  require "dentro.php";

  $id = $_GET["id"] ?? -1;
  $cate=$_GET['cate'];

  try {
    //construir un objeto de la clase PDO para conectar a la base de datos	
    $conn = new PDO("mysql:host=".$_SESSION["servidor"].";dbname=".$_SESSION["basededatos"], $_SESSION["usuario"], $_SESSION["pass"]);
    
    //fijar el atributo MODO de ERROR en el valor EXCEPTION
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE FROM temas WHERE id=".$id. " AND id_usuario=".$_SESSION["id"];

    $conn->exec($sql);

  } catch(PDOException $e) {
    error_log("Error en la inserción: " . $e->getMessage());
  }

  //deconectar de la BD
  $conn = null;

  header('Location: http://basededatos.razvan/registrousuariosajaxBD/temas.php?cate='.$cate);