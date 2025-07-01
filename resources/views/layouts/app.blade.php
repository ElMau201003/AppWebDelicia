<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panadería Delicia')</title>

    <!-- Estilos -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')
</head>
<body>

<header class="navbar navbar-expand-lg navbar-light shadow-sm py-3 px-4">
    <a class="navbar-brand fw-bold" href="{{ url('/') }}">🥐 Panadería Delicia</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}"><i class="fas fa-home"></i> Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/productos') }}"><i class="fas fa-bread-slice"></i> Productos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link position-relative" href="{{ route('carrito.ver') }}">
                    <i class="fas fa-shopping-cart"></i> Carrito
                    @if($cantidadCarrito > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $cantidadCarrito }}
                        </span>
                    @endif
                </a>
            </li>
            @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('pedidos.index') }}"><i class="fas fa-clipboard-list"></i> Pedidos</a>
            </li>
            @endauth
        </ul>

        <div class="d-flex align-items-center gap-2">
            <button id="login-btn" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </button>
            <button id="register-btn" class="btn btn-outline-success btn-sm">
                <i class="fas fa-user-plus"></i> Registrarse
            </button>
            <span id="user-greeting" class="fw-semibold" style="display:none;"></span>
            <button id="logout-btn" class="btn btn-outline-danger btn-sm" style="display:none;">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </button>
        </div>
    </div>
</header>

<!-- Modal Login -->
<div class="modal fade" id="login-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="modal-header">
        <h5 class="modal-title">Iniciar Sesión</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="login-form">
          <div class="mb-3">
            <label for="login-email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="login-email" required>
          </div>
          <div class="mb-3">
            <label for="login-password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="login-password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Registro -->
<div class="modal fade" id="register-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content p-4">
      <div class="modal-header">
        <h5 class="modal-title">Registrarse</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="register-form">
          <div class="mb-2"><input type="text" class="form-control" id="register-nombre" placeholder="Nombre" required></div>
          <div class="mb-2"><input type="text" class="form-control" id="register-apellido" placeholder="Apellido" required></div>
          <div class="mb-2"><input type="email" class="form-control" id="register-email" placeholder="Correo Electrónico" required></div>
          <div class="mb-2"><input type="text" class="form-control" id="register-telefono" placeholder="Teléfono" required></div>
          <div class="mb-2"><input type="text" class="form-control" id="register-direccion" placeholder="Dirección" required></div>
          <div class="mb-2"><input type="text" class="form-control" id="register-dni" placeholder="DNI" required></div>
          <div class="mb-2"><input type="date" class="form-control" id="register-fecha" required></div>
          <div class="mb-2">
            <select class="form-select" id="register-genero" required>
              <option value="">Género</option>
              <option value="M">Masculino</option>
              <option value="F">Femenino</option>
              <option value="Otro">Otro</option>
            </select>
          </div>
          <div class="mb-2"><input type="password" class="form-control" id="register-password" placeholder="Contraseña" required></div>
          <div class="mb-3"><input type="password" class="form-control" id="register-password-confirm" placeholder="Confirmar Contraseña" required></div>
          <button type="submit" class="btn btn-success w-100">Registrarse</button>
        </form>
      </div>
    </div>
  </div>
</div>

<main class="container my-5">
    @yield('content')
</main>

<footer class="bg-dark text-light pt-5 pb-3 mt-5">
  <div class="container">
    <div class="row gy-4">
      <div class="col-md-3">
        <h5>Panadería Delicia</h5>
        <p>El sabor tradicional que tu familia merece.</p>
        <div class="d-flex gap-2">
          <a href="#" class="text-light"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="text-light"><i class="fab fa-instagram"></i></a>
          <a href="#" class="text-light"><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>
      <div class="col-md-3">
        <h5>Enlaces</h5>
        <ul class="list-unstyled">
          <li><a href="/" class="text-light text-decoration-none">Inicio</a></li>
          <li><a href="/productos" class="text-light text-decoration-none">Productos</a></li>
          <li><a href="/pedidos" class="text-light text-decoration-none">Pedidos</a></li>
          <li><a href="#" class="text-light text-decoration-none">Términos y condiciones</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h5>Contacto</h5>
        <p><i class="fas fa-map-marker-alt"></i> Calle Panadería 123, Ciudad</p>
        <p><i class="fas fa-phone"></i> (123) 456-7890</p>
        <p><i class="fas fa-envelope"></i> info@panaderiadelicia.com</p>
      </div>
      <div class="col-md-3">
        <h5>Newsletter</h5>
        <p>Suscríbete para recibir promociones</p>
        <form class="d-flex">
          <input type="email" class="form-control me-2" placeholder="Tu correo" required>
          <button class="btn btn-outline-light"><i class="fas fa-paper-plane"></i></button>
        </form>
      </div>
    </div>
    <div class="text-center mt-4 border-top pt-3">
      <p class="mb-0">&copy; 2025 Panadería Delicia. Todos los derechos reservados.</p>
    </div>
  </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Bootstrap modal instances
const loginModal = new bootstrap.Modal(document.getElementById('login-modal'));
const registerModal = new bootstrap.Modal(document.getElementById('register-modal'));

document.getElementById('login-btn').addEventListener('click', () => loginModal.show());
document.getElementById('register-btn').addEventListener('click', () => registerModal.show());

function showUser(name) {
    document.getElementById('user-greeting').textContent = `Hola, ${name}`;
    document.getElementById('user-greeting').style.display = 'inline-block';
    document.getElementById('login-btn').style.display = 'none';
    document.getElementById('register-btn').style.display = 'none';
    document.getElementById('logout-btn').style.display = 'inline-block';
}

document.getElementById('logout-btn').addEventListener('click', async () => {
    try {
        const res = await fetch('/logout', {
            method: 'POST',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        if (res.ok) {
            location.reload();
        } else {
            alert('Error al cerrar sesión');
        }
    } catch (err) {
        alert('Error de red');
    }
});

document.getElementById('login-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;

    try {
        const res = await fetch('/login', {
            method: 'POST',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });
        const data = await res.json();
        if (res.ok) {
            showUser(data.user.name);
            loginModal.hide();
        } else {
            alert(data.message || 'Error al iniciar sesión');
        }
    } catch (err) {
        alert('Error de red');
    }
});

document.getElementById('register-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const data = {
        nombre: document.getElementById('register-nombre').value,
        apellido: document.getElementById('register-apellido').value,
        email: document.getElementById('register-email').value,
        telefono: document.getElementById('register-telefono').value,
        direccion: document.getElementById('register-direccion').value,
        dni: document.getElementById('register-dni').value,
        fecha_nacimiento: document.getElementById('register-fecha').value,
        genero: document.getElementById('register-genero').value,
        password: document.getElementById('register-password').value,
        password_confirmation: document.getElementById('register-password-confirm').value,
    };

    if (data.password !== data.password_confirmation) {
        alert('Las contraseñas no coinciden');
        return;
    }

    try {
        const res = await fetch('/register', {
            method: 'POST',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });
        const response = await res.json();
        if (res.ok) {
            showUser(response.user.name);
            registerModal.hide();
        } else {
            alert(response.message || 'Error al registrar');
        }
    } catch (err) {
        alert('Error de red');
    }
});
</script>

@stack('scripts')

@auth
<script> showUser(@json(auth()->user()->name)); </script>
@endauth

</body>
</html>
