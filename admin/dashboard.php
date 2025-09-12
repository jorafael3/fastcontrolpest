<?php
session_start();

// Verificar si está logueado
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

require_once '../config/data_loader.php';
$empresa = empresa();
$servicios = servicios();
$links = links();

// Procesar logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo $empresa['nombre']; ?></title>
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
                    <span class="mr-4 text-gray-600">¡Hola, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</span>
                    <a href="?action=logout" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        <i class="fas fa-sign-out-alt mr-1"></i> Salir
                    </a>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Panel de Administración</h1>
            <p class="text-gray-600">Gestiona los datos de tu sitio web desde aquí.</p>
        </div>
        
        <!-- Sections -->
        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-building"></i>
                    </div>
                    <h2 class="text-xl font-bold">Datos de la Empresa</h2>
                </div>
                <p class="text-gray-600 mb-4">Actualiza la información general de tu empresa, contactos, ubicaciones y más.</p>
                <a href="editar-empresa.php" class="inline-block bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition-colors">
                    Editar Datos
                </a>
            </div>
            
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    <h2 class="text-xl font-bold">Servicios</h2>
                </div>
                <p class="text-gray-600 mb-4">Administra los servicios que ofreces, descripciones, precios y más.</p>
                <a href="servicios.php" class="inline-block bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition-colors">
                    Gestionar Servicios
                </a>
            </div>
        </div>
        
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-link"></i>
                    </div>
                    <h2 class="text-xl font-bold">Enlaces y Navegación</h2>
                </div>
                <p class="text-gray-600 mb-4">Configura los enlaces del menú, redes sociales y otros links importantes.</p>
                <a href="enlaces.php" class="inline-block bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition-colors">
                    Editar Enlaces
                </a>
            </div>
            
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-database"></i>
                    </div>
                    <h2 class="text-xl font-bold">Respaldo y Base de Datos</h2>
                </div>
                <p class="text-gray-600 mb-4">Realiza respaldos de tus datos y configura la base de datos.</p>
                <a href="respaldo.php" class="inline-block bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition-colors">
                    Opciones de Respaldo
                </a>
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
