<?php
function CreacionClave()
{
    /* Asignamos el juego de caracteres al array $caracteres para generar la contraseña.
    Podemos añadir más caracteres para hacer más segura la contraseña.
    */
    $longitud=6;
    
    $password="";
    
    $minusculas = 'abcdefghijklmnopqrstuvwxyz';
    $letras = 'ABCDEFGHIJKLMNOPQRSTXYZabcdefghijklmnopqrstuvwxyz0123456789';
    //$caracteres = '0123456789';
    
    /* Introduce la semilla del generador de números aleatorios mejorado */
    mt_srand(microtime() * 1000000);
    
    /* Genera un valor aleatorio mejorado con mt_rand, entre 0 y el tamaño del array
    $caracteres menos 1. Posteríormente vamos concatenando en la cadena $password
    los caracteres que se van eligiendo aleatoriamente.
    Vamos a generar la clave de grupo aleatoriamente, formada por 2 caracter y 4 numeros
    */
    
    //Primer caracter debe de ser una letra y estar en minusculas
    $key = mt_rand(0,strlen($minusculas)-1);
    $password = $password . $minusculas{$key};
    
    //11 caracter
    $key = mt_rand(0,strlen($letras)-1);
    $password = $password . $letras{$key};
    $key = mt_rand(0,strlen($letras)-1);
    $password = $password . $letras{$key};
    $key = mt_rand(0,strlen($letras)-1);
    $password = $password . $letras{$key};
    $key = mt_rand(0,strlen($letras)-1);
    $password = $password . $letras{$key};
    $key = mt_rand(0,strlen($letras)-1);
    $password = $password . $letras{$key};
    $key = mt_rand(0,strlen($letras)-1);
    $password = $password . $letras{$key};
    $key = mt_rand(0,strlen($letras)-1);
    $password = $password . $letras{$key};
    $key = mt_rand(0,strlen($letras)-1);
    $password = $password . $letras{$key};
    $key = mt_rand(0,strlen($letras)-1);
    $password = $password . $letras{$key};
    $key = mt_rand(0,strlen($letras)-1);
    $password = $password . $letras{$key};
    $key = mt_rand(0,strlen($letras)-1);
    $password = $password . $letras{$key};
    $key = mt_rand(0,strlen($letras)-1);
    $password = $password . $letras{$key};                                      
    
    //4 números
/*  $key = mt_rand(0,strlen($caracteres)-1);
    $password = $password . $caracteres{$key};  
    $key = mt_rand(0,strlen($caracteres)-1);
    $password = $password . $caracteres{$key};  
    $key = mt_rand(0,strlen($caracteres)-1);
    $password = $password . $caracteres{$key};  
    $key = mt_rand(0,strlen($caracteres)-1);
    $password = $password . $caracteres{$key};*/
    

    return $password;
}
function comprobar_email($email)
{
    $mail_correcto = 0;
    //compruebo unas cosas primeras
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
          //miro si tiene caracter .
          if (substr_count($email,".")>= 1){
         //obtengo la terminacion del dominio
         $term_dom = substr(strrchr ($email, '.'),1);
         //compruebo que la terminación del dominio sea correcta
         if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
            //compruebo que lo de antes del dominio sea correcto
            $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
            $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
            if ($caracter_ult != "@" && $caracter_ult != "."){
               $mail_correcto = 1;
            }
         }
          }
       }
    }
    if ($mail_correcto)
       return 1;
    else
       return 0;
}//fin del function comprobar_email($email)
?>