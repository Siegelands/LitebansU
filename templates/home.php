    <div class="w-full">
<!-- Hero Section -->
<section class="hero-section relative min-h-screen flex items-center justify-center px-4 overflow-hidden">
    <!-- Background gradient -->
    <div class="absolute inset-0 bg-gradient-to-br from-white via-gray-50 to-white -z-10"></div>
    
    <div class="max-w-4xl mx-auto text-center" data-animate>
        <div class="mb-6 inline-block">
            <div class="w-16 h-16 bg-gradient-to-br from-gray-900 to-gray-700 rounded-full flex items-center justify-center shadow-luxury">
                <i class="fas fa-shield-alt text-white text-2xl"></i>
            </div>
        </div>
        
        <h1 class="text-5xl md:text-6xl font-bold tracking-tight text-gray-900 mb-6 leading-tight">
            <?= htmlspecialchars($lang->get('home.welcome'), ENT_QUOTES, 'UTF-8') ?>
        </h1>
        
        <p class="text-xl md:text-2xl text-gray-600 leading-relaxed max-w-2xl mx-auto mb-12">
            <?= htmlspecialchars($lang->get('home.description'), ENT_QUOTES, 'UTF-8') ?>
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= htmlspecialchars($config['base_path'] . 'punishments', ENT_QUOTES, 'UTF-8') ?>" class="px-8 py-3 bg-gray-900 text-white rounded-lg font-semibold hover:bg-gray-800 transition-colors inline-flex items-center gap-2">
                <i class="fas fa-list"></i>
                <?= htmlspecialchars($lang->get('nav.punishments') ?? 'View Punishments', ENT_QUOTES, 'UTF-8') ?>
            </a>
            <a href="#search-section" class="px-8 py-3 bg-white text-gray-900 border border-gray-200 rounded-lg font-semibold hover:bg-gray-50 transition-colors inline-flex items-center gap-2">
                <i class="fas fa-search"></i>
                <?= htmlspecialchars($lang->get('search.title') ?? 'Search', ENT_QUOTES, 'UTF-8') ?>
            </a>
        </div>
    </div>
</section>


<!-- Search Section -->
<section class="py-20 px-4" id="search-section">
    <div class="max-w-4xl mx-auto" data-animate>
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                <i class="fas fa-search text-gray-700 mr-3"></i>
                <?= htmlspecialchars($lang->get('search.title'), ENT_QUOTES, 'UTF-8') ?>
            </h2>
            <p class="text-lg text-gray-600">
                <?= htmlspecialchars($lang->get('search.help'), ENT_QUOTES, 'UTF-8') ?>
            </p>
        </div>
        
        <div class="bg-white/80 backdrop-blur-md border border-gray-200/50 rounded-2xl shadow-luxury p-8">
            <form id="search-form" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(SecurityManager::generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-grow">
                        <div class="relative">
                            <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input 
                                type="text" 
                                id="search-input"
                                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all"
                                placeholder="<?= htmlspecialchars($lang->get('search.placeholder'), ENT_QUOTES, 'UTF-8') ?>"
                                autocomplete="off"
                                maxlength="36"
                            >
                        </div>
                    </div>
                    <button type="submit" class="px-8 py-3 bg-gray-900 text-white rounded-lg font-semibold hover:bg-gray-800 transition-colors whitespace-nowrap inline-flex items-center justify-center gap-2">
                        <i class="fas fa-search"></i>
                        <?= htmlspecialchars($lang->get('search.button'), ENT_QUOTES, 'UTF-8') ?>
                    </button>
                </div>
            </form>
            
            <div id="search-results" class="mt-8"></div>
        </div>
    </div>
</section>

<?php if (isset($searchQuery) && !empty($searchQuery)): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const searchForm = document.getElementById('search-form');
    
    if (searchInput && searchForm) {
        searchInput.value = <?= json_encode($searchQuery) ?>;
        setTimeout(() => {
            searchForm.dispatchEvent(new Event('submit'));
        }, 100);
    }
});
</script>
<?php endif; ?>

