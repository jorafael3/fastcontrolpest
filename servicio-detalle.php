<?php
require_once 'config/data_loader.php';
$empresa = empresa();
$servicios = servicios();
$links = links();
require 'includes/header.php';

// Obtener el servicio solicitado
$servicio_id = $_GET['servicio'] ?? '';

$servicio = null;
if ($servicio_id !== '' && isset($servicios[$servicio_id])) {
    $servicio = $servicios[$servicio_id];
}

// Si no existe el servicio, mostrar error y salir
if (!$servicio) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Servicio no encontrado - <?php echo $empresa['nombre']; ?></title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100">
        <div class="min-h-screen flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center">
                <div class="mb-6">
                    <i class="fas fa-exclamation-triangle text-red-500 text-6xl mb-4"></i>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Servicio No Encontrado</h1>
                    <?php if (empty($servicio_id)): ?>
                        <p class="text-gray-600">No se especificó un servicio.</p>
                    <?php else: ?>
                        <p class="text-gray-600">El servicio "<?php echo htmlspecialchars($servicio_id); ?>" no existe.</p>
                        <p class="text-sm text-gray-500 mt-2">Servicios disponibles: <?php echo implode(', ', array_keys($servicios)); ?></p>
                    <?php endif; ?>
                </div>
                <a href="servicios.php" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition-colors">
                    Ver Todos los Servicios
                </a>
            </div>
        </div>
        <script>
            // Redirigir después de 5 segundos si no estamos en modo debug
            <?php if (!isset($_GET['debug'])): ?>
            setTimeout(function(){ window.location.href='servicios.php'; }, 5000);
            <?php endif; ?>
        </script>
    </body>
    </html>
    <?php
    exit();
}

// Si llegamos aquí, el servicio existe, incluir header y continuar
?>

<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-primary to-primary-dark text-white py-20">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <nav class="text-white text-sm mb-4">
                    <a href="index.php" class="hover:underline">Inicio</a> 
                    <span class="mx-2">/</span>
                    <a href="servicios.php" class="hover:underline">Servicios</a>
                    <span class="mx-2">/</span>
                    <span><?php echo $servicio["nombre"]; ?></span>
                </nav>
                <h1 class="text-5xl font-bold mb-6"><?php echo $servicio['nombre']; ?></h1>
                <p class="text-xl mb-8"><?php echo $servicio['descripcion_larga']; ?></p>
                <div class="flex flex-wrap gap-4">
                    <div class="bg-white bg-opacity-20 px-4 py-2 rounded-lg">
                        <i class="fas fa-clock mr-2"></i>
                        Duración: <?php echo $servicio['tiempo_servicio']; ?>
                    </div>
                    <div class="bg-white bg-opacity-20 px-4 py-2 rounded-lg">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Garantía: <?php echo $servicio['garantia']; ?>
                    </div>
                    <div class="bg-white bg-opacity-20 px-4 py-2 rounded-lg">
                        <i class="fas fa-dollar-sign mr-2"></i>
                        Desde: $<?php echo $servicio['precio_desde']; ?>
                    </div>
                </div>
            </div>
            <div class="relative">
                <img src="<?php echo $servicio['imagen']; ?>" alt="<?php echo $servicio['nombre']; ?>" 
                     class="rounded-xl shadow-2xl w-full h-96 object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-30 rounded-xl"></div>
            </div>
        </div>
    </div>
</section>

