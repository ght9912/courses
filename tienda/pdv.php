<?php require "inc/top.php"; ?>
<div class="d-flex h-100 flex-wrap">
    <div class="col-lg-7 col-12 p-1">
        <div class="my-2">
            <form action="#" id="formBuscarCliente" class="d-flex">
                <input type="text" name="" id="buscarCliente" class="form-control" placeholder="Buscar Cliente" required>
                <button class="mx-2 btn btn-primary">Buscar</button>
            </form>
        </div>
        <div style="border: solid gray .5px; border-radius: 5px;" class="mb-2">
            <table class="table">
                <thead style="background: #00ae13">
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>P/U</th>
                    <th>Sub Total</th>
                    <th>Acciones</th>
                </thead>
                <tbody style="height: 50vh;">

                </tbody>
            </table>
            <div class="d-flex">
                <div class="col-6" id="datosCliente">
                    Datos del Cliente
                    <div class="d-flex justify-content-between m-1">
                        <b class="mx-1">Nombre</b>
                        <b class="mx-1" id="nombre_cliente">Publico Genera</b>
                    </div>
                    <div class="d-flex justify-content-between m-1">
                        <b class="mx-1">RFC</b>
                        <b class="mx-1" id="rfc_cliente">XXXX000000XXX</b>
                    </div>
                    <div class="d-flex justify-content-between m-1">
                        <b class="mx-1">Email</b>
                        <b class="mx-1" id="email_cliente">sinemail@hotmail.com</b>
                    </div>
                </div>
                <div class="col-6">

                    <div class="d-flex justify-content-between m-1">
                        <b class="mx-1">TOTAL</b>
                        <b class="mx-1" id="total">$0.00</b>
                    </div>
                    <div class="d-flex m-1">
                        <form action="#" id="formMetodoPago">
                        <select class="form-select" name="metodo_pago" id="metodo_pago" required>
                            <option value="">Seleciona Metodo de pago</option>
                            <option value="1">Efectivo</option>
                            <option value="2">Tarjeta Debito</option>
                            <option value="3">Tarjeta Credito</option>
                            <option value="4">Cheque</option>
                            <!-- <option value="5">Credito</option> -->
                        </select>
                        </form>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-danger m-1" id="cancelarCompra">Cancelar Compra</button>
                        <button class="btn btn-success m-1" id="confirmarCompra">Confirmar Compra</button>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-12 p-1">
        <div class="my-2 ">
        <form action="#" id="formBuscarProducto" class="d-flex">
                <input type="text" name="" id="buscarProducto" class="form-control" placeholder="Buscar Producto" required>
                <button class="mx-2 btn btn-primary">Buscar</button>
            </form>
        </div>
        <div style="border: solid gray .5px; border-radius: 5px;" class="mb-2">
            <div id="tituloCategoria">
                Categoria
            </div>
            <div class="d-flex flex-wrap justify-content-around align-content-start" id="productos" style="height: 58vh;">

            </div>
            <div class="d-flex justify-content-around" id="categorias" style="overflow: auto ;">


            </div>
        </div>
    </div>
   
</div>
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<?php require_once "inc/scripts.php"; ?>

