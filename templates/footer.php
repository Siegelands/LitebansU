</div>    </main>
    
    <!-- Footer -->
    <footer class="mt-20 border-t border-gray-200 bg-luxury-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-8">
                <!-- Brand -->
                <div>
                    <h3 class="font-bold text-lg tracking-tight mb-2">
                        <?= htmlspecialchars($config['site_name'], ENT_QUOTES, 'UTF-8') ?>
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        <?= htmlspecialchars($config['site_description'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>
                
                <!-- Links -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4 text-sm uppercase tracking-wide">
                        <?= htmlspecialchars($lang->get('footer.navigation') ?? 'Navigation', ENT_QUOTES, 'UTF-8') ?>
                    </h4>
                    <ul class="space-y-2">
                        <li><a href="<?= htmlspecialchars($config['base_path'], ENT_QUOTES, 'UTF-8') ?>" class="text-gray-600 hover:text-gray-900 transition-colors text-sm">
                            <?= htmlspecialchars($lang->get('nav.home') ?? 'Home', ENT_QUOTES, 'UTF-8') ?>
                        </a></li>
                        <li><a href="<?= htmlspecialchars($config['base_path'] . 'punishments', ENT_QUOTES, 'UTF-8') ?>" class="text-gray-600 hover:text-gray-900 transition-colors text-sm">
                            <?= htmlspecialchars($lang->get('nav.punishments') ?? 'Punishments', ENT_QUOTES, 'UTF-8') ?>
                        </a></li>
                        <li><a href="<?= htmlspecialchars($config['base_path'] . 'stats', ENT_QUOTES, 'UTF-8') ?>" class="text-gray-600 hover:text-gray-900 transition-colors text-sm">
                            <?= htmlspecialchars($lang->get('nav.statistics') ?? 'Statistics', ENT_QUOTES, 'UTF-8') ?>
                        </a></li>
                    </ul>
                </div>
                
                <!-- Legal -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4 text-sm uppercase tracking-wide">
                        <?= htmlspecialchars($lang->get('footer.legal') ?? 'Legal', ENT_QUOTES, 'UTF-8') ?>
                    </h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-gray-900 transition-colors text-sm">
                            <?= htmlspecialchars($lang->get('footer.privacy') ?? 'Privacy Policy', ENT_QUOTES, 'UTF-8') ?>
                        </a></li>
                        <li><a href="#" class="text-gray-600 hover:text-gray-900 transition-colors text-sm">
                            <?= htmlspecialchars($lang->get('footer.terms') ?? 'Terms of Service', ENT_QUOTES, 'UTF-8') ?>
                        </a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Section -->
            <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-600 text-sm text-center md:text-left">
                    &copy; <?= htmlspecialchars(date('Y') . ' ' . $config['site_name'], ENT_QUOTES, 'UTF-8') ?>
                    <span class="mx-2">•</span>
                    <span><?= htmlspecialchars($lang->get('footer.copyright') ?? 'All rights reserved.', ENT_QUOTES, 'UTF-8') ?></span>
                </p>
                <p class="text-gray-600 text-sm mt-4 md:mt-0">
                    LiteBansU v3.8
                </p>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="<?= htmlspecialchars(asset('assets/js/main.js'), ENT_QUOTES, 'UTF-8') ?>"></script>
    
    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
        
        // User menu toggle
        function toggleUserMenu() {
            const dropdown = document.getElementById('user-menu-dropdown');
            dropdown.classList.toggle('hidden');
        }
        
        // Close user menu when clicking outside
        document.addEventListener('click', function(e) {
            const userMenu = document.getElementById('user-menu');
            if (userMenu && !userMenu.contains(e.target)) {
                document.getElementById('user-menu-dropdown').classList.add('hidden');
            }
        });
        
        // Sticky navbar scroll behavior
        let lastScrollTop = 0;
        const navbar = document.getElementById('navbar');
        
        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > 100) {
                navbar.classList.add('shadow-luxury');
            } else {
                navbar.classList.remove('shadow-luxury');
            }
            
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });
        
        // Smooth scroll animations
        gsap.registerPlugin(ScrollTrigger);
        
        // Animate elements on scroll
        document.querySelectorAll('[data-animate]').forEach((el) => {
            gsap.to(el, {
                scrollTrigger: {
                    trigger: el,
                    start: 'top 80%',
                    onEnter: () => {
                        el.classList.remove('opacity-0', 'translate-y-10');
                        el.classList.add('opacity-100', 'translate-y-0');
                    }
                },
                duration: 0.8,
                ease: 'power2.out'
            });
        });
    </script>
</body>
</html>