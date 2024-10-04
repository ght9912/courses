<?php
    require_once "connection.php";

    if(!isset($_POST["action"])){
        http_response_code(400);
        die("No Action");
    }

switch ($_POST["action"]) {
    case 'create':
        $r=$_POST;
        if(isset($r["nombre"],$r["rfc"],$r["telefono"],$r["responsable"])){
            $a=$r["nombre"];
            $b=$r["rfc"];
            $c=$r["telefono"];
            $d=$r["responsable"];
            $query="INSERT INTO proveedores VALUES (null,'$a','$b','$c','$d')";
            $resutl=$db->query($query);
            if($resutl){
                echo json_encode(["success"=>"true",
                "message"=>"Añadido con Exito",
                "data"=>[],]);
            }else{
               http_response_code(400);
               echo $db->error." number:". $db->errno;
               
            }

        }else{
            http_response_code(400);
            echo "Bad Request";
            // header("Location: ../clientes.php");
        }
        break;
    case 'read':
        
            $query="SELECT * FROM proveedores";
            $resutl=$db->query($query);
            if($resutl){
                $rows = array();
                while($row = $resutl->fetch_assoc())
                {
                    $rows[] = $row;
                }
                echo json_encode([
                    "success"=>true,"data"=>$rows,
                    "message"=>"Estos son todos los proveedores"
                ]); // Retornar JSON
                
                //var_dump( $rows);
            }else{
                http_response_code(400);
               echo $db->error." number:". $db->errno;
            }
        break;
    case 'update':
       // echo "Estas tratando de actualizar ";
        $r=$_POST;
        if(isset($r["nombre"],$r["rfc"],$r["telefono"],$r["responsable"],$r["id"])){
            $a=$r["nombre"];
            $b=$r["rfc"];
            $c=$r["telefono"];
            $d=$r["responsable"];
            $id=$r["id"];
            $query="UPDATE proveedores SET nombre='$a',rfc='$b'
            ,telefono='$c',responsable='$d' WHERE id='$id'";
            $resutl=$db->query($query);
            if($resutl){
                echo json_encode(["success"=>"true",
                "message"=>"Actualizado con Exito",
                "data"=>[],]);
            }else{
                http_response_code(400);
               echo $db->error." number:". $db->errno;
            }

        }else{
            http_response_code(400);
            echo "Bad Request";
            // header("Location: ../clientes.php");
        }
        break;
    case 'delete':

        $r=$_POST;
        if(isset($r["id"])){
            $a=$r["id"];
            $query="DELETE FROM proveedores WHERE id='$a'";
            $resutl=$db->query($query);
            if($resutl){
                echo json_encode(["success"=>"true",
                "message"=>"Eliminado con Exito",
                "data"=>[],]);
            }else{
                http_response_code(400);
               echo $db->error." number:". $db->errno;
            }

        }else{
            http_response_code(400);
            echo "Bad Request";
            // header("Location: ../clientes.php");
        }
        break;
}

?>