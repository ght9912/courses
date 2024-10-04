<?php require "inc/top.php";?>

    <h1 class="mt-1">Proveedores</h1>
    <div>
        <div class="d-flex w-100 justify-content-between">
            <button type="button" class="btn btn-success" id="addCliente">Añadir Proveedores</button>
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
                    <th>RFC</th>
                    <th>Telefono</th>
                    <th>Responsable</th>
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
    
    <div class="modal fade" id="clienteModal" tabindex="-1" aria-labelledby="clienteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clienteLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="clienteForm">
                    <input type="hidden" name="action" id="clienteAction" value="">
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre Proveedor</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"  required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">RFC</label>
                        <input type="text" class="form-control" id="rfc" name="rfc"  required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Telefono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono"  required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Responsable</label>
                        <input type="text" class="form-control" id="responsable" name="responsable"  required>
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
        $(document).ready(()=>{
            cargarDatos();
            
        })
        function cargarDatos(){
            const fd=new FormData();
            fd.append("action","read")
            $.ajax({
                type: "POST",
                url: "controllers/proveedores.php",
                data: fd,
                processData: false,
                contentType: false,
                success: function (response) {
                   response= JSON.parse(response)
                   if(response.success){
                    datos=response.data;
                    cargarTabla();
                   }else{
                    alert(response.message);
                   }
                },
                error: function(jqHXR,textStatus,errorThrow){
                    console.log(jqHXR,textStatus,errorThrow);
                }
            });
        }
        function cargarTabla(){
           //SELECT * FROM `ventas` WHERE fecha BETWEEN DATE_FORMAT("2022-11-25",'%Y-%m-%d') and DATE_FORMAT('2022-11-30','%Y-%m-%d'); 
            const dt=$("table").DataTable();
            dt.clear().draw();

            datos.forEach((e,i)=>{
                // const ht =`
                // <tr>
                //     <td>${e.id}</td>
                //     <td>${e.nombre}</td>
                //     <td>${e.rfc}</td>
                //     <td>${e.telefono}</td>
                //     <td>${e.responsable}</td>
                //     <td></tr>
                // `;
                const ht =`<button type="button" class="btn btn-secondary" onclick="editar(${e.id})">Editar</button>
                    <button type="button" class="btn btn-danger" onclick="eliminar(${e.id})">Elminar</button>  </td>
                `;
              dt.row.add([e.id,e.nombre,e.rfc,e.telefono,e.responsable,ht]).draw( false );
           
            })
        }
        function findProveedor(id){
           let proveedor;
            datos.every((e)=>{
                if(e.id=id){
                    proveedor=e;
                    return false;
                }
            })
            return proveedor;
        }
        function editar(id){
            const provee=findProveedor(id);
            $("#clienteLabel").html("Editar Proveedor");
            $("#clienteAction").val("update");
            $("#nombre").val(provee.nombre);
            $("#rfc").val(provee.rfc);
            $("#telefono").val(provee.telefono);
            $("#responsable").val(provee.responsable);
            $("#clienteModal").modal("show");
            $("#clienteForm").append('<input type="hidden" name="id" value="'+id+'">')
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
                url: "controllers/proveedores.php",
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
            $("#clienteModal").modal("show");
            $("#clienteLabel").html("Añadir Proveedor");
            $("#clienteAction").val("create");
        });       
        $("#submitCliente").click(()=>{
            $("#clienteForm").submit();
        })
        $("#clienteForm").submit((e)=>{
            e.preventDefault();
            const fd = new FormData (document.querySelector("#clienteForm"))
            console.log(fd);
            $.ajax({
                type: "POST",
                url: "controllers/proveedores.php",
                data: fd,
                processData: false,
                contentType: false,
                success: function (response) {
                   response= JSON.parse(response)
                   if(response.success){
                    $("#clienteModal").modal("hide");
                    $("#clienteForm").trigger("reset");
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