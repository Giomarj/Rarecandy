<?php 
    include_once "clases/bib_emailBoletin.php";
if (isset($_POST['pirate-forms-contact-name'], $_POST['pirate-forms-contact-email'], $_POST['pirate-forms-contact-subject'], $_POST['pirate-forms-contact-message'])) {
    if (isset($_POST['title7']) && !empty($_POST['title7'])) {
        die();
    }
            $from="info@saltotech.com";
            $direccionMail="info@saltotech.com";
            $asunto=utf8_decode("Saltotech .- Contac Index Cliente");      
            $ficheroAEnviar="";// va con un enlace al ser un boletin
            $nombreAMostrar="";         
            $cuerpo ="Nombre :". $_POST['pirate-forms-contact-name']."<br> Email: ". $_POST['pirate-forms-contact-email'] ."<br> Asunto :".$_POST['pirate-forms-contact-subject']."<br> Mensaje:". $_POST['pirate-forms-contact-message'];    
            $envio= email($direccionMail,$from,$asunto,$cuerpo,$ficheroAEnviar,$nombreAMostrar);
}

 ?>


<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">


<title>Saltotech &#8211; &#8211; Sistema y tecnología</title>
<link rel='dns-prefetch' href='//fonts.googleapis.com' />
<!-- This site uses the Google Analytics by MonsterInsights plugin v7.6.0 - Using Analytics tracking - https://www.monsterinsights.com/ -->
<!-- Nota: MonsterInsights no est├í actualmente configurado en este sitio. El due├▒o del sitio necesita identificarse usando su cuenta de Google Analytics en el panel de ajustes de MonsterInsights. -->
<!-- No UA code set -->
<!-- / Google Analytics by MonsterInsights -->

<link rel='stylesheet' id='wp-block-library-css'  href='css/style.min.css' type='text/css' media='all' />

<link rel='stylesheet' id='themeisle-block_styles-css'  href='css/style2.css' type='text/css' media='all' />
<link rel='stylesheet' id='contact-form-7-css'  href='css/style3.css' type='text/css' media='all' />
<link rel='stylesheet' id='dashicons-css'  href='css/dashicons.min.css' type='text/css' media='all' />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel='stylesheet' id='zerif_font-css'  href='//fonts.googleapis.com/css?family=Lato%3A300%2C400%2C700%2C400italic%7CMontserrat%3A400%2C700%7CHomemade+Apple&#038;subset=latin%2Clatin-ext' type='text/css' media='all' />
<link rel='stylesheet' id='zerif_font_all-css'  href='//fonts.googleapis.com/css?family=Open+Sans%3A300%2C300italic%2C400%2C400italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic&#038;subset=latin&#038;ver=5.2.1' type='text/css' media='all' />
<link rel='stylesheet' id='zerif_bootstrap_style-css'  href='css/bootstrap.css' type='text/css' media='all' />

<link rel='stylesheet' id='zerif_style-css'  href='css/style4.css' type='text/css' media='all' />

<!--[if lt IE 9]>
<link rel='stylesheet' id='zerif_ie_style-css'  href='https://saltotech.com/wp-content/themes/zerif-lite/css/ie.css?ver=1.8.5.48' type='text/css' media='all' />
<![endif]-->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.4.1.js"></script>
<script type='text/javascript' src='js/js.js'></script>
                <style type="text/css" id="custom-background-css">

</style>
        <link rel="icon" href="img/cropped-logo-saltotech-32x32.png" sizes="32x32" />
<link rel="icon" href="img/cropped-logo-saltotech-192x192.png" sizes="192x192" />
<link rel="apple-touch-icon-precomposed" href="img/cropped-logo-saltotech-180x180.png" />
<meta name="msapplication-TileImage" content="img/cropped-logo-saltotech-270x270.png" />
</head>


<body class="home page-template-default page page-id-9 custom-background wp-custom-logo" >


<header id="home" class="header" itemscope="itemscope" itemtype="">
<?php require "./layout/nav.php"; ?>
        <!-- / END TOP BAR -->
<div class=" home-header-wrap"><div class="header-content-wrap "><div class="container"><h1 class="intro-text">.<h1 id="extra2">Servicios tecnológicos a tu alcance</h1></h1>
<!-- <div class="buttons">
    <a href="#" class="btn btn-primary custom-button green-btn" data-toggle="modal" data-target="#loginModal">Area de Cliente</a>
</div> -->
</div></div><!-- .header-content-wrap --><div class="clear"></div>
</div>

</header> <!-- / END HOME SECTION  -->
<div id="content" class="site-content">

