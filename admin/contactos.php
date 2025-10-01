<?php
session_start();

// Verificar si está logueado
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

require_once '../config/data_loader.php';
$empresa = empresa();

// Leer contactos
$contactos_file = '../data/contactos.json';
$contactos = [];
if (file_exists($contactos_file)) {
    $json = file_get_contents($contactos_file);
    $contactos = json_decode($json, true);
    if (!is_array($contactos)) $contactos = [];
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos Recibidos - <?php echo $empresa['nombre']; ?></title>
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
                <h1 class="text-3xl font-bold text-gray-900">Contactos Recibidos</h1>
                <p class="text-gray-600">Consulta los mensajes enviados desde el formulario de contacto.</p>
            </div>
            <div class="flex gap-2">
                <a href="?export=csv" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    <i class="fas fa-file-csv mr-2"></i> Exportar CSV
                </a>
                <a href="dashboard.php" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>
        </div>
        
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <?php
            // Exportar CSV si se solicita
            if (isset($_GET['export']) && $_GET['export'] === 'csv' && count($contactos) > 0) {
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename=contactos_' . date('Ymd_His') . '.csv');
                $output = fopen('php://output', 'w');
                // Encabezados
                fputcsv($output, ['Fecha', 'Nombre', 'Email', 'Teléfono', 'Servicio', 'Mensaje', 'IP', 'User Agent']);
                foreach ($contactos as $c) {
                    fputcsv($output, [
                        $c['fecha'] ?? '',
                        $c['nombre'] ?? '',
                        $c['email'] ?? '',
                        $c['telefono'] ?? '',
                        $c['servicio'] ?? '',
                        $c['mensaje'] ?? '',
                        $c['ip'] ?? '',
                        $c['user_agent'] ?? ''
                    ]);
                }
                fclose($output);
                exit;
            }
            ?>
            <?php if (count($contactos) > 0): ?>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teléfono</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Servicio</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mensaje</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach (array_reverse($contactos) as $c): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700"> <?php echo htmlspecialchars($c['fecha']); ?> </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 font-semibold"> <?php echo htmlspecialchars($c['nombre']); ?> </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-blue-700"> <?php echo htmlspecialchars($c['email']); ?> </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700"> <?php echo htmlspecialchars($c['telefono']); ?> </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700"> <?php echo htmlspecialchars($c['servicio']); ?> </td>
                                <td class="px-4 py-2 whitespace-pre-line text-sm text-gray-700 max-w-xs"> <?php echo htmlspecialchars($c['mensaje']); ?> </td>
                                <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500"> <?php echo htmlspecialchars($c['ip']); ?> </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="p-8 text-center text-gray-500">
                    No hay mensajes recibidos aún.
                </div>
            <?php endif; ?>
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
