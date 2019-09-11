<?php 
    $conexion = new conexion();
    $vectorUser=NULL;
    $imagen="imagen/cliente/default.jpg";
    $nombre_cliente="";
        
    if(isset($_SESSION['usuario_salto']) && isset($_SESSION['password_salto']))
    {
    $sqlUser="SELECT * FROM cliente WHERE cliente_Login='".$_SESSION['usuario_salto']."' AND cliente_Pass='".$_SESSION['password_salto']."' AND cliente_Estado='Activo'";    
    $resUser=$conexion->BD_Consulta($sqlUser);
    $vectorUser=$conexion->BD_GetTupla($resUser);
    
    if($vectorUser!=NULL)
    {
        $nombre_cliente=$vectorUser['cliente_Nombre'];
        $imagen="img/cliente/default.jpg";
        if(trim($vectorUser['cliente_Logo'])!="")
            $imagen="img/cliente/" . $vectorUser['cliente_Logo'];
    }//fin del if($vectorUser!=NULL)
    }//fin del if(isset($_SESSION['usuario_salto']) && isset($_SESSION['password_salto']))
    
 ?>

<div id="main-nav" class="navbar navbar-inverse bs-docs-nav" role="banner">

        <div class="container">


                <div class="navbar-header responsive-logo">

                        <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">

                        <span class="sr-only">Cambiar navegación</span>

                        <span class="icon-bar"></span>

                        <span class="icon-bar"></span>

                        <span class="icon-bar"></span>

                      </button>

                                <div class="navbar-brand" itemscope itemtype="http://schema.org/Organization">

                                        <a href="https://saltotech.com/" class="custom-logo-link" rel="home"><img width="559" height="414" src="img/cropped-WhatsApp-Image-2019-05-29-at-4.04.07-PM.jpeg" class="custom-logo" alt="Saltotech" srcset="img/cropped-WhatsApp-Image-2019-05-29-at-4.04.07-PM.jpeg 559w, img/cropped-WhatsApp-Image-2019-05-29-at-4.04.07-PM-300x222.jpeg 300w" sizes="(max-width: 559px) 100vw, 559px" /></a>
                                </div> <!-- /.navbar-brand -->

                        </div> <!-- /.navbar-header -->



        <nav class="navbar-collapse bs-navbar-collapse collapse" id="site-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
                <ul id="menu-menu-principal" class="nav navbar-nav navbar-right responsive-nav main-nav-list">
                    <div class="btn-group pull-right" >
                
                    <button type="button" class="btn btn-default dropdown-toggle responsive-logo" data-toggle="dropdown">
                          <img src="<?php print($imagen) ?>" alt="" . $nombre_cliente . "" height="45px" width="45px"  /><span translate="no"><code translate="no" style="color: #333; background-color: #FFFFFF; font: 14px; font-family: 'Open Sans', Arial, Helvetica, sans-serif!important;"> <?php print($nombre_cliente) ?> </code></span><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu logado" role="menu">
      <!--               <li class="perfil"><a href="saldo-acumulado.php" translate="no">Campañas - Saldo</a></li>
                    <li class="perfil"><a href="mis-consultas.php">Mis consultas</a></li>
                            <li class="perfil"><a href="mis-reservas.php">Mis reservas</a></li>
                            <li class="mensajes"><a href="mis-datos.php">Mis datos</a></li>
                            <li class="mensajes"><a href="infoutil.php">Info útil</a></li>
                            <li class="divider"></li> -->
                            <li class="salir"><a href="desconectar.php">Salir</a></li>
                        </ul>
                
                    </div>

                </ul>           
        </nav>


        </div> <!-- /.container -->


</div>