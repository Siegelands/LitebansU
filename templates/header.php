<!DOCTYPE html>
<html lang="<?= htmlspecialchars($config['site_lang'] ?? $lang->getCurrentLanguage(), ENT_QUOTES, 'UTF-8') ?>">
<head>
    <meta charset="<?= htmlspecialchars($config['site_charset'] ?? 'UTF-8', ENT_QUOTES, 'UTF-8') ?>">
    <meta name="viewport" content="<?= htmlspecialchars($config['site_viewport'] ?? 'width=device-width, initial-scale=1.0', ENT_QUOTES, 'UTF-8') ?>">
    <meta name="csrf-token" content="<?= htmlspecialchars(SecurityManager::generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
    <meta name="base-path" content="<?= htmlspecialchars($config['base_path'], ENT_QUOTES, 'UTF-8') ?>">
    <meta http-equiv="Content-Type" content="text/html; charset=<?= htmlspecialchars($config['site_charset'] ?? 'UTF-8', ENT_QUOTES, 'UTF-8') ?>">
    <meta name="robots" content="<?= htmlspecialchars($config['site_robots'] ?? 'index, follow', ENT_QUOTES, 'UTF-8') ?>">
    
    <!-- SEO Meta Tags -->
    <title><?php 
        if (isset($title)) {
            if (!empty($config['site_title_template'])) {
                echo htmlspecialchars(str_replace(['{page}', '{site}'], [$title, $config['site_name']], $config['site_title_template']), ENT_QUOTES, 'UTF-8');
            } else {
                echo htmlspecialchars($title . ' - ' . $config['site_name'], ENT_QUOTES, 'UTF-8');
            }
        } else {
            echo htmlspecialchars($config['site_name'], ENT_QUOTES, 'UTF-8');
        }
    ?></title>
    <meta name="description" content="<?= htmlspecialchars(isset($description) ? $description : $config['site_description'], ENT_QUOTES, 'UTF-8') ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?= htmlspecialchars($config['site_url'] . $_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8') ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= htmlspecialchars($config['site_favicon'] ?? asset('favicon.ico'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="apple-touch-icon" href="<?= htmlspecialchars($config['site_apple_icon'] ?? asset('apple-touch-icon.png'), ENT_QUOTES, 'UTF-8') ?>">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= htmlspecialchars(isset($title) ? $title . ' - ' . $config['site_name'] : $config['site_name'], ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description" content="<?= htmlspecialchars(isset($description) ? $description : $config['site_description'], ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:url" content="<?= htmlspecialchars($config['site_url'] . $_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= htmlspecialchars($config['site_name'], ENT_QUOTES, 'UTF-8') ?>">
    <?php if (isset($config['site_og_image'])): ?>
    <meta property="og:image" content="<?= htmlspecialchars($config['site_og_image'], ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?= htmlspecialchars(isset($title) ? $title . ' - ' . $config['site_name'] : $config['site_name'], ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars(isset($description) ? $description : $config['site_description'], ENT_QUOTES, 'UTF-8') ?>">
    <?php if (isset($config['site_twitter_site'])): ?>
    <meta name="twitter:site" content="<?= htmlspecialchars($config['site_twitter_site'], ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>
    
    <!-- Preconnect to external resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'display': ['-apple-system', 'BlinkMacSystemFont', 'San Francisco', 'Helvetica Neue', 'Segoe UI', 'Arial', 'sans-serif'],
                        'sans': ['-apple-system', 'BlinkMacSystemFont', 'San Francisco', 'Helvetica Neue', 'Segoe UI', 'Arial', 'sans-serif'],
                    },
                    colors: {
                        'luxury': {
                            50: '#fafafa',
                            100: '#f5f5f5',
                            200: '#efefef',
                            900: '#1a1a1a',
                        }
                    },
                    backdropBlur: {
                        xs: '2px',
                    },
                    boxShadow: {
                        'luxury': '0 10px 40px rgba(0, 0, 0, 0.08)',
                        'luxury-lg': '0 20px 60px rgba(0, 0, 0, 0.12)',
                        'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.1)',
                    }
                }
            },
            corePlugins: {
                backdropOpacity: true
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <!-- GSAP for animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    
    <!-- Modern CSS -->
    <link href="<?= htmlspecialchars(asset('assets/css/modern.css'), ENT_QUOTES, 'UTF-8') ?>" rel="stylesheet">
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#ffffff">
    
    <!-- Additional SEO Meta Tags -->
    <?php if (isset($config['site_keywords']) && !empty($config['site_keywords'])): ?>
    <meta name="keywords" content="<?= htmlspecialchars($config['site_keywords'], ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>
    <meta name="author" content="<?= htmlspecialchars($config['seo_organization_name'] ?? $config['site_name'], ENT_QUOTES, 'UTF-8') ?>">
    <meta name="rating" content="general">
    <meta name="revisit-after" content="7 days">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Enhanced SEO Meta Tags -->
    <meta name="distribution" content="global">
    <meta name="language" content="<?= htmlspecialchars($config['site_lang'] ?? $lang->getCurrentLanguage(), ENT_QUOTES, 'UTF-8') ?>">
    <meta name="generator" content="LiteBansU 3.0">
    <meta name="coverage" content="Worldwide">
    <meta name="target" content="all">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="<?= htmlspecialchars($config['site_name'], ENT_QUOTES, 'UTF-8') ?>">
    <meta name="application-name" content="<?= htmlspecialchars($config['site_name'], ENT_QUOTES, 'UTF-8') ?>">
    <meta name="msapplication-TileColor" content="<?= htmlspecialchars($config['site_theme_color'] ?? '#ef4444', ENT_QUOTES, 'UTF-8') ?>">
    <meta name="msapplication-config" content="none">
    
    <!-- Geo Meta Tags (Optional) -->
    <?php if (isset($config['seo_geo_region'])): ?>
    <meta name="geo.region" content="<?= htmlspecialchars($config['seo_geo_region'], ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>
    <?php if (isset($config['seo_geo_placename'])): ?>
    <meta name="geo.placename" content="<?= htmlspecialchars($config['seo_geo_placename'], ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>
    <?php if (isset($config['seo_geo_position'])): ?>
    <meta name="geo.position" content="<?= htmlspecialchars($config['seo_geo_position'], ENT_QUOTES, 'UTF-8') ?>">
    <meta name="ICBM" content="<?= htmlspecialchars($config['seo_geo_position'], ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>
    
    <!-- AI Search Engine Tags -->
    <meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="googlebot-news" content="index, follow">
    <?php if (isset($config['seo_ai_training']) && $config['seo_ai_training'] === false): ?>
    <meta name="robots" content="noai, noimageai">
    <?php endif; ?>
    
    <!-- Open Graph Enhanced -->
    <meta property="og:locale" content="<?= htmlspecialchars($config['seo_locale'] ?? 'en_US', ENT_QUOTES, 'UTF-8') ?>">
    <?php if (isset($config['seo_facebook_app_id'])): ?>
    <meta property="fb:app_id" content="<?= htmlspecialchars($config['seo_facebook_app_id'], ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>
    
    <!-- Twitter Card Enhanced -->
    <meta name="twitter:card" content="summary_large_image">
    <?php if (isset($config['seo_twitter_creator'])): ?>
    <meta name="twitter:creator" content="<?= htmlspecialchars($config['seo_twitter_creator'], ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>
    <?php if (isset($config['site_og_image'])): ?>
    <meta name="twitter:image" content="<?= htmlspecialchars($config['site_og_image'], ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>
    
    <!-- DNS Prefetch for Performance -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    
    <!-- Alternate Languages (if multilingual) -->
    <?php if (isset($config['seo_alternate_languages']) && is_array($config['seo_alternate_languages'])): ?>
    <?php foreach ($config['seo_alternate_languages'] as $langCode => $langUrl): ?>
    <link rel="alternate" hreflang="<?= htmlspecialchars($langCode, ENT_QUOTES, 'UTF-8') ?>" href="<?= htmlspecialchars($langUrl, ENT_QUOTES, 'UTF-8') ?>">
    <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- JSON-LD for SEO -->
    <!-- Schema.org Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "<?= htmlspecialchars($config['site_name'], ENT_QUOTES, 'UTF-8') ?>",
        "url": "<?= htmlspecialchars($config['site_url'], ENT_QUOTES, 'UTF-8') ?>",
        "description": "<?= htmlspecialchars($config['site_description'], ENT_QUOTES, 'UTF-8') ?>",
        "potentialAction": {
            "@type": "SearchAction",
            "target": {
                "@type": "EntryPoint",
                "urlTemplate": "<?= htmlspecialchars($config['site_url'], ENT_QUOTES, 'UTF-8') ?>/search?q={search_term_string}"
            },
            "query-input": "required name=search_term_string"
        }
    }
    </script>
    
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?= htmlspecialchars($config['seo_organization_name'] ?? $config['site_name'], ENT_QUOTES, 'UTF-8') ?>",
        "url": "<?= htmlspecialchars($config['site_url'], ENT_QUOTES, 'UTF-8') ?>",
        <?php if (isset($config['seo_organization_logo'])): ?>
        "logo": "<?= htmlspecialchars($config['seo_organization_logo'], ENT_QUOTES, 'UTF-8') ?>",
        <?php endif; ?>
        "sameAs": [
            <?php 
            $socialLinks = [];
            if (!empty($config['seo_social_facebook'])) $socialLinks[] = '"' . htmlspecialchars($config['seo_social_facebook'], ENT_QUOTES, 'UTF-8') . '"';
            if (!empty($config['seo_social_twitter'])) $socialLinks[] = '"' . htmlspecialchars($config['seo_social_twitter'], ENT_QUOTES, 'UTF-8') . '"';
            if (!empty($config['seo_social_youtube'])) $socialLinks[] = '"' . htmlspecialchars($config['seo_social_youtube'], ENT_QUOTES, 'UTF-8') . '"';
            echo implode(',', $socialLinks);
            ?>
        ],
        "contactPoint": {
            "@type": "ContactPoint",
            "contactType": "<?= htmlspecialchars($config['seo_contact_type'] ?? 'customer service', ENT_QUOTES, 'UTF-8') ?>",
            <?php if (isset($config['seo_contact_phone'])): ?>
            "telephone": "<?= htmlspecialchars($config['seo_contact_phone'], ENT_QUOTES, 'UTF-8') ?>",
            <?php endif; ?>
            <?php if (isset($config['seo_contact_email'])): ?>
            "email": "<?= htmlspecialchars($config['seo_contact_email'], ENT_QUOTES, 'UTF-8') ?>"
            <?php endif; ?>
        }
    }
    </script>
    
    <?php if (isset($config['seo_enable_breadcrumbs']) && $config['seo_enable_breadcrumbs'] && isset($breadcrumbs) && is_array($breadcrumbs)): ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            <?php 
            $breadcrumbItems = [];
            foreach ($breadcrumbs as $index => $crumb) {
                $breadcrumbItems[] = '{
                    "@type": "ListItem",
                    "position": ' . ($index + 1) . ',
                    "name": "' . htmlspecialchars($crumb['name'], ENT_QUOTES, 'UTF-8') . '",
                    "item": "' . htmlspecialchars($crumb['url'], ENT_QUOTES, 'UTF-8') . '"
                }';
            }
            echo implode(',', $breadcrumbItems);
            ?>
        ]
    }
    </script>
    <?php endif; ?>
    
    <?php if (($currentPage ?? '') === 'home' || !isset($currentPage)): ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "SoftwareApplication",
        "name": "<?= htmlspecialchars($config['site_name'], ENT_QUOTES, 'UTF-8') ?>",
        "applicationCategory": "Game",
        "operatingSystem": "Web",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "<?= htmlspecialchars($config['seo_price_currency'] ?? 'EUR', ENT_QUOTES, 'UTF-8') ?>"
        }
    }
    </script>
    <?php endif; ?>