<section class="focus " id="focus">

        <div class="container">

                <!-- SECTION HEADER -->

                <div class="section-header">

                        <!-- SECTION TITLE AND SUBTITLE -->

                        <h2 class="dark-text">características/Servicios</h2>
                </div>

                <div class="row">








      <div class="wrap">
        <div class="tarjeta-wrap" id="uno">
          <div class="tarjeta">
            <div class="adelante">
                <img src="img/LogoMakr_0Pip59-150x150.png" alt="" style=" width: 50%;  margin-top: 25%;" />
                <br><br>
                <h3 class="dark-text">Tu propia pagina web</h3>
            </div>
            <div class="atras">
              <p align="justify">En saltotech desarrollamos páginas webs que
                              se encuentran perfectamente integradas dentro de nuestras estrategias de Inbound Marketing.
                               No basta con tener una web con un diseño espectacular, sino que tiene que estar diseñada y
                                alineada una estrategia que va mucho más allá de tener una presencia online de tu marca.</p>
            </div>
          </div>
        </div>

        <div class="tarjeta-wrap" id="dos">
          <div class="tarjeta">
            <div class="adelante" >
                <img src="img/LogoMakr_2AEOOi-150x150.png" alt="" style=" width: 50%;  margin-top: 25%;"/>
                <br><br>
                <h3 class="dark-text">BI / Base de datos</h3>
            </div>
            <div class="atras">
              <p align="justify">Instrumentando las soluciones a través
                              de las aplicaciones de diferente plataformas de Inteligencia de Negocios.
                               Saltotech sirve a sus clientes en la integración de fuentes de datos,
                               sistemas de soporte a la toma de decisiones, aplicaciones analíticas y
                               sistemas de indicadores de gestión.</p>
            </div>
          </div>
        </div>

        <div class="tarjeta-wrap" id="tres">
          <div class="tarjeta">
            <div class="adelante" > <!-- style="background-image: url(img/econtrolaccesos-150x150.png);" -->
                <img src="img/econtrolaccesos-150x150.png" alt=""style=" width: 50%;  margin-top: 25%;"/>
                <br><br>
                <h3 class="dark-text">Control de acceso</h3>
            </div>
            <div class="atras">
              <p align="justify">Nuestro interés está orientado a facilitar servicios
                               de instalación, mantenimiento y soporte de sistemas de control acceso y registro de horario
                               . proporcionando la confianza y asesorado por especialista para garantizar nuestros servicios.</p>
            </div>
          </div>
        </div>

        <div class="tarjeta-wrap" id="cuatro">
          <div class="tarjeta">
            <div class="adelante">
                <img src="img/Sevices-150x149.png" alt="" style=" width: 50%;  margin-top: 25%;"/>
                <br><br>
                <h3 class="dark-text">Servicios de dominio</h3>
            </div>
            <div class="atras">
              <p align="justify">Administracion Creacion Host Domain, Suite Ip ,Redes, Certificacion IP, Levantamiento Parte Informatico, Actualizacion / Asesoria Software Hardware, Alojamiento Cloud, Administracion de Ctas de correo y perfiles usuarios.</p>
            </div>
          </div>
        </div>


        <div class="tarjeta-wrap" id="cinco">
          <div class="tarjeta">
            <div class="adelante">
                <img src="img/ImageSAPService.png" alt="" style=" width: 50%;  margin-top: 25%;"/>
                <br><br><br>
                <h3 class="dark-text">SAP BusinessObjects Business Intelligence Suite</h3>
            </div>
            <div class="atras">
              <p align="justify">Desarrolle y comparta ideas, tome mejores decisiones con la suite de SAP BusinessObjects Business Intelligence (BI). Ofrecemos una larga experiencia en implementación de proyectos de SAP BO –BI, basados la arquitectura flexible que proporciona dicha plataforma de análisis de información que servirán tanto para amientes de unos pocos usuarios hasta decenas de miles de usuarios, mejorando la toma de decisiones y respaldando su crecimiento desde una sola herramienta hasta múltiples herramientas e interfaces.                                     
</p>
            </div>
          </div>
        </div>

        <div class="tarjeta-wrap" id="seis">
          <div class="tarjeta">
            <div class="adelante">
                <img src="img/imagenr.jpg" alt="" style=" width: 50%;  margin-top: 25%;"/>
                <br><br>
                <h3 class="dark-text">Desarrollar aplicaciones web Empresariales</h3>
            </div>
            <div class="atras">
              <p align="justify">Somos especialistas en diseño y desarrollo de aplicaciones Web a medida de tus necesidades, acumulamos una amplia experiencia en programación Web para asesorarte y guiarte en tu proyecto, con nosotros conseguirás alcanzar tus metas y objetivos.</p>
            </div>
          </div>
        </div>

