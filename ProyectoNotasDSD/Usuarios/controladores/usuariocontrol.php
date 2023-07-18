<?php

require_once('../../Conexion.php');
require_once('../modelo/usuarios.php');

if($_SERVER['REQUEST_METHOD']=='POST'){
    $usuariosusu = $_POST['txtNombre'];
    $contrasena = $_POST['txtcontrasena'];

    $usu = new Usuario();

    $usu->login($usuariosusu,$contrasena);

    //redirigir al controlador de acuerdo al rol
    if($usu->isloggedIn()){
        if($usu->isAdmin()){
            header('location:../../Administrador/pages/index.php');
        }elseif($usu->isDocen()){
            header('location:../../Materias/pages/index.php');
        }
        exit();
    }else{
        print "<script>alert(\"Nombre de usuario o contraseña incorrecta.\");
        window.location='../../Administrador/pages/index.php';</script>";

    }
}





?>