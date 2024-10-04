<?php require "inc/top.php";?>

    <h1 class="mt-1">Productos</h1>
    <div>
        <div class="d-flex w-100 justify-content-between">
            <button type="button" class="btn btn-success" id="addCliente">Añadir Producto</button>
            <div>
                <input type="text" class="form-control d-inline" style="width: auto;">
                <button type="button" class="btn btn-primary">Buscar</button>
            </div>
        </div>
        <table class="table mt-3 bg-white ">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Producto</th>
                    <th>Proveedor</th>
                    <th>Descripcion</th>
                    <th>Categoria</th>
                    <th>Precio</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- <tr>
                    <td>1</td>
                    <td>Coca Cola</td>
                    <td>PUHL950612N74</td>
                    <td>8441223334</td>
                    <td>Luis</td>
                    <td><button type="button" class="btn btn-secondary">Editar</button>
                    <button type="button" class="btn btn-danger">Elminar</button>  </td>
                </tr> -->
               
            </tbody>  
        </table>
    </div>
    
    <div class="modal fade" id="addEditModal" tabindex="-1" aria-labelledby="clienteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clienteLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="addEditForm">
                    <input type="hidden" name="action" id="clienteAction" value="">
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre Producto</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"  required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Proveedor</label>
                        <select name="proveedor" id="proveedor"  class="form-select" required>
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Descripcion</label>
                        <input type="text" class="form-control" id="des" name="des"  required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Categoria</label>
                        <input type="text" class="form-control" id="cat" name="cat"  required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Precio</label>
                        <input type="text" class="form-control" id="precio" name="precio"  required>
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
        let datos =[];
        let recursos=[];
        const urlController="controllers/productos.php";

        $(document).ready(()=>{
            cargarRecursos();
            cargarDatos();
            
        })
    
        $( window ).on("load",function() {
            // $("table").DataTable();
        });
        function cargarRecursos(){
            const fd=new FormData();
            fd.append("action","resources")
            $.ajax({
                type: "POST",
                url: urlController ,
                data: fd,
                processData: false,
                contentType: false,
                success: function (response) {
                   response= JSON.parse(response)
                   if(response.success){
                    recursos=response.data;
                    actualizarFormulario();
                    cargarTabla();
                   }else{
                    alert(response.message);
                   }
                },
                error: function(jqHXR,textStatus,errorThrow){
                    console.log(jqHXR,textStatus,errorThrow);
                }
            })
               
        
        }
        function actualizarFormulario(){
            recursos.forEach((e)=>{
                const ht =`<option value="${e.id}">${e.nombre}</option>`;
                $("#proveedor").append(ht)
            })
            
        }
        async function Table(){
            await cargarTabla();
            $("table").DataTable();
        }
        function cargarDatos(){
            const fd=new FormData();
            fd.append("action","read")
            $.ajax({
                type: "POST",
                url: urlController,
                data: fd,
                processData: false,
                contentType: false,
                success: function (response) {
                   response= JSON.parse(response)
                   if(response.success){
                    datos=response.data;
                    cargarTabla1();
                   // Table();
                   }else{
                    alert(response.message);
                   }
                },
                error: function(jqHXR,textStatus,errorThrow){
                    console.log(jqHXR,textStatus,errorThrow);
                }
            });
        }
        function cargarTabla1(){
            let dt = $("table").DataTable();
            dt.clear().draw();
            datos.forEach((e,i)=>{
                const ht =`<button type="button" class="btn btn-secondary" onclick="editar(${e.id})">Editar</button>
                    <button type="button" class="btn btn-danger" onclick="eliminar(${e.id})">Elminar</button> `;
              dt.row.add([e.id,e.nombre,e.proveedor,e.descripcion,e.categoria,e.precio,ht]).draw( false );
            })
            
        }
        function cargarTabla(){
            $("#tableBody").empty();
            datos.forEach((e,i)=>{
                let proveedor ="";
                // for (let j = 0; j < recursos.length; j++) {
                //     const e1 = recursos[j];
                //     if(e1.id==e.id_proveedor){
                //         proveedor=e1.nombre;
                //         break;
                //     }
                // }
                
                const ht =`
                <tr>
                    <td>${e.id}</td>
                    <td>${e.nombre}</td>
                    <td>${proveedor}${e.proveedor}</td>
                    <td>${e.descripcion}</td>
                    <td>${e.categoria}</td>
                    <td>${e.precio}</td>
                    <td> </td>
                </tr>
                `;
                $("#tableBody").append(ht);
            })  
           
        }
        function findProveedor(id){
           let Proveedor;
            datos.every((e)=>{
                if(e.id=id){
                    Proveedor=e;
                    return false;
                }
            })
            return Proveedor;
        }
        function editar(id){
            const provee=find<(id);
            $("#clienteLabel").html("Editar <");
            $("#clienteAction").val("update");
            $("#nombre").val(provee.nombre);
            $("#rfc").val(provee.rfc);
            $("#telefono").val(provee.telefono);
            $("#responsable").val(provee.responsable);
            $("#addEditModal").modal("show");
            $("#addEditForm").append('<input type="hidden" name="id" value="'+id+'">')
        }
        function eliminar(id){
            const sure = confirm("Seguro que deseas eliminar?")
            if(!sure){
                return;
            }
            const fd=new FormData();
            fd.append("action","delete")
            fd.append("id",id)
            $.ajax({
                type: "POST",
                url: urlController,
                data: fd,
                processData: false,
                contentType: false,
                success: function (response) {
                   response= JSON.parse(response)
                   if(response.success){                    
                   cargarDatos();
                   }else{
                    alert(response.message);
                   }
                },
                error: function(jqHXR,textStatus,errorThrow){
                    console.log(jqHXR,textStatus,errorThrow);
                }
            });
        }
        $("#addCliente").click(()=>{
            $("#addEditModal").modal("show");
            $("#clienteLabel").html("Añadir Producto");
            $("#clienteAction").val("create");
        });       
        $("#submitCliente").click(()=>{
            $("#addEditForm").submit();
        })
        $("#addEditForm").submit((e)=>{
            e.preventDefault();
            const fd = new FormData (document.querySelector("#addEditForm"))
            console.log(fd);
            $.ajax({
                type: "POST",
                url: urlController,
                data: fd,
                processData: false,
                contentType: false,
                success: function (response) {
                   response= JSON.parse(response)
                   if(response.success){
                    $("#addEditModal").modal("hide");
                    $("#addEditForm").trigger("reset");
                    cargarDatos();
                   }else{
                    alert(response.message);
                   }
                },
                error: function(jqHXR,textStatus,errorThrow){
                    console.log(jqHXR,textStatus,errorThrow);
                }
            });
        })



   
    
        
    </script>

<?php require "inc/foot.php";?>