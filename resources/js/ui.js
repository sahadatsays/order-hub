// ============================================================
// Order Hub — UI Interactivity System
// Pure vanilla JS, no dependencies.
// ============================================================

// ---- Toast System ------------------------------------------

const TOAST_ICONS = {
    success: `<svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
    error:   `<svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
    warning: `<svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`,
    info:    `<svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
};

const TOAST_BORDERS = {
    success: 'border-green-200',
    error:   'border-red-200',
    warning: 'border-yellow-200',
    info:    'border-blue-200',
};

function createToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) { return; }

    const border = TOAST_BORDERS[type] ?? TOAST_BORDERS.info;
    const icon   = TOAST_ICONS[type]   ?? TOAST_ICONS.info;

    const toast = document.createElement('div');
    toast.className = [
        'flex items-start gap-3 w-full bg-white border rounded-xl shadow-lg px-4 py-3',
        'translate-x-full opacity-0 transition-all duration-300 ease-out',
        border,
    ].join(' ');

    toast.innerHTML = `
        ${icon}
        <p class="flex-1 text-sm text-zinc-800 leading-snug">${message}</p>
        <button type="button" class="text-zinc-400 hover:text-zinc-600 transition-colors duration-150 shrink-0 mt-0.5" aria-label="Dismiss">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    `;

    const closeBtn = toast.querySelector('button');
    closeBtn.addEventListener('click', () => removeToast(toast));

    container.appendChild(toast);

    // Trigger slide-in on next frame
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
        });
    });

    const timer = setTimeout(() => removeToast(toast), 4000);
    toast._dismissTimer = timer;
}

function removeToast(toast) {
    clearTimeout(toast._dismissTimer);
    toast.classList.add('translate-x-full', 'opacity-0');
    toast.addEventListener('transitionend', () => toast.remove(), { once: true });
}

window.toast = createToast;

// ---- Modal System ------------------------------------------

function openModal(id) {
    const modal = document.getElementById(id);
    if (!modal) { return; }
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    modal.setAttribute('data-modal-open-state', 'true');
}

function closeModal(modal) {
    if (!modal) { return; }
    modal.classList.add('hidden');
    modal.removeAttribute('data-modal-open-state');

    // Re-enable body scroll only if no other modals are open
    const openModals = document.querySelectorAll('[data-modal-open-state]');
    if (openModals.length === 0) {
        document.body.classList.remove('overflow-hidden');
    }
}

function findModalAncestor(el) {
    return el.closest('[data-modal]');
}

function initModals() {
    // Open triggers
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-modal-open]');
        if (trigger) {
            e.preventDefault();
            openModal(trigger.dataset.modalOpen);
            return;
        }

        // Close triggers
        const closeTrigger = e.target.closest('[data-modal-close]');
        if (closeTrigger) {
            e.preventDefault();
            closeModal(findModalAncestor(closeTrigger));
            return;
        }

        // Backdrop click — target must BE the modal wrapper (not a child)
        if (e.target.hasAttribute('data-modal-backdrop')) {
            closeModal(e.target.closest('[data-modal]'));
        }
    });

    // ESC key closes top-most open modal
    document.addEventListener('keydown', (e) => {
        if (e.key !== 'Escape') { return; }
        const openModals = document.querySelectorAll('[data-modal]:not(.hidden)');
        if (openModals.length > 0) {
            closeModal(openModals[openModals.length - 1]);
        }
    });
}

window.openModal  = openModal;
window.closeModal = (id) => closeModal(document.getElementById(id));

// ---- Drawer System -----------------------------------------

function openDrawer(id) {
    const drawer = document.getElementById(id);
    if (!drawer) { return; }
    drawer.classList.remove('translate-x-full');
    drawer.classList.add('translate-x-0');
    drawer.setAttribute('data-drawer-open-state', 'true');
    document.body.classList.add('overflow-hidden');

    const backdrop = drawer.querySelector('[data-drawer-backdrop]');
    if (backdrop) { backdrop.classList.remove('hidden'); }
}

function closeDrawer(drawer) {
    if (!drawer) { return; }
    drawer.classList.remove('translate-x-0');
    drawer.classList.add('translate-x-full');
    drawer.removeAttribute('data-drawer-open-state');

    const backdrop = drawer.querySelector('[data-drawer-backdrop]');
    if (backdrop) { backdrop.classList.add('hidden'); }

    const openDrawers = document.querySelectorAll('[data-drawer-open-state]');
    if (openDrawers.length === 0) {
        document.body.classList.remove('overflow-hidden');
    }
}

function initDrawers() {
    document.addEventListener('click', (e) => {
        const openTrigger = e.target.closest('[data-drawer-open]');
        if (openTrigger) {
            e.preventDefault();
            openDrawer(openTrigger.dataset.drawerOpen);
            return;
        }

        const closeTrigger = e.target.closest('[data-drawer-close]');
        if (closeTrigger) {
            e.preventDefault();
            closeDrawer(closeTrigger.closest('[data-drawer]'));
            return;
        }

        if (e.target.hasAttribute('data-drawer-backdrop')) {
            closeDrawer(e.target.closest('[data-drawer]'));
        }
    });
}

window.openDrawer  = openDrawer;
window.closeDrawer = (id) => closeDrawer(document.getElementById(id));

// ---- Dropdown System ---------------------------------------

function closeAllDropdowns(except = null) {
    document.querySelectorAll('[data-dropdown]').forEach((dropdown) => {
        if (dropdown === except) { return; }
        const menu = dropdown.querySelector('[data-dropdown-menu]');
        if (menu) { menu.classList.add('hidden'); }
        dropdown.removeAttribute('data-dropdown-open');
    });
}

function initDropdowns() {
    document.addEventListener('click', (e) => {
        const toggleBtn = e.target.closest('[data-dropdown-toggle]');
        if (toggleBtn) {
            e.stopPropagation();
            const dropdown = toggleBtn.closest('[data-dropdown]');
            if (!dropdown) { return; }
            const menu = dropdown.querySelector('[data-dropdown-menu]');
            if (!menu) { return; }

            const isOpen = !menu.classList.contains('hidden');
            closeAllDropdowns(isOpen ? null : dropdown);

            if (!isOpen) {
                menu.classList.remove('hidden');
                dropdown.setAttribute('data-dropdown-open', 'true');
            } else {
                menu.classList.add('hidden');
                dropdown.removeAttribute('data-dropdown-open');
            }
            return;
        }

        // Click outside closes all dropdowns
        closeAllDropdowns();
    });
}

// ---- Sidebar Toggle ----------------------------------------

function initSidebar() {
    document.addEventListener('click', (e) => {
        const toggle = e.target.closest('[data-sidebar-toggle]');
        if (!toggle) { return; }

        const sidebar  = document.getElementById('app-sidebar');
        const overlay  = document.getElementById('sidebar-overlay');
        if (!sidebar) { return; }

        const isMobile = window.innerWidth < 1024;

        if (isMobile) {
            const isOpen = sidebar.getAttribute('data-sidebar-open') === 'true';
            if (isOpen) {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                sidebar.setAttribute('data-sidebar-open', 'false');
                if (overlay) { overlay.classList.add('hidden'); }
            } else {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                sidebar.setAttribute('data-sidebar-open', 'true');
                if (overlay) { overlay.classList.remove('hidden'); }
            }
        } else {
            const isCollapsed = sidebar.getAttribute('data-sidebar-collapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.remove('lg:w-16');
                sidebar.classList.add('lg:w-64');
                sidebar.setAttribute('data-sidebar-collapsed', 'false');
            } else {
                sidebar.classList.remove('lg:w-64');
                sidebar.classList.add('lg:w-16');
                sidebar.setAttribute('data-sidebar-collapsed', 'true');
            }
        }
    });
}

// ---- Tabs System -------------------------------------------

function activateTab(tabsContainer, name) {
    // Hide all panels
    tabsContainer.querySelectorAll('[data-tab-panel]').forEach((panel) => {
        panel.classList.add('hidden');
    });

    // Deactivate all triggers
    tabsContainer.querySelectorAll('[data-tab-trigger]').forEach((trigger) => {
        trigger.classList.remove(
            'border-indigo-600', 'text-indigo-600',
            'bg-indigo-50', 'font-semibold',
        );
        trigger.classList.add('text-zinc-500', 'border-transparent');
        trigger.setAttribute('aria-selected', 'false');
    });

    // Show target panel
    const panel = tabsContainer.querySelector(`[data-tab-panel="${name}"]`);
    if (panel) { panel.classList.remove('hidden'); }

    // Activate trigger
    const trigger = tabsContainer.querySelector(`[data-tab-trigger="${name}"]`);
    if (trigger) {
        trigger.classList.add('border-indigo-600', 'text-indigo-600', 'font-semibold');
        trigger.classList.remove('text-zinc-500', 'border-transparent');
        trigger.setAttribute('aria-selected', 'true');
    }
}

function initTabs() {
    // Activate the first tab in each tabs container on load
    document.querySelectorAll('[data-tabs]').forEach((tabsContainer) => {
        const firstTrigger = tabsContainer.querySelector('[data-tab-trigger]');
        if (firstTrigger) {
            activateTab(tabsContainer, firstTrigger.dataset.tabTrigger);
        }
    });

    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-tab-trigger]');
        if (!trigger) { return; }
        const tabsContainer = trigger.closest('[data-tabs]');
        if (!tabsContainer) { return; }
        activateTab(tabsContainer, trigger.dataset.tabTrigger);
    });
}

// ---- Init --------------------------------------------------

function init() {
    initModals();
    initDrawers();
    initDropdowns();
    initSidebar();
    initTabs();
}

document.addEventListener('DOMContentLoaded', init);
