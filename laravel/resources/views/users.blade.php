@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex mb-2 justify-content-between">
                <h1>Users Manager</h1>
                {{-- <button class="btn btn-success" id="addBtn" >Añadir</button> --}}
            </div>
            <div class="table-responsive">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Fechas</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $u)
                            <tr>
                                <td>{{$u->id}}</td>
                                <td>{{$u->name}}</td>
                                <td>{{$u->email}}</td>
                                <td>
                                   {{$u->created_at}} <br>
                                   {{$u->updated_at}}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-primary" onclick="editMain({{$u->id}},this)">Editar</button>
                                        <button type="button" name="" id="" class="btn btn-danger" onclick="deleteMain({{$u->id}},this)">Eliminar</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>





<!-- Modal Delete -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteTitle"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
            <div class="modal-body">
                Seguro que deseas Eliminar Usuario?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmDelete">Confirmar</button>
            </div>
        </div>
    </div>
</div>





<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:80% !important">
        <div class="modal-content" >
                <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Añadir Post</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="#" id="formAdd">
                    <div class="mb-3">
                        <label for="Titulo" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Aqui escribe tu nombre">
                      </div>
                      <div class="mb-3">
                        <label for="subtitulo" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Aqui escribe tu email">
                      </div>

                      <div class="mb-3">
                        <label for="categoria" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Escribe tu contraseña ">
                      </div>
                      <div class="mb-3">
                        <label for="categoria" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password2" id="password2" placeholder="Confirma tu contraseña">
                      </div>
                   </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addSave">Save</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section("scripts")
    <script >
        const mainData = {{ Js::from($users)}}
        const mainRecursos = {{ Js::from($recursos)}}
        const URLBase="users"


        const findTag = (id) =>{
            let el;
            mainRecursos.tags.every((e)=>{
                if(e.id==id){
                    el=e;
                    return false
                }
                return true;
            })
            return el;
        }
        const deleteTag=(el) =>{
            $(el).remove()
        }
        const findMain = (id) =>{
            let el;
            mainData.every((e)=>{
                if(e.id==id){
                    el=e;
                    return false
                }
                return true;
            })
            return el;
        }
        const updatePost = (id,data) =>{
            let updated=false;
            mainData.every((e,i)=>{
                if(e.id==id){
                    mainData[i]=data;
                    updated=true;
                    return false
                }
                return true;
            })
            return updated;
        }
        const editMain = (id,el) =>{
            const post = findMain(id);
            if(post==undefined){return}
            console.log(post);
            $("#name").val(post.name);
            $("#email").val(post.email);
            $("#formAdd").data("update",1)
            $("#formAdd").data("id",post.id);
            $("#modalTitleId").html("Actualizar Usario "+post.name)
            $("#modalAdd").modal("show");
            $(el).parent().parent().parent().addClass("update-"+id)
        }
        const deleteMain=(id,el)=>{
            $("#modalDelete").modal("show");
            $("#modalDelete").data("id",id);
            $("#modalDeleteTitle").html("Usuario "+findMain(id).name);
            $(el).parent().parent().parent().addClass("remove-"+id)
           // console.log();
        }
        const delFoto=()=>{
            event.preventDefault();
            $("#formAdd").data("delFoto",true);
            $("#portada").show();
            $("#existingImage").hide();
        }
        const ver=(id, titulo)=>{
            window.open(`/post/${id}/${titulo.replaceAll(" ","-")}`);
        }
        const validatePW=()=>{
            if($("#password").val()==$("#password2").val()){
                return true
            }else{
                alert("contrasñeas no coinciden")
                return false
            }


        }

    </script>
    <script type="module">
        $(document).ready(()=>{
            $(".table").DataTable()
            var editor = new FroalaEditor('#contenido',{requestHeaders: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            imageUploadURL: '/dashboard/post/uploadImage',
            fileUploadParams: {
            id: 'contenido'
            }});
        })
        $("#addBtn").click(()=>{
            $("#modalAdd").modal("show");
            $("#formAdd").data("update",0)
             $("#formAdd").data("delFoto",false);
        })
        $("#tags").change(function (e) {
           let tagId=$("#tags").val()
           if(tagId==null||tagId==""){return};
           let tag= findTag(tagId);
           $("#tagsContainer").append(`
           <span class="badge bg-secondary tagBadge" style="cursor:pointer" onclick="deleteTag(this)" data-id="${tag.id}" >${tag.nombre} X </span>
           `)
        });
        $("#addSave").click(function (e) {
            if(!validatePW()) return;
            let inputs = $("#formAdd").serializeArray();
            const data = new FormData(document.getElementById("formAdd"));

            if($("#formAdd").data("update")==1){
                let id=$("#formAdd").data("id");
                data.append("_method","PUT")

                axios.post(URLBase+"/"+id,data).then((e)=>{

                   if( !updatePost(id,e.data.data)){console.log("error al actualizar local")}
                   $("#modalAdd").modal("hide")
                    $("#formAdd").trigger("reset")

                    const dt=$(".table").DataTable();
                    const r = e.data.data

                    let time= ` ${r.created_at.split(".")[0]} <br> ${r.updated_at.split(".")[0]} `;
                    let buttons = `<div class="d-flex">
                                <button type="button" class="btn btn-primary" onclick="editMain(${r.id},this)">Editar</button>
                                <button type="button" name="" id="" class="btn btn-danger" onclick="deleteMain(${r.id},this)">Eliminar</button>
                                </div>`
                    dt.row($('.update-'+id)).data([r.id,r.name,r.email,time,buttons ]).draw()

            }).catch((e)=>{
                console.log(e);
            })
            }else{
                axios.post("",data).then((e)=>{
                    $("#modalAdd").modal("hide")
                    $("#formAdd").trigger("reset")
                    const dt=$(".table").DataTable();
                    const r = e.data.data
                    let tags=r.tags!=null?r.tags.split(","):[];
                    tags= tags.map((e,i)=>{
                        return findTag(e).nombre+"<br>";
                    }).join("")
                    let time= `Creado: ${r.created_at.split(".")[0]} <br>Actualizado: ${r.updated_at.split(".")[0]} `;
                    let buttons = `<div class="d-flex">
                                <button type="button" name="" id="" class="btn btn-success">Ver</button>
                                <button type="button" class="btn btn-primary" onclick="editPost(${r.id},this)">Editar</button>
                                <button type="button" name="" id="" class="btn btn-danger" onclick="deletePost(${r.id},this)">Eliminar</button>
                                </div>`
                    let portada=r.portada!=null&&r.portada!=""?`<img src="/storage/${r.portada}" class="img-fluid" alt="">`:"";
                    dt.row.add([r.id,r.usuario.name,r.titulo,r.categoria,portada,tags,time,buttons ]).draw()

                mainData.push(e.data.data)
            }).catch((e)=>{
                console.log(e);
            })
            }
        });

        $("#btnConfirmDelete").click(function (e) {
            const id= $("#modalDelete").data("id");
            axios.delete(URLBase+"/"+id).then((e)=>{
                $("#modalDelete").modal("hide");
                $("#modalDelete").data("id","");
                const dt=$(".table").DataTable();
                dt.rows('.remove-'+id).remove().draw();
            }).catch((e)=>{
                console.log(e);
            })

        });

    </script>
@endsection