</head>
<body class="bg-white text-gray-900 font-display antialiased">
    <!-- Sticky Navigation Bar with Glassmorphism -->
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" id="navbar">
        <div class="backdrop-blur-md bg-white/70 border-b border-gray-200/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="<?= htmlspecialchars($config['base_path'], ENT_QUOTES, 'UTF-8') ?>" class="font-bold text-xl tracking-tight hover:opacity-80 transition-opacity">
                            <?= htmlspecialchars($config['site_name'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="<?= htmlspecialchars($config['base_path'], ENT_QUOTES, 'UTF-8') ?>" class="text-sm font-medium text-gray-900 hover:text-gray-600 transition-colors">
                            <?= htmlspecialchars($lang->get('nav.home') ?? 'Home', ENT_QUOTES, 'UTF-8') ?>
                        </a>
                        <a href="<?= htmlspecialchars($config['base_path'] . 'punishments', ENT_QUOTES, 'UTF-8') ?>" class="text-sm font-medium text-gray-900 hover:text-gray-600 transition-colors">
                            <?= htmlspecialchars($lang->get('nav.punishments') ?? 'Punishments', ENT_QUOTES, 'UTF-8') ?>
                        </a>
                        <a href="<?= htmlspecialchars($config['base_path'] . 'stats', ENT_QUOTES, 'UTF-8') ?>" class="text-sm font-medium text-gray-900 hover:text-gray-600 transition-colors">
                            <?= htmlspecialchars($lang->get('nav.statistics') ?? 'Statistics', ENT_QUOTES, 'UTF-8') ?>
                        </a>
                        
                        <?php if (AuthManager::isAuthenticated()): ?>
                        <a href="<?= htmlspecialchars($config['base_path'] . 'admin', ENT_QUOTES, 'UTF-8') ?>" class="text-sm font-medium text-gray-900 hover:text-gray-600 transition-colors">
                            <?= htmlspecialchars($lang->get('nav.admin') ?? 'Admin', ENT_QUOTES, 'UTF-8') ?>
                        </a>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Auth & Mobile Menu -->
                    <div class="flex items-center space-x-4">
                        <?php if (!AuthManager::isAuthenticated()): ?>
                        <a href="<?= htmlspecialchars($config['base_path'] . 'admin/login', ENT_QUOTES, 'UTF-8') ?>" class="hidden sm:inline-flex px-6 py-2 rounded-lg text-sm font-semibold text-white bg-gray-900 hover:bg-gray-800 transition-colors">
                            <?= htmlspecialchars($lang->get('nav.login') ?? 'Sign In', ENT_QUOTES, 'UTF-8') ?>
                        </a>
                        <?php else: ?>
                        <div class="relative" id="user-menu">
                            <button onclick="toggleUserMenu()" class="px-6 py-2 rounded-lg text-sm font-semibold text-white bg-gray-900 hover:bg-gray-800 transition-colors flex items-center gap-2">
                                <i class="fas fa-user text-sm"></i>
                                <span class="hidden sm:inline"><?= htmlspecialchars($lang->get('nav.menu') ?? 'Menu', ENT_QUOTES, 'UTF-8') ?></span>
                            </button>
                            <div id="user-menu-dropdown" class="hidden absolute right-0 mt-2 w-48 rounded-lg shadow-luxury-lg bg-white border border-gray-200">
                                <a href="<?= htmlspecialchars($config['base_path'] . 'admin', ENT_QUOTES, 'UTF-8') ?>" class="block px-4 py-3 text-sm text-gray-900 hover:bg-gray-50 transition-colors first:rounded-t-lg">
                                    <?= htmlspecialchars($lang->get('nav.admin_panel') ?? 'Admin Panel', ENT_QUOTES, 'UTF-8') ?>
                                </a>
                                <a href="<?= htmlspecialchars($config['base_path'] . 'admin/logout', ENT_QUOTES, 'UTF-8') ?>" class="block px-4 py-3 text-sm text-red-600 hover:bg-gray-50 transition-colors last:rounded-b-lg border-t border-gray-200">
                                    <?= htmlspecialchars($lang->get('nav.logout') ?? 'Sign Out', ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Mobile Menu Button -->
                        <button onclick="toggleMobileMenu()" class="md:hidden text-gray-900 hover:text-gray-600 transition-colors">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden fixed top-16 left-0 right-0 bg-white border-b border-gray-200 md:hidden z-40">
        <div class="px-4 py-4 space-y-2">
            <a href="<?= htmlspecialchars($config['base_path'], ENT_QUOTES, 'UTF-8') ?>" class="block px-4 py-2 rounded-lg text-gray-900 hover:bg-gray-100 transition-colors">
                <?= htmlspecialchars($lang->get('nav.home') ?? 'Home', ENT_QUOTES, 'UTF-8') ?>
            </a>
            <a href="<?= htmlspecialchars($config['base_path'] . 'punishments', ENT_QUOTES, 'UTF-8') ?>" class="block px-4 py-2 rounded-lg text-gray-900 hover:bg-gray-100 transition-colors">
                <?= htmlspecialchars($lang->get('nav.punishments') ?? 'Punishments', ENT_QUOTES, 'UTF-8') ?>
            </a>
            <a href="<?= htmlspecialchars($config['base_path'] . 'stats', ENT_QUOTES, 'UTF-8') ?>" class="block px-4 py-2 rounded-lg text-gray-900 hover:bg-gray-100 transition-colors">
                <?= htmlspecialchars($lang->get('nav.statistics') ?? 'Statistics', ENT_QUOTES, 'UTF-8') ?>
            </a>
            <?php if (!AuthManager::isAuthenticated()): ?>
            <a href="<?= htmlspecialchars($config['base_path'] . 'admin/login', ENT_QUOTES, 'UTF-8') ?>" class="block px-4 py-2 rounded-lg text-gray-900 hover:bg-gray-100 transition-colors sm:hidden">
                <?= htmlspecialchars($lang->get('nav.login') ?? 'Sign In', ENT_QUOTES, 'UTF-8') ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Main Content with Padding for Fixed Nav -->
    <main class="pt-16">
