<?php
session_start();

// Verificar si está logueado
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

require_once '../config/data_loader.php';
$servicios = servicios();
$empresa = empresa();
$mensaje = '';
$tipo_mensaje = '';

// Variables para el formulario
$id = '';
$servicio = [
    'id' => '',
    'nombre' => '',
    'descripcion_corta' => '',
    'descripcion_larga' => '',
    'imagen' => '',
    'proceso' => ['', '', '', '', ''],
    'beneficios' => ['', '', '', '', ''],
    'precio_desde' => 0,
    'tiempo_servicio' => '',
    'garantia' => ''
];
$is_edit = false;

// Cargar servicio para editar
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($servicios[$id])) {
        $servicio = $servicios[$id];
        $is_edit = true;
    } else {
        $mensaje = 'El servicio solicitado no existe';
        $tipo_mensaje = 'error';
    }
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar datos requeridos
    if (empty($_POST['nombre']) || empty($_POST['descripcion_corta'])) {
        $mensaje = 'El nombre y la descripción corta son obligatorios';
        $tipo_mensaje = 'error';
    } else {
        // Crear ID único para nuevos servicios
        if (empty($_POST['id'])) {
            $id = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $_POST['nombre'])));
            if (isset($servicios[$id])) {
                $id = $id . '-' . uniqid();
            }
        } else {
            $id = $_POST['id'];
        }
        
        // Preparar datos del servicio
        $nuevo_servicio = [
            'id' => $id,
            'nombre' => $_POST['nombre'],
            'descripcion_corta' => $_POST['descripcion_corta'],
            'descripcion_larga' => $_POST['descripcion_larga'],
            'imagen' => $_POST['imagen'],
            'proceso' => array_filter($_POST['proceso']),
            'beneficios' => array_filter($_POST['beneficios']),
            'precio_desde' => intval($_POST['precio_desde']),
            'tiempo_servicio' => $_POST['tiempo_servicio'],
            'garantia' => $_POST['garantia']
        ];
        
        // Guardar servicio
        $servicios[$id] = $nuevo_servicio;
        
        if (DataLoader::save('servicios', $servicios)) {
            $mensaje = $is_edit ? 'Servicio actualizado correctamente' : 'Servicio creado correctamente';
            $tipo_mensaje = 'success';
            
            // Redireccionar en caso de ser un nuevo servicio
            if (!$is_edit) {
                header('Location: editar-servicio.php?id=' . $id . '&msg=created');
                exit;
            }
            
            // Recargar datos para edición
            $servicios = servicios();
            $servicio = $servicios[$id];
        } else {
            $mensaje = 'Error al guardar el servicio';
            $tipo_mensaje = 'error';
        }
    }
}

