    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-2">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-shield-alt text-primary text-2xl mr-3"></i>
                        <h3 class="text-2xl font-bold"><?php echo $empresa['nombre']; ?></h3>
                    </div>
                    <p class="text-gray-300 mb-4"><?php echo $empresa['descripcion']; ?></p>
                    
                    <!-- Contact Info -->
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <i class="fas fa-phone text-primary mr-3"></i>
                            <span><?php echo $empresa['telefono_display']; ?></span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-primary mr-3"></i>
                            <span><?php echo $empresa['email']; ?></span>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-primary mr-3 mt-1"></i>
                            <div>
                                <p><?php echo $empresa['direcciones']['guayaquil']['direccion']; ?></p>
                                <p class="text-sm text-gray-400"><?php echo $empresa['direcciones']['guayaquil']['ciudad']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Services -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-primary">Servicios Principales</h4>
                    <ul class="space-y-2">
                        <?php foreach($links['footer_links']['servicios_rapidos']['enlaces'] as $nombre => $url): ?>
                            <li>
                                <a href="<?php echo $url; ?>" class="text-gray-300 hover:text-primary transition-colors">
                                    <?php echo $nombre; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Company Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-primary">Empresa</h4>
                    <ul class="space-y-2">
                        <?php foreach($links['footer_links']['empresa_info']['enlaces'] as $nombre => $url): ?>
                            <li>
                                <a href="<?php echo $url; ?>" class="text-gray-300 hover:text-primary transition-colors">
                                    <?php echo $nombre; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <!-- Social Media -->
                    <div class="mt-6">
                        <h5 class="text-sm font-semibold mb-3">Síguenos</h5>
                        <div class="flex space-x-3">
                            <a href="<?php echo $empresa['redes']['facebook']; ?>" target="_blank" 
                               class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="<?php echo $empresa['redes']['instagram']; ?>" target="_blank" 
                               class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700 transition-colors">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="<?php echo $empresa['redes']['whatsapp']; ?>" target="_blank" 
                               class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center hover:bg-green-700 transition-colors">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Business Hours -->
            <div class="mt-8 pt-8 border-t border-gray-700">
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-lg font-semibold mb-4 text-primary">Horarios de Atención</h4>
                        <div class="space-y-2 text-gray-300">
                            <div class="flex justify-between">
                                <span>Lunes - Viernes:</span>
                                <span class="font-medium"><?php echo $empresa['horarios']['lunes_viernes']; ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Sábados:</span>
                                <span class="font-medium"><?php echo $empresa['horarios']['sabados']; ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Domingos:</span>
                                <span class="font-medium"><?php echo $empresa['horarios']['domingos']; ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-semibold mb-4 text-primary">Certificaciones</h4>
                        <div class="grid grid-cols-1 gap-2 text-sm text-gray-300">
                            <?php foreach($empresa['certificaciones'] as $cert): ?>
                                <div class="flex items-center">
                                    <i class="fas fa-certificate text-primary mr-2"></i>
                                    <?php echo $cert; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
                <p>&copy; <?php echo date('Y'); ?> <?php echo $empresa['nombre']; ?>. Todos los derechos reservados.</p>
                <p class="mt-2 text-sm">Control de Plagas Profesional en Guayaquil y Salinas</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animation on scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.animate-on-scroll');
            const windowHeight = window.innerHeight;

            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;

                if (elementTop < windowHeight - elementVisible) {
                    element.classList.add('animate-fade-in-up');
                }
            });
        }

        window.addEventListener('scroll', animateOnScroll);
        document.addEventListener('DOMContentLoaded', animateOnScroll);
    </script>

    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

</body>
</html>
