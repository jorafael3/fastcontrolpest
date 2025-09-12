<?php
// Cargar configuraciones
$empresa = include 'config/empresa.php';
$servicios = include 'config/servicios.php';
$links = include 'config/links.php';

// Incluir header
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-primary to-primary-dark text-white py-20">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-bold mb-6">Nuestra Empresa</h1>
        <p class="text-xl max-w-3xl mx-auto">
            Conoce más sobre <?php echo $empresa['nombre']; ?> y nuestro compromiso con el control profesional de plagas
        </p>
    </div>
</section>

<!-- Company Overview -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="animate-on-scroll">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">¿Quiénes Somos?</h2>
                <p class="text-lg text-gray-600 mb-6">
                    <?php echo $empresa['nombre']; ?> es una empresa líder en control de plagas urbanas en Ecuador, 
                    especializada en brindar soluciones integrales con los más altos estándares de calidad y seguridad.
                </p>
                <p class="text-lg text-gray-600 mb-6">
                    Con años de experiencia en el mercado, nos hemos consolidado como la opción preferida por hogares 
                    y empresas que buscan servicios profesionales, seguros y efectivos para el control de plagas.
                </p>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="text-center p-6 bg-primary text-white rounded-lg">
                        <div class="text-3xl font-bold mb-2">500+</div>
                        <div class="text-sm">Clientes Satisfechos</div>
                    </div>
                    <div class="text-center p-6 bg-gray-100 rounded-lg">
                        <div class="text-3xl font-bold mb-2 text-primary">100%</div>
                        <div class="text-sm text-gray-600">Garantía de Satisfacción</div>
                    </div>
                </div>
            </div>
            <div class="animate-on-scroll">
                <img src="<?php echo $links['carrusel_imagenes'][0]; ?>" alt="Equipo de trabajo" 
                     class="rounded-xl shadow-2xl w-full h-96 object-cover">
            </div>
        </div>
    </div>
</section>

<!-- Mission and Vision -->
<section class="py-20 bg-gray-50" id="mision-vision">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Misión y Visión</h2>
            <p class="text-xl text-gray-600">Los pilares que guían nuestro trabajo diario</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Mission -->
            <div class="bg-white p-8 rounded-xl shadow-elegant animate-on-scroll">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bullseye text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Nuestra Misión</h3>
                </div>
                <p class="text-gray-600 text-lg leading-relaxed text-center">
                    "<?php echo $empresa['mision']; ?>"
                </p>
            </div>

            <!-- Vision -->
            <div class="bg-white p-8 rounded-xl shadow-elegant animate-on-scroll">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-eye text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Nuestra Visión</h3>
                </div>
                <p class="text-gray-600 text-lg leading-relaxed text-center">
                    "<?php echo $empresa['vision']; ?>"
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Nuestros Valores</h2>
            <p class="text-xl text-gray-600">Los principios que nos definen como empresa</p>
        </div>

        <div class="grid md:grid-cols-3 lg:grid-cols-5 gap-8">
            <?php 
            $iconos_valores = [
                'Calidad' => 'fas fa-award',
                'Seguridad' => 'fas fa-shield-alt', 
                'Confianza' => 'fas fa-handshake',
                'Experiencia' => 'fas fa-graduation-cap',
                'Innovación' => 'fas fa-lightbulb'
            ];
            foreach($empresa['valores'] as $valor => $descripcion): 
            ?>
                <div class="text-center animate-on-scroll">
                    <div class="w-20 h-20 bg-gradient-to-br from-primary to-primary-dark text-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="<?php echo $iconos_valores[$valor]; ?> text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3"><?php echo $valor; ?></h3>
                    <p class="text-gray-600 text-sm"><?php echo $descripcion; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Certifications -->
<section class="py-20 bg-gray-50" id="certificaciones">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Certificaciones y Licencias</h2>
            <p class="text-xl text-gray-600">Cumplimos con todos los estándares de calidad y seguridad</p>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-elegant">
            <div class="grid md:grid-cols-2 gap-8">
                <?php foreach($empresa['certificaciones'] as $cert): ?>
                    <div class="flex items-center space-x-4 animate-on-scroll">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-certificate text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900"><?php echo $cert; ?></h3>
                            <p class="text-gray-600 text-sm">Certificación vigente y verificada</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Locations -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Nuestras Ubicaciones</h2>
            <p class="text-xl text-gray-600">Estamos cerca de usted para brindarle el mejor servicio</p>
        </div>

        <div class="grid md:grid-cols-2 gap-12">
            <?php foreach($empresa['direcciones'] as $ubicacion): ?>
                <div class="bg-gray-50 p-8 rounded-xl animate-on-scroll">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-map-marker-alt text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900"><?php echo $ubicacion['ciudad']; ?></h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-home text-primary mt-1"></i>
                            <div>
                                <p class="font-semibold text-gray-900"><?php echo $ubicacion['direccion']; ?></p>
                                <p class="text-gray-600 text-sm"><?php echo $ubicacion['referencia']; ?></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-phone text-primary"></i>
                            <span class="text-gray-700"><?php echo $empresa['telefono_display']; ?></span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-primary"></i>
                            <span class="text-gray-700"><?php echo $empresa['email']; ?></span>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="<?php echo $empresa['redes']['google_maps']; ?>" target="_blank"
                           class="w-full btn-primary text-white py-3 rounded-lg font-semibold text-center inline-flex items-center justify-center">
                            <i class="fas fa-directions mr-2"></i>
                            Ver en Mapa
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Nuestro Equipo</h2>
            <p class="text-xl text-gray-600">Profesionales certificados comprometidos con la excelencia</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center bg-white p-8 rounded-xl shadow-elegant animate-on-scroll">
                <div class="w-24 h-24 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-user-tie text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Técnicos Certificados</h3>
                <p class="text-gray-600">Personal altamente capacitado con certificaciones nacionales e internacionales en control de plagas.</p>
            </div>

            <div class="text-center bg-white p-8 rounded-xl shadow-elegant animate-on-scroll">
                <div class="w-24 h-24 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-headset text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Atención al Cliente</h3>
                <p class="text-gray-600">Equipo dedicado a brindar la mejor experiencia y resolver todas sus consultas de manera eficiente.</p>
            </div>

            <div class="text-center bg-white p-8 rounded-xl shadow-elegant animate-on-scroll">
                <div class="w-24 h-24 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-cogs text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Soporte Técnico</h3>
                <p class="text-gray-600">Especialistas en diagnóstico y solución de problemas complejos de infestación de plagas.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 gradient-bg">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8 animate-on-scroll">
        <h2 class="text-4xl font-bold text-white mb-6">¿Quiere Formar Parte de Nuestro Equipo?</h2>
        <p class="text-xl text-white opacity-90 mb-8">
            Estamos siempre en búsqueda de profesionales comprometidos con la excelencia
        </p>
        <div class="space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center">
            <a href="contacto.php" 
               class="bg-white text-primary px-8 py-4 rounded-lg text-lg font-semibold inline-flex items-center hover:bg-gray-100 transition-colors">
                <i class="fas fa-envelope mr-3"></i>
                Enviar CV
            </a>
            <!-- Botón de llamar comentado - no funciona desde web
            <a href="tel:<?php echo $empresa['telefono']; ?>" 
               class="bg-white bg-opacity-20 text-white border-2 border-white px-8 py-4 rounded-lg text-lg font-semibold inline-flex items-center hover:bg-white hover:text-primary transition-colors">
                <i class="fas fa-phone mr-3"></i>
                Consultar Vacantes
            </a>
            -->
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
