@extends('layouts.cliente')

@section('title', 'Nuestro Equipo')

@section('styles')
<style>
    .hero-team {
        background: linear-gradient(rgba(139, 21, 56, 0.85), rgba(139, 21, 56, 0.85)), 
                    url('{{ asset('images/hero-bg.jpg') }}') center/cover;
        min-height: 350px;
        display: flex;
        align-items: center;
        color: white;
    }
    
    .team-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
    }
    
    .team-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }
    
    .achievement-badge {
        background: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        display: inline-block;
        margin: 5px;
    }
    
    .icon-circle {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: linear-gradient(135deg, #8B1538 0%, #6B0F28 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-team">
    <div class="container text-center">
        <h1 class="display-3 fw-bold mb-3">Nuestro Equipo</h1>
        <p class="lead">Dos estudiantes con un sueño: transformar la experiencia gastronómica con tecnología</p>
    </div>
</section>

<!-- Equipo Fundador -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="color: #8B1538;">Los Fundadores</h2>
            <p class="lead text-muted">De un proyecto universitario a una visión empresarial con 7 innovaciones técnicas</p>
        </div>
        
        <div class="row g-4 mb-5">
            <!-- Daniella -->
            <div class="col-md-6">
                <div class="card team-card shadow-sm p-4">
                    <div class="icon-circle">
                        <i class="fas fa-user-tie fa-4x text-white"></i>
                    </div>
                    <h4 class="text-center" style="color: #8B1538;">Daniella León Andrés</h4>
                    <p class="text-muted text-center mb-3"><strong>Fundadora & CEO</strong></p>
                    <div class="text-center mb-3">
                        <span class="achievement-badge"><i class="fas fa-graduation-cap me-1"></i>Ing. Sistemas</span>
                        <span class="achievement-badge"><i class="fas fa-lightbulb me-1"></i>Visionaria</span>
                        <span class="achievement-badge"><i class="fas fa-heart me-1"></i>Emprendedora Social</span>
                    </div>
                    <p class="text-center">Estudiante de Ingeniería en Sistemas con pasión por la gastronomía y el emprendimiento social. Creadora de la visión de TuSabor: un restaurante donde la tecnología humaniza experiencias.</p>
                    
                    <div class="mt-4">
                        <h6 style="color: #8B1538;"><i class="fas fa-check-circle me-2"></i>Responsabilidades:</h6>
                        <ul class="small">
                            <li>Conceptualización de las 7 innovaciones</li>
                            <li>Diseño de experiencia de usuario</li>
                            <li>Definición de valores y propósito</li>
                            <li>Estrategia de sostenibilidad e impacto social</li>
                            <li>Branding e identidad visual</li>
                        </ul>
                    </div>
                    
                    <blockquote class="blockquote-footer text-center mt-3 fst-italic">
                        "Quiero demostrar que la tecnología puede servir a las personas, no al revés"
                    </blockquote>
                </div>
            </div>
            
            <!-- Harold -->
            <div class="col-md-6">
                <div class="card team-card shadow-sm p-4">
                    <div class="icon-circle">
                        <i class="fas fa-code fa-4x text-white"></i>
                    </div>
                    <h4 class="text-center" style="color: #8B1538;">Harold</h4>
                    <p class="text-muted text-center mb-3"><strong>Co-fundador & CTO</strong></p>
                    <div class="text-center mb-3">
                        <span class="achievement-badge"><i class="fas fa-code me-1"></i>Laravel Expert</span>
                        <span class="achievement-badge"><i class="fas fa-database me-1"></i>DB Architect</span>
                        <span class="achievement-badge"><i class="fas fa-robot me-1"></i>IA Integration</span>
                    </div>
                    <p class="text-center">Desarrollador Full Stack especializado en Laravel y arquitectura de software. Responsable de convertir la visión de TuSabor en código funcional y elegante.</p>
                    
                    <div class="mt-4">
                        <h6 style="color: #8B1538;"><i class="fas fa-check-circle me-2"></i>Responsabilidades:</h6>
                        <ul class="small">
                            <li>Desarrollo completo en Laravel (MVC)</li>
                            <li>Arquitectura e implementación de base de datos</li>
                            <li>Creación de 7 procedimientos almacenados</li>
                            <li>Integración de chatbot con OpenAI</li>
                            <li>Sistema de autenticación y autorización</li>
                        </ul>
                    </div>
                    
                    <blockquote class="blockquote-footer text-center mt-3 fst-italic">
                        "El código bien escrito es como una buena receta: cada línea tiene un propósito"
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- La Sinergia -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5" style="color: #8B1538;">La Sinergia Perfecta</h2>
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 style="color: #8B1538;">De Compañeros de Clase a Socios</h4>
                <p>Daniella y Harold se conocieron en la clase de Base de Datos Avanzada. Cuando el profesor asignó un proyecto para diseñar un sistema de gestión para restaurante, Daniella vio más que una tarea académica: vio una oportunidad.</p>
                <p>Le propuso a Harold convertir el proyecto en algo real, con innovaciones que pudieran defenderse frente a competidores establecidos. Él, que siempre había querido aplicar sus conocimientos a algo tangible, aceptó sin dudarlo.</p>
                <p class="mb-0">Así nació TuSabor: de la combinación perfecta entre <strong>visión</strong> y <strong>ejecución</strong>, entre <strong>sueño</strong> y <strong>código</strong>.</p>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-4" style="background: linear-gradient(135deg, #8B1538 0%, #6B0F28 100%); color: white;">
                    <h5 class="mb-4"><i class="fas fa-handshake me-2"></i>División de Trabajo</h5>
                    <div class="row">
                        <div class="col-6">
                            <h6 style="color: #D4AF37;">Daniella aporta:</h6>
                            <ul class="list-unstyled small">
                                <li><i class="fas fa-check me-2"></i>Visión de negocio</li>
                                <li><i class="fas fa-check me-2"></i>Diseño UX/UI</li>
                                <li><i class="fas fa-check me-2"></i>Innovaciones</li>
                                <li><i class="fas fa-check me-2"></i>Valores</li>
                                <li><i class="fas fa-check me-2"></i>Estrategia</li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <h6 style="color: #D4AF37;">Harold aporta:</h6>
                            <ul class="list-unstyled small">
                                <li><i class="fas fa-check me-2"></i>Laravel MVC</li>
                                <li><i class="fas fa-check me-2"></i>Arquitectura BD</li>
                                <li><i class="fas fa-check me-2"></i>7 Stored Procedures</li>
                                <li><i class="fas fa-check me-2"></i>Integración IA</li>
                                <li><i class="fas fa-check me-2"></i>Optimización</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filosofía de Trabajo -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5" style="color: #8B1538;">Nuestra Filosofía de Trabajo</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-users fa-3x" style="color: #D4AF37;"></i>
                    </div>
                    <h5 style="color: #8B1538;">Colaboración</h5>
                    <p class="text-muted">Trabajamos juntos, combinando nuestras fortalezas para crear algo más grande que la suma de las partes.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-rocket fa-3x" style="color: #D4AF37;"></i>
                    </div>
                    <h5 style="color: #8B1538;">Innovación</h5>
                    <p class="text-muted">No nos conformamos con lo convencional. Creamos 7 innovaciones técnicas defendibles.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-heart fa-3x" style="color: #D4AF37;"></i>
                    </div>
                    <h5 style="color: #8B1538;">Propósito</h5>
                    <p class="text-muted">Cada línea de código, cada decisión de diseño, tiene un propósito: crear experiencias memorables.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visión a Futuro -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5" style="color: #8B1538;">Nuestra Visión a Futuro</h2>
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 style="color: #8B1538;">Más Allá del Proyecto Académico</h4>
                <p>Aunque TuSabor comenzó como un proyecto para la clase de Base de Datos Avanzada, nuestra visión va mucho más allá de una calificación.</p>
                <p><strong>Queremos:</strong></p>
                <ul>
                    <li>Convertir TuSabor en un restaurante real</li>
                    <li>Demostrar que la tecnología puede humanizar experiencias</li>
                    <li>Crear un modelo de negocio sostenible y con impacto social</li>
                    <li>Licenciar nuestra plataforma a otros restaurantes</li>
                    <li>Inspirar a otros estudiantes a convertir sus proyectos en realidades</li>
                </ul>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-lg p-4" style="background: linear-gradient(135deg, #8B1538 0%, #6B0F28 100%); color: white;">
                    <h4 class="mb-3">Nuestro Compromiso</h4>
                    <p class="mb-0 fst-italic">"TuSabor es nuestra forma de demostrar que los estudiantes no solo aprendemos teoría, sino que podemos crear soluciones reales con innovaciones defendibles que impacten positivamente en el mundo. Este es solo el comienzo de nuestro viaje emprendedor."</p>
                    <div class="text-end mt-3">
                        <small>- Daniella & Harold</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5" style="background: linear-gradient(135deg, #8B1538 0%, #6B0F28 100%);">
    <div class="container text-center text-white">
        <h2 class="mb-4">¿Quieres Saber Más?</h2>
        <p class="lead mb-4">Conoce nuestras 7 innovaciones tecnológicas que nos diferencian de la competencia</p>
        <a href="{{ route('about') }}" class="btn btn-dorado btn-lg">
            <i class="fas fa-lightbulb me-2"></i>Ver Innovaciones
        </a>
    </div>
</section>
@endsection
