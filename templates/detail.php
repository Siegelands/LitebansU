<?php
$status = $punishment['active']
    ? ['label' => $lang->get('status.active'), 'class' => 'bg-rose-50 text-rose-700 ring-rose-200', 'dot' => 'bg-rose-500']
    : ($punishment['removed']
        ? ['label' => $lang->get('status.removed'), 'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-200', 'dot' => 'bg-emerald-500']
        : ['label' => $lang->get('status.expired'), 'class' => 'bg-gray-100 text-gray-700 ring-gray-200', 'dot' => 'bg-gray-400']);

$typeMeta = match ($type) {
    'ban' => ['label' => 'Ban', 'icon' => 'fa-ban', 'accent' => 'from-rose-500 to-red-600'],
    'mute' => ['label' => 'Mute', 'icon' => 'fa-volume-mute', 'accent' => 'from-amber-400 to-orange-500'],
    'warning' => ['label' => 'Warning', 'icon' => 'fa-exclamation-triangle', 'accent' => 'from-sky-400 to-blue-500'],
    'kick' => ['label' => 'Kick', 'icon' => 'fa-sign-out-alt', 'accent' => 'from-gray-500 to-gray-800'],
    default => ['label' => ucfirst($type), 'icon' => 'fa-list', 'accent' => 'from-gray-500 to-gray-800'],
};

$detailItems = [
    ['icon' => 'fa-comment-alt', 'label' => $lang->get('table.reason'), 'value' => $punishment['reason'], 'wide' => true],
    ['icon' => 'fa-user-shield', 'label' => $lang->get('table.staff'), 'value' => $punishment['staff']],
    ['icon' => 'fa-calendar', 'label' => $lang->get('table.date'), 'value' => $punishment['date']],
    ['icon' => 'fa-server', 'label' => $lang->get('table.server'), 'value' => $punishment['server'] ?? 'Global'],
];

if (($config['show_server_origin'] ?? true) && !empty($punishment['server_origin']) && $punishment['server_origin'] !== '*') {
    $detailItems[] = ['icon' => 'fa-sign-in-alt', 'label' => 'Server Origin', 'value' => $punishment['server_origin']];
}

if (($config['show_server_scope'] ?? true) && !empty($punishment['server_scope']) && $punishment['server_scope'] !== '*') {
    $detailItems[] = ['icon' => 'fa-globe', 'label' => 'Server Scope', 'value' => $punishment['server_scope']];
}

if (in_array($type, ['ban', 'mute'], true)) {
    if (!empty($punishment['duration'])) {
        $detailItems[] = ['icon' => 'fa-hourglass-half', 'label' => $lang->get('detail.duration'), 'value' => $punishment['duration']];
    }
    if (!empty($punishment['timeLeft'])) {
        $detailItems[] = ['icon' => 'fa-clock', 'label' => $lang->get('detail.time_left'), 'value' => $punishment['timeLeft']];
    }
    if (!empty($punishment['until'])) {
        $detailItems[] = ['icon' => 'fa-calendar-times', 'label' => $lang->get('table.expires'), 'value' => $punishment['until']];
    }
}

if ($punishment['removed']) {
    $detailItems[] = ['icon' => 'fa-user-times', 'label' => $lang->get('detail.removed_by'), 'value' => $punishment['removed_by'] ?? 'Unknown'];
    if (!empty($punishment['removed_date'])) {
        $detailItems[] = ['icon' => 'fa-calendar-check', 'label' => $lang->get('detail.removed_date'), 'value' => $punishment['removed_date']];
    }
}

$skinUrl = 'https://visage.surgeplay.com/bust/128/' . rawurlencode($punishment['name']);
?>

