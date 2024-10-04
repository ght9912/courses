<?php require "inc/top.php";?>

    <h1 class="mt-1">Inventario</h1>
    <div>
        <div class="d-flex w-100 justify-content-between">
            <button type="button" class="btn btn-success" id="addCliente">Añadir Inventario</button>
            <div>
                <input type="text" class="form-control d-inline" style="width: auto;">
                <button type="button" class="btn btn-primary">Buscar</button>
            </div>
        </div>
        <table class="table mt-3 bg-white " id="miTabla">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    
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
    
    <div class="modal fade" id="addEditModal" tabindex="-1" aria-labelledby="formLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="addEditForm">
                    <input type="hidden" name="action" id="action" value="">
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre Producto</label>
                        <select name="id_producto" id="id_producto"  class="form-select" required>
                            <option value=""></option>
                        </select> 
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Precio</label>
                        <input type="text" class="form-control" id="cantidad" name="cantidad"  required>
                    </div>
           
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitForm">Save changes</button>
                </div>
            </div>
        </div>
    </div>

<?php require_once "inc/scripts.php";?>

    <script type="text/javascript">
        let datos =[];
        let recursos=[];
        const urlController="controllers/inventario.php";

        $(document).ready(()=>{
            cargarRecursos();
            cargarDatos();
            $("#miTabla").DataTable();
            
        })
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
            });
        }
        function actualizarFormulario(){
            recursos.forEach((e)=>{
                const ht =`<option value="${e.id}">${e.nombre}</option>`;
                $("#id_producto").append(ht)
            })
            
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
            //$("#tableBody").empty();
            const dt=$("table").DataTable();
            datos.forEach((e,i)=>{
                let producto ="";
                for (let j = 0; j < recursos.length; j++) {
                    const e1 = recursos[j];
                    if(e1.id==e.id_producto){
                        producto=e1.nombre;
                        break;
                    }
                }
                const ht =`
                <button type="button" class="btn btn-secondary" onclick="editar(${e.id})">Editar</button>
                 <button type="button" class="btn btn-danger" onclick="eliminar(${e.id})">Elminar</button>  </td>
                `
                dt.row.add([e.id,producto,e.cantidad,ht]).draw(false);
                // const ht =`
                // <tr>
                //     <td>${e.id}</td>
                //     <td>${producto}</td>
                //     <td>${e.cantidad}</td>
                //     <td><button type="button" class="btn btn-secondary" onclick="editar(${e.id})">Editar</button>
                //     <button type="button" class="btn btn-danger" onclick="eliminar(${e.id})">Elminar</button>  </td>
                // </tr>
                // `;
                // $("#tableBody").append(ht);
            })
        }
        function findElemen(id){
           let Element;
           datos.every((e)=>{
                if(e.id=id){
                    Element=e;
                     return false;
                }
            })
            return Element;
        }
        function editar(id){
            const el=findElemen(id);
            $("#clienteLabel").html("Editar Inventario");
            $("#action").val("update");
            $("#id_producto").val(el.id_producto);
            $("#cantidad").val(el.cantidad);
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
            $("#formLabel").html("Añadir Inventario");
            $("#action").val("create");
        });       
        $("#submitForm").click(()=>{
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
        function findElement2(id){
           let Element;
           datos.every((e)=>{
                if(e.id_producto=id){
                    Element=e;
                     return false;
                }
            })
            return Element;
        }
        $("#id_producto").change((e)=>{
            // let id=e.target.value;
            // const el=findElement2(id)
            // if(el!=undefined){
            //     $("#formLabel").html("Editar Inventario");
            //     $("#action").val("update");
            //     if($("input[name='id']").length>0){    
            //         $("input[name='id']").val(el.id);
            //     }else{
            //         $("#addEditForm").append('<input type="hidden" name="id" value="'+el.id+'">')
            //     }
            //     $("#cantidad").val(el.cantidad);
            // }else{
            // $("#formLabel").html("Añadir Inventario");
            // $("#action").val("create");
            // }
        })


   
    
        
    </script>

<?php require "inc/foot.php";?>