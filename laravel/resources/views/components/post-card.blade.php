<!-- Post preview-->
<div class="post-preview">
    <a href="post/{{$p->id}}/{{$p->titulo}}">
        <h2 class="post-title">{{$p->titulo}}</h2>
        <h3 class="post-subtitle">{{$p->sub_titulo}}</h3>
    </a>
    <p class="post-meta">
        Posteado por
        <a href="#!">{{$p->usuario->name}}</a>
        el {{$p->created_at}}
    </p>
    <div class="d-flex">
        @php
        $tags=explode(",",$p->tags);
        foreach ($tags as $t ) {
            foreach ($recurso as $t1) {
               if($t1->id==$t){
                echo '<span class="badge bg-secondary ms-1">'.$t1->nombre.'</span>';
                break;
               }
            }
        }
        @endphp
    </div>

</div>
<!-- Divider-->
<hr class="my-4" />
