@extends('layouts.app')
@section('titulo')
Posts de {{ $category->nombre }}
@endsection
@section('contenido')
<nav class="navbar navbar-inverse navbar-expand-lg bg-dark fixed-top" role="navigation-demo">
    <div class="container">
        <a class="navbar-brand">
            <div class="logo-small">
                <img src="{{ asset('img/code.png') }}" width="25px" height="25px" class="img-fluid">
            </div>
        </a>
        <a class="navbar-brand" href="{{ route('home') }}">CodeFinder</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">CodeFinder</span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-center">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mx-2">
                    <a class="nav-link" href="{{ route('home') }}">Inicio </span></a>
                </li>
                <li class="nav-item mx-2 dropdown nav-item inline-block">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Buscar Código <span class="sr-only">(current)</span></a>
                        <div class="dropdown-menu dropdown-menu-center">
                            <a href="{{ route('posts.buscador') }}" class="dropdown-item">Título</a>
                            <a href="{{ route('categorias.listado') }}" class="dropdown-item">Categoría</a>
                        </div>
                    </li>
                </li>
                <li class="dropdown nav-item inline-block" id="lista">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->username }}</a>
                    <div class="dropdown-menu dropdown-menu-center">
                        @role('admin')
                        <a href="{{ route('admin.index') }}" class="dropdown-item">
                            Panel de Administrador
                        </a>
                        <hr>
                        @endrole
                        <a href="{{ route('users.show', Auth::user()) }}" class="dropdown-item">Perfil</a>
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
        <div class="col-lg-8">
            <div id="divPosts" class="card border-0 shadow mb-4">
                <div class="shadow-lg p-3 mb-3 mt-2 bg-white rounded">
                    <h4 id="encabezado" class="text-center">{{ $category->nombre }}</h4>
                    <h3 id="encabezado" class="text-center">Búsqueda por título</h3>
                    <br>
                    <div class="container">
                        <form class="form ml-auto" method="GET" action="{{ route('categorias.posts', $category) }}">
                            <div class="input-group mb-3">
                                @if ($request)
                                    <input type="text" class="form-control" placeholder="Introduce palabras clave..." value="{{ $request->titulo }}" name="titulo">  
                                @else
                                    <input type="text" class="form-control" placeholder="Introduce palabras clave..." name="titulo">
                                @endif
                                <button type="submit" class="btn btn-white btn-just-icon btn-round ml-2">
                                    <i class="material-icons">search</i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="resultados">
                        @forelse ($posts as $item)
                        <div class="container">
                            <div id="post" class="card-body shadow mb-5 animated bounceInDown">
                                <div class="col">
                                    <p id="fecha" class="text-center d-block d-sm-block d-md-none font-italic">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</p>
                                    <h5>
                                        <span class="font-weight-bold"><a href="{{ route('posts.show', $item) }}" class="text-dark">{{ $item->titulo }}</a></span>
                                        <span class="float-right"><a href="#" class="text-info">{{ $item->categoria->nombre }}</a></span>
                                    </h5>
                                    <p class="font-italic">{{ $item->descripcion }}</p>
                                    <br>
                                    <p>
                                        <img id="fotoPost" src="{{ asset($item->user->fotoPerfil) }}" alt="Foto de Perfil de {{ $item->user->username }}" class="img-fluid rounded-circle mr-2" width="40px" height="60px">
                                        <span><a href="{{ route('users.show', $item->user) }}" class="text-dark">{{ $item->user->name }}</a></span>
                                        <span id="fecha" class="float-right font-italic d-none d-sm-none d-md-block ">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</span>
                                    </p>
                                    @if (Auth::check() && $item->user_id == Auth::id())
                                    <form name="borrar" method='post' action='{{route('posts.destroy', $item)}}'>
                                        @csrf
                                        @method('DELETE')
                                        <button type='submit' class="btn btn-danger btn-fab btn-fab-mini btn-round d-none d-sm-none d-md-block" onclick="return confirm('¿Borrar post?')">
                                            <i class="material-icons">delete</i>
                                        </button>
                                        <div class="float-right">
                                            <button type='submit' class="btn btn-danger btn-fab btn-fab-mini btn-round d-block d-sm-block d-md-none" onclick="return confirm('¿Borrar post?')">
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </div>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                            <h3 class="text-center mb-5">No hay posts de {{ $category->nombre }}</h3>
                            <br><br>
                        @endforelse
                    {{$posts->appends(Request::except('page'))->links()}}
                </div>
            </div>


            <div id="divMas" class="card border-0 shadow mb-4">
                <div class="card-body">
                    <h5 class="m-0">Más Cosas</h5>
                    <hr>
                    <ul class="mb-0">
                        <li>Aquí irán más cosas</li>
                        <li>Aunque todavía no esté hecho</li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="col-lg-4">
            <div id="divPerfil" class="card border-0 shadow mb-4 d-lg-block">
                <div class="card-body">
                    <h3 class="text-center">Mi Perfil</h3>
                    <div class="text-center">
                        <img src="{{ Auth::user()->fotoPerfil }}" class="rounded-circle" width="100px" height="100px" />
                        <br><br>
                        <p><b>Nombre:</b> {{ Auth::user()->name }}</p>
                        <p><b>Usename:</b> {{ Auth::user()->username }}</p>
                        <p><b><a href="{{ route('users.show', Auth::user()) }}" class="text-dark">Mis posts:</a></b> {{ Auth::user()->totalPosts() }}</p>
                        <div class="text-center">
                            <div class="input-group text-center d-none d-sm-none d-md-block" style="margin-left: 10px;">
                                <a href="{{ route('posts.create') }}" class="btn btn-primary ml-2" data-toggle="tooltip" data-placement="left" data-html="true" title="<em>Crea tus propias publicaciones</em>">Crear Posts</a>
                                <a href="#" class="btn btn-primary mr-2" data-toggle="tooltip" data-placement="right" data-html="true" title="<em>Tus posts guardados como favoritos</em>">
                                    Favoritos
                                </a>
                            </div>
                            {{-- Para pantallas pequeñas --}}
                            <div class="input-group text-center d-block d-sm-block d-md-none" style="margin-left: 10px;">
                                <a href="{{ route('posts.create') }}" class="btn btn-primary ml-2" data-toggle="tooltip" data-placement="left" data-html="true" title="<em>Crea tus propias publicaciones</em>">Crear Posts</a>
                                <a href="#" class="btn btn-primary mr-2" data-toggle="tooltip" data-placement="right" data-html="true" title="<em>Tus posts guardados como favoritos</em>">
                                    Favoritos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="divExtra" class="card border-0 shadow mb-4 text-center">
                <div class="card-body">
                    <div class="small mb-2 font-weight-bold">Sigue los proyectos nuevos del creador del sitio!</div>
                    <a href="https://github.com/RubenGarciaGonzalez" target="_blank" class="btn btn-sm btn-block">
                        <div class="text-center">
                            <span class="text-primary">
                                <i class="fa fa-github"></i> Github
                            </span>
                        </div>
                    </a>
                </div>
            </div>

            <div id="divCarousel" class="card border-0 shadow mb-4 d-none d-sm-none d-lg-block">
                <div class="card-body">
                    <div class="text-center small">
                        <h5>Busca códigos por lenguajes</h5>
                    </div>
                    <br>
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style=" width:100%; height: 300px;">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                        </ol>
                        <div class="carousel-inner my-2">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{ asset('img/lenguajes/php.png') }}" alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{ asset('img/lenguajes/node.png') }}" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{ asset('img/lenguajes/js.png') }}" alt="Third slide" height="250px">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{ asset('img/lenguajes/java.png') }}" alt="Forth slide" height="250px">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Anterior</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Siguiente</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
<div class="footer-main bg-dark py-5 small d-block d-sm-block">
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
