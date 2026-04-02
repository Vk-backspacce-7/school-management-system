(function () {
    const triggers = Array.from(document.querySelectorAll('[data-panel-target]'));

    if (!triggers.length) {
        return;
    }

    const panels = new Map();

    triggers.forEach((trigger) => {
        const panelId = trigger.getAttribute('data-panel-target');

        if (!panelId) {
            return;
        }

        const panel = document.getElementById(panelId);

        if (!panel) {
            return;
        }

        panels.set(panelId, panel);
    });

    if (!panels.size) {
        return;
    }

    let activePanelId = null;

    function isMobileViewport() {
        return window.innerWidth <= 767;
    }

    function findTriggerByPanel(panelId) {
        return triggers.find((trigger) => trigger.getAttribute('data-panel-target') === panelId) || null;
    }

    function clamp(value, min, max) {
        return Math.min(Math.max(value, min), max);
    }

    function setPanelPosition(trigger, panel) {
        if (!trigger || !panel) {
            return;
        }

        if (isMobileViewport()) {
            panel.style.left = '';
            panel.style.right = '';
            panel.style.top = '';
            panel.style.bottom = '';
            return;
        }

        const triggerRect = trigger.getBoundingClientRect();
        const panelRect = panel.getBoundingClientRect();

        const panelWidth = panelRect.width || 360;
        const panelHeight = panelRect.height || 420;

        const margin = 10;
        const minimumTop = 60;
        const maximumLeft = window.innerWidth - panelWidth - margin;
        const maximumTop = window.innerHeight - panelHeight - margin;

        const nextLeft = clamp(triggerRect.right - panelWidth, margin, Math.max(margin, maximumLeft));
        const nextTop = clamp(triggerRect.bottom + 10, minimumTop, Math.max(minimumTop, maximumTop));

        panel.style.left = `${nextLeft}px`;
        panel.style.top = `${nextTop}px`;
        panel.style.right = 'auto';
        panel.style.bottom = 'auto';
    }

    function notify(panelId, state) {
        window.dispatchEvent(new CustomEvent('interaction:panel-toggle', {
            detail: {
                panelId,
                state,
            },
        }));
    }

    function closePanel(panelId) {
        if (!panelId || !panels.has(panelId)) {
            return;
        }

        const panel = panels.get(panelId);
        const trigger = findTriggerByPanel(panelId);

        panel.classList.remove('is-open');

        if (trigger) {
            trigger.setAttribute('aria-expanded', 'false');
        }

        if (activePanelId === panelId) {
            activePanelId = null;
        }

        notify(panelId, 'closed');
    }

    function openPanel(panelId, options) {
        if (!panelId || !panels.has(panelId)) {
            return;
        }

        const panel = panels.get(panelId);
        const trigger = findTriggerByPanel(panelId);

        if (!trigger) {
            return;
        }

        if (activePanelId && activePanelId !== panelId) {
            closePanel(activePanelId);
        }

        const skipReposition = options && options.skipReposition;

        if (!skipReposition) {
            const manualPosition = panel.dataset.manualPosition === '1';
            const shouldReposition = panelId !== 'chatPanel' || !manualPosition || isMobileViewport();

            if (shouldReposition) {
                setPanelPosition(trigger, panel);
            }
        }

        panel.classList.add('is-open');
        trigger.setAttribute('aria-expanded', 'true');
        activePanelId = panelId;

        notify(panelId, 'opened');
    }

    function togglePanel(panelId) {
        if (!panelId || !panels.has(panelId)) {
            return;
        }

        const panel = panels.get(panelId);

        if (panel.classList.contains('is-open')) {
            closePanel(panelId);
            return;
        }

        openPanel(panelId);
    }

    triggers.forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();

            const panelId = trigger.getAttribute('data-panel-target');
            togglePanel(panelId);
        });
    });

    const chatCloseButton = document.getElementById('chatCloseButton');

    if (chatCloseButton) {
        chatCloseButton.addEventListener('click', (event) => {
            event.preventDefault();
            closePanel('chatPanel');
        });
    }

    document.addEventListener('click', (event) => {
        if (!activePanelId) {
            return;
        }

        const activePanel = panels.get(activePanelId);
        const activeTrigger = findTriggerByPanel(activePanelId);

        const clickedInsidePanel = activePanel && activePanel.contains(event.target);
        const clickedTrigger = activeTrigger && activeTrigger.contains(event.target);

        if (!clickedInsidePanel && !clickedTrigger) {
            closePanel(activePanelId);
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && activePanelId) {
            closePanel(activePanelId);
        }
    });

    window.addEventListener('resize', () => {
        if (!activePanelId) {
            return;
        }

        const panel = panels.get(activePanelId);
        const trigger = findTriggerByPanel(activePanelId);

        if (!panel || !trigger) {
            return;
        }

        if (panel.dataset.manualPosition === '1' && activePanelId === 'chatPanel' && !isMobileViewport()) {
            return;
        }

        setPanelPosition(trigger, panel);
    });

    window.InteractionPanels = {
        open: openPanel,
        close: closePanel,
        isOpen(panelId) {
            return panels.has(panelId) && panels.get(panelId).classList.contains('is-open');
        },
    };
})();
