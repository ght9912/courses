<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments=Comments::all()->map(function($e){
            $e->usuario;
            return $e;
        });;

        $posts= Post::all();
        $data=["comments"=>$comments,"recursos"=>["posts"=>$posts]];
      //  return $data;
        return view("comments",$data);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function show(Comments $comments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function edit(Comments $comments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comments $comments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c = Comments::find($id);
        $c->delete();
        return response()->json([
            'message' => 'Comentario Elimando con exito',
            'data' => [],
            'status' => 200,
        ],200);
    }
    public function createFromPost(Request $r){

        $c= new Comments();
        $c->post_id=$r->id;
        $c->nombre=$r->nombre;
        $c->email=$r->email;
        $c->comentario=$r->comentario;
        $c->save();
        return response()->json([
            'message' => 'Comentario Creado con exito',
            'data' => $c,
            'status' => 200,
        ],200);

    }
}
