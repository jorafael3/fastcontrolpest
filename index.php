<?php
// Cargar configuraciones
$empresa = include 'config/empresa.php';
$servicios = include 'config/servicios.php';
$links = include 'config/links.php';

// Incluir header
include 'includes/header.php';
?>

<!-- Hero Section with Carousel -->
<section class="relative h-screen overflow-hidden">
    <div class="carousel-container relative w-full h-full">
        <?php foreach($links['carrusel_imagenes'] as $index => $imagen): ?>
            <div class="carousel-slide <?php echo $index === 0 ? 'active' : ''; ?> absolute inset-0 transition-opacity duration-1000 ease-in-out">
                <div class="absolute inset-0 bg-black bg-opacity-50 z-10"></div>
                <img src="<?php echo $imagen; ?>" alt="Control de Plagas" class="w-full h-full object-cover">
                <div class="absolute inset-0 z-20 flex items-center justify-center">
                    <div class="text-center text-white max-w-4xl mx-auto px-4">
                        <h1 class="text-5xl md:text-7xl font-bold mb-6 animate-fade-in-up">
                            <?php echo $empresa['nombre']; ?>
                        </h1>
                        <p class="text-xl md:text-2xl mb-8 animate-fade-in-up animation-delay-300">
                            <?php echo $empresa['slogan']; ?>
                        </p>
                        <p class="text-lg mb-10 max-w-2xl mx-auto animate-fade-in-up animation-delay-600">
                            <?php echo $empresa['descripcion']; ?>
                        </p>
                        <div class="space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center animate-fade-in-up animation-delay-900">
                            <a href="contacto.php" class="btn-primary text-white px-8 py-4 rounded-lg text-lg font-semibold inline-flex items-center">
                                <i class="fas fa-calendar-check mr-3"></i>
                                Solicitar Cotización
                            </a>
                            <!-- Botón de llamar comentado - no funciona desde web
                            <a href="tel:<?php echo $empresa['telefono']; ?>" class="bg-white text-primary px-8 py-4 rounded-lg text-lg font-semibold inline-flex items-center hover:bg-gray-100 transition-colors">
                                <i class="fas fa-phone mr-3"></i>
                                <?php echo $empresa['telefono_display']; ?>
                            </a>
                            -->
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Carousel Navigation -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-30 flex space-x-3">
        <?php foreach($links['carrusel_imagenes'] as $index => $imagen): ?>
            <button class="carousel-dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-75 transition-all <?php echo $index === 0 ? 'bg-opacity-100' : ''; ?>" 
                    data-slide="<?php echo $index; ?>"></button>
        <?php endforeach; ?>
    </div>
</section>

