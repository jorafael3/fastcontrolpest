<?php
require_once 'config/data_loader.php';
$empresa = empresa();
$servicios = servicios();
$links = links();

// Incluir header
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-primary to-primary-dark text-white py-20">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-bold mb-6">Nuestros Servicios</h1>
        <p class="text-xl max-w-3xl mx-auto">
            Soluciones profesionales para el control integral de plagas con tecnología avanzada y métodos certificados
        </p>
    </div>
</section>

<!-- Services Grid -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($servicios as $key => $servicio): ?>
                <div class="bg-white rounded-xl shadow-elegant hover:shadow-2xl transition-all duration-300 overflow-hidden group animate-on-scroll">
                    <!-- Image -->
                    <div class="relative overflow-hidden h-64">
                        <img src="<?php echo $servicio['imagen']; ?>" alt="<?php echo $servicio['nombre']; ?>" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>
                        
                        <!-- Price Badge -->
                        <div class="absolute top-4 right-4 bg-primary text-white px-3 py-1 rounded-full text-sm font-semibold">
                            Desde $<?php echo $servicio['precio_desde']; ?>
                        </div>
                        
                        <!-- Service Icon -->
                        <div class="absolute bottom-4 left-4 text-white">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-bug text-2xl"></i>
                                <span class="text-sm bg-black bg-opacity-50 px-2 py-1 rounded">
                                    <?php echo $servicio['tiempo_servicio']; ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3"><?php echo $servicio['nombre']; ?></h3>
                        <p class="text-gray-600 mb-4"><?php echo $servicio['descripcion_corta']; ?></p>
                        
                        <!-- Benefits Preview -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-800 mb-2">Beneficios principales:</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <?php foreach(array_slice($servicio['beneficios'], 0, 3) as $beneficio): ?>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        <?php echo $beneficio; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- Service Details -->
                        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                            <div class="bg-gray-50 p-3 rounded-lg text-center">
                                <i class="fas fa-clock text-primary mb-1"></i>
                                <div class="font-semibold">Duración</div>
                                <div class="text-gray-600"><?php echo $servicio['tiempo_servicio']; ?></div>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg text-center">
                                <i class="fas fa-shield-alt text-primary mb-1"></i>
                                <div class="font-semibold">Garantía</div>
                                <div class="text-gray-600"><?php echo $servicio['garantia']; ?></div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <a href="servicio-detalle.php?servicio=<?php echo $key; ?>" 
                               class="w-full btn-primary text-white text-center py-3 rounded-lg font-semibold inline-flex items-center justify-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                Ver Detalles Completos
                            </a>
                            <div class="grid grid-cols-2 gap-2">
                                <a href="<?php echo $links['externos']['whatsapp_web']; ?>&text=Hola, necesito información sobre <?php echo urlencode($servicio['nombre']); ?>" 
                                   target="_blank"
                                   class="bg-green-500 hover:bg-green-600 text-white text-center py-2 rounded-lg font-medium text-sm transition-colors inline-flex items-center justify-center">
                                    <i class="fab fa-whatsapp mr-1"></i>
                                    WhatsApp
                                </a>
                                <!-- Botón de llamar comentado - no funciona desde web
                                <a href="tel:<?php echo $empresa['telefono']; ?>" 
                                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-center py-2 rounded-lg font-medium text-sm transition-colors inline-flex items-center justify-center">
                                    <i class="fas fa-phone mr-1"></i>
                                    Llamar
                                </a>
                                -->
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Service Categories -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Categorías de Servicios</h2>
            <p class="text-xl text-gray-600">Especializados en diferentes tipos de plagas y situaciones</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Residential Services -->
            <div class="text-center p-8 bg-blue-50 rounded-xl animate-on-scroll">
                <div class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-home text-3xl text-white"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Servicios Residenciales</h3>
                <p class="text-gray-600 mb-6">Control de plagas en hogares, apartamentos y condominios con métodos seguros para la familia.</p>
                <ul class="text-left text-gray-600 space-y-2">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Cucarachas y hormigas</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Ratones y roedores</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Termitas y insectos</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Desinfección general</li>
                </ul>
            </div>

            <!-- Commercial Services -->
            <div class="text-center p-8 bg-green-50 rounded-xl animate-on-scroll">
                <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-building text-3xl text-white"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Servicios Comerciales</h3>
                <p class="text-gray-600 mb-6">Soluciones para restaurantes, oficinas, hoteles y centros comerciales.</p>
                <ul class="text-left text-gray-600 space-y-2">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Programas preventivos</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Certificaciones sanitarias</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Monitoreo continuo</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Reportes detallados</li>
                </ul>
            </div>

            <!-- Emergency Services -->
            <div class="text-center p-8 bg-red-50 rounded-xl animate-on-scroll">
                <div class="w-20 h-20 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-exclamation-triangle text-3xl text-white"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Servicios de Emergencia</h3>
                <p class="text-gray-600 mb-6">Atención inmediata para situaciones urgentes las 24 horas del día.</p>
                <ul class="text-left text-gray-600 space-y-2">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Serpientes venenosas</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Enjambres de abejas</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Infestaciones severas</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Respuesta rápida</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 gradient-bg">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8 animate-on-scroll">
        <h2 class="text-4xl font-bold text-white mb-6">¿No Encuentra el Servicio que Necesita?</h2>
        <p class="text-xl text-white opacity-90 mb-8">
            Contáctenos para una consulta personalizada. Nuestros expertos evaluarán su situación específica.
        </p>
        <div class="space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center">
            <a href="contacto.php" 
               class="bg-white text-primary px-8 py-4 rounded-lg text-lg font-semibold inline-flex items-center hover:bg-gray-100 transition-colors">
                <i class="fas fa-envelope mr-3"></i>
                Consulta Personalizada
            </a>
            <!-- Botón de llamar comentado - no funciona desde web
            <a href="tel:<?php echo $empresa['telefono']; ?>" 
               class="bg-white bg-opacity-20 text-white border-2 border-white px-8 py-4 rounded-lg text-lg font-semibold inline-flex items-center hover:bg-white hover:text-primary transition-colors">
                <i class="fas fa-phone mr-3"></i>
                <?php echo $empresa['telefono_display']; ?>
            </a>
            -->
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
