    </main>
    
    <!-- Footer -->
    <footer class="border-t border-white/10 bg-[#02040a]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-8">
                <!-- Brand -->
                <div>
                    <h3 class="font-bold text-lg tracking-tight mb-2">
                        <?= htmlspecialchars($config['site_name'], ENT_QUOTES, 'UTF-8') ?>
                    </h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        <?= htmlspecialchars($config['site_description'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>
                
                <!-- Links -->
                <div>
                    <h4 class="font-semibold text-slate-100 mb-4 text-sm uppercase tracking-wide">
                        <?= htmlspecialchars($lang->get('footer.navigation') ?? 'Navigation', ENT_QUOTES, 'UTF-8') ?>
                    </h4>
                    <ul class="space-y-2">
                        <li><a href="<?= htmlspecialchars(url(), ENT_QUOTES, 'UTF-8') ?>" class="text-slate-400 hover:text-white transition-colors text-sm">
                            <?= htmlspecialchars($lang->get('nav.home') ?? 'Home', ENT_QUOTES, 'UTF-8') ?>
                        </a></li>
                        <li><a href="<?= htmlspecialchars(url('bans'), ENT_QUOTES, 'UTF-8') ?>" class="text-slate-400 hover:text-white transition-colors text-sm">
                            <?= htmlspecialchars($lang->get('nav.punishments') ?? 'Punishments', ENT_QUOTES, 'UTF-8') ?>
                        </a></li>
                        <li><a href="<?= htmlspecialchars(url('stats'), ENT_QUOTES, 'UTF-8') ?>" class="text-slate-400 hover:text-white transition-colors text-sm">
                            <?= htmlspecialchars($lang->get('nav.statistics') ?? 'Statistics', ENT_QUOTES, 'UTF-8') ?>
                        </a></li>
                    </ul>
                </div>
                
                <!-- Legal -->
                <div>
                    <h4 class="font-semibold text-slate-100 mb-4 text-sm uppercase tracking-wide">
                        <?= htmlspecialchars($lang->get('footer.legal') ?? 'Legal', ENT_QUOTES, 'UTF-8') ?>
                    </h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors text-sm">
                            <?= htmlspecialchars($lang->get('footer.privacy') ?? 'Privacy Policy', ENT_QUOTES, 'UTF-8') ?>
                        </a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors text-sm">
                            <?= htmlspecialchars($lang->get('footer.terms') ?? 'Terms of Service', ENT_QUOTES, 'UTF-8') ?>
                        </a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Section -->
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-slate-500 text-sm text-center md:text-left">
                    &copy; <?= htmlspecialchars(date('Y') . ' ' . $config['site_name'], ENT_QUOTES, 'UTF-8') ?>
                    <span class="mx-2">•</span>
                    <span><?= htmlspecialchars($lang->get('footer.copyright') ?? 'All rights reserved.', ENT_QUOTES, 'UTF-8') ?></span>
                </p>
                <p class="text-slate-500 text-sm mt-4 md:mt-0">
                    LiteBansU v3.8
                </p>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <?php
    $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $isAdminPage = ($currentPage ?? '') === 'admin' || str_contains($requestPath, '/admin');
    ?>
    <?php if ($isAdminPage): ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php endif; ?>
    <script src="<?= htmlspecialchars(asset('assets/js/main.js'), ENT_QUOTES, 'UTF-8') ?>"></script>
    
</body>
</html>