<!-- Services Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Nuestros Servicios</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Ofrecemos soluciones integrales para el control de plagas con tecnología avanzada y métodos seguros
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php 
            $servicios_destacados = array_slice($servicios, 0, 8, true);
            foreach($servicios_destacados as $key => $servicio): 
            ?>
                <div class="group bg-white rounded-xl shadow-elegant hover:shadow-2xl transition-all duration-300 overflow-hidden animate-on-scroll">
                    <div class="relative overflow-hidden">
                        <img src="<?php echo $servicio['imagen']; ?>" alt="<?php echo $servicio['nombre']; ?>" 
                             class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <div class="text-2xl font-bold">$<?php echo $servicio['precio_desde']; ?>+</div>
                            <div class="text-sm">Desde</div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3"><?php echo $servicio['nombre']; ?></h3>
                        <p class="text-gray-600 mb-4 text-sm"><?php echo $servicio['descripcion_corta']; ?></p>
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                <i class="fas fa-clock mr-1"></i>
                                <?php echo $servicio['tiempo_servicio']; ?>
                            </div>
                            <a href="servicio-detalle.php?servicio=<?php echo $key; ?>" 
                               class="text-primary hover:text-primary-dark font-semibold transition-colors">
                                Ver Más <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-12 animate-on-scroll">
            <a href="servicios.php" class="btn-primary text-white px-8 py-4 rounded-lg text-lg font-semibold inline-flex items-center">
                <i class="fas fa-list mr-3"></i>
                Ver Todos los Servicios
            </a>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-20 gradient-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold text-white mb-4">¿Por Qué Elegirnos?</h2>
            <p class="text-xl text-white opacity-90 max-w-3xl mx-auto">
                Somos líderes en control de plagas con años de experiencia y resultados garantizados
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php 
            $caracteristicas = [
                [
                    'icono' => 'fas fa-shield-alt',
                    'titulo' => 'Métodos Seguros',
                    'descripcion' => 'Utilizamos productos certificados y seguros para su familia y mascotas'
                ],
                [
                    'icono' => 'fas fa-clock',
                    'titulo' => 'Servicio Rápido',
                    'descripcion' => 'Respuesta inmediata y soluciones efectivas en el menor tiempo posible'
                ],
                [
                    'icono' => 'fas fa-certificate',
                    'titulo' => 'Certificados',
                    'descripcion' => 'Personal técnico certificado y productos con registro sanitario'
                ],
                [
                    'icono' => 'fas fa-handshake',
                    'titulo' => 'Garantía Total',
                    'descripcion' => 'Todos nuestros servicios incluyen garantía de satisfacción'
                ]
            ];
            foreach($caracteristicas as $caracteristica): 
            ?>
                <div class="text-center text-white animate-on-scroll">
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                        <i class="<?php echo $caracteristica['icono']; ?> text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4"><?php echo $caracteristica['titulo']; ?></h3>
                    <p class="opacity-90"><?php echo $caracteristica['descripcion']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gray-100">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8 animate-on-scroll">
        <h2 class="text-4xl font-bold text-gray-900 mb-6">¿Necesita Control de Plagas Urgente?</h2>
        <p class="text-xl text-gray-600 mb-8">
            Contáctenos ahora y reciba una cotización gratuita. Nuestros especialistas están listos para ayudarle.
        </p>
        <div class="space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center">
            <a href="<?php echo $links['externos']['whatsapp_web']; ?>" target="_blank"
               class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg text-lg font-semibold inline-flex items-center transition-colors">
                <i class="fab fa-whatsapp mr-3"></i>
                WhatsApp
            </a>
            <!-- Botón de llamar comentado - no funciona desde web
            <a href="tel:<?php echo $empresa['telefono']; ?>" 
               class="btn-primary text-white px-8 py-4 rounded-lg text-lg font-semibold inline-flex items-center">
                <i class="fas fa-phone mr-3"></i>
                Llamar Ahora
            </a>
            -->
            <a href="contacto.php" 
               class="bg-white text-primary border-2 border-primary px-8 py-4 rounded-lg text-lg font-semibold inline-flex items-center hover:bg-primary hover:text-white transition-colors">
                <i class="fas fa-envelope mr-3"></i>
                Contacto
            </a>
        </div>
    </div>
</section>

<script>
// Carousel functionality
let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-slide');
const dots = document.querySelectorAll('.carousel-dot');

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.toggle('active', i === index);
        slide.style.opacity = i === index ? '1' : '0';
    });
    
    dots.forEach((dot, i) => {
        dot.classList.toggle('bg-opacity-100', i === index);
        dot.classList.toggle('bg-opacity-50', i !== index);
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
}

// Auto-advance carousel
setInterval(nextSlide, 5000);

// Dot click handlers
dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        currentSlide = index;
        showSlide(currentSlide);
    });
});

// Animation delays
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.animation-delay-300');
    elements.forEach(el => {
        el.style.animationDelay = '0.3s';
    });
    
    const elements600 = document.querySelectorAll('.animation-delay-600');
    elements600.forEach(el => {
        el.style.animationDelay = '0.6s';
    });
    
    const elements900 = document.querySelectorAll('.animation-delay-900');
    elements900.forEach(el => {
        el.style.animationDelay = '0.9s';
    });
});
</script>

<style>
.animate-fade-in-up {
    animation: fadeInUp 1s ease-out forwards;
    opacity: 0;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<?php include 'includes/footer.php'; ?>