<!--         <div class="tarjeta-wrap">
          <div class="tarjeta">
            <div class="adelante" style="background-image: url(img/5.jpg);">
            </div>
            <div class="atras">
              <p align="justify">qweqweqweqweqweqwqweqweq, qweqweqweqweqweqweqeqw</p>
            </div>
          </div>
        </div>

        <div class="tarjeta-wrap">
          <div class="tarjeta">
            <div class="adelante" style="background-image: url(img/7.jpg);">

            </div>
            <div class="atras">
              <p align="justify">qweqweqweqweqweqwqweqweq, qweqweqweqweqweqweqeqw</p>
            </div>
          </div>
        </div>
 -->

      </div>










<!--                                 <span id="zerif_team-widget-6" class="">
                        <div class="col-lg-3 col-sm-3 team-box">

                                <div class="team-member" tabindex="0">



                                                <figure class="profile-pic">

                                                        <img src="img/LogoMakr_0Pip59-150x150.png" alt=""/>

                                                </figure>

                                        <div class="member-details">


                                                        <h3 class="dark-text red-border-bottom">Tu propia pagina web</h3>



                                                        <div
                                                                class="position"><br><P ALIGN="justify">En saltotech desarrollamos páginas webs que
                                                                  se encuentran perfectamente integradas dentro de nuestras estrategias de Inbound Marketing.
                                                                   No basta con tener una web con un diseño espectacular, sino que tiene que estar diseñada y
                                                                    alineada una estrategia que va mucho más allá de tener una presencia online de tu marca.</div>


                                        </div>

                                        <div class="social-icons">

                                                <ul>


                                                </ul>

                                        </div>


                                </div>

                        </div>

                        </span><span id="zerif_team-widget-8" class="">
                        <div class="col-lg-3 col-sm-3 team-box">

                                <div class="team-member" tabindex="0">



                                                <figure class="profile-pic">

                                                        <img src="img/LogoMakr_2AEOOi-150x150.png" alt=""/>

                                                </figure>

                                        <div class="member-details">


                                                        <h3 class="dark-text red-border-bottom">BI / Base de datos</h3>



                                                        <div
                                                                class="position"><br><P ALIGN="justify">Instrumentando las soluciones a través
                                                                  de las aplicaciones de diferente plataformas de Inteligencia de Negocios.
                                                                   Saltotech sirve a sus clientes en la integración de fuentes de datos,
                                                                   sistemas de soporte a la toma de decisiones, aplicaciones analíticas y
                                                                   sistemas de indicadores de gestión.</div>


                                        </div>

                                        <div class="social-icons">

                                                <ul>


                                                </ul>

                                        </div>


                                </div>

                        </div>

                        </span><span id="zerif_team-widget-9" class="">
                        <div class="col-lg-3 col-sm-3 team-box">

                                <div class="team-member" tabindex="0">



                                                <figure class="profile-pic">

                                                        <img src="img/econtrolaccesos-150x150.png" alt=""/>

                                                </figure>

                                        <div class="member-details">


                                                        <h3 class="dark-text red-border-bottom">Control de acceso</h3>



                                                        <div
                                                                class="position"><br><P ALIGN="justify">Nuestro interés está orientado a facilitar servicios
                                                                   de instalación, mantenimiento y soporte de sistemas de control acceso y registro de horario
                                                                   . proporcionando la confianza y asesorado por especialista para garantizar nuestros servicios.</div>


                                        </div>

                                        <div class="social-icons">

                                                <ul>


                                                </ul>

                                        </div>


                                </div>

                        </div>

                        </span><span id="zerif_team-widget-11" class="">
                        <div class="col-lg-3 col-sm-3 team-box">

                                <div class="team-member" tabindex="0">



                                                <figure class="profile-pic">

                                                        <img src="img/Sevices-150x149.png" alt=""/>

                                                </figure>

                                        <div class="member-details">


                                                        <h3 class="dark-text red-border-bottom">Servicios de dominio</h3>



                                                        <div
                                                                class="position"><br><P ALIGN="justify">Administracion Creacion Host Domain, Suite Ip ,Redes, Certificacion IP, Levantamiento Parte Informatico, Actualizacion / Asesoria Software Hardware, Alojamiento Cloud, Administracion de Ctas de correo y perfiles usuarios.</div>


                                        </div>

                                        <div class="social-icons">

                                                <ul>


                                                </ul>

                                        </div>


                                </div>

                        </div>

                        </span> -->
                </div>

        </div> <!-- / END CONTAINER -->


</section>  <!-- / END FOCUS SECTION -->

