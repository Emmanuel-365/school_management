document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const content = document.querySelector('.content');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const navLinks = document.querySelectorAll('.sidebar nav a');

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
    

    // Enrollment Chart
    const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
    new Chart(enrollmentCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
            datasets: [{
                label: 'Inscriptions des Étudiants',
                data: [1000, 1050, 1100, 1075, 1150, 1200],
                borderColor: '#1e40af',
                backgroundColor: 'rgba(30, 64, 175, 0.1)',
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
    new Chart(performanceCtx, {
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




   
    
});
// code de recherche dynamique
const searchInput = document.getElementById('search');
        const table = document.getElementById('studentsTable');
        const rows = Array.from(table.getElementsByTagName('tbody')[0].getElementsByTagName('tr'));

        function debounce(callback, delay) {
            let timeout;
            return (...args) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => callback(...args), delay);
            };
        }

        function filterStudents(keyword) {
            keyword = keyword.toLowerCase();
            rows.forEach(row => {
                const cells = Array.from(row.getElementsByTagName('td'));
                const matches = cells.some(cell => 
                    cell.textContent.toLowerCase().includes(keyword)
                );
                row.style.display = matches ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', debounce((e) => {
            const keyword = e.target.value;
            filterStudents(keyword);
        }, 300));
// fin

