<?php
include_once('../../Conexion.php');

class Usuario extends Conexion
{
    private $loggedIn = false; // estado de incio de sesion
    private $isAdmin = false; // estado de adminitrador 
    private $isdocente = false; // estado de docente 


    public function __construct()
    {
        $this->db=parent::__construct();
    }
  
    public function login($Usuario,$contrasena)
    {
        //obtener el usuario de la base de datos 
        $statement = $this->db->prepare("SELECT * FROM Usuarios WHERE Usuario = ?");
        $statement->execute([$Usuario]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        // verificar contraseña 
        if($user && password_verify($contrasena, $user['Passwoord']))
        {
            // verificar la contraseña 
            //$result=$statement->fetch(PDO::FETCH_ASSOC);
            //*$_SESSION['Usuario']= $result['Nombreusu']." ".$result['Apellidousu'];
            //*$_SESSION['id']=$result['id_usuario'];
            //*$_SESSION['Perfil']=$result['Perfil'];
            //*$_SESSION['start']=time();
            //*$_SESSION['expire']=$_SESSION['start']+(1*60); 
            //*return true;

            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['username'] = $user['Usuario'];
            $_SESSION['role'] = $user['Perfil'];
            $_SESSION["validar"] = true;
            $_SESSION['Nombre'] = $user['Nombreusu']." ".$user['Apellidousu'];
        }
        return false;
    }

    public function validarsesion()
    {
        if($_SESSION['id_usuario']){
            if(!isset ($_SESSION['start'])){
                $_SESSION['start'] = time();

            }else if(time() - $_SESSION['start'] > 60){
                session_destroy();
                echo "<script>alert('Cierre de sesion por roncon');
                windows.location='../../index.php';</script>";
                $_SESSION['validar']==false;
            }
            $_SESSION['start']=time();
        }
 

    }


    public function cerrasesion()
    
    
        {
            session_unset();
            session_destroy();
        }
        public function isloggedIn()
        {
            return isset($_SESSION['id_usuario']);
        }

        public function isAdmin()
        {
            return $this->isloggedIn() && $_SESSION['role'] === 'Administrador';
        }
        public function isDocen()
        {
            return $this->isloggedIn() && $_SESSION['role'] === 'Docente';
        }



    

    public function validarroles()
    {

    }
}




?>