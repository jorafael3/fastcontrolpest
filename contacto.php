<?php
require_once 'config/data_loader.php';
$empresa = empresa();
$servicios = servicios();
$links = links();

// Procesamiento del formulario
$mensaje_enviado = false;
$error_envio = false;
$servicio_seleccionado = $_GET['servicio'] ?? '';

if ($_POST) {
    include 'includes/mail.php';

    // $resultado_envio = Prueba_Correo();
    // $resultado_confirmacion = enviarCorreoConfirmacion($_POST['email'], $_POST['nombre']);
    // $mensaje_error_envio = null;
    // // var_dump($resultado_envio);
    // if (is_array($resultado_envio) && $resultado_envio[0]) {
    //     $mensaje_enviado = true;
    // } else {
    //     $error_envio = true;
    //     $mensaje_error_envio = is_array($resultado_envio) ? $resultado_envio[1] : '';
    // }

    $error_envio = true;
}

// Incluir header
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-primary to-primary-dark text-white py-20">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-bold mb-6">Contáctanos</h1>
        <p class="text-xl max-w-3xl mx-auto">
            Estamos aquí para ayudarte. Contáctanos para recibir una cotización gratuita o resolver cualquier consulta
        </p>
    </div>
</section>

<?php if ($mensaje_enviado): ?>
    <!-- Success Message -->
    <section class="py-8 bg-green-50 border-l-4 border-green-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400 text-2xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-green-800">¡Mensaje enviado correctamente!</h3>
                    <p class="text-green-700">Hemos recibido tu consulta. Nuestro equipo se pondrá en contacto contigo en las próximas horas.</p>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if ($error_envio): ?>
    <!-- Error Message -->
    <section class="py-8 bg-red-50 border-l-4 border-red-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-red-800">Error al enviar el mensaje</h3>
                    <p class="text-red-700">Hubo un problema al enviar tu consulta. Por favor, intenta nuevamente o contáctanos por teléfono.</p>
                    <?php if (!empty($mensaje_error_envio)): ?>
                        <div class="mt-2 p-3 bg-red-100 text-red-800 rounded">
                            <strong>Detalle técnico:</strong> <?php echo htmlspecialchars($mensaje_error_envio); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Contact Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white rounded-xl shadow-elegant p-8 animate-on-scroll">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Envíanos un Mensaje</h2>
                <p class="text-gray-600 mb-8">
                    Completa el formulario y nuestros especialistas te contactarán para ofrecerte la mejor solución.
                </p>

                <form method="POST" action="" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo *</label>
                            <input type="text" id="nombre" name="nombre" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary transition-colors"
                                placeholder="Tu nombre completo">
                        </div>
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                            <input type="tel" id="telefono" name="telefono" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary transition-colors"
                                placeholder="Tu número de teléfono">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico *</label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary transition-colors"
                            placeholder="tu@email.com">
                    </div>

                    <div>
                        <label for="servicio" class="block text-sm font-medium text-gray-700 mb-2">Servicio de Interés</label>
                        <select id="servicio" name="servicio"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary transition-colors">
                            <option value="">Selecciona un servicio</option>
                            <?php foreach ($servicios as $key => $servicio): ?>
                                <option value="<?php echo $servicio['nombre']; ?>"
                                    <?php echo ($servicio_seleccionado === $key) ? 'selected' : ''; ?>>
                                    <?php echo $servicio['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                            <option value="Consulta general">Consulta general</option>
                        </select>
                    </div>

                    <div>
                        <label for="mensaje" class="block text-sm font-medium text-gray-700 mb-2">Mensaje *</label>
                        <textarea id="mensaje" name="mensaje" rows="5" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary transition-colors"
                            placeholder="Describe tu problema o consulta..."></textarea>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full btn-primary text-white py-4 rounded-lg text-lg font-semibold inline-flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-3"></i>
                            Enviar Mensaje
                        </button>
                    </div>

                    <p class="text-sm text-gray-500 text-center">
                        Al enviar este formulario, aceptas que nos comuniquemos contigo para brindarte información sobre nuestros servicios.
                    </p>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <!-- Quick Contact -->
                <div class="bg-white rounded-xl shadow-elegant p-8 animate-on-scroll">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Contacto Directo</h3>

                    <div class="space-y-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Teléfono</h4>
                                <p class="text-gray-600"><?php echo $empresa['telefono_display']; ?></p>
                                <!-- Link de llamar comentado - no funciona desde web
                                <a href="tel:<?php echo $empresa['telefono']; ?>" 
                                   class="text-primary hover:underline">Llamar ahora</a>
                                -->
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-green-500 text-white rounded-full flex items-center justify-center">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">WhatsApp</h4>
                                <p class="text-gray-600"><?php echo $empresa['telefono_display']; ?></p>
                                <a href="<?php echo $links['externos']['whatsapp_web']; ?>" target="_blank"
                                    class="text-green-500 hover:underline">Escribir por WhatsApp</a>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Email</h4>
                                <p class="text-gray-600"><?php echo $empresa['email']; ?></p>
                                <a href="mailto:<?php echo $empresa['email']; ?>"
                                    class="text-blue-500 hover:underline">Enviar email</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Hours -->
                <div class="bg-white rounded-xl shadow-elegant p-8 animate-on-scroll">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Horarios de Atención</h3>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="font-medium text-gray-900">Lunes - Viernes</span>
                            <span class="text-primary font-semibold"><?php echo $empresa['horarios']['lunes_viernes']; ?></span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="font-medium text-gray-900">Sábados</span>
                            <span class="text-primary font-semibold"><?php echo $empresa['horarios']['sabados']; ?></span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="font-medium text-gray-900">Domingos</span>
                            <span class="text-gray-500"><?php echo $empresa['horarios']['domingos']; ?></span>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-yellow-800">Emergencias 24/7</h4>
                                <p class="text-yellow-700 text-sm">Para situaciones de emergencia, contáctanos en cualquier momento</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Locations -->
                <div class="bg-white rounded-xl shadow-elegant p-8 animate-on-scroll">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Nuestras Ubicaciones</h3>

                    <div class="space-y-6">
                        <?php foreach ($empresa['direcciones'] as $ubicacion): ?>
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900"><?php echo $ubicacion['ciudad']; ?></h4>
                                    <p class="text-gray-600"><?php echo $ubicacion['direccion']; ?></p>
                                    <p class="text-gray-500 text-sm"><?php echo $ubicacion['referencia']; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-6">
                        <a href="<?php echo $empresa['redes']['google_maps']; ?>" target="_blank"
                            class="w-full btn-primary text-white py-3 rounded-lg font-semibold text-center inline-flex items-center justify-center">
                            <i class="fas fa-directions mr-2"></i>
                            Ver en Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Preguntas Frecuentes</h2>
            <p class="text-gray-600">Respuestas a las consultas más comunes de nuestros clientes</p>
        </div>

        <div class="space-y-6">
            <?php
            $faqs_contacto = [
                "¿Ofrecen cotizaciones gratuitas?" => "Sí, todas nuestras evaluaciones e inspecciones iniciales son completamente gratuitas. Visitamos tu propiedad, evaluamos el problema y te damos un presupuesto sin compromiso.",
                "¿Cuál es el tiempo de respuesta?" => "Para servicios regulares respondemos en 24-48 horas. Para emergencias, contamos con disponibilidad las 24 horas y podemos estar en tu ubicación en 2-4 horas.",
                "¿Atienden fines de semana?" => "Sí, trabajamos los sábados con horario especial. Para emergencias atendemos cualquier día de la semana las 24 horas.",
                "¿Qué métodos de pago aceptan?" => "Aceptamos efectivo, transferencias bancarias, tarjetas de crédito y débito. También ofrecemos planes de pago para servicios comerciales.",
                "¿Dan garantía en sus servicios?" => "Todos nuestros servicios incluyen garantía. El tiempo varía según el tipo de tratamiento, desde 1 mes hasta 12 meses dependiendo del servicio contratado."
            ];
            foreach ($faqs_contacto as $pregunta => $respuesta):
            ?>
                <div class="bg-gray-50 rounded-lg shadow-md animate-on-scroll">
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

<!-- Emergency Contact -->
<section class="py-20 bg-red-600 text-white">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8 animate-on-scroll">
        <h2 class="text-4xl font-bold mb-6">¿Tienes una Emergencia?</h2>
        <p class="text-xl mb-8">
            Situaciones como serpientes venenosas, enjambres de abejas o infestaciones severas requieren atención inmediata
        </p>
        <div class="space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center">
            <!-- Botón de llamar comentado - no funciona desde web
            <a href="tel:<?php echo $empresa['telefono']; ?>" 
               class="bg-white text-red-600 px-8 py-4 rounded-lg text-xl font-bold inline-flex items-center hover:bg-gray-100 transition-colors">
                <i class="fas fa-phone mr-3"></i>
                Llamar AHORA: <?php echo $empresa['telefono_display']; ?>
            </a>
            -->
            <a href="<?php echo $links['externos']['whatsapp_web']; ?>&text=EMERGENCIA:%20Necesito%20ayuda%20urgente"
                target="_blank"
                class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg text-xl font-bold inline-flex items-center transition-colors">
                <i class="fab fa-whatsapp mr-3"></i>
                WhatsApp Urgente
            </a>
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

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const nombre = document.getElementById('nombre').value.trim();
        const telefono = document.getElementById('telefono').value.trim();
        const email = document.getElementById('email').value.trim();
        const mensaje = document.getElementById('mensaje').value.trim();

        if (!nombre || !telefono || !email || !mensaje) {
            e.preventDefault();
            alert('Por favor completa todos los campos obligatorios.');
            return false;
        }

        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            alert('Por favor ingresa un email válido.');
            return false;
        }
    });
</script>

<?php include 'includes/footer.php'; ?>