// Mensaje de creación exitosa
if (isset($_GET['msg']) && $_GET['msg'] === 'created') {
    $mensaje = 'Servicio creado correctamente';
    $tipo_mensaje = 'success';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $is_edit ? 'Editar' : 'Nuevo'; ?> Servicio - <?php echo $empresa['nombre']; ?></title>
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
                    <a href="servicios.php" class="mr-4 text-gray-600 hover:text-primary">
                        <i class="fas fa-list mr-1"></i> Todos los Servicios
                    </a>
                    <a href="dashboard.php" class="mr-4 text-gray-600 hover:text-primary">
                        <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900"><?php echo $is_edit ? 'Editar Servicio' : 'Nuevo Servicio'; ?></h1>
                <p class="text-gray-600"><?php echo $is_edit ? 'Actualiza la información del servicio.' : 'Crea un nuevo servicio para tu catálogo.'; ?></p>
            </div>
            <a href="servicios.php" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Volver a Servicios
            </a>
        </div>
        
        <?php if (!empty($mensaje)): ?>
            <div class="mb-8 p-4 rounded-lg <?php echo $tipo_mensaje === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <!-- Formulario -->
        <form action="editar-servicio.php<?php echo $is_edit ? '?id='.$id : ''; ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Información Básica -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold mb-4">Información Básica</h2>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Servicio *</label>
                            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($servicio['nombre']); ?>" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label for="imagen" class="block text-sm font-medium text-gray-700 mb-1">URL de la Imagen (ruta relativa) *</label>
                            <input type="text" id="imagen" name="imagen" value="<?php echo htmlspecialchars($servicio['imagen']); ?>" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            <p class="text-xs text-gray-500 mt-1">Ejemplo: imaganes/nombre-imagen.jpg</p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label for="descripcion_corta" class="block text-sm font-medium text-gray-700 mb-1">Descripción Corta *</label>
                        <input type="text" id="descripcion_corta" name="descripcion_corta" value="<?php echo htmlspecialchars($servicio['descripcion_corta']); ?>" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        <p class="text-xs text-gray-500 mt-1">Una frase breve que aparecerá en las tarjetas de servicios.</p>
                    </div>
                    
                    <div class="mt-4">
                        <label for="descripcion_larga" class="block text-sm font-medium text-gray-700 mb-1">Descripción Larga</label>
                        <textarea id="descripcion_larga" name="descripcion_larga" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"><?php echo htmlspecialchars($servicio['descripcion_larga']); ?></textarea>
                        <p class="text-xs text-gray-500 mt-1">Descripción detallada que aparecerá en la página del servicio.</p>
                    </div>
                </div>
                
                <!-- Detalles del Servicio -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold mb-4">Detalles del Servicio</h2>
                    
                    <div class="grid md:grid-cols-3 gap-6">
                        <div>
                            <label for="precio_desde" class="block text-sm font-medium text-gray-700 mb-1">Precio Desde ($)</label>
                            <input type="number" id="precio_desde" name="precio_desde" value="<?php echo htmlspecialchars($servicio['precio_desde']); ?>" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label for="tiempo_servicio" class="block text-sm font-medium text-gray-700 mb-1">Tiempo de Servicio</label>
                            <input type="text" id="tiempo_servicio" name="tiempo_servicio" value="<?php echo htmlspecialchars($servicio['tiempo_servicio']); ?>" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            <p class="text-xs text-gray-500 mt-1">Ejemplo: 2-3 horas</p>
                        </div>
                        
                        <div>
                            <label for="garantia" class="block text-sm font-medium text-gray-700 mb-1">Garantía</label>
                            <input type="text" id="garantia" name="garantia" value="<?php echo htmlspecialchars($servicio['garantia']); ?>" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            <p class="text-xs text-gray-500 mt-1">Ejemplo: 3 meses</p>
                        </div>
                    </div>
                </div>
                
                <!-- Proceso -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold mb-4">Proceso del Servicio</h2>
                    <p class="text-sm text-gray-600 mb-4">Describe los pasos que se siguen para realizar este servicio.</p>
                    
                    <div class="space-y-4">
                        <?php 
                        // Asegurar que siempre haya al menos 5 campos de proceso
                        $proceso = $servicio['proceso'];
                        while (count($proceso) < 5) {
                            $proceso[] = '';
                        }
                        
                        foreach ($proceso as $index => $paso): 
                        ?>
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center font-medium">
                                    <?php echo $index + 1; ?>
                                </div>
                                <div class="ml-4 flex-grow">
                                    <input type="text" name="proceso[]" value="<?php echo htmlspecialchars($paso); ?>" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                                           placeholder="Paso <?php echo $index + 1; ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="mt-4">
                            <button type="button" id="add-paso" class="text-primary hover:text-primary-dark text-sm font-medium">
                                <i class="fas fa-plus-circle mr-1"></i> Añadir otro paso
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Beneficios -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold mb-4">Beneficios del Servicio</h2>
                    <p class="text-sm text-gray-600 mb-4">Enumera los principales beneficios que ofrece este servicio.</p>
                    
                    <div id="beneficios-container" class="space-y-3">
                        <?php 
                        // Asegurar que siempre haya al menos 5 campos de beneficios
                        $beneficios = $servicio['beneficios'];
                        while (count($beneficios) < 5) {
                            $beneficios[] = '';
                        }
                        
                        foreach ($beneficios as $index => $beneficio): 
                        ?>
                            <div class="flex items-center beneficio-item">
                                <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-green-600"></i>
                                </div>
                                <div class="ml-3 flex-grow">
                                    <input type="text" name="beneficios[]" value="<?php echo htmlspecialchars($beneficio); ?>" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                                           placeholder="Beneficio">
                                </div>
                                <?php if ($index > 0): ?>
                                    <button type="button" class="ml-2 text-red-500 hover:text-red-700 remove-beneficio">
                                        <i class="fas fa-times"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="mt-4">
                        <button type="button" id="add-beneficio" class="text-primary hover:text-primary-dark text-sm font-medium">
                            <i class="fas fa-plus-circle mr-1"></i> Añadir otro beneficio
                        </button>
                    </div>
                </div>
                
                <!-- Submit -->
                <div class="p-6">
                    <div class="flex justify-end">
                        <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-medium py-2 px-6 rounded-md transition-colors">
                            <?php echo $is_edit ? 'Actualizar Servicio' : 'Crear Servicio'; ?>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <script>
        // Agregar paso
        document.getElementById('add-paso').addEventListener('click', function() {
            const container = document.querySelector('.space-y-4');
            const pasos = container.querySelectorAll('.flex.items-center').length;
            
            const newItem = document.createElement('div');
            newItem.className = 'flex items-center';
            newItem.innerHTML = `
                <div class="flex-shrink-0 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center font-medium">
                    ${pasos + 1}
                </div>
                <div class="ml-4 flex-grow">
                    <input type="text" name="proceso[]" value="" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                           placeholder="Paso ${pasos + 1}">
                </div>
            `;
            
            container.insertBefore(newItem, document.getElementById('add-paso').parentNode);
        });
        
        // Agregar beneficio
        document.getElementById('add-beneficio').addEventListener('click', function() {
            const container = document.getElementById('beneficios-container');
            
            const newItem = document.createElement('div');
            newItem.className = 'flex items-center beneficio-item';
            newItem.innerHTML = `
                <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600"></i>
                </div>
                <div class="ml-3 flex-grow">
                    <input type="text" name="beneficios[]" value="" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                           placeholder="Beneficio">
                </div>
                <button type="button" class="ml-2 text-red-500 hover:text-red-700 remove-beneficio">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            container.appendChild(newItem);
            
            // Agregar evento al botón de eliminar
            newItem.querySelector('.remove-beneficio').addEventListener('click', function() {
                this.closest('.beneficio-item').remove();
            });
        });
        
        // Eliminar beneficio
        document.querySelectorAll('.remove-beneficio').forEach(function(button) {
            button.addEventListener('click', function() {
                this.closest('.beneficio-item').remove();
            });
        });
    </script>
</body>
</html>
