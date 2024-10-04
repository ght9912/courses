<?php session_start();
    require_once "connection.php";

    if(!isset($_POST["action"])){
        http_response_code(400);
        die("No Action");
    }

switch ($_POST["action"]) {
    case 'create':
        $r=$_POST;
        if(isset($r["nombre"],$r["pass"])){
            $a=$r["nombre"];
            $b=md5($r["pass"]);
            $query="INSERT INTO usuarios VALUES (null,'$a','$b')";
            $resutl=$db->query($query);
            if($resutl){
                echo json_encode(["success"=>"true",
                "message"=>"Usuario registrado con exito",
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
        
            $query="SELECT * FROM usuarios";
            $resutl=$db->query($query);
            if($resutl){
                $rows = array();
                while($row = $resutl->fetch_assoc())
                {
                    $rows[] = $row;
                }
                echo json_encode([
                    "success"=>true,"data"=>$rows,
                    "message"=>"Estos son todos los usuarios"
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
        if(isset($r["nombre"],$r["pass"])){
            $a=$r["nombre"];
            $b=md5( $r["pass"]);
            $id=$r["id"];
            $query="UPDATE usuarios SET nombre='$a',pass='$b' WHERE id='$id'";
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
            $query="DELETE FROM usuarios WHERE id='$a'";
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

    case 'login':
        // echo "Estas tratando de actualizar ";
        $r=$_POST;
        if(isset($r["nombre"],$r["pass"])){
            $a=$r["nombre"];
            $b=md5( $r["pass"]);
            $query="SELECT * from usuarios WHERE userName='$a' and pass='$b' limit 1";
            $resutl=$db->query($query);
            if($resutl){
                if($resutl->num_rows>0){
                    $rows=array();
                    while ($row=$resutl->fetch_assoc()){
                        $rows[]=$row;
                    }
                    $_SESSION["user"]=$rows[0];
                    echo json_encode(["success"=>"true",
                "message"=>"Login Success",
                "data"=>$rows[0]]);
                }else{
                    http_response_code(401);
                    echo json_encode(["success"=>"false",
                "message"=>"Usuarios y contraseña no coinciden",
                "data"=>[],]);
                }
                
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
        case 'logout':
           session_destroy();
           
            break;
}

?>