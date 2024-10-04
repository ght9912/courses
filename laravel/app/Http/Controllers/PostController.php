<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Settings;
use App\Models\Tags;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\MockObject\Stub\ReturnSelf;

class PostController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios=User::all();
        $tags=Tags::all();
        $post= Post::all()->map(function($e){
            $e->usuario;
            return $e;
        });
        $data=["post"=>$post,"recursos"=>["tags"=>$tags,"usuarios"=>$usuarios]];
        return view("post",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        $r->validate([
            '' => 'required',
            'titulo' => 'required',
            'contenido' => 'required',
        ]);

        $p=new Post();
        $p->user_id=$r->usuario;
        $p->titulo=$r->titulo;
        $p->sub_titulo=$r->subtitulo;
        $p->categoria=$r->categoria;
        if($r->portada!=""){
            $r->validate([
                'portada' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
            ]);
            $file=$r->file('portada');
            $file->hashName();
            $image_path = $file->store('img/post', 'public');
            $p->portada=$image_path;

        }
        $p->contenido=$r->contenido;
        $p->tags=$r->tags;
        $p->save();
        $p->usuario;

        return response()->json([
            'message' => 'Post Creado con exito',
            'data' => $p,
            'status' => 200,
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        $r->validate([
            'usuario' => 'required',
            'titulo' => 'required',
            'contenido' => 'required',
        ]);
        $p = Post::find($id);
        $p->user_id=$r->usuario;
        $p->titulo=$r->titulo;
        $p->sub_titulo=$r->subtitulo;
        $p->categoria=$r->categoria;

        if($r->delFoto=="true"){
            if(!Storage::disk("public")->delete($p->portada)){
                return response()->json(["status"=>'fail',"data"=>[],"message"=>'Error al Eliminar Imagen'],500);
            }
            $p->portada="";
        }
        if($r->portada!=""){
            $r->validate([
                'portada' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
            ]);
            $file=$r->file('portada');
            $file->hashName();
            $image_path = $file->store('img/post', 'public');
            $p->portada=$image_path;

        }
        $p->contenido=$r->contenido;
        $p->tags=$r->tags;
        $p->save();
        $p->usuario;

        return response()->json([
            'message' => 'Post Actualizado con exito',
            'data' => $p,
            'status' => 200,
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $p = Post::find($id);
        $p->delete();
        return response()->json([
            'message' => 'Post Elimando con exito',
            'data' => [],
            'status' => 200,
        ],200);
    }
    public function uploadImage(Request $r){
        if($r->file!=""){
            $r->validate([
                'file' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
            ]);
            $file=$r->file('file');
            $file->hashName();
            $image_path = $file->store('img/post/contenido', 'public');

            return response()->json(["status"=>'ok',"link"=>"/storage/".$image_path,"message"=>'Insersión realizada con exito'], 200, []);
        }else{
            return response()->json(["status"=>'fail',"message"=>'No image'], 401, []);
        }
    }
    public function showPost($id,$titulo){
        $tags=Tags::all();
        $post=  Post::find($id);
        $post->usuario;
        $post->comments;
        $data=["post"=>$post,"recursos"=>["tags"=>$tags ]];
        //return $data;
        return view("postView",$data);

    }

    public function postList(){
        $s =Settings::where("pagina","=","post")->first();
        $tags=Tags::all();
        $post= Post::all()->map(function($e){
            $e->usuario;
            return $e;
        });
        $data=["post"=>$post,"recursos"=>["tags"=>$tags],"setting"=>$s];
        //return $data;
        return view("postList",$data);
    }
}
