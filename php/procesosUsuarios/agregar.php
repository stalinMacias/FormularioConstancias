<?php
	require_once "../conexion.php";
	require_once "crud.php";
	$obj= new crud();

	$datos=array(
		$_POST['usuario'],
		$_POST['password'],
		$_POST['email'],
		$_POST['tipoUsuario'],
				);

	echo $obj->agregar($datos);


 ?>