<div class="min-h-screen bg-[radial-gradient(circle_at_top,#f8fafc_0%,#ffffff_42%,#f4f4f5_100%)]">
    <section class="relative overflow-hidden px-4 py-20 sm:py-24">
        <div class="absolute inset-x-0 top-0 h-72 bg-gradient-to-b from-gray-100/80 to-transparent pointer-events-none"></div>
        <div class="relative mx-auto max-w-7xl">
            <nav class="mb-10 flex items-center gap-2 text-sm text-gray-500" aria-label="Breadcrumb">
                <a class="hover:text-gray-950 transition-colors" href="<?= htmlspecialchars(url(), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($lang->get('nav.home'), ENT_QUOTES, 'UTF-8') ?></a>
                <span>/</span>
                <a class="hover:text-gray-950 transition-colors" href="<?= htmlspecialchars(url($type . 's'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($lang->get('nav.' . $type . 's'), ENT_QUOTES, 'UTF-8') ?></a>
                <span>/</span>
                <span class="text-gray-950">#<?= htmlspecialchars((string)$punishment['id'], ENT_QUOTES, 'UTF-8') ?></span>
            </nav>

            <div class="grid items-center gap-12 lg:grid-cols-[0.9fr_1.1fr]">
                <div class="text-center lg:text-left" data-animate>
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/80 px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-gray-200 backdrop-blur">
                        <span class="h-2 w-2 rounded-full <?= htmlspecialchars($status['dot'], ENT_QUOTES, 'UTF-8') ?>"></span>
                        <?= htmlspecialchars($status['label'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                    <h1 class="mt-8 text-5xl font-bold tracking-tight text-gray-950 sm:text-7xl">
                        <?= htmlspecialchars($typeMeta['label'], ENT_QUOTES, 'UTF-8') ?> #<?= htmlspecialchars((string)$punishment['id'], ENT_QUOTES, 'UTF-8') ?>
                    </h1>
                    <p class="mt-6 max-w-2xl text-lg leading-8 text-gray-600 lg:text-xl">
                        <?= htmlspecialchars($punishment['reason'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center lg:justify-start">
                        <a href="<?= htmlspecialchars(url($type . 's'), ENT_QUOTES, 'UTF-8') ?>" class="inline-flex items-center justify-center gap-2 rounded-full bg-gray-950 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-gray-950/10 transition hover:bg-gray-800 hover:scale-[1.02]">
                            <i class="fas fa-arrow-left text-xs"></i>
                            Back to <?= htmlspecialchars($lang->get('nav.' . $type . 's'), ENT_QUOTES, 'UTF-8') ?>
                        </a>
                        <a href="<?= htmlspecialchars(url('stats'), ENT_QUOTES, 'UTF-8') ?>" class="inline-flex items-center justify-center gap-2 rounded-full bg-white/80 px-6 py-3 text-sm font-semibold text-gray-950 ring-1 ring-gray-200 backdrop-blur transition hover:bg-white hover:scale-[1.02]">
                            <i class="fas fa-chart-line text-xs"></i>
                            <?= htmlspecialchars($lang->get('nav.statistics'), ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </div>
                </div>

                <div class="relative mx-auto w-full max-w-xl" data-animate>
                    <div class="absolute -inset-6 rounded-[2.5rem] bg-gradient-to-br <?= htmlspecialchars($typeMeta['accent'], ENT_QUOTES, 'UTF-8') ?> opacity-10 blur-3xl"></div>
                    <div class="relative overflow-hidden rounded-[2rem] border border-white/70 bg-white/75 p-8 shadow-2xl shadow-gray-950/10 backdrop-blur-2xl">
                        <div class="flex flex-col items-center gap-6 sm:flex-row">
                            <img src="<?= htmlspecialchars($skinUrl, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($punishment['name'], ENT_QUOTES, 'UTF-8') ?>" class="h-36 w-36 rounded-3xl object-contain shadow-xl shadow-gray-950/15" decoding="async" onerror="this.onerror=null;this.src='https://visage.surgeplay.com/bust/128/MHF_Steve';">
                            <div class="min-w-0 text-center sm:text-left">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br <?= htmlspecialchars($typeMeta['accent'], ENT_QUOTES, 'UTF-8') ?> text-white shadow-lg">
                                    <i class="fas <?= htmlspecialchars($typeMeta['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                                </div>
                                <h2 class="mt-4 truncate text-3xl font-bold text-gray-950"><?= htmlspecialchars($punishment['name'], ENT_QUOTES, 'UTF-8') ?></h2>
                                <?php if ($controller->shouldShowUuid()): ?>
                                <p class="font-monospace mt-2 break-all text-xs text-gray-500"><?= htmlspecialchars($punishment['uuid'], ENT_QUOTES, 'UTF-8') ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-4 pb-20">
        <div class="mx-auto max-w-7xl">
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($detailItems as $item): ?>
                <article class="<?= !empty($item['wide']) ? 'md:col-span-2 lg:col-span-3' : '' ?> rounded-3xl border border-gray-200/70 bg-white/80 p-6 shadow-sm shadow-gray-950/5 backdrop-blur transition hover:-translate-y-1 hover:shadow-xl hover:shadow-gray-950/10" data-animate>
                    <div class="mb-4 flex items-center gap-3 text-sm font-semibold text-gray-500">
                        <span class="flex h-9 w-9 items-center justify-center rounded-2xl bg-gray-100 text-gray-700"><i class="fas <?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8') ?>"></i></span>
                        <?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?>
                    </div>
                    <p class="break-words text-xl font-semibold leading-8 text-gray-950"><?= htmlspecialchars((string)$item['value'], ENT_QUOTES, 'UTF-8') ?></p>
                </article>
                <?php endforeach; ?>
            </div>

            <?php if ($punishment['active'] && $punishment['until_timestamp'] > 0): ?>
            <div class="mt-6 rounded-3xl border border-gray-200/70 bg-white/80 p-6 shadow-sm shadow-gray-950/5 backdrop-blur" data-animate>
                <div class="mb-3 flex items-center justify-between text-sm font-semibold text-gray-600">
                    <span><?= htmlspecialchars($lang->get('detail.progress'), ENT_QUOTES, 'UTF-8') ?></span>
                    <span><?= round($punishment['progress'], 1) ?>%</span>
                </div>
                <div class="h-3 overflow-hidden rounded-full bg-gray-100">
                    <div class="progress-bar h-full rounded-full bg-gradient-to-r from-gray-950 to-gray-600" style="width: <?= (float)$punishment['progress'] ?>%"></div>
                </div>
            </div>
            <?php endif; ?>

            <div class="mt-6 rounded-3xl border border-gray-200/70 bg-white/80 p-6 shadow-sm shadow-gray-950/5 backdrop-blur" data-animate>
                <div class="mb-5 flex items-center gap-3 text-sm font-semibold text-gray-500">
                    <span class="flex h-9 w-9 items-center justify-center rounded-2xl bg-gray-100 text-gray-700"><i class="fas fa-tags"></i></span>
                    <?= htmlspecialchars($lang->get('detail.flags'), ENT_QUOTES, 'UTF-8') ?>
                </div>
                <div class="flex flex-wrap gap-3">
                    <?php if ($punishment['silent']): ?><span class="rounded-full bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700">Silent</span><?php endif; ?>
                    <?php if ($punishment['ipban']): ?><span class="rounded-full bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700">IP Ban</span><?php endif; ?>
                    <?php if ($punishment['warned']): ?><span class="rounded-full bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700">Warned</span><?php endif; ?>
                    <?php if (!$punishment['silent'] && !$punishment['ipban'] && !$punishment['warned']): ?><span class="text-sm text-gray-500">None</span><?php endif; ?>
                </div>
            </div>

            <?php if (!empty($relatedPunishments)): ?>
            <section class="mt-20" data-animate>
                <div class="mb-8 text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500">History</p>
                    <h2 class="mt-3 text-4xl font-bold text-gray-950"><?= htmlspecialchars($lang->get('detail.other_punishments'), ENT_QUOTES, 'UTF-8') ?></h2>
                </div>
                <div class="overflow-hidden rounded-3xl border border-gray-200/70 bg-white/85 shadow-xl shadow-gray-950/5 backdrop-blur">
                    <?php foreach ($relatedPunishments as $related): ?>
                    <a href="<?= htmlspecialchars(url('detail?type=' . rtrim($related['type'], 's') . '&id=' . $related['id']), ENT_QUOTES, 'UTF-8') ?>" class="grid gap-4 border-b border-gray-100 p-5 transition hover:bg-gray-50/80 md:grid-cols-[120px_1fr_160px_100px] md:items-center last:border-b-0">
                        <span class="text-sm font-semibold text-gray-500"><?= htmlspecialchars(ucfirst(rtrim($related['type'], 's')), ENT_QUOTES, 'UTF-8') ?> #<?= (int)$related['id'] ?></span>
                        <span class="min-w-0 truncate font-semibold text-gray-950"><?= htmlspecialchars($related['reason'], ENT_QUOTES, 'UTF-8') ?></span>
                        <span class="text-sm text-gray-500"><?= htmlspecialchars($related['date'], ENT_QUOTES, 'UTF-8') ?></span>
                        <span class="justify-self-start rounded-full <?= $related['active'] ? 'bg-rose-50 text-rose-700' : 'bg-gray-100 text-gray-600' ?> px-3 py-1 text-xs font-bold uppercase"><?= htmlspecialchars($related['active'] ? $lang->get('status.active') : $lang->get('status.inactive'), ENT_QUOTES, 'UTF-8') ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
        </div>
    </section>
</div>
