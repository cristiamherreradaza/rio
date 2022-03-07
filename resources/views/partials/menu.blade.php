<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
	<!--begin::Menu Container-->
	<div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
		<!--begin::Menu Nav-->
		<ul class="menu-nav">

			<li>
				<div class="text-center mb-10">
					<div class="symbol symbol-60 symbol-circle">
						<div class="symbol-label" style="background-image:url('{{ url('assets/media/users/fotoPerfil.jpg') }}')">
						</div>
						<i class="symbol-badge symbol-badge-bottom bg-success"></i>
					</div>
					@auth
					<h4 class="font-weight-bold my-2 text-success">{{ Auth::user()->name }}</h4>
					<div class="text-light mb-2">{{ Auth::user()->perfil }}</div>
					
					<br />
					<a href="{{ route('logout') }}"
						onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
						class="label label-light-danger label-inline font-weight-bold label-lg">Salir</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
						@csrf
					</form>
					@endauth
				</div>
			</li> 

			@if (Auth::user()->perfil == 'Administrador')

			{{-- MENU ADMINISTRACION --}}

			<li class="menu-item" aria-haspopup="true">
				<a href="{{ url('/home') }}" class="menu-link">
					<i class="fas fa-chart-bar menu-icon"></i>
					<span class="menu-text">CONTROL PANEL</span>
				</a>
			</li>
		
			<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
				<a href="javascript:;" class="menu-link menu-toggle">
					<i class="fas fa-users menu-icon"></i>
					<span class="menu-text">SOCIOS</span>
					<i class="menu-arrow"></i>
				</a>
				<div class="menu-submenu">
					<i class="menu-arrow"></i>
					<ul class="menu-subnav">
						
						<li class="menu-item" aria-haspopup="true">
							<a href="{{ url('User/listado') }}" class="menu-link">
								<i class="menu-bullet menu-bullet-dot">
									<span></span>
								</i>
								<span class="menu-text">Listado</span>
							</a>
						</li>

						<li class="menu-item" aria-haspopup="true">
							<a href="{{ url('User/nuevo') }}" class="menu-link">
								<i class="menu-bullet menu-bullet-dot">
									<span></span>
								</i>
								<span class="menu-text">Nuevo</span>
							</a>
						</li>
						
					</ul>
				</div>
			</li>

			<li class="menu-item" aria-haspopup="true">
				<a href="{{ url('Recibo/listado') }}" class="menu-link">
					<i class="fas fa-file-invoice menu-icon"></i>
					<span class="menu-text">RECIBOS</span>
				</a>
			</li>

			<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
				<a href="javascript:;" class="menu-link menu-toggle">
					<i class="fas fa-calendar-day menu-icon"></i>
					<span class="menu-text">EVENTOS</span>
					<i class="menu-arrow"></i>
				</a>
				<div class="menu-submenu">
					<ul class="menu-subnav">
						
						<li class="menu-item" aria-haspopup="true">
							<a href="{{ url('Evento/listado') }}" class="menu-link">
								<i class="menu-bullet menu-bullet-dot">
									<span></span>
								</i>
								<span class="menu-text">Listado</span>
							</a>
						</li>
			
					</ul>
				</div>
			</li>

			<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
				<a href="javascript:;" class="menu-link menu-toggle">
					<i class="fas fa-list menu-icon"></i>
					<span class="menu-text">REPORTES</span>
					<i class="menu-arrow"></i>
				</a>
				<div class="menu-submenu">
					<i class="menu-arrow"></i>
					<ul class="menu-subnav">
			
						<li class="menu-item" aria-haspopup="true">
							<a href="{{ url('Reporte/pagos') }}" class="menu-link">
								<i class="menu-bullet menu-bullet-dot">
									<span></span>
								</i>
								<span class="menu-text">Reporte de Pagos</span>
							</a>
						</li>
			
						<li class="menu-item" aria-haspopup="true">
							<a href="{{ url('Reporte/gestion') }}" class="menu-link">
								<i class="menu-bullet menu-bullet-dot">
									<span></span>
								</i>
								<span class="menu-text">Pagos por Gestion</span>
							</a>
						</li>
			
					</ul>
				</div>
			</li>

			<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
				<a href="javascript:;" class="menu-link menu-toggle">
					<i class="fas fa-tools menu-icon"></i>
					<span class="menu-text">ADMINISTRACION</span>
					<i class="menu-arrow"></i>
				</a>
				<div class="menu-submenu">
					<i class="menu-arrow"></i>
					<ul class="menu-subnav">
			
						<li class="menu-item" aria-haspopup="true">
							<a href="{{ url('User/listadoAdmin') }}" class="menu-link">
								<i class="menu-bullet menu-bullet-dot">
									<span></span>
								</i>
								<span class="menu-text">Listado Usuarios</span>
							</a>
						</li>
						<li class="menu-item" aria-haspopup="true">
							<a href="{{ url('User/nuevoAdmin/0') }}" class="menu-link">
								<i class="menu-bullet menu-bullet-dot">
									<span></span>
								</i>
								<span class="menu-text">Nuevo Usuario</span>
							</a>
						</li>

						<li class="menu-item" aria-haspopup="true">
							<a href="{{ url('Categoria/listado') }}" class="menu-link">
								<i class="menu-bullet menu-bullet-dot">
									<span></span>
								</i>
								<span class="menu-text">Categorias</span>
							</a>
						</li>

						<li class="menu-item" aria-haspopup="true">
							<a href="{{ url('Configuracion/listado') }}" class="menu-link">
								<i class="menu-bullet menu-bullet-dot">
									<span></span>
								</i>
								<span class="menu-text">Configuracion</span>
							</a>
						</li>
			
					</ul>
				</div>
			</li>

			{{-- FIN MENU ADMINISTRADORES --}}
				
			@elseif (Auth::user()->perfil == 'Doctor')


			{{-- MENU DOCTORES --}}

			<li class="menu-item" aria-haspopup="true">
				<a href="{{ url('Medico/perfil')."/".Auth::user()->id}}" class="menu-link">
					<i class="fas fa-user menu-icon"></i>
					<span class="menu-text">MI PERFIL</span>
				</a>
			</li>

			<li class="menu-item" aria-haspopup="true">
				<a href="{{ url('Medico/eventos', []) }}" class="menu-link">
					<i class="fas fa-calendar-alt menu-icon"></i>
					<span class="menu-text">EVENTOS</span>
				</a>
			</li>

			<li class="menu-item" aria-haspopup="true">
				<a href="{{ url('User/pagos', [Auth::user()->id])}}" class="menu-link">
					<i class="fas fa-coins menu-icon"></i>
					<span class="menu-text">CUOTAS</span>
				</a>
			</li>

			<li class="menu-item" aria-haspopup="true">
				<a href="{{ url('Medico/verRecibo', [Auth::user()->id]) }}" class="menu-link">
					<i class="fas fa-th-list menu-icon"></i>
					<span class="menu-text">RECIBOS</span>
				</a>
			</li>

			{{-- FIN MENU DOCTORES --}}

			@else
				
			@endif



		</ul>
		<!--end::Menu Nav-->
	</div>
	<!--end::Menu Container-->
</div>