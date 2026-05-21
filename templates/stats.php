<?php
$metricCards = [
    ['label' => $lang->get('stats.active_bans'), 'value' => $stats['bans_active'] ?? 0, 'total' => ($lang->get('stats.total_of') . ' ' . number_format($stats['bans'] ?? 0)), 'badge' => $lang->get('stats.active'), 'icon' => 'fa-ban', 'tone' => 'text-rose-600 bg-rose-50'],
    ['label' => $lang->get('stats.active_mutes'), 'value' => $stats['mutes_active'] ?? 0, 'total' => ($lang->get('stats.total_of') . ' ' . number_format($stats['mutes'] ?? 0)), 'badge' => $lang->get('stats.active'), 'icon' => 'fa-volume-mute', 'tone' => 'text-amber-600 bg-amber-50'],
    ['label' => $lang->get('stats.total_warnings'), 'value' => $stats['warnings'] ?? 0, 'total' => $lang->get('stats.all_time'), 'badge' => $lang->get('stats.all_time'), 'icon' => 'fa-exclamation-triangle', 'tone' => 'text-sky-600 bg-sky-50'],
    ['label' => $lang->get('stats.total_kicks'), 'value' => $stats['kicks'] ?? 0, 'total' => $lang->get('stats.all_time'), 'badge' => $lang->get('stats.all_time'), 'icon' => 'fa-sign-out-alt', 'tone' => 'text-gray-700 bg-gray-100'],
];

$activityWindows = [
    'last_24h' => $lang->get('stats.last_24h'),
    'last_7d' => $lang->get('stats.last_7d'),
    'last_30d' => $lang->get('stats.last_30d'),
];
?>

