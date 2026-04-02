(function () {
    const STORAGE_KEY = 'principalDashboardActiveSection';
    const SECTION_IDS = ['mainContent', 'teachers', 'students', 'classes', 'subjects'];

    function hideAllSections() {
        SECTION_IDS.forEach(function (id) {
            const el = document.getElementById(id);
            if (el) {
                el.style.display = 'none';
            }
        });
    }

    function setActiveSection(sectionId) {
        try {
            localStorage.setItem(STORAGE_KEY, sectionId);
        } catch (err) {
            // Ignore storage errors (private mode/restricted browsers)
        }
    }

    function getActiveSection() {
        try {
            return localStorage.getItem(STORAGE_KEY);
        } catch (err) {
            return null;
        }
    }

    function showSection(sectionId, options) {
        const settings = Object.assign({ save: true, scroll: true }, options || {});
        const targetId = SECTION_IDS.includes(sectionId) ? sectionId : 'mainContent';

        hideAllSections();

        const target = document.getElementById(targetId);
        if (target) {
            target.style.display = 'block';
        }

        if (settings.save) {
            setActiveSection(targetId);
        }

        if (settings.scroll) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }

    function bindSectionTriggers() {
        document.querySelectorAll('[data-section]').forEach(function (trigger) {
            trigger.addEventListener('click', function (event) {
                if (trigger.tagName.toLowerCase() === 'a') {
                    event.preventDefault();
                }
                showSection(trigger.getAttribute('data-section'));
            });
        });
    }

    function bindKeyboardForCards() {
        document.querySelectorAll('.feature-card[data-section]').forEach(function (card) {
            card.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    showSection(card.getAttribute('data-section'));
                }
            });
        });
    }

    function openProfile() {
        const modalEl = document.getElementById('profileModal');
        if (!modalEl) return;
        const profileModal = new bootstrap.Modal(modalEl);
        profileModal.show();
    }

    function openAbout() {
        alert('School Management System v1.0');
    }

    document.addEventListener('DOMContentLoaded', function () {
        bindSectionTriggers();
        bindKeyboardForCards();

        const savedSection = getActiveSection();
        showSection(savedSection || 'mainContent', { save: false, scroll: false });

        // Keep compatibility with any existing inline handlers in this page.
        window.backHome = function () { showSection('mainContent'); };
        window.showTeachers = function () { showSection('teachers'); };
        window.showStudents = function () { showSection('students'); };
        window.showClasses = function () { showSection('classes'); };
        window.showSubjects = function () { showSection('subjects'); };
        window.openProfile = openProfile;
        window.openAbout = openAbout;
    });
})();


