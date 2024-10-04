<?php
    require_once "connection.php";

    if(!isset($_POST["action"])){
        http_response_code(400);
        die("No Action");
    }

switch ($_POST["action"]) {
    case 'create':
        $r=$_POST;
        if(isset($r["id_producto"],$r["cantidad"])){
            $a=$r["id_producto"];
            $b=$r["cantidad"];
            $query=" SELECT id,cantidad FROM `inventario` WHERE id_producto='$a'";
            $resutl=$db->query($query);
            if(!$resutl){
                http_response_code(400);
                echo $db->error." number:". $db->errno;
                exit;
            }
            if($resutl->num_rows>0){
                $row = $resutl->fetch_assoc();
                $id=$row["id"];
                $b+= $row["cantidad"];
                $query="UPDATE inventario SET id_producto='$a',cantidad='$b'
                WHERE id='$id'";
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
                $query="INSERT INTO inventario VALUES (null,'$a','$b')";
                $resutl=$db->query($query);
                if($resutl){
                    echo json_encode(["success"=>"true",
                    "message"=>"Añadido con Exito",
                    "data"=>[],]);
                }else{
                http_response_code(400);
                echo $db->error." number:". $db->errno;
                
                }
            }         

        }else{
            http_response_code(400);
            echo "Bad Request";
            // header("Location: ../clientes.php");
        }
        break;
    case 'read':
        
            $query="SELECT * FROM inventario";
            $resutl=$db->query($query);
            if($resutl){
                $rows = array();
                while($row = $resutl->fetch_assoc())
                {
                    $rows[] = $row;
                }
                echo json_encode([
                    "success"=>true,"data"=>$rows,
                    "message"=>"Esto es todo el inventario"
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
        if(isset($r["id_producto"],$r["cantidad"],$r["id"])){
            $a=$r["id_producto"];
            $b=$r["cantidad"];
            $id=$r["id"];
            $query="UPDATE inventario SET id_producto='$a',cantidad='$b'
            WHERE id='$id'";
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
            $query="DELETE FROM inventario WHERE id='$a'";
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
        case "resources":
            $query="SELECT id,nombre FROM productos";
                $resutl=$db->query($query);
                if($resutl){
                    $rows = array();
                    while($row = $resutl->fetch_assoc())
                    {
                        $rows[] = $row;
                    }
                    echo json_encode([
                        "success"=>true,"data"=>$rows,
                        "message"=>"Estos son todos los productos"
                    ]); // Retornar JSON
                    
                    //var_dump( $rows);
                }else{
                    http_response_code(400);
                   echo $db->error." number:". $db->errno;
                }
            break;
}

?>