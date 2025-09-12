<?php
session_start();

// Verificar si está logueado
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

require_once '../config/data_loader.php';
$empresa = empresa();
$mensaje = '';
$tipo_mensaje = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación básica
    if (empty($_POST['nombre']) || empty($_POST['email'])) {
        $mensaje = 'Los campos Nombre y Email son obligatorios';
        $tipo_mensaje = 'error';
    } else {
        // Actualizar datos generales
        $empresa['nombre'] = $_POST['nombre'];
        $empresa['slogan'] = $_POST['slogan'];
        $empresa['descripcion'] = $_POST['descripcion'];
        $empresa['telefono'] = $_POST['telefono'];
        $empresa['telefono_display'] = $_POST['telefono_display'];
        $empresa['whatsapp'] = $_POST['whatsapp'];
        $empresa['email'] = $_POST['email'];
        $empresa['email_contacto'] = $_POST['email_contacto'];
        
        // Actualizar misión y visión
        $empresa['mision'] = $_POST['mision'];
        $empresa['vision'] = $_POST['vision'];
        
        // Actualizar direcciones
        if (isset($_POST['direccion_guayaquil']) && isset($_POST['direccion_salinas'])) {
            $empresa['direcciones']['guayaquil']['direccion'] = $_POST['direccion_guayaquil'];
            $empresa['direcciones']['guayaquil']['referencia'] = $_POST['referencia_guayaquil'];
            $empresa['direcciones']['salinas']['direccion'] = $_POST['direccion_salinas'];
            $empresa['direcciones']['salinas']['referencia'] = $_POST['referencia_salinas'];
        }
        
        // Actualizar horarios
        if (isset($_POST['horario_lv']) && isset($_POST['horario_s']) && isset($_POST['horario_d'])) {
            $empresa['horarios']['lunes_viernes'] = $_POST['horario_lv'];
            $empresa['horarios']['sabados'] = $_POST['horario_s'];
            $empresa['horarios']['domingos'] = $_POST['horario_d'];
        }
        
        // Actualizar redes sociales
        if (isset($_POST['facebook']) && isset($_POST['instagram'])) {
            $empresa['redes']['facebook'] = $_POST['facebook'];
            $empresa['redes']['instagram'] = $_POST['instagram'];
            $empresa['redes']['whatsapp'] = 'https://wa.me/' . $_POST['whatsapp'];
            $empresa['redes']['google_maps'] = $_POST['google_maps'];
        }
        
        // Actualizar valores (formato array asociativo)
        if (isset($_POST['valores_titulos']) && isset($_POST['valores_descripciones'])) {
            $valores = [];
            foreach ($_POST['valores_titulos'] as $index => $titulo) {
                if (!empty($titulo) && isset($_POST['valores_descripciones'][$index])) {
                    $valores[$titulo] = $_POST['valores_descripciones'][$index];
                }
            }
            $empresa['valores'] = $valores;
        }
        
        // Actualizar certificaciones (formato array simple)
        if (isset($_POST['certificaciones'])) {
            $certificaciones = [];
            foreach ($_POST['certificaciones'] as $cert) {
                if (!empty($cert)) {
                    $certificaciones[] = $cert;
                }
            }
            $empresa['certificaciones'] = $certificaciones;
        }
        
        // Guardar cambios
        if (DataLoader::save('empresa', $empresa)) {
            $mensaje = 'Datos de la empresa actualizados correctamente';
            $tipo_mensaje = 'success';
            // Recargar datos
            $empresa = empresa();
        } else {
            $mensaje = 'Error al guardar los datos';
            $tipo_mensaje = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empresa - <?php echo $empresa['nombre']; ?></title>
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
                <h1 class="text-3xl font-bold text-gray-900">Datos de la Empresa</h1>
                <p class="text-gray-600">Actualiza la información general de tu empresa.</p>
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
        <form action="editar-empresa.php" method="POST">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Información General -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold mb-4">Información General</h2>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Empresa *</label>
                            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($empresa['nombre']); ?>" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label for="slogan" class="block text-sm font-medium text-gray-700 mb-1">Eslogan</label>
                            <input type="text" id="slogan" name="slogan" value="<?php echo htmlspecialchars($empresa['slogan']); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"><?php echo htmlspecialchars($empresa['descripcion']); ?></textarea>
                    </div>
                </div>
                
                <!-- Contacto -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold mb-4">Información de Contacto</h2>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono (solo números)</label>
                            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($empresa['telefono']); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label for="telefono_display" class="block text-sm font-medium text-gray-700 mb-1">Teléfono (formato de visualización)</label>
                            <input type="text" id="telefono_display" name="telefono_display" value="<?php echo htmlspecialchars($empresa['telefono_display']); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp (solo números con código país)</label>
                            <input type="text" id="whatsapp" name="whatsapp" value="<?php echo htmlspecialchars($empresa['whatsapp']); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Principal *</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($empresa['email']); ?>" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label for="email_contacto" class="block text-sm font-medium text-gray-700 mb-1">Email de Contacto</label>
                            <input type="email" id="email_contacto" name="email_contacto" value="<?php echo htmlspecialchars($empresa['email_contacto']); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                </div>
                
                <!-- Direcciones -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold mb-4">Ubicaciones</h2>
                    
                    <div class="mb-6">
                        <h3 class="font-medium text-gray-900 mb-2">Guayaquil</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="direccion_guayaquil" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                <input type="text" id="direccion_guayaquil" name="direccion_guayaquil" value="<?php echo htmlspecialchars($empresa['direcciones']['guayaquil']['direccion']); ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            </div>
                            
                            <div>
                                <label for="referencia_guayaquil" class="block text-sm font-medium text-gray-700 mb-1">Referencia</label>
                                <input type="text" id="referencia_guayaquil" name="referencia_guayaquil" value="<?php echo htmlspecialchars($empresa['direcciones']['guayaquil']['referencia']); ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="font-medium text-gray-900 mb-2">Salinas</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="direccion_salinas" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                <input type="text" id="direccion_salinas" name="direccion_salinas" value="<?php echo htmlspecialchars($empresa['direcciones']['salinas']['direccion']); ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            </div>
                            
                            <div>
                                <label for="referencia_salinas" class="block text-sm font-medium text-gray-700 mb-1">Referencia</label>
                                <input type="text" id="referencia_salinas" name="referencia_salinas" value="<?php echo htmlspecialchars($empresa['direcciones']['salinas']['referencia']); ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Horarios -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold mb-4">Horarios de Atención</h2>
                    
                    <div class="grid md:grid-cols-3 gap-6">
                        <div>
                            <label for="horario_lv" class="block text-sm font-medium text-gray-700 mb-1">Lunes a Viernes</label>
                            <input type="text" id="horario_lv" name="horario_lv" value="<?php echo htmlspecialchars($empresa['horarios']['lunes_viernes']); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label for="horario_s" class="block text-sm font-medium text-gray-700 mb-1">Sábados</label>
                            <input type="text" id="horario_s" name="horario_s" value="<?php echo htmlspecialchars($empresa['horarios']['sabados']); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label for="horario_d" class="block text-sm font-medium text-gray-700 mb-1">Domingos</label>
                            <input type="text" id="horario_d" name="horario_d" value="<?php echo htmlspecialchars($empresa['horarios']['domingos']); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                </div>
                
                <!-- Redes Sociales -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold mb-4">Redes Sociales</h2>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="facebook" class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                            <input type="url" id="facebook" name="facebook" value="<?php echo htmlspecialchars($empresa['redes']['facebook']); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label for="instagram" class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                            <input type="url" id="instagram" name="instagram" value="<?php echo htmlspecialchars($empresa['redes']['instagram']); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label for="google_maps" class="block text-sm font-medium text-gray-700 mb-1">Google Maps</label>
                            <input type="url" id="google_maps" name="google_maps" value="<?php echo htmlspecialchars($empresa['redes']['google_maps']); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                </div>
                
                <!-- Misión y Visión -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold mb-4">Misión y Visión</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="mision" class="block text-sm font-medium text-gray-700 mb-1">Misión</label>
                            <textarea id="mision" name="mision" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"><?php echo htmlspecialchars($empresa['mision']); ?></textarea>
                        </div>
                        
                        <div>
                            <label for="vision" class="block text-sm font-medium text-gray-700 mb-1">Visión</label>
                            <textarea id="vision" name="vision" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"><?php echo htmlspecialchars($empresa['vision']); ?></textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Valores -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold mb-4">Valores de la Empresa</h2>
                    
                    <div id="valores-container">
                        <?php $i = 0; foreach ($empresa['valores'] as $titulo => $descripcion): ?>
                            <div class="grid md:grid-cols-2 gap-4 mb-4 valor-item">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                                    <input type="text" name="valores_titulos[]" value="<?php echo htmlspecialchars($titulo); ?>"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                    <input type="text" name="valores_descripciones[]" value="<?php echo htmlspecialchars($descripcion); ?>"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                </div>
                            </div>
                        <?php $i++; endforeach; ?>
                    </div>
                    
                    <div class="mt-4 flex justify-end">
                        <button type="button" id="add-valor" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-plus mr-1"></i> Agregar Valor
                        </button>
                    </div>
                </div>
                
                <!-- Certificaciones -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold mb-4">Certificaciones</h2>
                    
                    <div id="certificaciones-container">
                        <?php foreach ($empresa['certificaciones'] as $index => $cert): ?>
                            <div class="mb-3 certificacion-item">
                                <div class="flex items-center">
                                    <input type="text" name="certificaciones[]" value="<?php echo htmlspecialchars($cert); ?>"
                                           class="flex-grow px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                    <?php if ($index > 0): ?>
                                        <button type="button" class="ml-2 text-red-500 hover:text-red-700 remove-cert">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="mt-4 flex justify-end">
                        <button type="button" id="add-certificacion" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-plus mr-1"></i> Agregar Certificación
                        </button>
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
    
    <script>
        // Agregar valor
        document.getElementById('add-valor').addEventListener('click', function() {
            const container = document.getElementById('valores-container');
            const newItem = document.createElement('div');
            newItem.className = 'grid md:grid-cols-2 gap-4 mb-4 valor-item';
            newItem.innerHTML = `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                    <input type="text" name="valores_titulos[]" value=""
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <input type="text" name="valores_descripciones[]" value=""
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                </div>
            `;
            container.appendChild(newItem);
        });
        
        // Agregar certificación
        document.getElementById('add-certificacion').addEventListener('click', function() {
            const container = document.getElementById('certificaciones-container');
            const newItem = document.createElement('div');
            newItem.className = 'mb-3 certificacion-item';
            newItem.innerHTML = `
                <div class="flex items-center">
                    <input type="text" name="certificaciones[]" value=""
                           class="flex-grow px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    <button type="button" class="ml-2 text-red-500 hover:text-red-700 remove-cert">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            container.appendChild(newItem);
            
            // Agregar evento al botón de eliminar
            newItem.querySelector('.remove-cert').addEventListener('click', function() {
                this.closest('.certificacion-item').remove();
            });
        });
        
        // Eliminar certificación
        document.querySelectorAll('.remove-cert').forEach(function(button) {
            button.addEventListener('click', function() {
                this.closest('.certificacion-item').remove();
            });
        });
    </script>
</body>
</html>