<div class="min-h-screen bg-[radial-gradient(circle_at_top,#f8fafc_0%,#ffffff_44%,#f4f4f5_100%)]">
    <section class="relative overflow-hidden px-4 py-20 sm:py-28">
        <div class="absolute inset-x-0 top-0 h-80 bg-gradient-to-b from-gray-100/90 to-transparent pointer-events-none"></div>
        <div class="relative mx-auto max-w-7xl text-center" data-animate>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-gray-500"><?= htmlspecialchars($config['site_name'], ENT_QUOTES, 'UTF-8') ?> Intelligence</p>
            <h1 class="mx-auto mt-5 max-w-4xl text-5xl font-bold tracking-tight text-gray-950 sm:text-7xl">
                <?= htmlspecialchars($lang->get('nav.statistics'), ENT_QUOTES, 'UTF-8') ?>
            </h1>
            <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-gray-600">
                <?= htmlspecialchars($lang->get('stats.overview'), ENT_QUOTES, 'UTF-8') ?>
            </p>
            <div class="mt-9 flex justify-center">
                <button id="clear-cache-btn" type="button" class="inline-flex items-center gap-2 rounded-full bg-gray-950 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-gray-950/10 transition hover:bg-gray-800 hover:scale-[1.02]">
                    <i class="fas fa-sync-alt text-xs"></i>
                    <?= htmlspecialchars($lang->get('stats.clear_cache'), ENT_QUOTES, 'UTF-8') ?>
                </button>
            </div>
        </div>
    </section>

    <section class="px-4 pb-20">
        <div class="mx-auto max-w-7xl">
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <?php foreach ($metricCards as $metric): ?>
                <article class="group rounded-[2rem] border border-gray-200/70 bg-white/80 p-7 shadow-sm shadow-gray-950/5 backdrop-blur transition hover:-translate-y-1 hover:shadow-2xl hover:shadow-gray-950/10" data-animate>
                    <div class="mb-8 flex items-center justify-between">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl <?= htmlspecialchars($metric['tone'], ENT_QUOTES, 'UTF-8') ?>">
                            <i class="fas <?= htmlspecialchars($metric['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                        </span>
                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-gray-500"><?= htmlspecialchars($metric['badge'], ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <div class="text-5xl font-bold tracking-tight text-gray-950"><?= number_format($metric['value']) ?></div>
                    <div class="mt-3 text-sm font-semibold uppercase tracking-wide text-gray-500"><?= htmlspecialchars($metric['label'], ENT_QUOTES, 'UTF-8') ?></div>
                    <div class="mt-2 text-sm text-gray-400"><?= htmlspecialchars($metric['total'], ENT_QUOTES, 'UTF-8') ?></div>
                </article>
                <?php endforeach; ?>
            </div>

            <?php if (!empty($stats['recent_activity'])): ?>
            <section class="mt-20" data-animate>
                <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500">Momentum</p>
                        <h2 class="mt-3 text-4xl font-bold text-gray-950"><?= htmlspecialchars($lang->get('stats.recent_activity_overview'), ENT_QUOTES, 'UTF-8') ?></h2>
                    </div>
                </div>
                <div class="grid gap-5 lg:grid-cols-3">
                    <?php foreach ($activityWindows as $key => $label): $window = $stats['recent_activity'][$key] ?? []; ?>
                    <article class="rounded-[2rem] border border-gray-200/70 bg-white/80 p-6 shadow-sm shadow-gray-950/5 backdrop-blur">
                        <h3 class="text-lg font-bold text-gray-950"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></h3>
                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <?php foreach (['bans' => 'Bans', 'mutes' => 'Mutes', 'warnings' => 'Warnings', 'kicks' => 'Kicks'] as $field => $labelText): ?>
                            <div class="rounded-2xl bg-gray-50 p-4">
                                <div class="text-2xl font-bold text-gray-950"><?= number_format($window[$field] ?? 0) ?></div>
                                <div class="mt-1 text-xs font-semibold uppercase tracking-wide text-gray-500"><?= htmlspecialchars($labelText, ENT_QUOTES, 'UTF-8') ?></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <div class="mt-20 grid gap-6 lg:grid-cols-2">
                <?php if (!empty($stats['top_banned_players'])): ?>
                <section class="rounded-[2rem] border border-gray-200/70 bg-white/80 p-6 shadow-xl shadow-gray-950/5 backdrop-blur" data-animate>
                    <h2 class="text-2xl font-bold text-gray-950"><?= htmlspecialchars($lang->get('stats.most_banned_players'), ENT_QUOTES, 'UTF-8') ?></h2>
                    <div class="mt-6 space-y-3">
                        <?php $rank = 1; foreach ($stats['top_banned_players'] as $player): $playerName = $player['player_name'] ?? 'Unknown'; $skinUrl = 'https://visage.surgeplay.com/bust/128/' . rawurlencode($playerName); ?>
                        <div class="flex items-center gap-4 rounded-2xl bg-gray-50/80 p-4">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-950 text-sm font-bold text-white"><?= $rank++ ?></span>
                            <img src="<?= htmlspecialchars($skinUrl, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($playerName, ENT_QUOTES, 'UTF-8') ?>" class="h-12 w-12 rounded-2xl object-contain" onerror="this.onerror=null;this.src='https://visage.surgeplay.com/bust/128/MHF_Steve';">
                            <div class="min-w-0 flex-1">
                                <div class="truncate font-bold text-gray-950"><?= htmlspecialchars($playerName, ENT_QUOTES, 'UTF-8') ?></div>
                                <div class="text-xs text-gray-500">Last: <?= htmlspecialchars($this->formatDate((int)$player['last_ban_time']), ENT_QUOTES, 'UTF-8') ?></div>
                            </div>
                            <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-bold text-rose-700"><?= (int)$player['ban_count'] ?> bans</span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>

                <?php if (!empty($stats['most_active_staff'])): ?>
                <section class="rounded-[2rem] border border-gray-200/70 bg-white/80 p-6 shadow-xl shadow-gray-950/5 backdrop-blur" data-animate>
                    <h2 class="text-2xl font-bold text-gray-950"><?= htmlspecialchars($lang->get('stats.most_active_staff'), ENT_QUOTES, 'UTF-8') ?></h2>
                    <div class="mt-6 space-y-3">
                        <?php $rank = 1; foreach ($stats['most_active_staff'] as $staff): ?>
                        <div class="flex items-center gap-4 rounded-2xl bg-gray-50/80 p-4">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-950 text-sm font-bold text-white"><?= $rank++ ?></span>
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-gray-100 text-gray-700"><i class="fas fa-user-shield"></i></span>
                            <div class="min-w-0 flex-1">
                                <div class="truncate font-bold text-gray-950"><?= htmlspecialchars(SecurityManager::preventXss($staff['staff_name']), ENT_QUOTES, 'UTF-8') ?></div>
                                <div class="text-xs text-gray-500"><?= (int)$staff['bans'] ?>B · <?= (int)$staff['mutes'] ?>M · <?= (int)$staff['warnings'] ?>W · <?= (int)$staff['kicks'] ?>K</div>
                            </div>
                            <span class="rounded-full bg-gray-950 px-3 py-1 text-xs font-bold text-white"><?= (int)$staff['total_punishments'] ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>
            </div>

            <?php if (!empty($stats['top_ban_reasons'])): ?>
            <section class="mt-20 rounded-[2rem] border border-gray-200/70 bg-white/80 p-6 shadow-xl shadow-gray-950/5 backdrop-blur" data-animate>
                <h2 class="text-2xl font-bold text-gray-950"><?= htmlspecialchars($lang->get('stats.top_ban_reasons'), ENT_QUOTES, 'UTF-8') ?></h2>
                <div class="mt-6 grid gap-3 md:grid-cols-2">
                    <?php foreach ($stats['top_ban_reasons'] as $reason): ?>
                    <div class="flex items-center justify-between gap-4 rounded-2xl bg-gray-50/80 p-4">
                        <span class="min-w-0 truncate font-semibold text-gray-800"><?= htmlspecialchars(mb_substr($reason['reason'], 0, 80), ENT_QUOTES, 'UTF-8') ?><?= mb_strlen($reason['reason']) > 80 ? '...' : '' ?></span>
                        <span class="rounded-full bg-gray-950 px-3 py-1 text-xs font-bold text-white"><?= (int)$reason['count'] ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <?php if (!empty($stats['daily_activity'])): ?>
            <section class="mt-20 rounded-[2rem] border border-gray-200/70 bg-white/80 p-6 shadow-xl shadow-gray-950/5 backdrop-blur" data-animate>
                <h2 class="text-2xl font-bold text-gray-950"><?= htmlspecialchars($lang->get('stats.activity_by_day'), ENT_QUOTES, 'UTF-8') ?></h2>
                <div class="mt-8 flex h-72 items-end gap-3 overflow-x-auto pb-2">
                    <?php $maxCount = max(1, max(array_column($stats['daily_activity'], 'count'))); foreach ($stats['daily_activity'] as $day): ?>
                    <div class="flex min-w-20 flex-1 flex-col items-center justify-end gap-3">
                        <div class="flex w-full items-end justify-center rounded-t-2xl bg-gradient-to-t from-gray-950 to-gray-500 text-xs font-bold text-white shadow-lg shadow-gray-950/10" style="height: <?= max(8, min(100, ($day['count'] / $maxCount) * 100)) ?>%">
                            <span class="pb-2"><?= (int)$day['count'] ?></span>
                        </div>
                        <div class="text-xs font-semibold uppercase tracking-wide text-gray-500"><?= htmlspecialchars(substr($day['day_name'], 0, 3), ENT_QUOTES, 'UTF-8') ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
        </div>
    </section>

    <div id="cacheModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-gray-950/40 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="cacheModalLabel">
        <div class="w-full max-w-md rounded-[2rem] bg-white p-6 shadow-2xl shadow-gray-950/20">
            <h2 id="cacheModalLabel" class="text-2xl font-bold text-gray-950">Clear Statistics Cache</h2>
            <p class="mt-3 text-sm leading-6 text-gray-600">This refreshes cached statistics data. The page will reload after the cache clears.</p>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" data-modal-close class="rounded-full bg-gray-100 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-200">Cancel</button>
                <button type="button" id="confirm-clear-cache" class="rounded-full bg-gray-950 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800">Clear Cache</button>
            </div>
        </div>
    </div>
</div>
