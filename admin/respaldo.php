<?php
session_start();

// Verificar si está logueado
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

require_once '../config/data_loader.php';
$empresa = empresa();

// Variables de respaldo
$backupPath = '../data/backups/';
$mensaje = '';
$tipo_mensaje = '';

// Crear directorio de respaldos si no existe
if (!is_dir($backupPath)) {
    mkdir($backupPath, 0755, true);
}

// Manejar acciones
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'backup':
            // Crear backup de todos los archivos JSON
            $fecha = date('Y-m-d_H-i-s');
            $backupFile = $backupPath . 'backup_' . $fecha . '.zip';
            
            $zip = new ZipArchive();
            if ($zip->open($backupFile, ZipArchive::CREATE) === TRUE) {
                // Añadir archivos JSON
                $dataPath = '../data/';
                $files = glob($dataPath . '*.json');
                
                foreach ($files as $file) {
                    $zip->addFile($file, basename($file));
                }
                
                $zip->close();
                $mensaje = 'Respaldo creado correctamente: ' . basename($backupFile);
                $tipo_mensaje = 'success';
            } else {
                $mensaje = 'Error al crear el archivo de respaldo.';
                $tipo_mensaje = 'error';
            }
            break;
            
        case 'restore':
            if (isset($_FILES['backup_file']) && $_FILES['backup_file']['error'] === UPLOAD_ERR_OK) {
                $tempFile = $_FILES['backup_file']['tmp_name'];
                $fileName = $_FILES['backup_file']['name'];
                
                // Verificar que sea un archivo ZIP
                if (pathinfo($fileName, PATHINFO_EXTENSION) === 'zip') {
                    $zip = new ZipArchive();
                    if ($zip->open($tempFile) === TRUE) {
                        // Extraer archivos en data/
                        $zip->extractTo('../data/');
                        $zip->close();
                        
                        $mensaje = 'Respaldo restaurado correctamente.';
                        $tipo_mensaje = 'success';
                    } else {
                        $mensaje = 'Error al abrir el archivo de respaldo.';
                        $tipo_mensaje = 'error';
                    }
                } else {
                    $mensaje = 'El archivo debe ser un ZIP válido.';
                    $tipo_mensaje = 'error';
                }
            } else {
                $mensaje = 'Error al subir el archivo.';
                $tipo_mensaje = 'error';
            }
            break;
    }
}

// Obtener lista de respaldos
$backupFiles = [];
if (is_dir($backupPath)) {
    $backupFiles = array_reverse(glob($backupPath . 'backup_*.zip'));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respaldo y Base de Datos - <?php echo $empresa['nombre']; ?></title>
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
                <h1 class="text-3xl font-bold text-gray-900">Respaldo y Base de Datos</h1>
                <p class="text-gray-600">Gestiona respaldos y opciones de la base de datos.</p>
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
        
        <!-- Backup Section -->
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">
                        <i class="fas fa-download mr-2 text-primary"></i> Crear Respaldo
                    </h2>
                    <p class="text-gray-600 mt-1">Genera un respaldo completo de todos los datos del sitio.</p>
                </div>
                
                <div class="p-6">
                    <form action="" method="POST">
                        <input type="hidden" name="action" value="backup">
                        
                        <div class="mb-6">
                            <p class="text-gray-700 mb-4">
                                Un respaldo contiene todos los archivos JSON con la información de tu sitio web. 
                                Te recomendamos crear respaldos regularmente.
                            </p>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-medium py-2 px-6 rounded-md transition-colors">
                                <i class="fas fa-download mr-2"></i> Crear Respaldo Ahora
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">
                        <i class="fas fa-upload mr-2 text-primary"></i> Restaurar Respaldo
                    </h2>
                    <p class="text-gray-600 mt-1">Restaura un respaldo previo de tus datos.</p>
                </div>
                
                <div class="p-6">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="restore">
                        
                        <div class="mb-6">
                            <label for="backup_file" class="block text-sm font-medium text-gray-700 mb-1">Archivo de Respaldo (.zip)</label>
                            <input type="file" id="backup_file" name="backup_file" accept=".zip"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            <p class="text-xs text-gray-500 mt-1">Selecciona un archivo ZIP de respaldo.</p>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-6 rounded-md transition-colors">
                                <i class="fas fa-upload mr-2"></i> Restaurar Respaldo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Backup History -->
        <div class="mt-8 bg-white shadow rounded-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="fas fa-history mr-2 text-primary"></i> Historial de Respaldos
                </h2>
                <p class="text-gray-600 mt-1">Lista de respaldos generados anteriormente.</p>
            </div>
            
            <div class="overflow-x-auto">
                <?php if (count($backupFiles) > 0): ?>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Archivo
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tamaño
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($backupFiles as $file): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <?php echo basename($file); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php 
                                            $date = preg_replace('/backup_(\d{4}-\d{2}-\d{2})_(\d{2}-\d{2}-\d{2})\.zip/', '$1 $2', basename($file));
                                            $date = str_replace('-', ':', $date);
                                            echo $date; 
                                        ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo round(filesize($file) / 1024, 2); ?> KB
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="<?php echo str_replace('../', '', $file); ?>" download class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <i class="fas fa-download mr-1"></i> Descargar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="p-6 text-center text-gray-500">
                        No hay respaldos disponibles.
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Database Status -->
        <div class="mt-8 bg-white shadow rounded-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="fas fa-database mr-2 text-primary"></i> Estado de los Datos
                </h2>
                <p class="text-gray-600 mt-1">Información sobre el estado actual de los archivos de datos.</p>
            </div>
            
            <div class="p-6">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php 
                    $dataFiles = [
                        'empresa.json' => 'Datos de Empresa',
                        'servicios.json' => 'Servicios',
                        'links.json' => 'Enlaces',
                        'usuarios.json' => 'Usuarios'
                    ];
                    
                    foreach ($dataFiles as $file => $label):
                        $filePath = '../data/' . $file;
                        $exists = file_exists($filePath);
                        $fileSize = $exists ? round(filesize($filePath) / 1024, 2) : 0;
                        $lastModified = $exists ? date("d/m/Y H:i:s", filemtime($filePath)) : 'N/A';
                    ?>
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-file-code text-primary mr-2"></i>
                                <h3 class="font-medium"><?php echo $label; ?></h3>
                            </div>
                            <div class="text-sm text-gray-600">
                                <p>Archivo: <?php echo $file; ?></p>
                                <p>Estado: 
                                    <?php if ($exists): ?>
                                        <span class="text-green-600">Existe</span>
                                    <?php else: ?>
                                        <span class="text-red-600">No existe</span>
                                    <?php endif; ?>
                                </p>
                                <p>Tamaño: <?php echo $fileSize; ?> KB</p>
                                <p>Última modificación: <?php echo $lastModified; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-white mt-12 py-6 border-t">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 text-sm">
                Panel de Administración &copy; <?php echo date('Y'); ?> - <?php echo $empresa['nombre']; ?>
            </p>
        </div>
    </footer>
</body>
</html>
