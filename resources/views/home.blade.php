@extends('layouts.app')

@section('title', 'Inicio - Panadería Delicia')

@section('content')

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Panadería y Pastelería Delicia</h1>
        <p class="subtexto">El sabor que enamora</p>
        <div class="hero-text">
            <p>Somos una panadería artesanal dedicada a ofrecer panes y pasteles frescos todos los días. Usamos ingredientes de calidad y mucho amor.</p>
            <a href="{{ url('/productos') }}" class="btn-primario">Ver Productos</a>
        </div>
    </div>
</section>

<!-- Productos Destacados -->
<section class="destacados">
    <div class="container">
        <h2>Nuestros Productos Destacados</h2>
        <div class="destacados-grid">
            @foreach ([
                ['img' => 'pan-frances.png', 'nombre' => 'Pan Francés', 'desc' => 'Recién horneado todos los días', 'precio' => 'S/2.00'],
                ['img' => 'empanadas-de-pollo.png', 'nombre' => 'Empanadas de Pollo', 'desc' => 'Rellenas con ingredientes frescos', 'precio' => 'S/3.50'],
                ['img' => 'pastel-de-chocolate.png', 'nombre' => 'Pastel de Chocolate', 'desc' => 'Puro sabor en cada rebanada', 'precio' => 'S/5.00'],
                ['img' => 'pay-de-manzana.png', 'nombre' => 'Pie de manzana', 'desc' => 'Dulce sabor a manzana', 'precio' => 'S/4.50'],
                ['img' => 'bizcochos-de-vainilla.png', 'nombre' => 'Bizcocho de vainilla', 'desc' => 'Un sabor que gusta', 'precio' => 'S/4.00'],
            ] as $producto)
                <div class="destacado-item">
                    <img src="{{ asset('imagenes/' . $producto['img']) }}" alt="{{ $producto['nombre'] }}" class="zoom-img" />
                    <h3>{{ $producto['nombre'] }}</h3>
                    <p>{{ $producto['desc'] }}</p>
                    <span class="precio">{{ $producto['precio'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Sobre Nosotros -->
<section class="sobre-nosotros">
    <div class="container">
        <div class="sobre-content">
            <div class="sobre-text">
                <h2>Nuestra Historia</h2>
                <p>Desde 1985, Panadería Delicia ha sido un referente en la elaboración de productos artesanales de la más alta calidad. Nuestro secreto es la combinación de técnicas tradicionales con ingredientes seleccionados.</p>
                <ul class="sobre-lista">
                    <li><i class="fas fa-check"></i> Ingredientes 100% naturales</li>
                    <li><i class="fas fa-check"></i> Elaboración artesanal</li>
                    <li><i class="fas fa-check"></i> Horneado diario</li>
                </ul>
            </div>
            <div class="sobre-img">
                <img src="{{ asset('imagenes/panaderia-interior.jpg') }}" alt="Interior de la panadería Delicia" />
            </div>
        </div>
    </div>
</section>

<!-- Testimonios -->
<section class="testimonios">
    <div class="container">
        <h2>Lo que dicen nuestros clientes</h2>
        <div class="testimonios-grid">
            @foreach ([
                ['autor' => 'María González', 'texto' => 'El mejor pan francés que he probado en mi vida. Siempre fresco y delicioso.', 'rol' => 'Cliente frecuente'],
                ['autor' => 'Carlos Mendoza', 'texto' => 'Las empanadas son simplemente increíbles. Siempre pido para llevar cuando visito la ciudad.', 'rol' => 'Cliente desde 2010'],
            ] as $testimonio)
                <div class="testimonio-item">
                    <div class="testimonio-text">
                        <p>"{{ $testimonio['texto'] }}"</p>
                    </div>
                    <div class="testimonio-autor">
                        <img src="{{ asset('imagenes/usuario.png') }}" alt="Foto de {{ $testimonio['autor'] }}" />
                        <div>
                            <h4>{{ $testimonio['autor'] }}</h4>
                            <span>{{ $testimonio['rol'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Formulario de Pedidos -->
<section id="pedidos" class="pedidos-section">
    <div class="container">
        <h2>Haz tu Pedido</h2>
        <div class="pedidos-content">
            <form class="pedidos-form" method="POST" action="#">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" required />
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección de entrega</label>
                    <input type="text" id="direccion" name="direccion" required />
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" required />
                </div>
                <div class="form-group">
                    <label for="producto">Producto</label>
                    <select id="producto" name="producto" required>
                        <option value="">Seleccione un producto</option>
                        <option value="pan-frances">Pan francés</option>
                        <option value="empanadas-pollo">Empanadas de pollo</option>
                        <option value="pastel-chocolate">Pastel de chocolate</option>
                        <option value="pay-manzana">Pie de manzana</option>
                        <option value="bizcocho-vainilla">Bizcocho de vainilla</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" id="cantidad" name="cantidad" min="1" required />
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha de recolección</label>
                    <input type="date" id="fecha" name="fecha" required />
                </div>
                <button type="submit" class="btn-primario">Enviar Pedido</button>
            </form>

            <div class="pedidos-info">
                <h3>Horario de atención</h3>
                <p><i class="fas fa-clock"></i> Lunes a Viernes: 7:00 am - 8:00 pm</p>
                <p><i class="fas fa-clock"></i> Sábados: 7:00 am - 6:00 pm</p>
                <p><i class="fas fa-clock"></i> Domingos: 8:00 am - 2:00 pm</p>

                <h3>Métodos de pago</h3>
                <div class="metodos-pago">
                    <i class="fab fa-cc-visa" aria-label="Visa"></i>
                    <i class="fab fa-cc-mastercard" aria-label="MasterCard"></i>
                    <i class="fab fa-cc-amex" aria-label="Amex"></i>
                    <i class="fas fa-money-bill-wave" aria-label="Efectivo"></i>
                </div>
            </div>

            <div class="pedidos-confirmacion" style="display: none; margin-top: 20px; color: green;">
                Pedido enviado exitosamente. ¡Gracias por confiar en nosotros!
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.querySelector('.pedidos-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const confirmacion = document.querySelector('.pedidos-confirmacion');
        const campos = ['nombre', 'direccion', 'telefono', 'producto'];
        const valid = campos.every(c => this[c].value.trim());

        if (!valid) {
            alert('Por favor completa todos los campos obligatorios.');
            return;
        }

        // Simulación de envío
        setTimeout(() => {
            this.reset();
            confirmacion.style.display = 'block';
        }, 500);
    });
</script>
@endsection
