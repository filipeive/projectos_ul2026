(function () {
    const STORAGE_KEY = 'ul-techhub-theme';
    const modes = ['system', 'light', 'dark'];
    const icons = {
        system: 'monitor',
        light: 'sun',
        dark: 'moon'
    };
    const labels = {
        system: 'Sistema',
        light: 'Claro',
        dark: 'Escuro'
    };
    const media = window.matchMedia('(prefers-color-scheme: dark)');

    function readPreference() {
        try {
            return localStorage.getItem(STORAGE_KEY);
        } catch (error) {
            return null;
        }
    }

    function savePreference(mode) {
        try {
            localStorage.setItem(STORAGE_KEY, mode);
        } catch (error) {
            document.documentElement.dataset.themeMemory = mode;
        }
    }

    function getStoredMode() {
        const stored = readPreference() || document.documentElement.dataset.themeMemory;
        return modes.includes(stored) ? stored : 'system';
    }

    function resolveMode(mode) {
        return mode === 'system' ? (media.matches ? 'dark' : 'light') : mode;
    }

    function applyTheme(mode) {
        const resolved = resolveMode(mode);
        document.documentElement.dataset.themeMode = mode;
        document.documentElement.dataset.theme = resolved;
        document.documentElement.style.colorScheme = resolved;
        
        // Support Tailwind dark mode class-based strategy
        if (resolved === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        
        updateToggle(mode);
    }

    function updateToggle(mode) {
        const toggle = document.getElementById('theme-toggle');
        if (!toggle) return;
        toggle.setAttribute('aria-label', `Tema atual: ${labels[mode]}. Clique para alternar.`);
        toggle.title = `Tema: ${labels[mode]}`;
        toggle.innerHTML = `<i data-lucide="${icons[mode]}"></i><span>${labels[mode]}</span>`;
        if (window.lucide) window.lucide.createIcons();
    }

    function nextMode(mode) {
        if (mode === 'system') {
            return resolveMode(mode) === 'dark' ? 'light' : 'dark';
        }
        return mode === 'dark' ? 'light' : 'dark';
    }

    function setMode(mode) {
        savePreference(mode);
        applyTheme(mode);
    }

    function mountToggle() {
        if (document.getElementById('theme-toggle')) return;

        const toggle = document.createElement('button');
        toggle.id = 'theme-toggle';
        toggle.type = 'button';
        toggle.className = 'theme-toggle';
        toggle.addEventListener('click', () => setMode(nextMode(getStoredMode())));
        document.body.appendChild(toggle);
        updateToggle(getStoredMode());
    }

    applyTheme(getStoredMode());

    const handleSystemChange = () => {
        if (getStoredMode() === 'system') applyTheme('system');
    };

    if (typeof media.addEventListener === 'function') {
        media.addEventListener('change', handleSystemChange);
    } else if (typeof media.addListener === 'function') {
        media.addListener(handleSystemChange);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', mountToggle);
    } else {
        mountToggle();
    }
})();