<script type="text/javascript">
    let datos = [];
    let recursos = [];
    const urlController = "controllers/pdv.php";

    let orden = []
    let cliente = [];

    $(document).ready(() => {
        cargarRecursos();
        const cookie = getCookie("orden");
        const cookie1 = getCookie("cliente");
        if (cookie != "") {
            orden = JSON.parse(cookie);
        }
        if(cookie1!=""){
            cliente=JSON.parse(cookie1)
            cargarClienteInicio()
        }

    })

    function cargarRecursos() {
        const fd = new FormData();
        fd.append("action", "resources")
        $.ajax({
            type: "POST",
            url: urlController,
            data: fd,
            processData: false,
            contentType: false,
            success: function(response) {
                response = JSON.parse(response)
                if (response.success) {
                    recursos = response.data;
                    imprimirCategorias();
                    if (getCookie("orden") != "") {
                        actualizarRecursos(JSON.parse(getCookie("orden")));
                    }
                    cargarOrden();
                } else {
                    alert(response.message);
                }
            },
            error: function(jqHXR, textStatus, errorThrow) {
                console.log(jqHXR, textStatus, errorThrow);
            }
        });
    }

    function actualizarRecursos(e) {
        e.map((o) => {
            const p = findProducto(o.producto);
            p.cantidad -= o.cantidad;
        })
    }

    function imprimirCategorias() {
        $("#categorias").empty();
        recursos.categorias.map((e) => {
            const ht = `<button class="p-3 mx-1 btn btn-primary" onclick="cargarProductos('${e}')" >${e}</button>`
            $("#categorias").append(ht);
        })
    }

    function cargarProductos(cat) {
        $("#tituloCategoria").html(cat)
        $("#productos").empty();
        recursos.productos.forEach((e) => {
            if (e.categoria == cat) {
                const ht = `<button class="p-3 m-1 btn btn-primary" onclick="addProducto(${e.id})">${e.nombre}</button>`;
                $("#productos").append(ht);
            }
        })
    }

    function cargarOrden() {

        setCookie("orden", JSON.stringify(orden), 10);
        $("tbody").empty();
        let total = 0;
        orden.map((e, i) => {
            const p = findProducto(e.producto)
            let sub = parseFloat(e.cantidad) * parseFloat(p.precio)
            const ht = `<tr>  
                                <td>${i+1}</td>
                                <td>${p.nombre}</td>
                                <td><button class="btn btn-danger" onclick="substract(${i})">-</button>
                                    <input type="text" value="${e.cantidad}" style="width:50px;" >                                
                                 <button class="btn btn-success" onclick="add(${i})">+</button>
                                 </td>
                                <td>${ currency(p.precio).format()}</td>
                                <td>${currency(sub).format()}</td>
                                <td><button class="btn btn-danger" onclick="deleteProducto(${i})">X</button></td>
                            </tr>`;
            total += sub;
            $("tbody").append(ht);
        })
        $("#total").html(currency(total).format())
    }

    function findProducto(id) {
        let El;
        recursos.productos.every((e) => {

            if (e.id == id) {

                El = e;
                return false;
            } else {
                return true;
            }
        })
        return El
    }

    function addProducto(id) {
        let index;
        const exist = orden.every((e, i) => {
            if (e.producto == id) {
                index = i;
                return false
            } else {
                return true;
            }
        })
        if (!exist) {
            const p = findProducto(id)
            if (p.cantidad > 0) {
                p.cantidad--;
                orden[index].cantidad++;
            } else {
                alert("Ya no hay mas " + p.nombre);
            }


        } else {
            const p = findProducto(id)
            if (p.cantidad > 0) {
                p.cantidad--;
                orden.push({
                    producto: id,
                    cantidad: 1
                });
            } else {
                alert("Ya no hay mas " + p.nombre);
            }
        }
        cargarOrden();
    }

    function deleteProducto(i) {

        let o = orden[i];
        const p = findProducto(o.producto);
        const sure = confirm("Seguro que deseas eliminar el producto " + p.nombre)
        if (sure) {
            p.cantidad += o.cantidad;
            orden.splice(i, 1);
            cargarOrden();
        }

    }

    function substract(i) {
        let o = orden[i];
        const p = findProducto(o.producto);
        o.cantidad--;
        p.cantidad++;
        cargarOrden();

    }

    function add(i) {
        let o = orden[i];
        const p = findProducto(o.producto);
        if (p.cantidad > 0) {
            o.cantidad++;
            p.cantidad--;
            cargarOrden();
        } else {
            alert("ya no hay mas " + p.nombre)
        }

    }

    function actualizarF() {
        recursos.forEach((e) => {
            const ht = `<option value="${e.id}">${e.nombre}</option>`;
            $("#id_producto").append(ht)
        })

    }

    function cargarDatos() {
        const fd = new FormData();
        fd.append("action", "read")
        $.ajax({
            type: "POST",
            url: urlController,
            data: fd,
            processData: false,
            contentType: false,
            success: function(response) {
                response = JSON.parse(response)
                if (response.success) {
                    datos = response.data;
                    cargarTabla();
                } else {
                    alert(response.message);
                }
            },
            error: function(jqHXR, textStatus, errorThrow) {
                console.log(jqHXR, textStatus, errorThrow);
            }
        });
    }

    function cargarTabla() {
        $("#tableBody").empty();
        datos.forEach((e, i) => {
            let producto = "";
            for (let j = 0; j < recursos.length; j++) {
                const e1 = recursos[j];
                if (e1.id == e.id_producto) {
                    producto = e1.nombre;
                    break;
                }
            }

            const ht = `
                <tr>
                    <td>${e.id}</td>
                    <td>${producto}</td>
                    <td>${e.cantidad}</td>
                    <td><button type="button" class="btn btn-secondary" onclick="editar(${e.id})">Editar</button>
                    <button type="button" class="btn btn-danger" onclick="eliminar(${e.id})">Elminar</button>  </td>
                </tr>
                `;
            $("#tableBody").append(ht);
        })
    }

    function findElemen(id) {
        let Element;
        datos.every((e) => {
            if (e.id = id) {
                Element = e;
                return false;
            }
        })
        return Element;
    }

    function editar(id) {
        const el = findElemen(id);
        $("#clienteLabel").html("Editar Inventario");
        $("#action").val("update");
        $("#id_producto").val(el.id_producto);
        $("#cantidad").val(el.cantidad);
        $("#addEditModal").modal("show");
        $("#addEditForm").append('<input type="hidden" name="id" value="' + id + '">')
    }

    function eliminar(id) {
        const sure = confirm("Seguro que deseas eliminar?")
        if (!sure) {
            return;
        }
        const fd = new FormData();
        fd.append("action", "delete")
        fd.append("id", id)
        $.ajax({
            type: "POST",
            url: urlController,
            data: fd,
            processData: false,
            contentType: false,
            success: function(response) {
                response = JSON.parse(response)
                if (response.success) {
                    cargarDatos();
                } else {
                    alert(response.message);
                }
            },
            error: function(jqHXR, textStatus, errorThrow) {
                console.log(jqHXR, textStatus, errorThrow);
            }
        });
    }
    $("#addCliente").click(() => {
        $("#addEditModal").modal("show");
        $("#formLabel").html("Añadir Inventario");
        $("#action").val("create");
    });
    $("#submitForm").click(() => {
        $("#addEditForm").submit();
    })

    $("#addEditForm").submit((e) => {
        e.preventDefault();
        const fd = new FormData(document.querySelector("#addEditForm"))
        console.log(fd);
        $.ajax({
            type: "POST",
            url: urlController,
            data: fd,
            processData: false,
            contentType: false,
            success: function(response) {
                response = JSON.parse(response)
                if (response.success) {
                    $("#addEditModal").modal("hide");
                    $("#addEditForm").trigger("reset");
                    cargarDatos();
                } else {
                    alert(response.message);
                }
            },
            error: function(jqHXR, textStatus, errorThrow) {
                console.log(jqHXR, textStatus, errorThrow);
            }
        });
    })

    function findElement2(id) {
        let Element;
        datos.every((e) => {
            if (e.id_producto = id) {
                Element = e;
                return false;
            }
        })
        return Element;
    }
    $("#id_producto").change((e) => {
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
    $("#cancelarCompra").click(() => {
        const sure = confirm("¿Seguro que deseas cancelar la compra?");
        if (sure) {
            orden.map((o) => {
                const p = findProducto(o.producto);
                p.cantidad += o.cantidad;
            })
            orden = [];
            cargarOrden();
        }
    })
    let resultadoBusquedaClientes=[];
    $("#formBuscarCliente").submit((e) => {
        e.preventDefault();
        let data = {
            cliente: $("#buscarCliente").val(),
            action: "buscarCliente",
        }
        $.ajax({
            type: "POST",
            url: urlController,
            data: data,
            success: function(response) {
                response = JSON.parse(response)
                if (response.success) {                    
                    const data = response.data;
                    resultadoBusquedaClientes=data;
                    $(".modal-body").empty();
                    $("#modalLabel").html("Resultados de Busqueda");
                    data.map((e) => {
                        const ht = ` 
                        <div class="d-flex align-items-center justify-content-around">
                            <div class="d-flex flex-column"> 
                            <b>${e.nombre}</b>
                                <p> RFC: ${e.rfc} <br>
                                Email: ${e.email}</p>
                            </div>
                            <button class="btn btn-success" onclick="cargarCliente(${e.id})">&#10004;</button>
                        </div>
                    
                     
                     `;
                        $(".modal-body").append(ht);
                    })
                    if (data.length == 0) {
                        $(".modal-body").append("No hay resultados");
                    }

                    $("#modal").modal("show");
                }
            }
        });
    })
    
    $("#formBuscarProducto").submit((e) => {
        e.preventDefault();
        $("#tituloCategoria").html("Resultado de Busqueda");
        const st=$("#buscarProducto").val().toLowerCase();
        $("#productos").empty();
        let count=0;
        recursos.productos.map((e) => {
            if ( e.nombre.toLowerCase().includes(st) || e.descripcion.toLowerCase().includes(st)) {
                const ht = `<button class="p-3 m-1 btn btn-primary" onclick="addProducto(${e.id})">${e.nombre}</button>`;
                $("#productos").append(ht);
                count++
            }
        })
        if(!count){
            $("#productos").append("No se encontraron productos");
        }
    })
    function limpiarCliente(){
        $("#nombre_cliente").html("Publica en General");
        $("#rfc_cliente").html("XXXX000000XXX");
        $("#email_cliente").html("sinemail@hotmail.com");
        setCookie("cliente","",0);
        cliente=[];
        $("#limpiarCliente").remove();
    }   
    function cargarClienteInicio(){
        $("#nombre_cliente").html(cliente.nombre);
        $("#rfc_cliente").html(cliente.rfc);
        $("#email_cliente").html(cliente.email);
        $("#datosCliente").append(`
            <button class="btn btn-danger" id="limpiarCliente" onclick="limpiarCliente()"> Limpiar Cliente</button>
        `);
    }
    function cargarCliente(id){
        const cliente1= findClienteBusqueda(id);
        cliente=cliente1
        $("#nombre_cliente").html(cliente.nombre);
        $("#rfc_cliente").html(cliente.rfc);
        $("#email_cliente").html(cliente.email);
        $("#datosCliente").append(`
            <button class="btn btn-danger" id="limpiarCliente" onclick="limpiarCliente()"> Limpiar Cliente</button>
        `);
        setCookie("cliente",JSON.stringify(cliente),10)
        $("#modal").modal("hide");
        
    }
    function findClienteBusqueda(id){
        let el;
        resultadoBusquedaClientes.every((e)=>{
            if(e.id==id){
              el=e;
              return false;  
            }else{
                return true;
            }
        })
        return el;
    }
    $("#confirmarCompra").click((e)=>{
        const valid=document.querySelector('#formMetodoPago').reportValidity();
        if(!valid){
            return
        }
        if(orden.length==0){
            alert("Por favor agrega articulos a la orden");
            return
        }
        const data ={
            action:"confirmarCompra",
            orden:orden,
            cliente:cliente,
            m_pago:$("#metodo_pago").val()
        }
        console.log(data);
        $.ajax({
            type: "POST",
            url: urlController,
            data: data,
            success: function (response) {
                $("#metodo_pago").val("");
                orden=[];
                cargarRecursos();
                setCookie("orden", JSON.stringify(orden), 0);
                limpiarCliente();
                $(".modal-body").empty();
                $("#modalLabel").html("Confirmación de Compra");
                $(".modal-body").append(`<i class="fa-solid fa-check" style="color:green;font-size:80px;"></i> <br>`);
                $(".modal-body").append("Gracias por su Compra ");  

                $("#modal").modal("show");
            }
        });
    })
</script>

<?php require "inc/foot.php"; ?>