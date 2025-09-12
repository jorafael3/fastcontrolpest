<?php
session_start();

// Verificar si está logueado
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

require_once '../config/data_loader.php';
$empresa = empresa();
$links = links();
$mensaje = '';
$tipo_mensaje = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Actualizar enlaces externos
    if (isset($_POST['whatsapp_web']) && isset($_POST['google_maps'])) {
        $links['externos']['whatsapp_web'] = $_POST['whatsapp_web'];
        $links['externos']['google_maps'] = $_POST['google_maps'];
        $links['externos']['facebook'] = $_POST['facebook'];
        $links['externos']['instagram'] = $_POST['instagram'];
    }
    
    // Actualizar imágenes de carrusel
    if (isset($_POST['carrusel_imagenes'])) {
        $imagenes = [];
        foreach (explode("\n", $_POST['carrusel_imagenes']) as $linea) {
            $linea = trim($linea);
            if (!empty($linea)) {
                $imagenes[] = $linea;
            }
        }
        $links['carrusel_imagenes'] = $imagenes;
    }
    
    // Guardar cambios
    if (DataLoader::save('links', $links)) {
        $mensaje = 'Enlaces actualizados correctamente';
        $tipo_mensaje = 'success';
        // Recargar datos
        $links = links();
    } else {
        $mensaje = 'Error al guardar los enlaces';
        $tipo_mensaje = 'error';
    }
}

// Preparar imágenes de carrusel para mostrar en textarea
$carrusel_imagenes_texto = implode("\n", $links['carrusel_imagenes']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enlaces y Navegación - <?php echo $empresa['nombre']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#B91C1C',
                        'primary-dark': '#991B1B',
                    },
                    boxShadow: {
                        'elegant': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="dashboard.php" class="text-2xl font-bold text-primary">
                            <i class="fas fa-shield-alt mr-2"></i>
                            Administración
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="dashboard.php" class="mr-4 text-gray-600 hover:text-primary">
                        <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                    </a>
                    <a href="?action=logout" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        <i class="fas fa-sign-out-alt mr-1"></i> Salir
                    </a>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Enlaces y Navegación</h1>
                <p class="text-gray-600">Configura los enlaces y opciones de navegación del sitio.</p>
            </div>
            <a href="dashboard.php" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
        </div>
        
        <?php if (!empty($mensaje)): ?>
            <div class="mb-8 p-4 rounded-lg <?php echo $tipo_mensaje === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <!-- Formulario -->
        <form action="enlaces.php" method="POST">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Enlaces Externos -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold mb-4">Enlaces Externos</h2>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="whatsapp_web" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Web</label>
                            <input type="url" id="whatsapp_web" name="whatsapp_web" value="<?php echo htmlspecialchars($links['externos']['whatsapp_web']); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            <p class="text-xs text-gray-500 mt-1">Enlace para chat de WhatsApp Web.</p>
                        </div>
                        
                        <div>
                            <label for="google_maps" class="block text-sm font-medium text-gray-700 mb-1">Google Maps</label>
                            <input type="url" id="google_maps" name="google_maps" value="<?php echo htmlspecialchars($links['externos']['google_maps']); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            <p class="text-xs text-gray-500 mt-1">Enlace a la ubicación en Google Maps.</p>
                        </div>
                        
                        <div>
                            <label for="facebook" class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                            <input type="url" id="facebook" name="facebook" value="<?php echo htmlspecialchars($links['externos']['facebook']); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label for="instagram" class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                            <input type="url" id="instagram" name="instagram" value="<?php echo htmlspecialchars($links['externos']['instagram']); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                </div>
                
                <!-- Imágenes de Carrusel -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold mb-4">Imágenes del Carrusel</h2>
                    <p class="text-sm text-gray-600 mb-4">Una imagen por línea. Usa rutas relativas (p. ej. imagenes/foto.jpg).</p>
                    
                    <div>
                        <textarea id="carrusel_imagenes" name="carrusel_imagenes" rows="6"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"><?php echo htmlspecialchars($carrusel_imagenes_texto); ?></textarea>
                    </div>
                </div>
                
                <!-- Menú Principal (solo visualización) -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold mb-4">Menú Principal</h2>
                    <p class="text-sm text-gray-600 mb-4">Vista previa del menú principal (edición avanzada disponible en próximas versiones).</p>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <ul class="space-y-2">
                            <?php foreach ($links['menu_principal'] as $key => $item): ?>
                                <li>
                                    <div class="flex items-center">
                                        <i class="fas fa-link text-primary mr-2"></i>
                                        <span class="font-medium"><?php echo htmlspecialchars($item['texto']); ?></span>
                                        <span class="text-gray-500 text-sm ml-2">(<?php echo htmlspecialchars($item['url']); ?>)</span>
                                    </div>
                                    
                                    <?php if (isset($item['submenu']) && $item['submenu'] && $key === 'servicios'): ?>
                                        <div class="mt-2 ml-6 pl-2 border-l-2 border-gray-200">
                                            <p class="text-xs text-gray-500 mb-1">Submenú:</p>
                                            <ul class="space-y-1">
                                                <?php foreach ($links['menu_servicios'] as $servicio): ?>
                                                    <li class="text-sm text-gray-600">
                                                        <?php echo htmlspecialchars($servicio['texto']); ?> 
                                                        <span class="text-xs text-gray-500">(<?php echo htmlspecialchars($servicio['url']); ?>)</span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                
                <!-- Submit -->
                <div class="p-6">
                    <div class="flex justify-end">
                        <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-medium py-2 px-6 rounded-md transition-colors">
                            Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
