<?php require "inc/top.php";?>

<!-- Genereal fuctions PHP -->

<?php 
       function createRequest($url, $data){
    
        $params=$data;
        $defaults = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_RETURNTRANSFER=> 1
        );
        $ch = curl_init();
        curl_setopt_array($ch,  $defaults);
        $result=curl_exec($ch);
        if(curl_error($ch)) {
            echo(curl_error($ch));
        }
        curl_close($ch); 
        return $result;
    }
?>
<?php $clientes= createRequest("http://localhost:8080/CursoSabados/tienda/controllers/clientes.php",['action'=>"read"]);
      $clientes=json_decode($clientes);

        if (isset($_POST["edit"]) && $_POST["edit"]==1){
            foreach ($clientes as $cliente){
                if( $_POST["id"]==$cliente->id){
                    $cliente_edit=$cliente;
                }
            }
            //var_dump($cliente_edit);
        }

?>

    <h1 class="mt-1">Clientes</h1>
    <div>
        <div class="d-flex w-100 justify-content-between">
            <button type="button" class="btn btn-success" id="addCliente">Añadir Cliente</button>
            <div>
                <input type="text" class="form-control d-inline" style="width: auto;">
                <button type="button" class="btn btn-primary">Buscar</button>
            </div>
        </div>
        <table class="table mt-3 bg-white ">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>RFC</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Celular</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <!-- <tr>
                    <td>1</td>
                    <td>Luis Fernando Pruneda</td>
                    <td>Real de Valencia #308</td>
                    <td>PUHL950612N74</td>
                    <td>8441223334</td>
                    <td>luisfer_hdz9@hotmail.com</td>
                    <td>844122334  </td>
                    <td><button type="button" class="btn btn-secondary">Editar</button>
                    <button type="button" class="btn btn-danger">Elminar</button>  </td>
                </tr> -->
                <?php
                    foreach ($clientes as $cliente){     
                ?>
                <tr>
                <td><?= $cliente->id; ?></td>
                <td><?= $cliente->nombre; ?></td>
                <td><?= $cliente->direccion; ?></td>
                <td><?= $cliente->rfc; ?></td>
                <td><?= $cliente->tel; ?></td>
                <td><?= $cliente->email; ?></td>
                <td><?= $cliente->cel; ?>  </td>
                <td>
                    
                <form action="" method="POST">
                    <input type="hidden" name="id" value="<?= $cliente->id; ?>">
                    <input type="hidden" name="edit" value="1">
                    <button type="submit" class="btn btn-secondary" >Editar</button>
                </form>
               
                <form action="controllers/clientes.php" method="POST" onsubmit="confirmar(event,this)">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $cliente->id; ?>">
                <button type="submit" class="btn btn-danger">Elminar</button>  </td>
                
                </form>
                </tr>
                <?php
                    }
                ?>
            </tbody>  
        </table>
    </div>
    
    <div class="modal fade" id="clienteModal" tabindex="-1" aria-labelledby="clienteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clienteLabel"> <?php 
                        if (isset($_POST["edit"]) && $_POST["edit"]==1){
                        echo 'Editar Cliente';
                        }else{
                            echo "Añadir Cliente";
                        }
                    ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="clienteForm" action="controllers/clientes.php" method="POST">
                    <input type="hidden" name="action" id="clienteAction" value="<?=isset($_POST["edit"]) && $_POST["edit"]==1?'update':'';  ?>">
                    <?=isset($_POST["edit"]) && $_POST["edit"]==1? '<input type="hidden" name="id" value="'.$cliente_edit->id.'">':'';  ?>
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?=isset($_POST["edit"]) && $_POST["edit"]==1?$cliente_edit->nombre:'';  ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?=isset($_POST["edit"]) && $_POST["edit"]==1?$cliente_edit->direccion:'';  ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">RFC</label>
                        <input type="text" class="form-control" id="rfc" name="rfc"  value="<?=isset($_POST["edit"]) && $_POST["edit"]==1?$cliente_edit->rfc:'';  ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Telefono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?=isset($_POST["edit"]) && $_POST["edit"]==1?$cliente_edit->tel:'';  ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?=isset($_POST["edit"]) && $_POST["edit"]==1?$cliente_edit->email:'';  ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Celular</label>
                        <input type="email" class="form-control" id="celular" name="celular" value="<?=isset($_POST["edit"]) && $_POST["edit"]==1?$cliente_edit->cel:'';  ?>" required>
                    </div>
                                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitCliente">Save changes</button>
                </div>
            </div>
        </div>
    </div>

<?php require_once "inc/scripts.php";?>

    <script type="text/javascript">
        $("table").DataTable();
        $("#addCliente").click(()=>{
            $("#clienteModal").modal("show");
            $("#clienteLabel").html("Añadir Cliente");
            $("#clienteAction").val("create");
        });       
        $("#submitCliente").click(()=>{
            $("#clienteForm").submit();
        }) 

        <?=isset($_POST["edit"]) && $_POST["edit"]==1?'
            $(document).ready(()=>{
                $("#clienteModal").modal("show");
            })
           ':'';  ?>
       
    
        function confirmar(event,form) {
            console.log(event,form);
            event.preventDefault();
            //alert("El Evento se detuvo ");
            let sure= confirm("Seguro que deseas eliminar?");
            if(sure){
                form.submit();
            }
          }
        
    </script>

<?php require "inc/foot.php";?>