<!-- Statistics Section -->
<section class="py-20 px-4 bg-gradient-to-br from-gray-50 via-white to-gray-50">
    <div class="max-w-6xl mx-auto" data-animate>
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                <i class="fas fa-chart-bar text-gray-700 mr-3"></i>
                <?= htmlspecialchars($lang->get('stats.title'), ENT_QUOTES, 'UTF-8') ?>
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                <?= htmlspecialchars($lang->get('stats.overview') ?? 'Real-time statistics and activity', ENT_QUOTES, 'UTF-8') ?>
            </p>
        </div>
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Bans Card -->
            <div class="stat-card group cursor-pointer" data-animate>
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-200 transition-colors">
                        <i class="fas fa-ban text-red-600 text-xl"></i>
                    </div>
                    <?php if (($stats['bans_active'] ?? 0) > 0): ?>
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                        <?= htmlspecialchars($lang->get('stats.active'), ENT_QUOTES, 'UTF-8') ?>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="stat-number text-4xl font-bold text-gray-900 mb-2">
                    <?= number_format($stats['bans_active'] ?? 0) ?>
                </div>
                <div class="stat-label text-sm text-gray-600 font-medium mb-1">
                    <?= htmlspecialchars($lang->get('stats.active_bans'), ENT_QUOTES, 'UTF-8') ?>
                </div>
                <div class="text-xs text-gray-500">
                    <?= htmlspecialchars($lang->get('stats.total_of'), ENT_QUOTES, 'UTF-8') ?> <?= number_format($stats['bans'] ?? 0) ?> total
                </div>
            </div>
            
            <!-- Mutes Card -->
            <div class="stat-card group cursor-pointer" data-animate>
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                        <i class="fas fa-volume-mute text-amber-600 text-xl"></i>
                    </div>
                    <?php if (($stats['mutes_active'] ?? 0) > 0): ?>
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">
                        <?= htmlspecialchars($lang->get('stats.active'), ENT_QUOTES, 'UTF-8') ?>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="stat-number text-4xl font-bold text-gray-900 mb-2">
                    <?= number_format($stats['mutes_active'] ?? 0) ?>
                </div>
                <div class="stat-label text-sm text-gray-600 font-medium mb-1">
                    <?= htmlspecialchars($lang->get('stats.active_mutes'), ENT_QUOTES, 'UTF-8') ?>
                </div>
                <div class="text-xs text-gray-500">
                    <?= htmlspecialchars($lang->get('stats.total_of'), ENT_QUOTES, 'UTF-8') ?> <?= number_format($stats['mutes'] ?? 0) ?> total
                </div>
            </div>
            
            <!-- Warnings Card -->
            <div class="stat-card group cursor-pointer" data-animate>
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <i class="fas fa-exclamation-triangle text-blue-600 text-xl"></i>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                        <?= htmlspecialchars($lang->get('stats.all_time'), ENT_QUOTES, 'UTF-8') ?>
                    </span>
                </div>
                <div class="stat-number text-4xl font-bold text-gray-900 mb-2">
                    <?= number_format($stats['warnings'] ?? 0) ?>
                </div>
                <div class="stat-label text-sm text-gray-600 font-medium mb-1">
                    <?= htmlspecialchars($lang->get('stats.total_warnings'), ENT_QUOTES, 'UTF-8') ?>
                </div>
                <div class="text-xs text-gray-500">
                    All-time total
                </div>
            </div>
            
            <!-- Kicks Card -->
            <div class="stat-card group cursor-pointer" data-animate>
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                        <i class="fas fa-sign-out-alt text-purple-600 text-xl"></i>
                    </div>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                        <?= htmlspecialchars($lang->get('stats.all_time'), ENT_QUOTES, 'UTF-8') ?>
                    </span>
                </div>
                <div class="stat-number text-4xl font-bold text-gray-900 mb-2">
                    <?= number_format($stats['kicks'] ?? 0) ?>
                </div>
                <div class="stat-label text-sm text-gray-600 font-medium mb-1">
                    <?= htmlspecialchars($lang->get('stats.total_kicks'), ENT_QUOTES, 'UTF-8') ?>
                </div>
                <div class="text-xs text-gray-500">
                    All-time total
                </div>
            </div>
        </div>
        
        <!-- View More Button -->
        <div class="text-center">
            <a href="<?= htmlspecialchars($config['base_path'] . 'stats', ENT_QUOTES, 'UTF-8') ?>" class="inline-flex items-center gap-2 px-8 py-3 bg-gray-900 text-white rounded-lg font-semibold hover:bg-gray-800 transition-colors">
                <i class="fas fa-chart-line"></i>
                <?= htmlspecialchars($lang->get('stats.view_detailed') ?? 'View Detailed Statistics', ENT_QUOTES, 'UTF-8') ?>
            </a>
        </div>
    </div>
</section>


