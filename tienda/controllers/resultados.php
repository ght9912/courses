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
        $r=$_POST;
        if(isset($r["f1"],$r["f2"])){
            $a=$r['f1'];
            $b=$r['f2'];
            $query="SELECT v.*, c.nombre FROM `ventas` v  inner join clientes c on c.id=v.id_cliente WHERE v.fecha BETWEEN DATE_FORMAT('$a','%Y-%m-%d') and DATE_FORMAT('$b','%Y-%m-%d')";
            $query1="SELECT p.nombre, vp.cantidad FROM ventas_productos vp inner join productos p on p.id=vp.id_producto WHERE vp.id_venta in (SELECT v.id FROM `ventas` v  WHERE v.fecha BETWEEN DATE_FORMAT('$a','%Y-%m-%d') and DATE_FORMAT('$b','%Y-%m-%d')) ";
            $resutl=$db->query($query);
            $result1=$db->query($query1);
            if($resutl && $result1){
                $rows = array();
                $rows1 = array();
                while($row = $resutl->fetch_assoc())
                {
                    $rows[] = $row;
                }
                while($row = $result1->fetch_assoc())
                {
                    $rows1[] = $row;
                }
                echo json_encode([
                    "success"=>true,"data"=>["ventas"=>$rows,"productos"=>$rows1],
                    "message"=>"Estos son todas las Ventas"
                ]); // Retornar JSON
                
                //var_dump( $rows);
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