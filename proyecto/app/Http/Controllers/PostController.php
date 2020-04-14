<?php

namespace App\Http\Controllers;

use App\Post;
use App\Categoria;
use App\User;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categorias = Categoria::orderBy('nombre')->get();

        return view ('posts.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //Usuario
        $user = auth()->user();
        //Recogida de datos
        $datos = $request->validated();
        $post = new Post();
        $post->titulo = \ucwords($datos['titulo']);
        $post->descripcion = $datos['descripcion'];
        $post->contenido = $datos['contenido'];
        $post->categoria_id=$datos['categoria_id'];
        $post->user_id=$user->id;

        $post->save();
        Alert::success('Post Creado', 'Has creado el post correctamente');
        return redirect()->route('home');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
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
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        Alert::info('Borrado', 'Has eliminado el post correctamente');
        return redirect()->route('home');

    }
}
