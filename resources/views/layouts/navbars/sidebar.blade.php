<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="https://creative-tim.com/" class="simple-text logo-normal">
      {{ __('Encuestas') }}
    </a>
    <label style="font-size: 15px; width: 100%; margin-bottom: 0px;     font-weight: 700; text-align: center;" class="">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</label>
    <label style="font-size: 15px; width: 100%;     font-weight: 700; text-align: center;" class="">Rol:
      @if (auth()->user()->id_rol == 1)
        Administrador
      @elseif (auth()->user()->id_rol == 2)
        Asesor
      @endif
    </label>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">

      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <p>{{ __('Inicio') }}</p>
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'survey' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('encuesta.index') }}">
          <p>{{ __('Encuestas') }}</p>
        </a>
      </li>
      @if (auth()->user()->id_rol == 1)
      <li class="nav-item{{ $activePage == 'project' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('project.index') }}">
          <p>{{ __('Proyectos') }}</p>
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'db' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('db.index') }}">
          <p>{{ __('Base de datos') }}</p>
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'users' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('users.index') }}">
          <p>{{ __('Usuarios') }}</p>
        </a>
      </li>

      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">          
          <p>{{ __('Reportes') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="#">
                <span class="sidebar-normal">{{ __('Grafico') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="#">
                <span class="sidebar-normal"> {{ __('Datos') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item{{ $activePage == 'client' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('client.index') }}">
          <p>{{ __('Clientes') }}</p>
        </a>
      </li>

      @endif;
    </ul>
  </div>
</div>