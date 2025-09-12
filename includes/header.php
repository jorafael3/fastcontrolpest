<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $empresa['nombre']; ?> - Control de Plagas Profesional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#B91C1C',
                        'primary-dark': '#991B1B',
                        'primary-light': '#EF4444',
                        'secondary': '#1F2937',
                        'accent': '#F59E0B'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #B91C1C 0%, #991B1B 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .shadow-elegant {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .btn-primary {
            background: linear-gradient(135deg, #B91C1C 0%, #991B1B 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(185, 28, 28, 0.3);
        }
        .navbar-scroll {
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.95);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-white shadow-lg" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="index.php" class="text-2xl font-bold text-primary">
                        <i class="fas fa-shield-alt mr-2"></i>
                        <?php echo $empresa['nombre']; ?>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <?php foreach($links['menu_principal'] as $key => $item): ?>
                            <?php if($key === 'servicios'): ?>
                                <div class="relative group">
                                    <a href="<?php echo $item['url']; ?>" 
                                       class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                                        <?php echo $item['texto']; ?>
                                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                                    </a>
                                    <!-- Dropdown -->
                                    <div class="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-elegant opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                        <div class="py-2">
                                            <?php foreach($links['menu_servicios'] as $servicio): ?>
                                                <a href="<?php echo $servicio['url']; ?>" 
                                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary hover:text-white transition-colors">
                                                    <?php echo $servicio['texto']; ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <a href="<?php echo $item['url']; ?>" 
                                   class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                    <?php echo $item['texto']; ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        
                        <!-- Botón de llamar comentado - no funciona desde web
                        <a href="tel:<?php echo $empresa['telefono']; ?>" 
                           class="btn-primary text-white px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            Llamar Ahora
                        </a>
                        -->
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-700 hover:text-primary focus:outline-none" id="mobile-menu-button">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white shadow-lg">
                <?php foreach($links['menu_principal'] as $item): ?>
                    <a href="<?php echo $item['url']; ?>" 
                       class="text-gray-700 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">
                        <?php echo $item['texto']; ?>
                    </a>
                <?php endforeach; ?>
                <!-- Botón de llamar comentado - no funciona desde web
                <a href="tel:<?php echo $empresa['telefono']; ?>" 
                   class="btn-primary text-white block px-3 py-2 rounded-md text-base font-medium text-center mt-4">
                    <i class="fas fa-phone mr-2"></i>
                    Llamar Ahora
                </a>
                -->
            </div>
        </div>
    </nav>

    <!-- WhatsApp Floating Button -->
    <a href="<?php echo $links['externos']['whatsapp_web']; ?>" 
       target="_blank"
       class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 z-40 group">
        <i class="fab fa-whatsapp text-2xl"></i>
        <span class="absolute right-16 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-3 py-2 rounded-lg text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
            ¡Escríbenos por WhatsApp!
        </span>
    </a>

    <script>
        // Navbar scroll effect (mantener estilo consistente)
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            // La navbar ya tiene fondo blanco y sombra siempre
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scroll');
            } else {
                navbar.classList.remove('navbar-scroll');
            }
        });

        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
