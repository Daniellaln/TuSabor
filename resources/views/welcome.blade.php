<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TuSabor - Experiencia Gastronómica de Alta Cocina</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/tusabor-modern.css') }}">
    
    <style>
        /* Estilos adicionales específicos para welcome */
        .stats-section {
            background: linear-gradient(135deg, #8B1538 0%, #6B0F2A 100%);
            color: white;
            padding: 4rem 2rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }
        
        .stat-item {
            animation: fadeInUp 1s ease-out;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: #D4AF37;
            font-family: 'Playfair Display', serif;
        }
        
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-top: 0.5rem;
        }
        
        .features-section {
            background: #FAF8F3;
            padding: 5rem 2rem;
        }
        
        .feature-card {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            font-size: 3.5rem;
            color: #D4AF37;
            margin-bottom: 1rem;
        }
        
        .cta-section {
            background: url('{{ asset("images/restaurant-ambiance.jpg") }}') center/cover no-repeat fixed;
            position: relative;
            padding: 6rem 2rem;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(139, 21, 56, 0.9);
        }
        
        .cta-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .cta-content h2 {
            color: white;
            font-size: 3rem;
            margin-bottom: 1.5rem;
        }
        
        .cta-content p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar-modern" id="navbar">
        <div class="navbar-container">
            <a href="/" class="navbar-logo">TuSabor</a>
            <ul class="navbar-menu">
                <li><a href="#inicio" class="navbar-link">Inicio</a></li>
                <li><a href="#servicios" class="navbar-link">Servicios</a></li>
                <li><a href="{{ route('about') }}" class="navbar-link">Nosotros</a></li>
                @auth
                    @if(auth()->user()->isAdmin())
                        <li><a href="{{ route('admin.dashboard') }}" class="navbar-link">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('cliente.catalogo') }}" class="navbar-link">Menú</a></li>
                        <li><a href="{{ route('cliente.carrito') }}" class="navbar-link">
                            <i class="fas fa-shopping-cart"></i> Carrito
                        </a></li>
                    @endif
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-modern btn-primary" style="padding: 0.5rem 1.5rem; font-size: 0.9rem;">
                                Cerrar Sesión
                            </button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="btn-modern btn-primary" style="padding: 0.5rem 1.5rem; font-size: 0.9rem;">Iniciar Sesión</a></li>
                    <li><a href="{{ route('register') }}" class="navbar-link">Registrarse</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="inicio">
        <div class="hero-background" style="background-image: url('{{ asset("images/hero-plato-principal.jpg") }}');"></div>
        <div class="hero-content">
            <h1 class="hero-title">Bienvenido a TuSabor</h1>
            <p class="hero-subtitle">Experiencia gastronómica de alta cocina donde la tradición se encuentra con la innovación</p>
            <div class="hero-buttons">
                @auth
                    @if(auth()->user()->isCliente())
                        <a href="{{ route('cliente.catalogo') }}" class="btn-modern btn-primary">
                            <i class="fas fa-utensils"></i> Ver Menú
                        </a>
                        <a href="{{ route('cliente.reservas.index') }}" class="btn-modern btn-secondary">
                            <i class="fas fa-calendar-alt"></i> Reservar Mesa
                        </a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="btn-modern btn-primary">
                            <i class="fas fa-tachometer-alt"></i> Ir al Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="btn-modern btn-primary">
                        <i class="fas fa-user-plus"></i> Comenzar Ahora
                    </a>
                    <a href="{{ route('login') }}" class="btn-modern btn-secondary">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">500+</div>
                <div class="stat-label">Clientes Satisfechos</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">50+</div>
                <div class="stat-label">Platos Gourmet</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">4.9</div>
                <div class="stat-label">Calificación Promedio</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">100%</div>
                <div class="stat-label">Ingredientes Frescos</div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section features-section" id="servicios">
        <div class="container">
            <h2 class="section-title">Nuestros Servicios</h2>
            <p class="section-subtitle">Experiencias gastronómicas diseñadas para ti</p>
            
            <div class="cards-grid">
                <!-- Menú Gourmet -->
                <div class="card-modern animate-on-scroll">
                    <img src="{{ asset('images/promo-pasta.jpg') }}" alt="Menú Gourmet" class="card-image">
                    <div class="card-content">
                        <div class="feature-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h3 class="card-title">Menú Gourmet</h3>
                        <p class="card-description">
                            Platos elaborados por chefs expertos con ingredientes de primera calidad. 
                            Fusión de tradición e innovación en cada bocado.
                        </p>
                        @auth
                            @if(auth()->user()->isCliente())
                                <a href="{{ route('cliente.catalogo') }}" class="btn-modern btn-primary" style="padding: 0.7rem 1.5rem; font-size: 0.9rem;">
                                    Ver Menú
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="btn-modern btn-primary" style="padding: 0.7rem 1.5rem; font-size: 0.9rem;">
                                Explorar
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Delivery Rápido -->
                <div class="card-modern animate-on-scroll">
                    <img src="{{ asset('images/delivery-food.jpg') }}" alt="Delivery Rápido" class="card-image">
                    <div class="card-content">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h3 class="card-title">Delivery Rápido</h3>
                        <p class="card-description">
                            Recibe tus platillos favoritos en la comodidad de tu hogar. 
                            Empaque premium que mantiene la calidad y temperatura.
                        </p>
                        @auth
                            @if(auth()->user()->isCliente())
                                <a href="{{ route('cliente.catalogo') }}" class="btn-modern btn-primary" style="padding: 0.7rem 1.5rem; font-size: 0.9rem;">
                                    Pedir Ahora
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="btn-modern btn-primary" style="padding: 0.7rem 1.5rem; font-size: 0.9rem;">
                                Ordenar
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Reserva de Mesas -->
                <div class="card-modern animate-on-scroll">
                    <img src="{{ asset('images/restaurant-ambiance.jpg') }}" alt="Reserva de Mesas" class="card-image">
                    <div class="card-content">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="card-title">Reserva de Mesas</h3>
                        <p class="card-description">
                            Sistema de reservas en línea fácil y rápido. 
                            Asegura tu lugar en nuestro elegante comedor.
                        </p>
                        @auth
                            @if(auth()->user()->isCliente())
                                <a href="{{ route('cliente.reservas.index') }}" class="btn-modern btn-primary" style="padding: 0.7rem 1.5rem; font-size: 0.9rem;">
                                    Reservar
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="btn-modern btn-primary" style="padding: 0.7rem 1.5rem; font-size: 0.9rem;">
                                Reservar
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Promo Section -->
    <section class="promo-section">
        <div class="container">
            <h2>¿Listo para una experiencia inolvidable?</h2>
            <p>Descubre por qué somos el restaurante favorito de la clase media que busca elegancia sin pretensiones</p>
            @auth
                @if(auth()->user()->isCliente())
                    <a href="{{ route('cliente.catalogo') }}" class="btn-modern btn-secondary" style="background: white; color: #8B1538;">
                        <i class="fas fa-star"></i> Explorar Menú Completo
                    </a>
                @endif
            @else
                <a href="{{ route('register') }}" class="btn-modern btn-secondary" style="background: white; color: #8B1538;">
                    <i class="fas fa-user-plus"></i> Únete a TuSabor
                </a>
            @endauth
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h2>Cada plato cuenta una historia</h2>
            <p>En TuSabor, combinamos ingredientes frescos, técnicas culinarias innovadoras y pasión por la gastronomía para crear experiencias que van más allá del sabor.</p>
            <a href="{{ route('about') }}" class="btn-modern btn-secondary">
                <i class="fas fa-info-circle"></i> Conoce Nuestra Historia
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-modern">
        <div class="footer-content">
            <div class="footer-section">
                <h3>TuSabor</h3>
                <p>Experiencia gastronómica de alta cocina donde la tradición se encuentra con la innovación.</p>
                <p style="margin-top: 1rem;">
                    <i class="fas fa-map-marker-alt"></i> Av. Principal 123, Ciudad<br>
                    <i class="fas fa-phone"></i> +51 999 888 777<br>
                    <i class="fas fa-envelope"></i> contacto@tusabor.com
                </p>
            </div>
            
            <div class="footer-section">
                <h3>Enlaces Rápidos</h3>
                <a href="{{ route('about') }}">Nosotros</a>
                <a href="{{ route('equipo') }}">Nuestro Equipo</a>
                @auth
                    @if(auth()->user()->isCliente())
                        <a href="{{ route('cliente.catalogo') }}">Menú</a>
                        <a href="{{ route('cliente.reservas.index') }}">Reservas</a>
                    @endif
                @else
                    <a href="{{ route('register') }}">Registrarse</a>
                    <a href="{{ route('login') }}">Iniciar Sesión</a>
                @endauth
            </div>
            
            <div class="footer-section">
                <h3>Horarios</h3>
                <p>Lunes - Viernes: 12:00 PM - 11:00 PM</p>
                <p>Sábados: 11:00 AM - 12:00 AM</p>
                <p>Domingos: 11:00 AM - 10:00 PM</p>
            </div>
            
            <div class="footer-section">
                <h3>Síguenos</h3>
                <p style="font-size: 1.5rem; margin-top: 1rem;">
                    <a href="#" style="margin-right: 1rem;"><i class="fab fa-facebook"></i></a>
                    <a href="#" style="margin-right: 1rem;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="margin-right: 1rem;"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2024 TuSabor - Todos los derechos reservados | Creado por Daniella León Andrés & Harold</p>
        </div>
    </footer>

    <!-- JavaScript para animaciones -->
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Animate on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-on-scroll').forEach(element => {
            observer.observe(element);
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
