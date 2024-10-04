<?php require "inc/top.php";?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


    <h1 class="mt-1">Resultados</h1>
    <div>
        <div class="d-flex w-100 justify-content-start">
            <input type="text" name="" id="picker">
            <button type="button" class="btn btn-success" id="mostrarResultados">Mostrar Resultados</button>

        </div>
        <table class="table mt-3 bg-white " id="miTabla">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Metodo de pago</th>
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
        <div class="d-flex flex-column my-2">
            <div class="d-flex justify-content-around">
                <h2>Ticket Promedio</h2>
                <h2 id="t_promedio"></h2>
            </div>
            <div class="d-flex flex-column mt-3" id="mejores_Clientes">
                <h2>Mejores Clientes</h2>
            </div>
            <div class="d-flex flex-column mt-3" id="">
                <h2>Venta diaria </h2>
                <canvas id="grafica"></canvas>
            </div>
            <div class="d-flex flex-column mt-3" id="">
                <h2>Productos mas vendidos </h2>
                <canvas id="grafica1"></canvas>
            </div>
        </div>
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

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="vendors/datejs/date.js"></script>

    <script type="text/javascript">
        let datos =[];
        let productos =[];
        let recursos=[];
        const urlController="controllers/resultados.php";

        const ctx = document.getElementById('grafica');
        const grafica=new Chart(ctx, {
            type: 'bar',
            data: {
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                // datasets: [{
                // label: '# of Votes en Saltillo',
                // data: [12, 19, 3, 5, 2, 3],
                // borderWidth: 1
                // },{
                // label: '# of Votes en torreon',
                // data: [12, 19, 3, 5, 2, 3],
                // borderWidth: 1
            },
            options: {
                scales: {
                y: {
                    beginAtZero: true
                }
                }
            }
        });
        const ctx1 = document.getElementById('grafica1');
        const grafica1=new Chart(ctx1, {
            type: 'bar',
            data: {
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                // datasets: [{
                // label: '# of Votes en Saltillo',
                // data: [12, 19, 3, 5, 2, 3],
                // borderWidth: 1
                // },{
                // label: '# of Votes en torreon',
                // data: [12, 19, 3, 5, 2, 3],
                // borderWidth: 1
            },
            options: {
                scales: {
                y: {
                    beginAtZero: true
                }
                }
            }
        });


        $(document).ready(()=>{
           // cargarRecursos();
            //cargarDatos();
            //$("#miTabla").DataTable();
            $("#picker").daterangepicker();

        })
        $("#mostrarResultados").click(()=>{
            let date= $('#picker').val().split(" - ");
            //console.log(date);
            let date1= Date.parse(date[0]);
            let date2=Date.parse(date[1]);
            let dif = date2-date1;
            let dias =Math.floor( dif/(1000*60*60*24));
            date[0]=Date.parse(date[0]).toString("yyyy-MM-dd");
            date[1]=Date.parse(date[1]).toString("yyyy-MM-dd");
            let arrDias=[{fecha:date[0],total:0}];
            for (let i = 0; i < dias; i++) {
                arrDias.push( {fecha:date1.add(1).day().toString("yyyy-MM-dd"),total:0});
            }
            //console.log(arrDias);
            cargarDatos(date,arrDias);
        })

        function cargarDatos(fechas,arrDias){

            const data={
                action:'read',
                f1:fechas[0],
                f2:fechas[1],
            }
            $.ajax({
                type: "POST",
                url: urlController,
                data: data,
                success: function (response) {
                   response= JSON.parse(response)
                   if(response.success){
                    datos=response.data.ventas;
                    productos=response.data.productos;
                    cargarTabla();
                    cargarGraficas(arrDias);
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
            dt.clear().draw();
            $("#mejores_Clientes").empty();
            let ticket_prom=0;
            let clientes=[];
            datos.forEach((e,i)=>{
                let m_pago ="";
                switch (e.metodo_de_pago) {
                    case "1":
                        m_pago="Efectivo"
                        break;
                    case "2":
                    m_pago="Tarjeta Debito"
                    break;
                    case "3":
                    m_pago="Tarjeta Credito"
                    break;
                    case "4":
                    m_pago="Cheque"
                    break;

                }
                const ind = clientes.findIndex(e1 => e1.id === e.id_cliente);

                if (ind > -1) {
                      /* clientes contains the element we're looking for, at index "i" */
                    clientes[ind].total+=parseFloat(e.total);
                }else{
                    clientes.push({
                        id:e.id_cliente,
                        name:e.nombre,
                        total: parseFloat(e.total)
                    })
                }
                const ht =`
                <button type="button" class="btn btn-secondary" onclick="editar(${e.id})">Editar</button>
                 <button type="button" class="btn btn-danger" onclick="eliminar(${e.id})">Elminar</button>  </td>
                `//  <th>Id</th>
                //     <th>Cliente</th>
                //     <th>Fecha</th>
                //     <th>Total</th>
                //     <th>Metodo de pago</th>
                dt.row.add([e.id,e.nombre,e.fecha,currency(e.total).format(),m_pago]).draw(false);
                ticket_prom+=parseFloat(e.total)

            })

            ticket_prom/=datos.length;
            $("#t_promedio").html(currency(ticket_prom).format())
            clientes.sort((p1, p2) => (p1.total < p2.total) ? 1 : (p1.total > p2.total) ? -1 : 0)
            //console.log(clientes);
            clientes.every((e,i)=>{
                if(i>4) {return false};

                const ht=`
                    <div class="d-flex">
                        <div class="col-6"><h5>${e.name}</h5></div >
                        <div class="col-6"><h5>${currency(e.total).format()}</h5></div >
                    </div>
                `;
                $("#mejores_Clientes").append(ht);
                return true;
            })

        }
        function cargarGraficas(arrDias){
            datos.forEach((e)=>{
                let dia= e.fecha.split(" ")[0];
                let objeto =arrDias.find((arr)=>{
                    return arr.fecha==dia;
                })
                if(objeto!=undefined){
                    objeto.total+= parseFloat(e.total);
                }
            })
            //console.log(arrDias);
            addDataset(grafica,"Total de Ventas", arrDias )

            let prod=[];
            productos.forEach((e)=>{
                if(prod.find((arr)=>{return arr.nombre==e.nombre})==undefined){
                    prod.push({nombre:e.nombre, cantidad:0});
                }
            })
            productos.forEach((e)=>{
                let objeto =prod.find((arr)=>{
                    return arr.nombre==e.nombre;
                })
                if(objeto!=undefined){
                    objeto.cantidad+= parseInt(e.cantidad);
                }
            })

            //console.log(prod);
            //ESTE ES EL CAMBIO
            addDataset1(grafica1,"Productos mas vendidos", prod )
        }
        function addDataset(chart, label, data) {
            let dataGrafico =data.map((e)=>{
                return e.total;
            })
            let labels =data.map((e)=>{
                return e.fecha;
            })
            const newDataset = {
                label: 'Total de Ventas',
                data: dataGrafico
            };
            chart.data.labels=labels;
            chart.data.datasets=[newDataset];
            chart.update();
        }
        function addDataset1(chart, label, data) {
            let dataGrafico =data.map((e)=>{
                return e.cantidad;
            })
            let labels =data.map((e)=>{
                return e.nombre;
            })
            const newDataset = {
                label: 'Cantidad vendida',
                data: dataGrafico
            };
            chart.data.labels=labels;
            chart.data.datasets=[newDataset];
            chart.update();
        }
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