<!-- Service Details -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Process Section -->
                <div class="mb-12 animate-on-scroll">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Nuestro Proceso</h2>
                    <div class="space-y-6">
                        <?php foreach($servicio['proceso'] as $index => $paso): ?>
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center font-bold text-lg">
                                    <?php echo $index + 1; ?>
                                </div>
                                <div class="flex-1">
                                    <p class="text-lg text-gray-700"><?php echo $paso; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Benefits Section -->
                <div class="mb-12 animate-on-scroll">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Beneficios del Servicio</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <?php foreach($servicio['beneficios'] as $beneficio): ?>
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-green-600"></i>
                                </div>
                                <p class="text-gray-700"><?php echo $beneficio; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Why Choose This Service -->
                <div class="mb-12 animate-on-scroll">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">¿Por Qué Elegir Este Servicio?</h2>
                    <div class="bg-gray-50 p-8 rounded-xl">
                        <div class="grid md:grid-cols-3 gap-6 text-center">
                            <div>
                                <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-award text-2xl"></i>
                                </div>
                                <h3 class="font-semibold text-gray-900 mb-2">Calidad Garantizada</h3>
                                <p class="text-gray-600 text-sm">Resultados efectivos con garantía de satisfacción</p>
                            </div>
                            <div>
                                <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-leaf text-2xl"></i>
                                </div>
                                <h3 class="font-semibold text-gray-900 mb-2">Eco-Amigable</h3>
                                <p class="text-gray-600 text-sm">Productos seguros para el medio ambiente</p>
                            </div>
                            <div>
                                <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-users text-2xl"></i>
                                </div>
                                <h3 class="font-semibold text-gray-900 mb-2">Expertos Certificados</h3>
                                <p class="text-gray-600 text-sm">Personal técnico altamente capacitado</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Quick Contact Card -->
                <div class="glass-effect rounded-xl p-6 mb-8 sticky top-24 animate-on-scroll">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Solicitar Este Servicio</h3>
                    <div class="space-y-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary">$<?php echo $servicio['precio_desde']; ?>+</div>
                            <div class="text-gray-600">Precio desde</div>
                        </div>
                        
                        <div class="space-y-3">
                            <a href="<?php echo $links['externos']['whatsapp_web']; ?>&text=Hola, necesito el servicio de <?php echo urlencode($servicio['nombre']); ?>. ¿Podrían darme más información?" 
                               target="_blank"
                               class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-lg font-semibold text-center inline-flex items-center justify-center transition-colors">
                                <i class="fab fa-whatsapp mr-2"></i>
                                Consultar por WhatsApp
                            </a>
                            
                            <!-- Botón de llamar comentado - no funciona desde web
                            <a href="tel:<?php echo $empresa['telefono']; ?>" 
                               class="w-full btn-primary text-white py-3 rounded-lg font-semibold text-center inline-flex items-center justify-center">
                                <i class="fas fa-phone mr-2"></i>
                                Llamar Ahora
                            </a>
                            -->
                            
                            <a href="contacto.php?servicio=<?php echo $servicio_id; ?>" 
                               class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded-lg font-semibold text-center inline-flex items-center justify-center transition-colors">
                                <i class="fas fa-envelope mr-2"></i>
                                Solicitar Cotización
                            </a>
                        </div>

                        <div class="border-t pt-4 mt-4">
                            <div class="text-sm text-gray-600 space-y-2">
                                <div class="flex justify-between">
                                    <span>Tiempo de servicio:</span>
                                    <span class="font-medium"><?php echo $servicio['tiempo_servicio']; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Garantía:</span>
                                    <span class="font-medium"><?php echo $servicio['garantia']; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Disponibilidad:</span>
                                    <span class="font-medium text-green-600">Inmediata</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Other Services -->
                <div class="bg-white rounded-xl shadow-elegant p-6 animate-on-scroll">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Otros Servicios</h3>
                    <div class="space-y-3">
                        <?php 
                        $otros_servicios = array_filter($servicios, function($key) use ($servicio_id) {
                            return $key !== $servicio_id;
                        }, ARRAY_FILTER_USE_KEY);
                        $otros_servicios = array_slice($otros_servicios, 0, 5, true);
                        foreach($otros_servicios as $key => $otro_servicio): 
                        ?>
                            <a href="servicio-detalle.php?servicio=<?php echo $key; ?>" 
                               class="block p-3 border border-gray-200 rounded-lg hover:border-primary hover:bg-primary hover:text-white transition-all group">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium"><?php echo $otro_servicio['nombre']; ?></span>
                                    <span class="text-xs bg-gray-100 group-hover:bg-white group-hover:text-primary px-2 py-1 rounded">
                                        $<?php echo $otro_servicio['precio_desde']; ?>+
                                    </span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-4">
                        <a href="servicios.php" class="text-primary hover:underline text-sm">
                            Ver todos los servicios →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Preguntas Frecuentes</h2>
            <p class="text-gray-600">Respuestas a las preguntas más comunes sobre este servicio</p>
        </div>

        <div class="space-y-6">
            <?php 
            $faqs = [
                "¿Es seguro este tratamiento?" => "Sí, utilizamos productos certificados y seguros para personas, mascotas y el medio ambiente. Nuestros técnicos están capacitados en el manejo seguro de todos los productos.",
                "¿Cuánto tiempo dura el efecto?" => "La duración del tratamiento varía según el tipo de servicio, pero generalmente ofrecemos garantía de {$servicio['garantia']} para este servicio específico.",
                "¿Necesito salir de casa durante el tratamiento?" => "En la mayoría de casos no es necesario, pero nuestro técnico le dará instrucciones específicas según el tipo de tratamiento a realizar.",
                "¿Cuándo veré resultados?" => "Los resultados suelen verse dentro de las primeras 24-48 horas, aunque algunos tratamientos pueden tomar un poco más de tiempo para ser completamente efectivos."
            ];
            foreach($faqs as $pregunta => $respuesta): 
            ?>
                <div class="bg-white rounded-lg shadow-md animate-on-scroll">
                    <button class="w-full px-6 py-4 text-left focus:outline-none faq-toggle" data-target="faq-<?php echo md5($pregunta); ?>">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900"><?php echo $pregunta; ?></h3>
                            <i class="fas fa-chevron-down text-gray-400 transform transition-transform faq-icon"></i>
                        </div>
                    </button>
                    <div class="px-6 pb-4 hidden faq-content" id="faq-<?php echo md5($pregunta); ?>">
                        <p class="text-gray-600"><?php echo $respuesta; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 gradient-bg">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8 animate-on-scroll">
        <h2 class="text-4xl font-bold text-white mb-6">¿Listo para Solucionar su Problema de Plagas?</h2>
        <p class="text-xl text-white opacity-90 mb-8">
            Contáctenos ahora y reciba atención inmediata de nuestros especialistas certificados
        </p>
        <div class="space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center">
            <a href="<?php echo $links['externos']['whatsapp_web']; ?>&text=Necesito el servicio de <?php echo urlencode($servicio['nombre']); ?>. ¿Pueden ayudarme?" 
               target="_blank"
               class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg text-lg font-semibold inline-flex items-center transition-colors">
                <i class="fab fa-whatsapp mr-3"></i>
                WhatsApp Inmediato
            </a>
            <!-- Botón de llamar comentado - no funciona desde web
            <a href="tel:<?php echo $empresa['telefono']; ?>" 
               class="bg-white text-primary px-8 py-4 rounded-lg text-lg font-semibold inline-flex items-center hover:bg-gray-100 transition-colors">
                <i class="fas fa-phone mr-3"></i>
                <?php echo $empresa['telefono_display']; ?>
            </a>
            -->
        </div>
    </div>
</section>

<script>
// FAQ Toggle functionality
document.querySelectorAll('.faq-toggle').forEach(button => {
    button.addEventListener('click', () => {
        const targetId = button.dataset.target;
        const content = document.getElementById(targetId);
        const icon = button.querySelector('.faq-icon');
        
        content.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    });
});
</script>

<?php include 'includes/footer.php'; ?>
