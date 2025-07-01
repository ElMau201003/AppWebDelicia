@extends('layouts.app')

@push('styles')
<style>
    .productos-section {
        padding: 40px 0;
    }

    .productos-section h1 {
        color: #8C4303;
        font-weight: 700;
        text-align: center;
        margin-bottom: 30px;
    }

    .productos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
    }

    .productos-item {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        padding: 15px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .productos-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .productos-item img {
        width: 100%;
        height: 200px; /* puedes ajustar esta altura según tu diseño */
        object-fit: cover;
        object-position: center;
        border-radius: 8px;
        margin-bottom: 15px;
        display: block;
    }


    .productos-item h3 {
        font-size: 1.2rem;
        margin: 10px 0;
        font-weight: 600;
    }

    .productos-item p {
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 10px;
    }

    .precio {
        display: block;
        font-size: 1.1rem;
        font-weight: bold;
        color: #F20530;
        margin-bottom: 10px;
    }

    .agregar-carrito-btn {
        padding: 8px 15px;
        background-color: #8C4303;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        transition: background 0.3s ease, transform 0.2s;
    }

    .agregar-carrito-btn:hover {
        background-color: #F28A2E;
        transform: scale(1.03);
    }

    .agregar-carrito-btn i {
        margin-right: 5px;
    }

    @media (max-width: 576px) {
        .productos-item img {
            height: 140px;
        }
    }
</style>
@endpush

@section('content')
<section class="productos-section">
    <div class="container">
        <h1>Nuestros Productos</h1>
        <div class="productos-grid">
            @foreach($productos as $producto)
                <div class="productos-item">
                    <img src="{{ asset('imagenes/' . $producto->imagen_url) }}" alt="{{ $producto->nombre }}" class="zoom-img">
                    <h3>{{ $producto->nombre }}</h3>
                    <p>{{ $producto->descripcion }}</p>
                    <span class="precio">S/ {{ number_format($producto->precio, 2) }}</span>
                    <button class="agregar-carrito-btn" data-id="{{ $producto->id }}">
                        <i class="fas fa-cart-plus"></i> Agregar al carrito
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.agregar-carrito-btn').forEach(button => {
    button.addEventListener('click', async function () {
        const productoId = this.getAttribute('data-id');

        try {
            const response = await fetch("{{ route('carrito.agregar') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ producto_id: productoId })
            });

            const data = await response.json();

            if (data.success) {
                actualizarContador(data.cantidad);
                mostrarToast('Producto agregado al carrito');
            } else {
                alert('Error al agregar al carrito');
            }
        } catch (error) {
            console.error(error);
            alert('Error de conexión');
        }
    });
});

function actualizarContador(cantidad) {
    const carritoLink = document.querySelector('a[href="{{ route('carrito.ver') }}"]');
    let badge = carritoLink.querySelector('.badge');
    if (!badge) {
        badge = document.createElement('span');
        badge.classList.add('badge', 'bg-danger');
        carritoLink.appendChild(badge);
    }
    badge.textContent = cantidad;
}

function mostrarToast(mensaje) {
    const toast = document.createElement('div');
    toast.textContent = mensaje;
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.right = '20px';
    toast.style.background = '#333';
    toast.style.color = '#fff';
    toast.style.padding = '10px 15px';
    toast.style.borderRadius = '5px';
    toast.style.zIndex = 9999;
    toast.style.opacity = 0.9;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
@endpush
