function setActiveStyleSheet(title) {
    var links = document.getElementsByTagName("link");
    for (var i = 0; i < links.length; i++) {
        var link = links[i];
        if (link.getAttribute("rel").indexOf("style") != -1 && link.getAttribute("title")) {
            link.disabled = true;
            if (link.getAttribute("title") === title) link.disabled = false;
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const content = document.querySelector('.content');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const navLinks = document.querySelectorAll('.sidebar nav a');
    const darkModeToggle = document.getElementById('darkModeToggle');

    // Fonction pour basculer la visibilité de la sidebar
    function toggleSidebar() {
        sidebar.classList.toggle('hidden');
        if (sidebar.classList.contains('hidden')) {
            content.style.marginLeft = '0';
        } else {
            content.style.marginLeft = getComputedStyle(document.documentElement).getPropertyValue('10px');
        }
    }

    // Gestionnaire d'événement pour le bouton sidebarToggle
    sidebarToggle.addEventListener('click', toggleSidebar);

    // Fonction pour activer le lien de navigation sélectionné
    function setActiveNavLink(clickedLink) {
        navLinks.forEach(link => {
            link.parentElement.classList.remove('active');
        });
        clickedLink.parentElement.classList.add('active');
    }

    // Gestionnaire d'événement pour les liens de navigation
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            setActiveNavLink(this);
            console.log(`Page sélectionnée : ${this.textContent.trim()}`);
            // Autorise la navigation vers la page si elle n'est pas gérée dynamiquement
            if (!isDynamicLoadingEnabled) {
                return; // Permet au lien d'effectuer sa navigation normale
            }
        });
    });
    
    // Dark mode toggle functionality
    function toggleDarkMode() {
        const isDarkMode = document.body.classList.toggle('dark-mode');
        localStorage.setItem('darkMode', isDarkMode);
        setActiveStyleSheet(isDarkMode ? 'dark' : 'light');
        updateChartColors();
    }

    // Check for saved dark mode preference
    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
        darkModeToggle.checked = true;
        setActiveStyleSheet('dark');
    } else {
        setActiveStyleSheet('light');
    }

    // Event listener for dark mode toggle
    darkModeToggle.addEventListener('change', toggleDarkMode);

    // Function to update chart colors based on the current mode
    function updateChartColors() {
        const isDarkMode = document.body.classList.contains('dark-mode');
        const textColor = isDarkMode ? '#f0f0f0' : '#333';
        const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';

        // Update Enrollment Chart
        if (window.enrollmentChart) {
            window.enrollmentChart.options.scales.x.ticks.color = textColor;
            window.enrollmentChart.options.scales.y.ticks.color = textColor;
            window.enrollmentChart.options.scales.x.grid.color = gridColor;
            window.enrollmentChart.options.scales.y.grid.color = gridColor;
            window.enrollmentChart.update();
        }

        // Update Performance Chart
        if (window.performanceChart) {
            window.performanceChart.options.scales.x.ticks.color = textColor;
            window.performanceChart.options.scales.y.ticks.color = textColor;
            window.performanceChart.options.scales.x.grid.color = gridColor;
            window.performanceChart.options.scales.y.grid.color = gridColor;
            window.performanceChart.update();
        }
    }

    // Enrollment Chart
    const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
    window.enrollmentChart = new Chart(enrollmentCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aou', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Inscriptions des Étudiants',
                data: [1000, 1050, 1100, 1075, 1150, 1200, 1180, 1220, 1250, 1300, 1350, 1400],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Inscriptions Mensuelles des Étudiants'
                }
            }
        }
    });

    // Performance Chart
    const performanceCtx = document.getElementById('performanceChart').getContext('2d');
    window.performanceChart = new Chart(performanceCtx, {
        type: 'bar',
        data: {
            labels: ['Maths', 'Sciences', 'Français', 'Histoire', 'Art'],
            datasets: [{
                label: 'Score Moyen',
                data: [85, 78, 82, 89, 92],
                backgroundColor: '#f97316',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Aperçu des Performances par Matière'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    // Initial update of chart colors
    updateChartColors();

    // Add hover effect to stat cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
            this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.1)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
        });
    });

   
    updateChartColors();
});

