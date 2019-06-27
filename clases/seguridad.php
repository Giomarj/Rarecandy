<?PHP
function Seguridad()
{
    if(isset($_SESSION['usuario_salto']) AND isset($_SESSION['password_salto']))
    {
        $correcto=BuscarUsuario();

        if(!$correcto)
        {
            echo "<script type='text/javascript'>alert('El Usuario o el Password no son correctos.');</script>";
            print("<script>document.location.href='index.php';</script>");
            exit();
        }//fin del if(!$correcto)


    }//fin del if(isset($_SESSION['usuario_salto']) AND isset($_SESSION['password_salto']))
    else
    {
        echo "<script type='text/javascript'>alert('Problemas con la pagina(Credenciales), Intentelo mas tarde.');</script>";
        print("<script>document.location.href='index.php';</script>");
        exit();
    }//fin del else del if(isset($_SESSION['usuario_salto']) AND isset($_SESSION['password_salto']))
}//fin del function Seguridad()

function BuscarUsuario()
{
    $conexion = new conexion();
    $valor=true;

    $sql="SELECT * FROM cliente WHERE cliente_Login='".$_SESSION['usuario_salto']."' AND cliente_Pass='".$_SESSION['password_salto']."' AND cliente_Estado='Activo'";
    $res=$conexion->BD_Consulta($sql);
    $vector=$conexion->BD_GetTupla($res);

    if($vector==NULL)
        $valor=false;
    else
        $_SESSION['caratula_salto']=$vector['cliente_TipoFK'];


    return $valor;
}//fin del function BuscarUsuario()

function Admin(){

    $conexion = new conexion();

    $sql="SELECT * FROM cliente WHERE cliente_Login='".$_SESSION['usuario_salto']."' AND cliente_Pass='".$_SESSION['password_salto']."' AND cliente_Estado='Activo'";
    $res=$conexion->BD_Consulta($sql);
    $vector=$conexion->BD_GetTupla($res);
        
    if($vector['tipo'] != "admin")
    {
        print("<script>document.location.href='index.php'</script>");
        exit();  
    }
}
?>