<section class="about-us " id="aboutus">

        <div class="container">

                <!-- SECTION HEADER -->

                <div class="section-header">

                        <h2 class="white-text"> "Quiénes somos"</h2>
                </div><!-- / END SECTION HEADER -->

                <!-- 3 COLUMNS OF ABOUT US-->

                <div class="row">

                        <!-- COLUMN 1 - BIG MESSAGE ABOUT THE COMPANY-->

                <div class="col-lg-6 col-md-6 column zerif-rtl-big-title"><div class="big-intro" data-scrollreveal="enter left after 0s over 1s"> "Da el salto a la tecnología con Saltotech"</div>
              </div><div class="col-lg-6 col-md-6 column zerif_about_us_center " data-scrollreveal="enter bottom after 0s over 1s">
                <p>SALTOTECH es una firma con capital humano especializado dedicada a ofrecer servicios de consultaría de desarrollo web, software e
                   implementación de modelos de inteligencia de negocios, que apoyan los requerimientos de aprovechamiento de análisis de información de gestión de los clientes. <br />
                   <br />
Instrumentando las soluciones a través de las aplicaciones de diferentes plataformas de Inteligencia de Negocios. Saltotech sirve a sus clientes en la integración de fuentes de datos,
 sistemas de soporte a la toma de decisiones, aplicaciones analíticas y sistemas de indicadores de gestión.<br /><br />
</p></div>
        </div> <!-- / END 3 COLUMNS OF ABOUT US-->

        <!-- CLIENTS -->

        </div> <!-- / END CONTAINER -->


</section> <!-- END ABOUT US SECTION -->

<section class="contact-us " id="contact"><div class="container">
        <!-- SECTION HEADER -->
        <div class="section-header">

                <h2 class="neon-text">Contacta con nosotros ahora</h2> </div>
        <!-- / END SECTION HEADER -->

        <div class="row">

<div class="pirate_forms_container widget-no" id="pirate_forms_container_default">
        <!-- header -->

        <!-- thank you -->

        <div class="pirate_forms_wrap">
        <!-- errors -->

        <!-- form -->

                <form
                        method="post"
                        enctype="application/x-www-form-urlencoded"
                        class="pirate_forms  form_honeypot-on wordpress-nonce-on pirate-forms-contact-name-on pirate-forms-contact-email-on pirate-forms-contact-subject-on pirate-forms-contact-message-on pirate-forms-contact-submit-on pirate_forms_from_form-on"
                                        >
                        <div class="pirate_forms_three_inputs_wrap ">


<div class="col-lg-4 col-sm-4 form_field_wrap">
                <input type="text" name="title7" class="hidden" value="">
                <input type="text" class="form-control input" id="pirate-forms-contact-name" name="pirate-forms-contact-name" class="" placeholder="Nombre" required oninvalid="this.setCustomValidity('Escriba su nombre')" onchange="this.setCustomValidity('')" >
</div>


<div class="col-lg-4 col-sm-4 form_field_wrap">
                <input type="email" class="form-control" id="pirate-forms-contact-email" name="pirate-forms-contact-email" class="" placeholder="Correo electrónico" required oninvalid="this.setCustomValidity('Escriba una dirección de correo electrónico inválida')" onchange="this.setCustomValidity('')" >
</div>


<div class="col-lg-4 col-sm-4 form_field_wrap">
                <input type="text" class="form-control input" id="pirate-forms-contact-subject" name="pirate-forms-contact-subject" class="" placeholder="Asunto" required oninvalid="this.setCustomValidity('Por favor, escriba un asunto')" onchange="this.setCustomValidity('')" >
</div>
                        </div>



<div class="col-lg-12 col-sm-12 form_field_wrap">
                <textarea rows="5" cols="30" class="form-control input" id="pirate-forms-contact-message" name="pirate-forms-contact-message" class="" placeholder="Mensaje" required oninvalid="this.setCustomValidity('Escriba su preguntao comentario')" onchange="this.setCustomValidity('')" ></textarea>
</div>


<div class="col-xs-12 form_field_wrap contact_submit_wrap">
        <button type="submit" class="btn btn-primary custom-button red-btn pirate-forms-submit-button" id="pirate-forms-contact-submit" name="pirate-forms-contact-submit" class="pirate-forms-submit-button btn btn-primary " placeholder="" >Enviar mensaje</button>
</div>
    </form>


                <div class="pirate_forms_clearfix"></div>
        </div>

        <!-- footer -->

</div>
</div>
                                </div> <!-- / END CONTAINER -->

                        </section> <!-- / END CONTACT US SECTION-->

</div><!-- .site-content -->
<?php require "./layout/footer.php"; ?>

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Inicia sesión</h4>
            </div>

            <div class="modal-body">
                <!-- The form is placed inside the body of modal -->
                <form id="loginForm" method="post" class="form-horizontal" action="login.php">
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Usuario</label>
                        <div class="col-xs-7">
                            <input type="text" class="form-control" name="username-salto" name="username-salto" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Contraseña</label>
                        <div class="col-xs-7">
                            <input type="password" class="form-control" name="password-salto" id="password-salto" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-5 col-xs-offset-3">
                            <button type="submit" class="btn btn-default">Entrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

</html>
