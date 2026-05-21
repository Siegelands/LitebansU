<?php
$pageMeta = match ($type) {
    'bans' => ['label' => $lang->get('nav.bans'), 'singular' => 'ban', 'icon' => 'fa-ban', 'accent' => 'from-rose-500 to-red-600'],
    'mutes' => ['label' => $lang->get('nav.mutes'), 'singular' => 'mute', 'icon' => 'fa-volume-mute', 'accent' => 'from-amber-400 to-orange-500'],
    'warnings' => ['label' => $lang->get('nav.warnings'), 'singular' => 'warning', 'icon' => 'fa-exclamation-triangle', 'accent' => 'from-sky-400 to-blue-500'],
    'kicks' => ['label' => $lang->get('nav.kicks'), 'singular' => 'kick', 'icon' => 'fa-sign-out-alt', 'accent' => 'from-gray-500 to-gray-800'],
    default => ['label' => $title, 'singular' => rtrim($type, 's'), 'icon' => 'fa-list', 'accent' => 'from-gray-500 to-gray-800'],
};

$sortUrl = static function (string $field) use ($sortParams): string {
    $order = ($sortParams['sort'] === $field && $sortParams['order'] === 'ASC') ? 'DESC' : 'ASC';
    return '?sort=' . urlencode($field) . '&order=' . urlencode($order);
};

$statusFor = function (array $punishment) use ($type, $lang): array {
    if ($type === 'kicks') {
        return ['label' => $lang->get('status.completed'), 'class' => 'bg-gray-100 text-gray-700'];
    }
    if ($punishment['active']) {
        return ['label' => $lang->get('status.active'), 'class' => 'bg-rose-50 text-rose-700'];
    }
    if (!empty($punishment['removed_by'])) {
        return ['label' => $lang->get('status.removed'), 'class' => 'bg-emerald-50 text-emerald-700'];
    }
    return ['label' => $lang->get('status.expired'), 'class' => 'bg-gray-100 text-gray-700'];
};
?>

