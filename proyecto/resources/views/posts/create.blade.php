@extends('layouts.app')
@section('titulo')
Creando Post
@endsection
@section('contenido')
<nav class="navbar navbar-inverse navbar-expand-lg bg-dark fixed-top" role="navigation-demo">
    <div class="container">
        <a class="navbar-brand">
            <div class="logo-small">
                <img src="{{ asset('img/code.png') }}" width="25px" height="25px" class="img-fluid">
            </div>
        </a>
        <a class="navbar-brand" href="#">CodeFinder</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">CodeFinder</span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-center">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mx-2">
                    <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="#">Buscar Código</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="#">Lenguajes</a>
                </li>
                <li class="nav-item active mx-2">
                    <a class="nav-link" href="#">Creando Post <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="#" style="pointer-events: none; cursor: default;">{{ Auth::user()->username }}</a>
                </li>
                <li class="dropdown nav-item inline-block">
                    <a href="#" class="profile-photo dropdown-toggle nav-link" data-toggle="dropdown">
                        <div class="profile-photo-small">
                            <img src="{{ asset('img/fotoUsuarios/default.jpg') }}" class="img-fluid rounded" width="30px" height="45px" style="margin-top:5px">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @role('admin')
                        <a href="{{ route('admin.panel') }}" class="dropdown-item">
                            Panel de Administrador
                        </a>
                        <hr>
                        @endrole
                        <a href="#" class="dropdown-item">Perfil</a>
                        <a href="#" class="dropdown-item">Mis Posts</a>
                        <a href="#" class="dropdown-item">
                            Posts Favoritos
                        </a>
                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Cerrar Sesión') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<br><br>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card border-0 shadow mb-4">
                <div class="shadow-lg p-3 mb-5 bg-white rounded">
                    <h2 class="mx-auto font-weight-bold text-center font-italic">Creación de Post</h2>
                    <br>
                    @if($errors->any())
                        <div class="alert alert-danger rounded">
                            <ul>
                                @foreach($errors->all() as $miError)
                                <li>{{$miError}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                            <div class="form-group">
                                <label for="title">Título</label>
                                <input type="text" name="titulo" class="form-control" id="title" placeholder="Título..." value="{{ old('title') }}" maxlength="80">
                            </div>
                            <div class="form-group">
                                <label for="categoria_id">Lenguaje</label>
                                    <select name="categoria_id" class="form-control">
                                        @foreach ($categorias as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                        @endforeach
                                    </select>
                              </div>
                            <div class="form-group">
                                <label for="descripcion">Descripcion</label>
                                <textarea name="descripcion" class="form-control" id="descripcion" placeholder="Descripcion..." value="{{ old('descripcion') }}" rows="2" maxlength="180"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="contenido">Código</label>
                                <textarea name="contenido" class="form-control" id="contenido" placeholder="Código..." value="{{ old('contenido') }}" rows="10">
                                        
                                </textarea>
                            </div>
                            <div class="form-group pt-2 text-center">
                                <input class="btn btn-info" type="submit" value="Submit">
                                <a href="{{ route('home') }}" class="btn btn-dark">Volver</a>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="footer" class="footer-main bg-dark small">
    <div class="container">
        Proyecto hecho con el Kit de UI
        <a href="https://demos.creative-tim.com/material-kit/docs/2.0/getting-started/introduction.html">Material Kit</a>.
        <br>
        <div class="copyright float-left">
            &copy;
            <script>
                document.write(new Date().getFullYear())

            </script> CodeFinder, Inc.
        </div>
    </div>
</div>

@endsection