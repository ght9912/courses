<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi documento PHP</title>
</head>
<body>
    <?php
        // Esto es un comentario de linea
        # esto es un comentario de linea
        /* Esto esun
         tag de comentario  
        */
        //Indicador de variable signo de dolar
        $variable;
        //Case sensitive, las muyusculas se reconocen 
        $Variable;

        //Data Types
        $string="Esto es una cadena de texto";
        $int=1;
        $int2=(int)"1";
        $float=12.1;
        $float2=floatval("12.5");
        $array =[1,2,3,4,5];
        $objeto=["key"=>"Valor"];
        $bolean= true;// o falso
        $null=NULL;
        $funcion = function(){};

        //imresiones

        echo "<h1>Hola Mundo</h1>";
        echo "Esta es mi variable : $string </br>";
        echo "Esta es mi variable entera: ".$int ." entero</br>";

        print "<strong>Esto es un tag html </strong>";

        //enlace PHP -JavaScript

        echo "<script type='text/javascript'>
        console.log('Esto fue generado atravez de php');
        </script>";

        //variable global;
        $x=1;
        //funciones
        function soyUnaFuncion(){
            //esta es una variable local de la funcion
            $x=0;
            echo $x." ";
            //Accediendo a la variable global
            global $x;
            echo  $x." ";
            // Accediento atravez del array GLOBALS
            echo $GLOBALS["x"]." ";
            // definiendo variables globales dentro de una funcion 
            $GLOBALS["y"]="Hola soy y";
        }
       // variable indefinida hasta que se ejecuta la funcion
            //echo $GLOBALS["y"];

        //ejecutando la funcion
        soyUnaFuncion();

        // variable global encontrada
        echo $GLOBALS["y"];

        function /*Flag de Funcion*/ myTest/*Nombre de funcion*/(/*Aqui van los parametros */) {
            // variable estatica guarda su valor final al terminar de ejecutar la función
            static $x = 0;
           // echo $x;
            $x++;
          }

          myTest();
          myTest();
          myTest();
        function A (int $a){
            //parametro $a debe de ser entero
            //sino sale error 
            //para epecificarlo debemos de declara 
            //declare(strict_types=1); 
            //al inicio del codigo PHP
        }
        function B(string $tx="Hola"){
            // Si la fución es llamada sin el parametro
            //string definido por default es Hola
        }
        B();//$tx ="Hola" dentro de la funcion
        B("Adios");//$tx ="Adios" dentro de la funcion
          
        function C(){
            return "Hola";
            //esta funcion retorna un valor
        }
        $valor=C();// $valor sera igual a Hola

          
        function add_five(&$value) {
            $value += 5;
            // & significa que se pasa la variabl y su instancia
            // Por lotanto afecta el valor de la variable pasada
            // como parametro 
        }
          
          $num = 2;
          add_five($num);
          // la variable $numa ahora vale 7

          //variables contantes 
            define("GREETING", "Welcome to W3Schools.com!", true);
            //echo greeting;
            $x=0;$y=1;
        // operadores
           //suma $x+$y
           //resta $x-$y
           //Division $x/$y
           //Reciduo $x%$y
           //Multiplicación $x*$y
           //Exponencianion $x**$y
        
         //Operadores de asignación
            //igual $x=$y
            //adición $x+=$y;
            //Substración $x-=$y
            // Multipliació $x*=$y
            //Division $x/=$y
            //reciduo $x%=$y

        // Opreadores logicos 

        //Operadores de comparación

        //Operadores decrementales 

        //Operadores de array

        //PHP Conditional Assignment Operators


       // condionales

       if(/*condicion*/1){

       }else if (/*Condicon 2*/ 2){

       }else/* Si ninguna anterior es verdadera*/{

       }
       $variable="Hola";
       switch ($variable) {
        case 'caso1': //caso
            # code...
            break;
        case 'caso2': //caso
            # code...
        break;
        
        default: // ningun caso verdadesro
            # code...
            break;
       }

       //loop o iteraciones

       for ($i=0; $i < 10; $i++) { 
        
        # code...
       }
       $a=0;
       while ($a <= 10) {
        # code...
        $a++;
       }
       $datos=[1,2,3];
       foreach ($datos as $dato){
        #codigo
       } 
       // break; rompe el iterador
       // continue; sigue con la siguiente iteración 

       try {
        //code...
        // si hay error pasa a catch
       } catch (\Throwable $th) {
        throw $th;
       }


       count([1,2,3,4]);
       //Retorna 4, ya que cuenta los elementos
       // dentro del array

       /*
            sort() - sort arrays in ascending order
            rsort() - sort arrays in descending order
            asort() - sort associative arrays in ascending order, according to the value
            ksort() - sort associative arrays in ascending order, according to the key
            arsort() - sort associative arrays in descending order, according to the value
            krsort() - sort associative arrays in descending order, according to the key
        */

        // Variables de servidor
        
        $GLOBALS;// Es un arreglo con todas las variables globales
        $_SERVER; // Obtiene todas las variables de servidor
           // var_dump($_SERVER);
        $_REQUEST; // Obtiene las variables pasadas por Request
           // var_dump($_REQUEST);
        $_POST; // Obtiene todas las variables pasadas por el metodo POST
            //var_dump($_POST);
        $_GET; // Obtiene todas las variables pasadas por metodo get

        $_FILES; // Obtiene todos los archivos pasados por formulario
        $_ENV; // Obtiene todas las variables de Ambiente o enviroment
        $_COOKIE; // Obtiene las variables guardadas en el navegador
            $_COOKIE["Prueba"]="Holas soy una prubea";
            setcookie("Prueba","hola",time()+60*60*24*30);
        $_SESSION; // ontiene las variables de sesión
            $_SESSION["id_usuario"]="10";
            var_dump($_SESSION);
        //session_start(); se debe declara al inicio del archivo 
        // funcionar con sesiones 

        //Funciones de inclusión
        // el contenido que se encuentra en el archivo se adihere
        // al archivo del que es llamado

        // require ""; Manda hablar al archivo pero es requerido para funcionar
        // require_once "" Manda hablar al archivo pero es requerido solo una vez para funcionar;
        // include "" Inlcuye el archivo ;
        // include_once "" Inlcuye el archivo una sola vez;

    ?>

    
</body>
</html>