<div class="min-h-screen bg-[radial-gradient(circle_at_top,#f8fafc_0%,#ffffff_44%,#f4f4f5_100%)]">
    <section class="relative overflow-hidden px-4 py-20 sm:py-28">
        <div class="absolute inset-x-0 top-0 h-80 bg-gradient-to-b from-gray-100/90 to-transparent pointer-events-none"></div>
        <div class="relative mx-auto max-w-7xl text-center" data-animate>
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-gradient-to-br <?= htmlspecialchars($pageMeta['accent'], ENT_QUOTES, 'UTF-8') ?> text-white shadow-xl shadow-gray-950/10">
                <i class="fas <?= htmlspecialchars($pageMeta['icon'], ENT_QUOTES, 'UTF-8') ?> text-xl"></i>
            </div>
            <h1 class="mx-auto mt-7 max-w-4xl text-5xl font-bold tracking-tight text-gray-950 sm:text-7xl">
                <?= htmlspecialchars($pageMeta['label'], ENT_QUOTES, 'UTF-8') ?>
            </h1>
            <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-gray-600">
                Clean, searchable moderation history with player context and precise status signals.
            </p>
        </div>
    </section>

    <section class="px-4 pb-20">
        <div class="mx-auto max-w-7xl">
            <?php if (empty($punishments)): ?>
                <div class="rounded-[2rem] border border-gray-200/70 bg-white/80 p-12 text-center shadow-xl shadow-gray-950/5 backdrop-blur" data-animate>
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-gray-100 text-gray-500">
                        <i class="fas fa-inbox text-2xl"></i>
                    </div>
                    <h2 class="mt-6 text-3xl font-bold text-gray-950"><?= htmlspecialchars($lang->get('punishments.no_data'), ENT_QUOTES, 'UTF-8') ?></h2>
                    <p class="mt-3 text-gray-500"><?= htmlspecialchars($lang->get('punishments.no_data_desc'), ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            <?php else: ?>
                <div class="mb-5 hidden grid-cols-[1.4fr_90px_130px_1.2fr_130px_150px_130px_90px] gap-4 px-5 text-xs font-bold uppercase tracking-wide text-gray-400 lg:grid">
                    <a class="hover:text-gray-900" href="<?= htmlspecialchars($sortUrl('name'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($lang->get('table.player'), ENT_QUOTES, 'UTF-8') ?></a>
                    <a class="hover:text-gray-900" href="<?= htmlspecialchars($sortUrl('id'), ENT_QUOTES, 'UTF-8') ?>">ID</a>
                    <a class="hover:text-gray-900" href="<?= htmlspecialchars($sortUrl('server'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($lang->get('table.server'), ENT_QUOTES, 'UTF-8') ?></a>
                    <a class="hover:text-gray-900" href="<?= htmlspecialchars($sortUrl('reason'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($lang->get('table.reason'), ENT_QUOTES, 'UTF-8') ?></a>
                    <a class="hover:text-gray-900" href="<?= htmlspecialchars($sortUrl('banned_by_name'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($lang->get('table.staff'), ENT_QUOTES, 'UTF-8') ?></a>
                    <a class="hover:text-gray-900" href="<?= htmlspecialchars($sortUrl('time'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($lang->get('table.date'), ENT_QUOTES, 'UTF-8') ?></a>
                    <a class="hover:text-gray-900" href="<?= htmlspecialchars($sortUrl('active'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($lang->get('table.status'), ENT_QUOTES, 'UTF-8') ?></a>
                    <span><?= htmlspecialchars($lang->get('table.actions'), ENT_QUOTES, 'UTF-8') ?></span>
                </div>

                <div class="space-y-3">
                    <?php foreach ($punishments as $punishment): $status = $statusFor($punishment); $skinUrl = 'https://visage.surgeplay.com/bust/128/' . rawurlencode($punishment['name']); ?>
                    <article class="group rounded-[1.75rem] border border-gray-200/70 bg-white/85 p-5 shadow-sm shadow-gray-950/5 backdrop-blur transition hover:-translate-y-0.5 hover:shadow-xl hover:shadow-gray-950/10" data-animate>
                        <div class="grid gap-5 lg:grid-cols-[1.4fr_90px_130px_1.2fr_130px_150px_130px_90px] lg:items-center">
                            <div class="flex min-w-0 items-center gap-4">
                                <img src="<?= htmlspecialchars($skinUrl, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($punishment['name'], ENT_QUOTES, 'UTF-8') ?>" class="h-14 w-14 rounded-2xl object-contain" onerror="this.onerror=null;this.src='https://visage.surgeplay.com/bust/128/MHF_Steve';">
                                <div class="min-w-0">
                                    <div class="truncate font-bold text-gray-950"><?= htmlspecialchars($punishment['name'], ENT_QUOTES, 'UTF-8') ?></div>
                                    <?php if ($controller->shouldShowUuid()): ?>
                                    <div class="font-monospace mt-1 truncate text-xs text-gray-400"><?= htmlspecialchars($punishment['uuid'], ENT_QUOTES, 'UTF-8') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="text-sm font-semibold text-gray-500">#<?= (int)$punishment['id'] ?></div>
                            <div>
                                <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-gray-600"><?= htmlspecialchars($punishment['server'] ?? 'Global', ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                            <div class="min-w-0">
                                <p class="line-clamp-2 font-semibold leading-6 text-gray-900" title="<?= htmlspecialchars($punishment['reason'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($punishment['reason'], ENT_QUOTES, 'UTF-8') ?></p>
                                <?php if ($type !== 'kicks' && empty($punishment['removed_by'])): ?>
                                <p class="mt-1 text-xs text-gray-400">
                                    <?= htmlspecialchars($lang->get('table.expires'), ENT_QUOTES, 'UTF-8') ?>:
                                    <?= htmlspecialchars($punishment['until'] ?: $lang->get('punishment.permanent'), ENT_QUOTES, 'UTF-8') ?>
                                </p>
                                <?php endif; ?>
                            </div>
                            <div class="truncate text-sm font-semibold text-gray-600"><?= htmlspecialchars($punishment['staff'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="text-sm text-gray-500"><?= htmlspecialchars($punishment['date'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div><span class="inline-flex rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wide <?= htmlspecialchars($status['class'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($status['label'], ENT_QUOTES, 'UTF-8') ?></span></div>
                            <div>
                                <a href="<?= htmlspecialchars(url('detail?type=' . $pageMeta['singular'] . '&id=' . $punishment['id']), ENT_QUOTES, 'UTF-8') ?>" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-950 text-white transition hover:scale-105 hover:bg-gray-800" aria-label="<?= htmlspecialchars($lang->get('table.view'), ENT_QUOTES, 'UTF-8') ?>">
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>

                <?php if ($pagination['total'] > 1): ?>
                <nav class="mt-10 flex flex-col items-center justify-between gap-4 rounded-[2rem] border border-gray-200/70 bg-white/80 p-4 shadow-sm shadow-gray-950/5 backdrop-blur sm:flex-row" aria-label="<?= htmlspecialchars($lang->get('pagination.label'), ENT_QUOTES, 'UTF-8') ?>">
                    <?php if ($pagination['has_prev']): ?>
                    <a href="<?= htmlspecialchars($pagination['prev_url'], ENT_QUOTES, 'UTF-8') ?>" class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-200">
                        <i class="fas fa-chevron-left text-xs"></i><?= htmlspecialchars($lang->get('pagination.previous'), ENT_QUOTES, 'UTF-8') ?>
                    </a>
                    <?php else: ?>
                    <span class="inline-flex items-center gap-2 rounded-full bg-gray-50 px-5 py-2.5 text-sm font-semibold text-gray-300">
                        <i class="fas fa-chevron-left text-xs"></i><?= htmlspecialchars($lang->get('pagination.previous'), ENT_QUOTES, 'UTF-8') ?>
                    </span>
                    <?php endif; ?>

                    <span class="text-sm font-semibold text-gray-500">
                        <?= htmlspecialchars($lang->get('pagination.page_info', ['current' => $pagination['current'], 'total' => $pagination['total']]), ENT_QUOTES, 'UTF-8') ?>
                    </span>

                    <?php if ($pagination['has_next']): ?>
                    <a href="<?= htmlspecialchars($pagination['next_url'], ENT_QUOTES, 'UTF-8') ?>" class="inline-flex items-center gap-2 rounded-full bg-gray-950 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800">
                        <?= htmlspecialchars($lang->get('pagination.next'), ENT_QUOTES, 'UTF-8') ?><i class="fas fa-chevron-right text-xs"></i>
                    </a>
                    <?php else: ?>
                    <span class="inline-flex items-center gap-2 rounded-full bg-gray-50 px-5 py-2.5 text-sm font-semibold text-gray-300">
                        <?= htmlspecialchars($lang->get('pagination.next'), ENT_QUOTES, 'UTF-8') ?><i class="fas fa-chevron-right text-xs"></i>
                    </span>
                    <?php endif; ?>
                </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
</div>
