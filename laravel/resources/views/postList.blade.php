@extends('layouts.blog')

@section("titulo-pagina")
   {{$setting->titulo}}
@endsection

@section("subtitulo-pagina")
    {{$setting->subtitulo}}
@endsection

@section("imagen"){{ asset('assets/img/post-bg.jpg') }}@endsection

@section("content")
@if ($setting->contenido!="" &&$setting->contenido!=null)
<div class="row gx-4 gx-lg-5 justify-content-center">
    <div class="col-md-10 col-lg-8 col-xl-7">
            <p>{{$setting->contenido}}</p>
        </div>
    </div>
@endif
<div class="col-md-10 col-lg-8 col-xl-7" id="listaPost">
    @foreach ($post as $p)
        @if ($loop->index>1)
            @break
        @endif
        @include('components.post-card',["post"=>$p,"recurso"=>$recursos["tags"]])
    @endforeach
</div>
<!-- Pager-->
<div class="d-flex justify-content-around">
    <div class=" mb-4"><a class="btn btn-primary text-uppercase" href="#!" style="display: none" id="newBtn"><- Newer Posts</a></div>
    <div class=" mb-4"><a class="btn btn-primary text-uppercase" href="#!" id="olderBtn">Older Posts →</a></div>
</div>

@endsection

@section ("scripts")
<script>
    const mainData = {{ Js::from($post)}}
    const mainRecursos = {{ Js::from($recursos)}}
    let pagina=0;
    let postPPagina=2
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
    $("#olderBtn").click(()=>{
        pagina++

        updatePage()
        if(pagina!=0){
            $("#newBtn").show();
        }

    })
    $("#newBtn").click(()=>{
        pagina--

        updatePage()
        if(pagina!=0){
            $("#newBtn").show();
        }else{
            pagina==0
            $("#newBtn").hide();
            $("#olderBtn").show();
        }
    })
    function updatePage(){
        $("#listaPost").empty()
            mainData.forEach((e,i) => {
            let tags=e.tags!=null?e.tags.split(","):[];
                    tags= tags.map((e,i)=>{
                        let ht=`<span class="badge bg-secondary ms-1">${findTag(e).nombre}</span>`
                        return ht;
                    }).join("")
            if(i>=(pagina*postPPagina) && i<((pagina+1)*postPPagina)){
                let ht =`
                <!-- Post preview-->
            <div class="post-preview">
                <a href="post/${e.id}/${e.titulo}">
                    <h2 class="post-title">${e.titulo}</h2>
                    <h3 class="post-subtitle">${e.sub_titulo}</h3>
                </a>
                <p class="post-meta">
                    Posteado por
                    <a href="#!">${e.usuario.name}</a>
                    el ${e.created_at}
                </p>
                <div class="d-flex">
                    ${tags}
                </div>

            </div>
            <!-- Divider-->
            <hr class="my-4">`
            $("#listaPost").append(ht)
            }
            if(pagina*postPPagina>=mainData.length-1){
                $("#olderBtn").hide();
            }else{
                $("#olderBtn").show();
            }
            if(i>(pagina*postPPagina)){
                return;
            }

        });
    }


</script>

@endsection


