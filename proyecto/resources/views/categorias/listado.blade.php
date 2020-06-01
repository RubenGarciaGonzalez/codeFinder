@extends('plantilla.plantilla')
@section('titulo')
Home | Buscador
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
                <li class="nav-item active mx-2 dropdown nav-item inline-block">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Buscar Código <span class="sr-only">(current)</span></a>
                    <div class="dropdown-menu dropdown-menu-center">
                        <a href="{{ route('posts.buscador') }}" class="dropdown-item">Título</a>
                        <a href="#" class="dropdown-item">Categoría</a>
                    </div>
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
                        <a href="{{ route('posts.fav') }}" class="dropdown-item">
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
                    <h3 id="encabezado" class="text-center">
                            <span class="float-left small">
                                    <a href="javascript:goBack();">
                                        <i class="fa fa-caret-left text-dark"></i>
                                    </a>
                                </span>
                        Búsqueda por categorías
                    </h3>
                    <br>
                    <div class="container">
                        <form class="form ml-auto" method="GET" action="{{ route('categorias.listado') }}" id="form">
                            <div class="input-group mb-3">
                                @if ($request)
                                    <input type="text" class="form-control" placeholder="Introduce palabras clave..." value="{{ $request->nombre }}" id="input" name="nombre" required>  
                                @else
                                    <input type="text" class="form-control" placeholder="Introduce palabras clave..." name="nombre" id="input" required>
                                @endif
                                <a href="javascript:submitForm();" type="submit" class="btn btn-white btn-just-icon btn-round ml-2">
                                    <i class="material-icons">search</i>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="categorías">
                    <div class="container text-center">
                    <div class="row">
                    @forelse($categorias as $category)
                            <div class="col-md-6 mb-5  animated fadeIn">
                            <a href="{{ route('categorias.posts', $category) }}" data-toggle="tooltip" data-placement="top" title="Posts: {{ $category->totalPosts() }}">
                              <div class="cate" id="categoria">
                                <img src="{{ asset($category->logo) }}" alt="" width="100px" height="100px">
                                <h4 class="info-title">{{ $category->nombre }}</h4>
                              </div>
                            </a>
                            </div>
                    @empty
                        <h3 class="text-center mb-5 ml-5" id="sinResultado">No hay categorías con el nombre <b><em>{{ $request->nombre }}</em></b></h3>
                        <br><br>
                    @endforelse
                        </div>
                    </div>
                    <div class="container text-center">
                        {{$categorias->appends(Request::except('page'))->links()}}
                    </div>
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
                        <img src="{{asset(Auth::user()->fotoPerfil) }}" class="rounded-circle" width="100px" height="100px" />
                        <br><br>
                        <p><b>Nombre:</b> {{ Auth::user()->name }}</p>
                        <p><b>Usename:</b> {{ Auth::user()->username }}</p>
                        <p><b><a href="{{ route('users.show', Auth::user()) }}" class="text-dark">Mis posts:</a></b> {{ Auth::user()->totalPosts() }}</p>
                        <div class="text-center">
                            <div class="input-group text-center d-none d-sm-none d-md-block" >
                                <a href="{{ route('posts.create') }}" class="btn btn-primary " data-toggle="tooltip" data-placement="left" data-html="true" title="<em>Crea tus propias publicaciones</em>">Crear Post</a>
                                
                            </div>
                            {{-- Para pantallas pequeñas --}}
                            <div class="input-group text-center d-block d-sm-block d-md-none" >
                                <a href="{{ route('posts.create') }}" class="btn btn-primary " data-toggle="tooltip" data-placement="left" data-html="true" title="<em>Crea tus propias publicaciones</em>">Crear Post</a>
                                
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
                                    <a href="{{route('categorias.posts', 20)}}">
                                        <img class="d-block w-100" src="{{ asset('img/lenguajes/python.png') }}" alt="First slide" height="260px">
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="{{route('categorias.posts', 1)}}">
                                        <img class="d-block w-100" src="{{ asset('img/lenguajes/php.png') }}" alt="Second slide">
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="{{route('categorias.posts', 3)}}">
                                        <img class="d-block w-100" src="{{ asset('img/lenguajes/js.png') }}" alt="Third slide" height="250px">
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="{{route('categorias.posts', 2)}}">
                                        <img class="d-block w-100" src="{{ asset('img/lenguajes/java.png') }}" alt="Forth slide" height="250px">
                                    </a>
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

<script>
        function submitForm()
        {
            let input = document.getElementById('input').value;

            if (input.trim() == "") {
                alert('Debes introducir algún valor para realizar la búsqueda');
            }else{
                document.getElementById('form').submit();
            }
        }

        function goBack() {
            window.history.back()
        }

</script>

@endsection
