 // Wait until DOM is fully loaded
document.addEventListener('DOMContentLoaded', function () {

    // Helper function to hide all sections
    function hideAllSections() {
        const sections = ['mainContent', 'teachers', 'students', 'classes','subjects'];
        sections.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.style.display = 'none';
        });
    }

    // Show Home / main content
    function backHome() {
        hideAllSections();
        document.getElementById('mainContent').style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Show Teachers section
    function showTeachers() {
        hideAllSections();
        document.getElementById('teachers').style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Show Students section
    function showStudents() {
        hideAllSections();
        document.getElementById('students').style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Show Classes section
    function showClasses() {
        hideAllSections();
        document.getElementById('classes').style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Show Subjects section
function showSubjects() {
    hideAllSections();
    document.getElementById('subjects').style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

    // Open Profile modal using Bootstrap 5
    function openProfile() {
        const profileModal = new bootstrap.Modal(document.getElementById('profileModal'));
        profileModal.show();
    }

    // Open About alert
    function openAbout() {
        alert("School Management System v1.0");
    }

    // Make functions globally accessible for inline onclick
    window.backHome = backHome;
    window.showTeachers = showTeachers;
    window.showStudents = showStudents;
    window.showClasses = showClasses;
    window.showSubjects = showSubjects;
    window.openProfile = openProfile;
    window.openAbout = openAbout;

    // Optionally, show home content on page load
    backHome();
});