<!-- Recent Activity Section -->
<section class="py-20 px-4">
    <div class="max-w-6xl mx-auto" data-animate>
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                <i class="fas fa-history text-gray-700 mr-3"></i>
                <?= htmlspecialchars($lang->get('home.recent_activity'), ENT_QUOTES, 'UTF-8') ?>
            </h2>
            <p class="text-lg text-gray-600">
                <?= htmlspecialchars($lang->get('home.latest_punishments') ?? 'Latest punishments and violations', ENT_QUOTES, 'UTF-8') ?>
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Bans -->
            <div class="card" data-animate>
                <div class="border-b border-gray-200/50 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-ban text-red-600"></i>
                        <?= htmlspecialchars($lang->get('home.recent_bans'), ENT_QUOTES, 'UTF-8') ?>
                    </h3>
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                        <?= count($recentBans) ?>
                    </span>
                </div>
                <div class="p-6">
                    <?php if (empty($recentBans)): ?>
                    <div class="text-center py-12">
                        <i class="fas fa-check-circle text-green-500 text-4xl mb-4"></i>
                        <p class="text-gray-600">
                            <?= htmlspecialchars($lang->get('home.no_recent_bans'), ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    </div>
                    <?php else: ?>
                    <div class="space-y-4">
                        <?php $banCount = 0; foreach ($recentBans as $ban): 
                            if ($banCount++ >= 5) break;
                            $playerName = $ban['player_name'] ?? $ban['name'] ?? 'Unknown';
                            $uuid = $ban['uuid'] ?? '';
                        ?>
                        <a href="<?= htmlspecialchars(url('detail?type=ban&id=' . $ban['id']), ENT_QUOTES, 'UTF-8') ?>" class="group block p-4 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <img src="<?= htmlspecialchars($controller->getAvatarUrl($uuid, $playerName), ENT_QUOTES, 'UTF-8') ?>" 
                                     alt="<?= htmlspecialchars($playerName, ENT_QUOTES, 'UTF-8') ?>" 
                                     class="w-10 h-10 rounded-lg">
                                <div class="flex-grow min-w-0">
                                    <div class="font-semibold text-gray-900 group-hover:text-gray-700 truncate">
                                        <?= htmlspecialchars($playerName, ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                    <div class="text-sm text-gray-600 truncate">
                                        <?php 
                                        $reason = $ban['reason'] ?? 'No reason';
                                        echo htmlspecialchars(mb_substr($reason, 0, 50), ENT_QUOTES, 'UTF-8');
                                        if (mb_strlen($reason) > 50) echo '...';
                                        ?>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <div class="text-xs text-gray-500 whitespace-nowrap">
                                        <?= htmlspecialchars($controller->formatDate((int)$ban['time']), ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                    <?php if ($ban['active'] ?? false): ?>
                                    <span class="inline-block mt-1 px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold">Active</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                        <a href="<?= htmlspecialchars(url('bans'), ENT_QUOTES, 'UTF-8') ?>" class="inline-flex items-center gap-2 text-gray-900 hover:text-gray-700 font-semibold text-sm">
                            <i class="fas fa-arrow-right"></i>
                            <?= htmlspecialchars($lang->get('home.view_all_bans') ?? 'View All Bans', ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Recent Mutes -->
            <div class="card" data-animate>
                <div class="border-b border-gray-200/50 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-volume-mute text-amber-600"></i>
                        <?= htmlspecialchars($lang->get('home.recent_mutes'), ENT_QUOTES, 'UTF-8') ?>
                    </h3>
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">
                        <?= count($recentMutes) ?>
                    </span>
                </div>
                <div class="p-6">
                    <?php if (empty($recentMutes)): ?>
                    <div class="text-center py-12">
                        <i class="fas fa-volume-up text-green-500 text-4xl mb-4"></i>
                        <p class="text-gray-600">
                            <?= htmlspecialchars($lang->get('home.no_recent_mutes'), ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    </div>
                    <?php else: ?>
                    <div class="space-y-4">
                        <?php $muteCount = 0; foreach ($recentMutes as $mute): 
                            if ($muteCount++ >= 5) break;
                            $playerName = $mute['player_name'] ?? $mute['name'] ?? 'Unknown';
                            $uuid = $mute['uuid'] ?? '';
                        ?>
                        <a href="<?= htmlspecialchars(url('detail?type=mute&id=' . $mute['id']), ENT_QUOTES, 'UTF-8') ?>" class="group block p-4 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <img src="<?= htmlspecialchars($controller->getAvatarUrl($uuid, $playerName), ENT_QUOTES, 'UTF-8') ?>" 
                                     alt="<?= htmlspecialchars($playerName, ENT_QUOTES, 'UTF-8') ?>" 
                                     class="w-10 h-10 rounded-lg">
                                <div class="flex-grow min-w-0">
                                    <div class="font-semibold text-gray-900 group-hover:text-gray-700 truncate">
                                        <?= htmlspecialchars($playerName, ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                    <div class="text-sm text-gray-600 truncate">
                                        <?php 
                                        $reason = $mute['reason'] ?? 'No reason';
                                        echo htmlspecialchars(mb_substr($reason, 0, 50), ENT_QUOTES, 'UTF-8');
                                        if (mb_strlen($reason) > 50) echo '...';
                                        ?>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <div class="text-xs text-gray-500 whitespace-nowrap">
                                        <?= htmlspecialchars($controller->formatDate((int)$mute['time']), ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                    <?php if ($mute['active'] ?? false): ?>
                                    <span class="inline-block mt-1 px-2 py-1 bg-amber-100 text-amber-700 rounded text-xs font-semibold">Active</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                        <a href="<?= htmlspecialchars(url('mutes'), ENT_QUOTES, 'UTF-8') ?>" class="inline-flex items-center gap-2 text-gray-900 hover:text-gray-700 font-semibold text-sm">
                            <i class="fas fa-arrow-right"></i>
                            <?= htmlspecialchars($lang->get('home.view_all_mutes') ?? 'View All Mutes', ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
    </div>
