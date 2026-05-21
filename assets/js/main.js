/**
 * LiteBansU public UI
 * Lean interactions only: no scroll-trigger storms, page fade delays, or hover JS.
 */

class LiteBansUI {
    constructor() {
        this.basePath = this.getBasePath();
        this.csrfToken = this.getCsrfToken();
        this.searchCache = new Map();
        this.debounceTimer = null;
        this.boundPunishmentClick = false;

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.initialize(), { once: true });
        } else {
            this.initialize();
        }
    }

    initialize() {
        this.setupNavigation();
        this.setupSearch();
        this.setupRevealAnimations();
        this.setupClickableRows();
        this.setupPunishmentRowClicks();
        this.setupDetailPageFeatures();
        this.setupBackButton();
    }

    getBasePath() {
        const metaBasePath = document.querySelector('meta[name="base-path"]');
        const path = metaBasePath ? (metaBasePath.getAttribute('content') || '') : '';
        return path.replace(/\/$/, '');
    }

    getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    setupNavigation() {
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenu) {
            mobileMenu.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
            });
        }

        document.addEventListener('click', (event) => {
            const userMenu = document.getElementById('user-menu');
            if (userMenu && !userMenu.contains(event.target)) {
                document.getElementById('user-menu-dropdown')?.classList.add('hidden');
            }
        });
    }

    setupRevealAnimations() {
        const elements = Array.from(document.querySelectorAll('[data-animate]'));
        if (!elements.length) return;
        elements.forEach((element) => element.classList.add('is-visible'));
    }

    setupSearch() {
        const form = document.getElementById('search-form');
        const input = document.getElementById('search-input');
        const results = document.getElementById('search-results');
        if (!form || !input || !results) return;

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            this.performSearch(input, results);
        });

        input.addEventListener('input', () => {
            clearTimeout(this.debounceTimer);
            if (input.value.trim().length >= 2) {
                this.debounceTimer = setTimeout(() => this.performSearch(input, results), 450);
            } else if (input.value.trim().length === 0) {
                results.innerHTML = '';
            }
        });

        input.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                input.value = '';
                results.innerHTML = '';
                input.blur();
            }
        });
    }

    async performSearch(input, results) {
        const query = input.value.trim();
        if (query.length < 1) return;

        if (this.searchCache.has(query)) {
            this.displaySearchResults(this.searchCache.get(query), results);
            return;
        }

        results.innerHTML = '<div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 text-center text-slate-400"><i class="fas fa-spinner fa-spin"></i> Searching...</div>';

        try {
            const data = await this.fetchSearch(query);
            if (data.success) {
                this.searchCache.set(query, data);
                setTimeout(() => this.searchCache.delete(query), 300000);
            }
            this.displaySearchResults(data, results);
        } catch (error) {
            results.innerHTML = `<div class="rounded-2xl border border-rose-400/20 bg-rose-500/10 p-5 text-rose-200">${this.escapeHtml(error.message || 'Search failed')}</div>`;
        }
    }

    async fetchSearch(query) {
        const formData = new FormData();
        formData.append('query', query);
        formData.append('csrf_token', this.csrfToken);

        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000);

        try {
            const response = await fetch(`${this.basePath}/search`, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                signal: controller.signal
            });

            clearTimeout(timeoutId);

            if (!response.ok) {
                throw new Error(`Server error: ${response.status}`);
            }

            const data = await response.json();
            if (data.error) {
                throw new Error(data.error);
            }
            return data;
        } catch (error) {
            if (error.name === 'AbortError') {
                throw new Error('Request timeout. Please try again.');
            }
            throw error;
        }
    }

    displaySearchResults(data, container) {
        if (!data.success) {
            container.innerHTML = `<div class="rounded-2xl border border-rose-400/20 bg-rose-500/10 p-5 text-rose-200">${this.escapeHtml(data.error || 'Search failed')}</div>`;
            return;
        }

        if (!data.punishments || data.punishments.length === 0) {
            container.innerHTML = '<div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5 text-slate-300">No punishments found for this player.</div>';
            return;
        }

        container.innerHTML = `
            <div class="space-y-3">
                <h3 class="text-lg font-bold text-white">Results for ${this.escapeHtml(data.player)}</h3>
                ${data.punishments.map((punishment) => this.renderSearchResult(punishment)).join('')}
            </div>
        `;
    }

    renderSearchResult(punishment) {
        const type = String(punishment.type || '').replace(/s$/, '');
        const statusClass = punishment.active ? 'bg-rose-500/15 text-rose-200' : 'bg-white/10 text-slate-300';

        return `
            <article class="punishment-row cursor-pointer rounded-2xl border border-white/10 bg-white/[0.05] p-4 transition-colors hover:bg-white/[0.08]" data-type="${this.escapeHtml(type)}" data-id="${this.escapeHtml(punishment.id || '')}">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <div class="font-bold text-white">${this.escapeHtml(punishment.player_name || punishment.player || 'Unknown')}</div>
                        <div class="mt-1 line-clamp-2 text-sm text-slate-400">${this.escapeHtml(punishment.reason || 'No reason provided')}</div>
                    </div>
                    <div class="flex shrink-0 items-center gap-2">
                        <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-bold uppercase text-slate-200">${this.escapeHtml(type || 'item')}</span>
                        <span class="rounded-full px-3 py-1 text-xs font-bold uppercase ${statusClass}">${punishment.active ? 'Active' : 'Inactive'}</span>
                    </div>
                </div>
            </article>
        `;
    }

    setupPunishmentRowClicks() {
        if (this.boundPunishmentClick) return;
        this.boundPunishmentClick = true;

        document.addEventListener('click', (event) => {
            const row = event.target.closest('.punishment-row');
            if (!row || event.target.closest('a, button')) return;

            const type = row.dataset.type;
            const id = row.dataset.id;
            if (type && id) {
                window.location.href = `${this.basePath}/detail?type=${encodeURIComponent(type)}&id=${encodeURIComponent(id)}`;
            }
        });
    }

    setupClickableRows() {
        document.addEventListener('click', (event) => {
            const row = event.target.closest('.clickable-row');
            if (!row || event.target.closest('a, button')) return;
            if (row.dataset.href) {
                window.location.href = row.dataset.href;
            }
        });
    }

    setupDetailPageFeatures() {
        document.querySelectorAll('.font-monospace').forEach((element) => {
            const text = element.textContent.trim();
            if (!/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i.test(text)) return;

            element.style.cursor = 'pointer';
            element.title = 'Copy UUID';
            element.addEventListener('click', () => this.copyToClipboard(text));
        });
    }

    setupBackButton() {
        document.addEventListener('click', (event) => {
            if (event.target.closest('.back-button')) {
                event.preventDefault();
                window.history.back();
            }
        });
    }

    showNotification(type, message) {
        const notification = document.createElement('div');
        const isSuccess = type === 'success';
        notification.className = `fixed left-1/2 top-4 z-[9999] -translate-x-1/2 rounded-2xl border px-5 py-3 text-sm font-semibold shadow-2xl ${
            isSuccess
                ? 'border-emerald-400/20 bg-emerald-500/15 text-emerald-100'
                : 'border-rose-400/20 bg-rose-500/15 text-rose-100'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => notification.remove(), 3000);
    }

    copyToClipboard(text) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text)
                .then(() => this.showNotification('success', 'Copied to clipboard'))
                .catch(() => this.fallbackCopy(text));
        } else {
            this.fallbackCopy(text);
        }
    }

    fallbackCopy(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.opacity = '0';
        document.body.appendChild(textArea);
        textArea.select();

        try {
            document.execCommand('copy');
            this.showNotification('success', 'Copied to clipboard');
        } catch {
            this.showNotification('error', 'Failed to copy');
        }

        textArea.remove();
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = String(text ?? '');
        return div.innerHTML;
    }
}

window.LiteBansU = new LiteBansUI();

function toggleMobileMenu() {
    document.getElementById('mobile-menu')?.classList.toggle('hidden');
}

function toggleUserMenu() {
    document.getElementById('user-menu-dropdown')?.classList.toggle('hidden');
}
