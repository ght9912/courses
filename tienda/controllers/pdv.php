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
                
                $clientes=array();
                $inventario=array();
                $categorias=array();
                //query clientes
                $query="SELECT id,nombre,rfc,email FROM clientes";
                $resutl=$db->query($query);
                if($resutl){
                    $rows = array();
                    while($row = $resutl->fetch_assoc())
                    {
                        $clientes[] = $row;
                    }
                }else{
                    http_response_code(400);
                   echo $db->error." number:". $db->errno;
                   exit;
                }
                //query inventario
                $query="SELECT i.cantidad, p.* FROM inventario as i INNER JOIN productos as p ON i.id_producto=p.id";
                $resutl=$db->query($query);
                if($resutl){
                    $rows = array();
                    while($row = $resutl->fetch_assoc())
                    {
                        $inventario[] = $row;
                    }
                }else{
                    http_response_code(400);
                   echo $db->error." number:". $db->errno;
                   exit;
                }
                //query categorias
                $query="SELECT DISTINCT categoria FROM productos";
                $resutl=$db->query($query);
                if($resutl){
                    $rows = array();
                    while($row = $resutl->fetch_assoc())
                    {
                        $categorias[] = $row["categoria"];
                    }
                }else{
                    http_response_code(400);
                   echo $db->error." number:". $db->errno;
                   exit;
                }

                echo json_encode([
                    "success"=>true,"data"=>[
                        "clientes"=>$clientes,
                        "productos"=>$inventario,
                        "categorias"=>$categorias
                    ],
                    "message"=>"Estos son todos los recursos"
                ]); 
            break;
        case 'buscarCliente':
            $r=$_POST;
            if(isset($r["cliente"])){
                $a=$r["cliente"];
                $query="SELECT * FROM clientes WHERE nombre like '%$a%' or direccion like '%$a%' or rfc like '%$a%' or tel like '%$a%'or email like '%$a%' or cel like '%$a%' LIMIT 10";
                $resutl=$db->query($query);
                if($resutl){
                    $rows=[];
                    while($row = $resutl->fetch_assoc())
                    {
                        $rows[] = $row;
                    }
                    echo json_encode(["success"=>"true",
                    "message"=>"Estos son los resultados",
                    "data"=>$rows]);
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
        case 'buscarProducto':
            $r=$_POST;
            if(isset($r["producto"])){
                $a=$r["producto"];
                $query="SELECT * FROM productos WHERE nombre like '%$a%' or descripcion like '%$a%'  LIMIT 10";
                $resutl=$db->query($query);
                if($resutl){
                    $rows=[];
                    while($row = $resutl->fetch_assoc())
                    {
                        $rows[] = $row;
                    }
                    echo json_encode(["success"=>"true",
                    "message"=>"Estos son los resultados",
                    "data"=>$rows]);
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
        case 'confirmarCompra':
            $r=$_POST;
            if(isset($r["orden"],$r["m_pago"])){
                $id_cliente=0;
                $pago=$r["m_pago"];
                $fecha = date("Y-m-d H:i:s");
                if(isset($r["cliente"]["id"])){
                    $id_cliente=$r["cliente"]["id"];
                }else{
                    $query="SELECT * FROM clientes WHERE nombre ='Publico General' LIMIT 1";
                    $resutl=$db->query($query);
                    if(!$resutl){
                        http_response_code(400);
                        echo $db->error." number:". $db->errno;
                    }
                    $id_cliente =$resutl->fetch_assoc()["id"];
                }
               
                $total=0;
                foreach ($r["orden"] as &$o){
                    $id=$o["producto"];
                    $query="SELECT precio FROM productos WHERE id='$id' LIMIT 1";
                    $resutl=$db->query($query);
                    if(!$resutl){
                        http_response_code(400);
                        echo $db->error." number:". $db->errno;
                    }
                    $o["precio"] =$resutl->fetch_assoc()["precio"];
                    $total+=($o["precio"]*$o["cantidad"]);
                }
                //var_dump($r["orden"]);
                
                $query="INSERT INTO ventas  values(null,'$id_cliente','$fecha','$total','$pago','$fecha')";
                $resutl=$db->query($query);
                if(!$resutl){
                    http_response_code(400);
                    echo $db->error." number:". $db->errno;
                }
                $venta_id= $db->insert_id;
                foreach ($r["orden"] as $o){
                    $p=$o["producto"];
                    $c=$o["cantidad"];
                    $precio=$o["precio"];
                    $query="INSERT INTO ventas_productos values(null,'$p','$venta_id','$fecha','$c','$precio')";
                    $resutl=$db->query($query);
                    if(!$resutl){
                        http_response_code(400);
                        echo $db->error." number:". $db->errno;
                    }
                    $query="UPDATE inventario SET cantidad=(cantidad-$c) WHERE id_producto=$p";
                    $resutl=$db->query($query);
                    if(!$resutl){
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

}

?>