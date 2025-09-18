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

// Procesar cambio de contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Verificar contraseña actual
    $usuarios = DataLoader::load('usuarios');
    $usuario = null;
    
    foreach ($usuarios as $u) {
        if ($u['username'] === $_SESSION['admin_username']) {
            $usuario = $u;
            break;
        }
    }
    
    if ($usuario && password_verify($current_password, $usuario['password'])) {
        // Verificar que las nuevas contraseñas coincidan
        if ($new_password === $confirm_password) {
            if (strlen($new_password) >= 8) {
                // Actualizar contraseña
                foreach ($usuarios as $key => $u) {
                    if ($u['username'] === $_SESSION['admin_username']) {
                        $usuarios[$key]['password'] = password_hash($new_password, PASSWORD_DEFAULT);
                        break;
                    }
                }
                
                if (DataLoader::save('usuarios', $usuarios)) {
                    $mensaje = 'Contraseña actualizada correctamente.';
                    $tipo_mensaje = 'success';
                } else {
                    $mensaje = 'Error al guardar la nueva contraseña.';
                    $tipo_mensaje = 'error';
                }
            } else {
                $mensaje = 'La contraseña debe tener al menos 8 caracteres.';
                $tipo_mensaje = 'error';
            }
        } else {
            $mensaje = 'Las nuevas contraseñas no coinciden.';
            $tipo_mensaje = 'error';
        }
    } else {
        $mensaje = 'La contraseña actual no es correcta.';
        $tipo_mensaje = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña - <?php echo $empresa['nombre']; ?></title>
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
                <h1 class="text-3xl font-bold text-gray-900">Cambiar Contraseña</h1>
                <p class="text-gray-600">Actualiza la contraseña de acceso al panel de administración.</p>
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
        
        <!-- Password Form -->
        <div class="max-w-md mx-auto bg-white shadow rounded-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="fas fa-lock mr-2 text-primary"></i> Cambiar Contraseña
                </h2>
                <p class="text-gray-600 mt-1">Ingresa tu contraseña actual y la nueva contraseña.</p>
            </div>
            
            <form action="" method="POST" class="p-6">
                <div class="mb-4">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña Actual</label>
                    <div class="relative">
                        <input type="password" id="current_password" name="current_password" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Nueva Contraseña</label>
                    <div class="relative">
                        <input type="password" id="new_password" name="new_password" required minlength="8"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="fas fa-key text-gray-400"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">La contraseña debe tener al menos 8 caracteres.</p>
                </div>
                
                <div class="mb-6">
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Nueva Contraseña</label>
                    <div class="relative">
                        <input type="password" id="confirm_password" name="confirm_password" required minlength="8"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="fas fa-check-circle text-gray-400"></i>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-medium py-2 px-6 rounded-md transition-colors">
                        <i class="fas fa-save mr-2"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Security Tips -->
        <div class="max-w-md mx-auto mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="font-medium text-blue-800 mb-2">
                <i class="fas fa-shield-alt mr-2"></i> Consejos de Seguridad
            </h3>
            <ul class="text-sm text-blue-700 space-y-2">
                <li><i class="fas fa-check mr-1"></i> Utiliza contraseñas con al menos 8 caracteres.</li>
                <li><i class="fas fa-check mr-1"></i> Combina letras mayúsculas, minúsculas, números y símbolos.</li>
                <li><i class="fas fa-check mr-1"></i> Evita usar información personal fácilmente identificable.</li>
                <li><i class="fas fa-check mr-1"></i> Cambia tu contraseña regularmente.</li>
                <li><i class="fas fa-check mr-1"></i> No uses la misma contraseña en múltiples sitios.</li>
            </ul>
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
