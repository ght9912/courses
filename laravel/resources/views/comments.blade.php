@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex mb-2 justify-content-between">
                <h1>Comments Manager</h1>
                {{-- <button class="btn btn-success" id="addBtn" >Añadir</button> --}}
            </div>
            <div class="table-responsive">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Email</th>
                            <th scope="col">Post</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $c)
                            <tr>
                                <td>{{$c->id}}</td>
                                <td>{{$c->nombre}}</td>
                                <td>{{$c->email}}</td>
                                <td>
                                    @forEach ($recursos["posts"] as $p)
                                        @if ($p->id==$c->post_id)
                                            <a href="/post/{{$p->id}}/{{$p->titulo}}" target="_blank"> {{$p->titulo}}</a>
                                            @break
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                   {{$c->created_at->format('j F, Y')}}

                                </td>
                                <td>
                                    <div class="d-flex">
                                          <button type="button" name="" id="" class="btn btn-danger" onclick="deleteComment({{$c->id}},this)">Eliminar</button>
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
                Seguro que deseas Eliminar Comentario?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmDelete">Confirmar</button>
            </div>
        </div>
    </div>
</div>







@endsection

@section("scripts")
    <script >
        const mainData = {{ Js::from($comments)}}
        const mainRecursos = {{ Js::from($recursos)}}
        const URLBase="comments"


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
        const editPost = (id,el) =>{
            const post = findPost(id);
            if(post==undefined){return}
            console.log(post);
            $("#usuario").val(post.user_id);
            $("#titulo").val(post.titulo);
            $("#subtitulo").val(post.sub_titulo);
            $("#categoria").val(post.categoria);
            $("#existingImage").hide()
            if(post.portada !=null && post.portada!=""){
                $("#portada").hide();
                $("#existingImage img").attr("src","/storage/"+post.portada)
                $("#existingImage").show()
            }

            $(".fr-view").html(post.contenido);
            $("#tagsContainer").empty();
            let tagsId=post.tags!=null?post.tags.split(","):[];
            tagsId.forEach((tagId)=>{
                let tag= findTag(tagId);
                $("#tagsContainer").append(`
                <span class="badge bg-secondary tagBadge" style="cursor:pointer" onclick="deleteTag(this)" data-id="${tag.id}" >${tag.nombre} X </span>
                `)
            })
            $("#formAdd").data("update",1)
            $("#formAdd").data("id",post.id);
            $("#modalTitleId").html("Actualizar Post "+post.id)
            $("#modalAdd").modal("show");
            $(el).parent().parent().parent().addClass("update-"+id)
            $("#formAdd").data("delFoto",false);
        }
        const deleteComment=(id,el)=>{
            $("#modalDelete").modal("show");
            $("#modalDelete").data("id",id);
            $("#modalDeleteTitle").html("Comentario de "+findMain(id).nombre);
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
            let inputs = $("#formAdd").serializeArray();
            // let data={}
            // inputs.forEach((e)=>{
            //     data[e.name]=e.value;
            // })
            // data.tags=[];
            // $("#tagsContainer .tagBadge").each((i,e)=>{
            //     data.tags.push($(e).data("id"));
            // })
            // data.tags=data.tags.toString();
            const data = new FormData(document.getElementById("formAdd"));
            data.append("contenido",$(".fr-view").html())
            let tags=[];
            $("#tagsContainer .tagBadge").each((i,e)=>{
                tags.push($(e).data("id"));
            })
            data.append("tags",tags.toString())
            if($("#formAdd").data("update")==1){
                let id=$("#formAdd").data("id");
                data.append("delFoto",$("#formAdd").data("delFoto"))
                data.append("_method","PUT")
                $("#modalAdd").modal("hide")
                $("#formAdd").trigger("reset")
                axios.post("post/"+id,data).then((e)=>{
                   if( !updatePost(id,e.data.data)){console.log("error al actualizar local")}

                const dt=$(".table").DataTable();
                    const r = e.data.data
                    let tags=r.tags!=null?r.tags.split(","):[];
                    tags= tags.map((e,i)=>{
                        return findTag(e).nombre+"<br>";
                    }).join("")
                    let time= `Creado: ${r.created_at.split(".")[0]} <br>Actualizado: ${r.updated_at.split(".")[0]} `;
                    let buttons = `<div class="d-flex">
                                <button type="button" name="" id="" class="btn btn-success" onclick="ver(${r.id},'${r.titulo}')">Ver</button>
                                <button type="button" class="btn btn-primary" onclick="editPost(${r.id},this)">Editar</button>
                                <button type="button" name="" id="" class="btn btn-danger" onclick="deletePost(${r.id},this)">Eliminar</button>
                                </div>`
                    let portada=r.portada!=null&&r.portada!=""?`<img src="/storage/${r.portada}" class="img-fluid" alt="">`:"";
                    dt.row($('.update-'+id)).data([r.id,r.usuario.name,r.titulo,r.categoria,portada,tags,time,buttons ]).draw()

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
