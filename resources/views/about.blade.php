@extends('layouts.cliente')

@section('title', 'Nuestra Historia')

@section('styles')
<style>
    .hero-about {
        background: linear-gradient(rgba(139, 21, 56, 0.85), rgba(139, 21, 56, 0.85)), 
                    url('{{ asset('images/hero-bg.jpg') }}') center/cover;
        min-height: 400px;
        display: flex;
        align-items: center;
        color: white;
    }
    
    .innovation-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        height: 100%;
    }
    
    .innovation-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }
    
    .innovation-icon {
        font-size: 3rem;
        color: #D4AF37;
        margin-bottom: 20px;
    }
    
    .value-card {
        transition: transform 0.3s;
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }
    
    .value-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .value-icon {
        font-size: 3rem;
        color: #D4AF37;
        margin-bottom: 20px;
    }
    
    .tech-badge {
        background: linear-gradient(135deg, #8B1538 0%, #6B0F28 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        display: inline-block;
        margin: 5px;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-about">
    <div class="container text-center">
        <h1 class="display-3 fw-bold mb-3">Nuestra Historia</h1>
        <p class="lead">De un sueño universitario a un sistema inteligente con impacto social</p>
    </div>
</section>

<!-- Historia Personal -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <h2 class="mb-4" style="color: #8B1538;">El Sueño de Daniella</h2>
                <p class="lead">TuSabor nació de una pregunta simple: <strong>¿Por qué es tan difícil encontrar un restaurante que realmente te entienda?</strong></p>
                <p>Durante años, cada vez que salía a comer, me enfrentaba a los mismos problemas: menús rígidos, falta de información sobre ingredientes, experiencias impersonales y restaurantes que no se preocupan por el impacto ambiental.</p>
                <p>Como estudiante de Ingeniería en Sistemas y amante de la buena comida, vi una <strong>oportunidad</strong>: combinar mi pasión por la gastronomía con mis conocimientos en tecnología para crear algo diferente.</p>
                <blockquote class="blockquote mt-4 border-start border-4 ps-3" style="border-color: #D4AF37 !important;">
                    <p class="mb-0 fst-italic">"Quiero crear un restaurante donde la tecnología no reemplace el toque humano, sino que lo amplifique. Donde cada comensal se sienta único."</p>
                    <footer class="blockquote-footer mt-2">Daniella León Andrés, <cite title="Source Title">Fundadora & CEO</cite></footer>
                </blockquote>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('images/hero-bg.jpg') }}" alt="Restaurante TuSabor" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Las 7 Innovaciones -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-3" style="color: #8B1538;">Nuestras 7 Innovaciones Tecnológicas</h2>
        <p class="text-center text-muted mb-5">Lo que nos hace únicos frente a la competencia</p>
        
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card innovation-card shadow-sm p-4 text-center">
                    <i class="fas fa-robot innovation-icon"></i>
                    <h5 style="color: #8B1538;">1. Chatbot con IA Contextual</h5>
                    <p class="text-muted small">No es genérico. Está integrado con nuestra base de datos y conoce todo el negocio en tiempo real.</p>
                    <div class="mt-3">
                        <span class="tech-badge">OpenAI GPT-4</span>
                        <span class="tech-badge">BD Integrada</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card innovation-card shadow-sm p-4 text-center">
                    <i class="fas fa-brain innovation-icon"></i>
                    <h5 style="color: #8B1538;">2. Memoria del Paladar</h5>
                    <p class="text-muted small">Procedimientos almacenados que recuerdan tus preferencias y hacen recomendaciones personalizadas.</p>
                    <div class="mt-3">
                        <span class="tech-badge">7 Stored Procedures</span>
                        <span class="tech-badge">Optimización BD</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card innovation-card shadow-sm p-4 text-center">
                    <i class="fas fa-link innovation-icon"></i>
                    <h5 style="color: #8B1538;">3. Trazabilidad Blockchain-Ready</h5>
                    <p class="text-muted small">Cada producto tiene origen certificado. Sistema preparado para integrar blockchain.</p>
                    <div class="mt-3">
                        <span class="tech-badge">Origen Certificado</span>
                        <span class="tech-badge">Transparencia Total</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card innovation-card shadow-sm p-4 text-center">
                    <i class="fas fa-calendar-check innovation-icon"></i>
                    <h5 style="color: #8B1538;">4. Reservas Inteligentes</h5>
                    <p class="text-muted small">Optimización automática de mesas. No solo guarda fechas, distribuye recursos eficientemente.</p>
                    <div class="mt-3">
                        <span class="tech-badge">Auto-Optimización</span>
                        <span class="tech-badge">Anti-Overbooking</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card innovation-card shadow-sm p-4 text-center">
                    <i class="fas fa-chart-line innovation-icon"></i>
                    <h5 style="color: #8B1538;">5. Dashboard Predictivo</h5>
                    <p class="text-muted small">No solo muestra datos, predice tendencias y sugiere acciones basadas en análisis en tiempo real.</p>
                    <div class="mt-3">
                        <span class="tech-badge">Tiempo Real</span>
                        <span class="tech-badge">Análisis Predictivo</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card innovation-card shadow-sm p-4 text-center">
                    <i class="fas fa-cubes innovation-icon"></i>
                    <h5 style="color: #8B1538;">6. Arquitectura Escalable</h5>
                    <p class="text-muted small">Diseño modular listo para escalar a microservicios cuando el negocio crezca.</p>
                    <div class="mt-3">
                        <span class="tech-badge">Modular</span>
                        <span class="tech-badge">Microservicios-Ready</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card innovation-card shadow-sm p-4 text-center" style="background: linear-gradient(135deg, #8B1538 0%, #6B0F28 100%); color: white;">
                    <i class="fas fa-hands-helping innovation-icon text-white" style="color: white !important;"></i>
                    <h5 class="text-white">7. Impacto Social Automatizado</h5>
                    <p class="small">El 5% a comedores comunitarios no es marketing. Está en el código y se calcula automáticamente en cada pedido.</p>
                    <div class="mt-3">
                        <span class="badge bg-light text-dark">Transparente</span>
                        <span class="badge bg-light text-dark">Medible</span>
                        <span class="badge bg-light text-dark">Automatizado</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Comparación con Competencia -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5" style="color: #8B1538;">¿Qué Nos Hace Diferentes?</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead style="background: #8B1538; color: white;">
                    <tr>
                        <th>Aspecto</th>
                        <th>Competencia</th>
                        <th>TuSabor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Chatbot</strong></td>
                        <td>Genérico, sin contexto</td>
                        <td><span class="badge" style="background: #D4AF37;">IA integrada con BD, contexto rico</span></td>
                    </tr>
                    <tr>
                        <td><strong>Recomendaciones</strong></td>
                        <td>Aleatorias o manuales</td>
                        <td><span class="badge" style="background: #D4AF37;">Basadas en historial (procedimientos almacenados)</span></td>
                    </tr>
                    <tr>
                        <td><strong>Trazabilidad</strong></td>
                        <td>No existe</td>
                        <td><span class="badge" style="background: #D4AF37;">Origen certificado de cada ingrediente</span></td>
                    </tr>
                    <tr>
                        <td><strong>Reservas</strong></td>
                        <td>Sistema simple</td>
                        <td><span class="badge" style="background: #D4AF37;">Optimización automática de mesas</span></td>
                    </tr>
                    <tr>
                        <td><strong>Dashboard</strong></td>
                        <td>Datos básicos</td>
                        <td><span class="badge" style="background: #D4AF37;">Análisis predictivo en tiempo real</span></td>
                    </tr>
                    <tr>
                        <td><strong>Arquitectura</strong></td>
                        <td>Monolítica rígida</td>
                        <td><span class="badge" style="background: #D4AF37;">Modular, escalable a microservicios</span></td>
                    </tr>
                    <tr>
                        <td><strong>Impacto Social</strong></td>
                        <td>Marketing</td>
                        <td><span class="badge" style="background: #D4AF37;">Automatizado, medible, transparente</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- El Equipo Fundador -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5" style="color: #8B1538;">El Equipo Fundador</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #8B1538 0%, #6B0F28 100%) !important;">
                                <i class="fas fa-user-tie fa-2x"></i>
                            </div>
                            <div>
                                <h4 class="mb-0" style="color: #8B1538;">Daniella León Andrés</h4>
                                <p class="text-muted mb-0">Fundadora & CEO</p>
                            </div>
                        </div>
                        <p><strong>Estudiante de Ingeniería en Sistemas</strong> con pasión por la gastronomía y el emprendimiento social.</p>
                        <p class="mb-0"><strong>Rol:</strong> Visión del negocio, diseño de experiencia de usuario, definición de innovaciones y valores de TuSabor.</p>
                        <div class="mt-3">
                            <span class="badge" style="background: #D4AF37;">Visionaria</span>
                            <span class="badge" style="background: #D4AF37;">Emprendedora</span>
                            <span class="badge" style="background: #D4AF37;">UX Designer</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #8B1538 0%, #6B0F28 100%) !important;">
                                <i class="fas fa-code fa-2x"></i>
                            </div>
                            <div>
                                <h4 class="mb-0" style="color: #8B1538;">Harold</h4>
                                <p class="text-muted mb-0">Co-fundador & CTO</p>
                            </div>
                        </div>
                        <p><strong>Desarrollador Full Stack</strong> especializado en Laravel y arquitectura de software.</p>
                        <p class="mb-0"><strong>Rol:</strong> Desarrollo de la plataforma completa, implementación de las 7 innovaciones técnicas, optimización de base de datos.</p>
                        <div class="mt-3">
                            <span class="badge" style="background: #D4AF37;">Laravel Expert</span>
                            <span class="badge" style="background: #D4AF37;">IA Integration</span>
                            <span class="badge" style="background: #D4AF37;">DB Architect</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Valores Fundamentales -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5" style="color: #8B1538;">Nuestros Valores</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card value-card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-laptop-code value-icon"></i>
                        <h4 style="color: #8B1538;">Tecnología con Propósito</h4>
                        <p class="text-muted">Usamos la tecnología para humanizar experiencias, no para deshumanizarlas.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card value-card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-user-check value-icon"></i>
                        <h4 style="color: #8B1538;">Personalización</h4>
                        <p class="text-muted">Cada persona es única y merece una experiencia a su medida.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card value-card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-hands-helping value-icon"></i>
                        <h4 style="color: #8B1538;">Impacto Social</h4>
                        <p class="text-muted">5% de ganancias a comedores comunitarios. Automatizado y transparente.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5" style="background: linear-gradient(135deg, #8B1538 0%, #6B0F28 100%);">
    <div class="container text-center text-white">
        <h2 class="mb-4">Experimenta la Diferencia</h2>
        <p class="lead mb-4">TuSabor no es solo un restaurante, es un sistema inteligente que aprende, optimiza y genera impacto social</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('cliente.catalogo.index') }}" class="btn btn-dorado btn-lg">
                <i class="fas fa-utensils me-2"></i>Explora el Menú
            </a>
            <a href="{{ route('cliente.reservas.index') }}" class="btn btn-outline-light btn-lg">
                <i class="fas fa-calendar-check me-2"></i>Reserva Ahora
            </a>
        </div>
    </div>
</section>
@endsection
