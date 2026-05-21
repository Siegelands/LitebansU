/**
 * ============================================================================
 * LiteBansU - Modern Premium JavaScript
 * ============================================================================
 * Apple-inspired animations, interactions, and smooth UX with GSAP
 */

// Initialize GSAP and ScrollTrigger
gsap.registerPlugin(ScrollTrigger);

class LiteBansModern {
    constructor() {
        this.basePath = this.getBasePath();
        this.csrfToken = this.getCsrfToken();
        this.searchCache = new Map();
        this.init();
    }

    init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.initialize());
        } else {
            this.initialize();
        }
    }

    getBasePath() {
        const metaBasePath = document.querySelector('meta[name="base-path"]');
        if (metaBasePath) {
            let path = metaBasePath.getAttribute('content') || '';
            return path.replace(/\/$/, '');
        }
        return '';
    }

    getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    initialize() {
        // Setup core interactions
        this.setupNavigation();
        this.setupSearch();
        this.setupScrollAnimations();
        this.setupInteractions();
        this.setupPageTransitions();
        this.setupClickableRows();
        
        // Page-specific features
        this.setupDetailPageFeatures();
        this.setupTableInteractions();
    }

    // ========================================================================
    // NAVIGATION
    // ========================================================================
    
    setupNavigation() {
        // Mobile menu
        const mobileMenuBtn = document.querySelector('[onclick*="toggleMobileMenu"]');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenu) {
            // Close menu when a link is clicked
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                });
            });
        }
        
        // Sticky navbar on scroll
        const navbar = document.getElementById('navbar');
        if (navbar) {
            let lastScroll = 0;
            window.addEventListener('scroll', () => {
                const scrollTop = window.pageYOffset;
                
                if (scrollTop > 100) {
                    navbar.classList.add('shadow-luxury');
                } else {
                    navbar.classList.remove('shadow-luxury');
                }
                
                lastScroll = scrollTop;
            });
        }
    }

    // ========================================================================
    // SEARCH FUNCTIONALITY
    // ========================================================================
    
    setupSearch() {
        const searchForm = document.getElementById('search-form');
        if (!searchForm) return;
        
        searchForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const searchInput = document.getElementById('search-input');
            const resultsContainer = document.getElementById('search-results');
            
            if (!searchInput || !resultsContainer) return;
            
            const query = searchInput.value.trim();
            if (query.length === 0) return;
            
            // Check cache
            if (this.searchCache.has(query)) {
                this.displaySearchResults(this.searchCache.get(query), resultsContainer);
                return;
            }
            
            // Show loading state
            gsap.to(resultsContainer, { opacity: 0.5, duration: 0.2 });
            resultsContainer.innerHTML = '<div class="text-center py-8"><i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i></div>';
            
            try {
                const response = await fetch(`${this.basePath}?search=${encodeURIComponent(query)}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-Token': this.csrfToken
                    }
                });
                
                if (response.ok) {
                    const html = await response.text();
                    this.searchCache.set(query, html);
                    this.displaySearchResults(html, resultsContainer);
                }
            } catch (error) {
                console.error('Search error:', error);
                resultsContainer.innerHTML = '<div class="text-center py-8 text-red-600">Error performing search</div>';
            }
        });
    }

    displaySearchResults(html, container) {
        gsap.to(container, {
            opacity: 0,
            duration: 0.2,
            onComplete: () => {
                container.innerHTML = html;
                gsap.to(container, { opacity: 1, duration: 0.3 });
            }
        });
    }

    // ========================================================================
    // SCROLL ANIMATIONS
    // ========================================================================
    
    setupScrollAnimations() {
        // Animate elements with data-animate attribute
        const animatedElements = document.querySelectorAll('[data-animate]');
        
        animatedElements.forEach((element, index) => {
            gsap.set(element, { opacity: 0, y: 30 });
            
            gsap.to(element, {
                scrollTrigger: {
                    trigger: element,
                    start: 'top 80%',
                    onEnter: () => {
                        gsap.to(element, {
                            opacity: 1,
                            y: 0,
                            duration: 0.6,
                            ease: 'power2.out',
                            delay: index * 0.1
                        });
                    }
                }
            });
        });
        
        // Parallax effect on hero section
        const heroSection = document.querySelector('.hero-section');
        if (heroSection) {
            gsap.to(heroSection, {
                scrollTrigger: {
                    trigger: heroSection,
                    start: 'top top',
                    end: 'bottom top',
                    scrub: 1,
                    markers: false
                },
                y: -50,
                ease: 'none'
            });
        }
        
        // Stat cards stagger animation
        const statCards = document.querySelectorAll('.stat-card');
        if (statCards.length > 0) {
            gsap.set(statCards, { opacity: 0, y: 30 });
            gsap.to(statCards, {
                scrollTrigger: {
                    trigger: '.stat-card',
                    start: 'top 80%'
                },
                opacity: 1,
                y: 0,
                duration: 0.6,
                stagger: 0.1,
                ease: 'power2.out'
            });
        }
    }

    // ========================================================================
    // INTERACTIVE ELEMENTS
    // ========================================================================
    
    setupInteractions() {
        // Button hover effects
        document.querySelectorAll('button, a.btn, .btn-primary').forEach(button => {
            button.addEventListener('mouseenter', () => {
                gsap.to(button, { scale: 1.02, duration: 0.2, ease: 'power2.out', overwrite: 'auto' });
            });
            button.addEventListener('mouseleave', () => {
                gsap.to(button, { scale: 1, duration: 0.2, ease: 'power2.out', overwrite: 'auto' });
            });
        });
        
        // Card hover effects
        document.querySelectorAll('.card, .stat-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                gsap.to(card, {
                    y: -4,
                    boxShadow: '0 20px 40px rgba(0, 0, 0, 0.1)',
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });
            card.addEventListener('mouseleave', () => {
                gsap.to(card, {
                    y: 0,
                    boxShadow: '0 10px 40px rgba(0, 0, 0, 0.08)',
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });
        });
        
        // Input focus effects
        document.querySelectorAll('input, textarea, select').forEach(input => {
            input.addEventListener('focus', () => {
                gsap.to(input, { boxShadow: '0 0 0 3px rgba(17, 24, 39, 0.1)', duration: 0.3 });
            });
            input.addEventListener('blur', () => {
                gsap.to(input, { boxShadow: 'none', duration: 0.3 });
            });
        });
        
        // Smooth scroll anchors
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                const href = anchor.getAttribute('href');
                if (href !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        gsap.to(window, { scrollTo: target, duration: 0.8, ease: 'power2.inOut' });
                    }
                }
            });
        });
    }

    // ========================================================================
    // PAGE TRANSITIONS
    // ========================================================================
    
    setupPageTransitions() {
        // Fade in on page load
        window.addEventListener('load', () => {
            gsap.to('body', { opacity: 1, duration: 0.5, ease: 'power2.out' });
        });
        
        // Page exit animation
        document.querySelectorAll('a:not([target="_blank"]):not([download])').forEach(link => {
            link.addEventListener('click', (e) => {
                if (link.href && !link.href.includes('#') && !link.href.includes('javascript:')) {
                    if (link.href.includes(window.location.host)) {
                        e.preventDefault();
                        gsap.to('main', {
                            opacity: 0,
                            y: 20,
                            duration: 0.4,
                            ease: 'power2.in',
                            onComplete: () => {
                                window.location.href = link.href;
                            }
                        });
                    }
                }
            });
        });
        
        // Page entry animation
        gsap.from('main', { opacity: 0, y: 20, duration: 0.5, ease: 'power2.out' });
    }

    // ========================================================================
    // CLICKABLE ROWS
    // ========================================================================
    
    setupClickableRows() {
        document.querySelectorAll('[data-href]').forEach(row => {
            row.addEventListener('click', (e) => {
                if (e.target.closest('a')) return;
                const href = row.getAttribute('data-href');
                if (href) {
                    gsap.to('main', {
                        opacity: 0,
                        y: 20,
                        duration: 0.3,
                        ease: 'power2.in',
                        onComplete: () => {
                            window.location.href = href;
                        }
                    });
                }
            });
            
            row.addEventListener('mouseenter', () => {
                gsap.to(row, { backgroundColor: 'rgba(249, 250, 251, 0.5)', duration: 0.2 });
            });
            row.addEventListener('mouseleave', () => {
                gsap.to(row, { backgroundColor: 'transparent', duration: 0.2 });
            });
        });
    }

    // ========================================================================
    // DETAIL PAGE FEATURES
    // ========================================================================
    
    setupDetailPageFeatures() {
        // Copy to clipboard functionality
        document.querySelectorAll('[data-copy]').forEach(element => {
            element.addEventListener('click', () => {
                const text = element.getAttribute('data-copy');
                navigator.clipboard.writeText(text).then(() => {
                    const originalText = element.innerHTML;
                    element.innerHTML = '<i class="fas fa-check"></i> Copied!';
                    setTimeout(() => {
                        element.innerHTML = originalText;
                    }, 2000);
                });
            });
        });
    }

    // ========================================================================
    // TABLE INTERACTIONS
    // ========================================================================
    
    setupTableInteractions() {
        // Table row hover effects
        document.querySelectorAll('table tbody tr').forEach(row => {
            row.addEventListener('mouseenter', () => {
                gsap.to(row, { backgroundColor: 'rgba(249, 250, 251, 0.5)', duration: 0.2 });
            });
            row.addEventListener('mouseleave', () => {
                gsap.to(row, { backgroundColor: 'transparent', duration: 0.2 });
            });
        });
    }
}

// ============================================================================
// INITIALIZATION
// ============================================================================

const liteBansModern = new LiteBansModern();

// ============================================================================
// UTILITY FUNCTIONS
// ============================================================================

/**
 * Format a number with commas
 */
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

/**
 * Format a date to readable string
 */
function formatDate(dateString) {
    const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(dateString).toLocaleDateString('en-US', options);
}

/**
 * Debounce function
 */
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func(...args), wait);
    };
}

console.log('LiteBans Modern JavaScript loaded successfully');

    constructor() {
        this.basePath = this.getBasePath();
        this.csrfToken = this.getCsrfToken();
        this.debounceTimer = null;
        this.searchCache = new Map();
        this.init();
    }

    init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.initialize());
        } else {
            this.initialize();
        }
    }

    initialize() {
        // Core functionality
        this.setupThemeSwitcher();
        this.setupLanguageSwitcher();
        this.setupSearch();
        this.setupMobileMenu();
        this.setupScrollEffects();
        this.setupTooltips();
        this.setupDetailPageFeatures();
        this.setupClearCache();
        this.setupModals();
        this.setupTables();
        this.setupClickableRows();
        this.setupBackButton();
        
        // Initialize Bootstrap components
        this.initializeBootstrapComponents();
    }

    getBasePath() {
        const metaBasePath = document.querySelector('meta[name="base-path"]');
        if (metaBasePath) {
            let path = metaBasePath.getAttribute('content') || '';
            return path.replace(/\/$/, '');
        }
        return '';
    }

    getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    setupThemeSwitcher() {
        const toggle = document.getElementById('theme-toggle');
        if (!toggle) return;

        toggle.addEventListener('change', (e) => {
            e.preventDefault();
            const theme = e.target.checked ? 'dark' : 'light';
            const url = new URL(window.location.href);
            url.searchParams.set('theme', theme);
            window.location.href = url.toString();
        });
    }

    setupLanguageSwitcher() {
        const dropdownItems = document.querySelectorAll('#langDropdown + .dropdown-menu .dropdown-item');
        if (dropdownItems.length === 0) return;

        dropdownItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const lang = e.currentTarget.getAttribute('href').match(/lang=(\w+)/);
                if (lang && lang[1]) {
                    const url = new URL(window.location.href);
                    url.searchParams.set('lang', lang[1]);
                    window.location.href = url.toString();
                }
            });
        });
    }

    // =====================================================================
    // ZMENA 1: PĂ´vodnĂˇ logika z form.addEventListener('submit') je presunutĂˇ 
    // do tejto novej metĂłdy, aby ju bolo moĹľnĂ© volaĹĄ priamo.
    // =====================================================================
    async performSearch() {
        const input = document.getElementById('search-input');
        const results = document.getElementById('search-results');

        if (!input || !results) return;

        const query = input.value.trim();
        if (!query || query.length < 1) {
            results.innerHTML = '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> Please enter at least 1 character</div>';
            return;
        }

        if (this.searchCache.has(query)) {
            this.displaySearchResults(this.searchCache.get(query), results);
            return;
        }

        try {
            results.innerHTML = '<div class="text-center p-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Searching...</span></div></div>';
            
            const response = await this.fetchSearch(query);
            
            if (response.success) {
                this.searchCache.set(query, response);
                setTimeout(() => this.searchCache.delete(query), 300000);
            }
            
            this.displaySearchResults(response, results);
        } catch (error) {
            console.error('Search error:', error);
            results.innerHTML = `<div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> 
                    ${this.escapeHtml(error.message || 'An error occurred while searching. Please try again.')}
                </div>`;
        }
    }


    setupSearch() {
        const form = document.getElementById('search-form');
        const input = document.getElementById('search-input');
        const results = document.getElementById('search-results');

        if (!form || !input || !results) return;

        // Prevent zoom on iOS when focusing input
        input.addEventListener('focus', (e) => {
            if (window.innerWidth <= 768) {
                e.target.setAttribute('style', 'font-size: 16px !important');
            }
        });

        input.addEventListener('blur', (e) => {
            e.target.removeAttribute('style');
        });

        // =====================================================================
        // ZMENA 2: Nahradenie celej pĂ´vodnej logiky volanĂ­m novej metĂłdy performSearch()
        // =====================================================================
        form.addEventListener('submit', (e) => {
            e.preventDefault(); // ZastavĂ­ ĹˇtandardnĂ© odoslanie formulĂˇra
            this.performSearch();
        });


        // Auto-search with debounce
        input.addEventListener('input', () => {
            clearTimeout(this.debounceTimer);
            if (input.value.length >= 1) {
                this.debounceTimer = setTimeout(() => {
                    // PĂ´vodne: form.dispatchEvent(new Event('submit'));
                    // NovĂ©: Priame volanie, ktorĂ© Firefox nezablokuje
                    this.performSearch(); 
                }, 500);
            } else if (input.value.length === 0) {
                results.innerHTML = '';
            }
        });
        // =====================================================================

        // Clear search on ESC
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                input.value = '';
                results.innerHTML = '';
                input.blur(); // Remove focus on mobile
            }
        });
    }

    async fetchSearch(query) {
        const formData = new FormData();
        formData.append('query', query);
        formData.append('csrf_token', this.csrfToken);

        const searchUrl = this.basePath + '/search';
        
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000);

        try {
            const response = await fetch(searchUrl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                signal: controller.signal
            });

            clearTimeout(timeoutId);

            if (!response.ok) {
                throw new Error(`Server error: ${response.status}`);
            }

            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Invalid response format from server');
            }

            const data = await response.json();
            
            if (!data || typeof data !== 'object') {
                throw new Error('Invalid response data');
            }

            if (data.error) {
                throw new Error(data.error);
            }

            return data;
        } catch (error) {
            if (error.name === 'AbortError') {
                throw new Error('Request timeout. Please check your connection and try again.');
            }
            throw error;
        }
    }

    displaySearchResults(data, container) {
        if (!data.success) {
            container.innerHTML = `<div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> 
                ${this.escapeHtml(data.error || 'Search failed. Please try again.')}
            </div>`;
            return;
        }

        if (!data.punishments || data.punishments.length === 0) {
            container.innerHTML = '<div class="alert alert-info"><i class="fas fa-info-circle"></i> No punishments found for this player.</div>';
            return;
        }

        // Mobile-friendly display for phones
        if (window.innerWidth <= 768) {
            const html = `
                <div class="search-results fade-in">
                    <h4 class="mb-3">Results for: <strong>${this.escapeHtml(data.player)}</strong></h4>
                    <div class="mobile-search-results">
                        ${data.punishments.map(p => this.renderMobilePunishmentCard(p)).join('')}
                    </div>
                </div>
            `;
            container.innerHTML = html;
        } else {
            const html = `
                <div class="search-results fade-in">
                    <h4 class="mb-3">Results for: <strong>${this.escapeHtml(data.player)}</strong></h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Player</th>
                                    <th>Type</th>
                                    <th>Reason</th>
                                    <th>Staff</th>
                                    <th>Date</th>
                                    <th>Expires</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.punishments.map(p => this.renderPunishmentRow(p)).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
            container.innerHTML = html;
        }
        
        this.fadeIn(container.querySelector('.search-results'));
        
        // Add click handlers for punishment rows
        this.setupPunishmentRowClicks();
    }

    renderMobilePunishmentCard(punishment) {
        const statusClass = punishment.active ? 'status-active' : 'status-inactive';
        const statusText = punishment.active ? 'Active' : 'Inactive';
        
        const typeClass = {
            'ban': 'bg-danger',
            'bans': 'bg-danger',
            'mute': 'bg-warning',
            'mutes': 'bg-warning',
            'warning': 'bg-info',
            'warnings': 'bg-info',
            'kick': 'bg-secondary',
            'kicks': 'bg-secondary'
        }[punishment.type] || 'bg-dark';

        const typeText = punishment.type.replace(/s$/, '').toUpperCase();
        const typeSingular = punishment.type.replace(/s$/, '');

        let untilText = '';
        if (punishment.until) {
            if (punishment.until.toLowerCase().includes('permanent')) {
                untilText = '<span class="badge bg-danger">Permanent</span>';
            } else if (punishment.until.toLowerCase().includes('expired')) {
                untilText = '<span class="badge bg-success">Expired</span>';
            } else {
                untilText = `<span class="badge bg-warning">${this.escapeHtml(punishment.until)}</span>`;
            }
        } else if (punishment.type === 'ban' || punishment.type === 'mute') {
            untilText = '<span class="badge bg-danger">Permanent</span>';
        }

        return `
            <div class="search-result-card mb-3 punishment-row" data-type="${typeSingular}" data-id="${punishment.id || ''}" style="cursor: pointer;">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="mb-1">
                                    <i class="fas fa-user text-primary me-2"></i>
                                    <strong>${this.escapeHtml(punishment.player_name)}</strong>
                                </h6>
                            </div>
                            <div class="d-flex gap-2">
                                <span class="badge ${typeClass}">${this.escapeHtml(typeText)}</span>
                                <span class="status-badge ${statusClass}">${this.escapeHtml(statusText)}</span>
                            </div>
                        </div>
                        <div class="mb-2">
                            <strong class="text-muted small">Reason:</strong>
                            <div class="mt-1">${this.escapeHtml(punishment.reason)}</div>
                        </div>
                        <div class="row g-2 small">
                            <div class="col-6">
                                <strong class="text-muted">Staff:</strong><br>
                                <span class="text-primary">${this.escapeHtml(punishment.staff)}</span>
                            </div>
                            <div class="col-6">
                                <strong class="text-muted">Date:</strong><br>
                                ${this.escapeHtml(punishment.date)}
                            </div>
                            ${untilText ? `
                                <div class="col-12 mt-2">
                                    <strong class="text-muted">Expires:</strong> ${untilText}
                                </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    renderPunishmentRow(punishment) {
        const statusClass = punishment.active ? 'status-active' : 'status-inactive';
        const statusText = punishment.active ? 'Active' : 'Inactive';
        
        const typeClass = {
            'ban': 'bg-danger',
            'bans': 'bg-danger',
            'mute': 'bg-warning',
            'mutes': 'bg-warning',
            'warning': 'bg-info',
            'warnings': 'bg-info',
            'kick': 'bg-secondary',
            'kicks': 'bg-secondary'
        }[punishment.type] || 'bg-dark';

        const typeText = punishment.type.replace(/s$/, '').toUpperCase();
        const typeSingular = punishment.type.replace(/s$/, '');

        let untilBadge = '';
        if (punishment.until) {
            if (punishment.until.toLowerCase().includes('permanent')) {
                untilBadge = '<span class="badge bg-danger">Permanent</span>';
            } else if (punishment.until.toLowerCase().includes('expired')) {
                untilBadge = '<span class="badge bg-success">Expired</span>';
            } else {
                untilBadge = `<span class="badge bg-warning">${this.escapeHtml(punishment.until)}</span>`;
            }
        } else if (punishment.type === 'ban' || punishment.type === 'mute') {
            untilBadge = '<span class="badge bg-danger">Permanent</span>';
        } else {
            untilBadge = '<span class="text-muted">N/A</span>';
        }

        return `
            <tr class="punishment-row" data-type="${typeSingular}" data-id="${punishment.id || ''}" style="cursor: pointer;">
                <td><strong>${this.escapeHtml(punishment.player_name)}</strong></td>
                <td><span class="badge ${typeClass}">${this.escapeHtml(typeText)}</span></td>
                <td class="text-truncate" style="max-width: 200px;" title="${this.escapeHtml(punishment.reason)}">${this.escapeHtml(punishment.reason)}</td>
                <td>${this.escapeHtml(punishment.staff)}</td>
                <td>${this.escapeHtml(punishment.date)}</td>
                <td>${untilBadge}</td>
                <td><span class="status-badge ${statusClass}">${this.escapeHtml(statusText)}</span></td>
            </tr>
        `;
    }

    setupPunishmentRowClicks() {
        // Use event delegation for dynamically added rows
        document.addEventListener('click', (e) => {
            const row = e.target.closest('.punishment-row');
            if (row) {
                const type = row.dataset.type;
                const id = row.dataset.id;
                
                if (type && id) {
                    const detailUrl = `${this.basePath}/detail?type=${type}&id=${id}`;
                    window.location.href = detailUrl;
                }
            }
        });
    }

    setupMobileMenu() {
        const toggler = document.querySelector('.navbar-toggler');
        const collapse = document.querySelector('.navbar-collapse');
        
        if (!toggler || !collapse) return;
        
        toggler.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            collapse.classList.toggle('show');
            toggler.setAttribute('aria-expanded', collapse.classList.contains('show'));
        });
        
        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.navbar-modern') && collapse.classList.contains('show')) {
                collapse.classList.remove('show');
                toggler.setAttribute('aria-expanded', 'false');
            }
        });

        // Close on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && collapse.classList.contains('show')) {
                collapse.classList.remove('show');
                toggler.setAttribute('aria-expanded', 'false');
            }
        });
    }

    setupScrollEffects() {
        const navbar = document.getElementById('mainNavbar');
        if (!navbar) return;
        
        let lastScroll = 0;
        let ticking = false;

        const updateNavbar = () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
            
            lastScroll = currentScroll;
            ticking = false;
        };

        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(updateNavbar);
                ticking = true;
            }
        });
    }

    setupTooltips() {
        const tooltips = document.querySelectorAll('[title]:not([data-bs-toggle="tooltip"])');
        tooltips.forEach(el => {
            if (!el.closest('.navbar-nav')) { // Skip nav items
                el.setAttribute('data-bs-toggle', 'tooltip');
                el.setAttribute('data-bs-placement', 'top');
            }
        });
    }

    setupDetailPageFeatures() {
        // Auto-refresh for active punishments
        const progressBar = document.querySelector('.progress-bar');
        if (progressBar) {
            // Update progress every minute
            setInterval(() => {
                if (document.visibilityState === 'visible') {
                    const progress = parseFloat(progressBar.style.width);
                    if (progress < 100) {
                        // Could implement real-time progress update here
                        // For now, just reload the page
                        location.reload();
                    }
                }
            }, 60000);
        }

        // Copy UUID on click
        const uuidElements = document.querySelectorAll('.font-monospace');
        uuidElements.forEach(el => {
            if (el.textContent.match(/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i)) {
                el.style.cursor = 'pointer';
                el.addEventListener('click', () => {
                    this.copyToClipboard(el.textContent);
                });
            }
        });
    }

    setupClearCache() {
        const clearCacheBtn = document.getElementById('clear-cache-btn');
        const confirmBtn = document.getElementById('confirm-clear-cache');
        const modal = document.getElementById('cacheModal');
        
        if (!clearCacheBtn || !confirmBtn || !modal) return;

        const showModal = () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        };

        const hideModal = () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };
        
        clearCacheBtn.addEventListener('click', () => {
            showModal();
        });

        modal.querySelectorAll('[data-modal-close]').forEach((button) => {
            button.addEventListener('click', hideModal);
        });

        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                hideModal();
            }
        });
        
        confirmBtn.addEventListener('click', async () => {
            try {
                const formData = new FormData();
                formData.append('csrf_token', this.csrfToken);
                
                const response = await fetch(this.basePath + '/stats/clear-cache', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    hideModal();
                    this.showNotification('success', data.message || 'Cache cleared successfully');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    throw new Error(data.message || 'Failed to clear cache');
                }
            } catch (error) {
                console.error('Cache clear error:', error);
                this.showNotification('danger', error.message);
                hideModal();
            }
        });
    }

    setupModals() {
        if (typeof bootstrap === 'undefined' || !bootstrap.Modal) {
            return;
        }

        // Handle all modal close buttons
        document.querySelectorAll('.modal .btn-close, [data-bs-dismiss="modal"]').forEach(btn => {
            btn.addEventListener('click', () => {
                const modal = btn.closest('.modal');
                if (modal) {
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    if (bsModal) bsModal.hide();
                }
            });
        });
    }

    setupTables() {
        // Make table rows clickable
        document.querySelectorAll('.table tbody tr[onclick]').forEach(row => {
            row.style.cursor = 'pointer';
            
            // Prevent navigation when clicking on buttons/links
            row.querySelectorAll('a, button').forEach(el => {
                el.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
            });
        });

        // Sort tables (if needed in future)
        this.setupTableSort();
    }

    setupTableSort() {
        // Placeholder for table sorting functionality
        // Can be implemented later if needed
    }

    setupClickableRows() {
        // Handle clickable rows with data-href attribute
        document.addEventListener('click', (e) => {
            const clickableRow = e.target.closest('.clickable-row');
            if (clickableRow && clickableRow.dataset.href) {
                // Don't navigate if clicking on a link or button inside the row
                if (e.target.closest('a, button')) {
                    return;
                }
                window.location.href = clickableRow.dataset.href;
            }
        });
    }

    setupBackButton() {
        // Handle back buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('.back-button')) {
                e.preventDefault();
                window.history.back();
            }
        });
    }

    initializeBootstrapComponents() {
        if (typeof bootstrap === 'undefined') {
            return;
        }

        // Initialize all Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            // Check if element has valid title attribute
            const title = tooltipTriggerEl.getAttribute('title') || tooltipTriggerEl.getAttribute('data-bs-title');
            if (title && title !== 'null' && title.trim() !== '') {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            }
            return null;
        });

        // Initialize all Bootstrap popovers
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function (popoverTriggerEl) {
            // Check if element has valid content
            const content = popoverTriggerEl.getAttribute('data-bs-content');
            if (content && content !== 'null' && content.trim() !== '') {
                return new bootstrap.Popover(popoverTriggerEl);
            }
            return null;
        });
    }

    // Utility functions
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = String(text);
        return div.innerHTML;
    }

    fadeIn(element) {
        if (!element) return;
        element.style.opacity = '0';
        element.style.transition = 'opacity 300ms ease-in-out';
        
        setTimeout(() => {
            element.style.opacity = '1';
        }, 10);
    }

    copyToClipboard(text) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(() => {
                this.showNotification('success', 'Copied to clipboard!');
            }).catch(() => {
                this.fallbackCopy(text);
            });
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
            this.showNotification('success', 'Copied to clipboard!');
        } catch (err) {
            this.showNotification('danger', 'Failed to copy');
        }
        
        document.body.removeChild(textArea);
    }

    showNotification(type, message) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
        alert.style.zIndex = '9999';
        alert.style.minWidth = '250px';
        
        const icon = type === 'success' ? 'check-circle' : 'exclamation-triangle';
        
        alert.innerHTML = `
            <i class="fas fa-${icon}"></i> ${this.escapeHtml(message)}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(alert);
        
        // Auto dismiss after 3 seconds
        setTimeout(() => {
            alert.classList.remove('show');
            setTimeout(() => alert.remove(), 150);
        }, 3000);
    }

    // Public API methods
    refresh() {
        location.reload();
    }

    navigateTo(url) {
        window.location.href = this.basePath + url;
    }
}

// Initialize the UI when DOM is ready
const LiteBansU = new LiteBansUI();

// Expose to global scope for external access
window.LiteBansU = LiteBansU;
