<?PHP
session_start();

$username="";
$password="";
$caratula_tipoFK=1;

if(isset($_POST['username-salto']) && trim($_POST['username-salto'])!="")
	$username=$_POST['username-salto'];
if(isset($_GET['username-salto']) && trim($_GET['username-salto'])!="")
	$username=$_GET['username-salto'];

if(isset($_POST['password-salto']) && trim($_POST['password-salto'])!="")
	$password=$_POST['password-salto'];
if(isset($_GET['password-salto']) && trim($_GET['password-salto'])!="")
	$password=$_GET['password-salto'];


//damos valor a la caratula si nos la envia desde login unico
if(isset($_GET['tipoFK']) && trim($_GET['tipoFK'])!="")
	$_SESSION['caratula_salto']=$_GET['tipoFK'];

$usercont=substr_count($username,"'");
$passcont=substr_count($password,"'");

if($usercont==0 && $passcont==0 && trim($username)!="" && trim($password)!="")
{
	$_SESSION['usuario_salto']=trim($username);
	$_SESSION['password_salto']=trim($password);
}//fin del if($usercont==0 && $passcont==0 && trim($username)!="" && trim($password)!="")

print("<script>document.location.href='jornadas.php'</script>");
exit();
?>
