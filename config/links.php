<?php
// Configuración de enlaces y navegación
return [
    // URLs principales
    'base_url' => '',
    'assets_url' => 'assets/',
    'images_url' => 'imaganes/',
    
    // Navegación principal
    'menu_principal' => [
        'inicio' => [
            'texto' => 'Inicio',
            'url' => 'index.php',
            'activo' => false
        ],
        'servicios' => [
            'texto' => 'Servicios',
            'url' => 'servicios.php',
            'activo' => false,
            'submenu' => true
        ],
        'empresa' => [
            'texto' => 'Empresa',
            'url' => 'empresa.php',
            'activo' => false
        ],
        'contacto' => [
            'texto' => 'Contacto',
            'url' => 'contacto.php',
            'activo' => false
        ]
    ],
    
    // Enlaces de servicios para el dropdown
    'menu_servicios' => [
        'todos' => [
            'texto' => 'Todos los Servicios',
            'url' => 'servicios.php'
        ],
        'murcielagos' => [
            'texto' => 'Control de Murciélagos',
            'url' => 'servicio-detalle.php?servicio=murcielagos'
        ],
        'termitas' => [
            'texto' => 'Control de Termitas',
            'url' => 'servicio-detalle.php?servicio=termitas'
        ],
        'cucarachas' => [
            'texto' => 'Control de Cucarachas',
            'url' => 'servicio-detalle.php?servicio=cucarachas'
        ],
        'serpientes' => [
            'texto' => 'Control de Serpientes',
            'url' => 'servicio-detalle.php?servicio=serpientes'
        ],
        'ratones' => [
            'texto' => 'Control de Ratones',
            'url' => 'servicio-detalle.php?servicio=ratones'
        ],
        'desinfeccion' => [
            'texto' => 'Desinfección',
            'url' => 'servicio-detalle.php?servicio=desinfeccion'
        ],
        'hormigas' => [
            'texto' => 'Control de Hormigas',
            'url' => 'servicio-detalle.php?servicio=hormigas'
        ],
        'mosquitos' => [
            'texto' => 'Control de Mosquitos',
            'url' => 'servicio-detalle.php?servicio=mosquitos'
        ]
    ],
    
    // Enlaces del footer
    'footer_links' => [
        'servicios_rapidos' => [
            'titulo' => 'Servicios Principales',
            'enlaces' => [
                'Control de Cucarachas' => 'servicio-detalle.php?servicio=cucarachas',
                'Control de Ratones' => 'servicio-detalle.php?servicio=ratones',
                'Control de Termitas' => 'servicio-detalle.php?servicio=termitas',
                'Desinfección' => 'servicio-detalle.php?servicio=desinfeccion'
            ]
        ],
        'empresa_info' => [
            'titulo' => 'Empresa',
            'enlaces' => [
                'Quiénes Somos' => 'empresa.php',
                'Misión y Visión' => 'empresa.php#mision-vision',
                'Certificaciones' => 'empresa.php#certificaciones',
                'Contacto' => 'contacto.php'
            ]
        ]
    ],
    
    // Enlaces externos
    'externos' => [
        'whatsapp_web' => 'https://wa.me/593986206825?text=Hola,%20necesito%20información%20sobre%20sus%20servicios%20de%20control%20de%20plagas',
        'google_maps' => 'https://www.google.com/maps/place/Alborada+14+Etapa,+Guayaquil',
        'facebook' => 'https://facebook.com/fastcontrolpest',
        'instagram' => 'https://instagram.com/fast_control_pest'
    ],
    
    // Configuración de carrusel
    'carrusel_imagenes' => [
        'imaganes/WhatsApp Image 2025-09-11 at 12.45.30 PM (1).jpeg',
        'imaganes/WhatsApp Image 2025-09-11 at 12.45.30 PM (2).jpeg',
        'imaganes/WhatsApp Image 2025-09-11 at 12.45.31 PM (1).jpeg',
        'imaganes/WhatsApp Image 2025-09-11 at 12.45.31 PM (2).jpeg',
        'imaganes/WhatsApp Image 2025-09-11 at 12.45.31 PM (3).jpeg'
    ]
];
?>
