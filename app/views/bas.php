 </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/js/script.js"></script>
    <script src="/js/lang.js" defer></script>
    <script src="/js/student_script.js"></script>
    <script src="/js/chatbot.js"></script>
    <!-- design delete popup -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script>
    document.addEventListener('DOMContentLoaded', function () {
    const phoneInputs = document.querySelectorAll('[id^="phone"]'); // Tous les champs avec id qui commence par 'phone'
    const amountInputs = document.querySelectorAll('[id^="amount"]'); // Tous les champs avec id qui commence par 'amount'
    const dobInputs = document.querySelectorAll('[id^="date_of_birth"]'); // Tous les champs avec id qui commence par 'date_of_birth'
    const dropdowns = document.querySelectorAll('.dynamic-dropdown'); // Tous les champs de type liste déroulante
    const submitButtons = document.querySelectorAll('button[type="submit"]'); // Tous les boutons de type "submit"

    // Fonction pour afficher un message d'erreur sous un champ
    function showError(input, message) {
        let errorElement = input.nextElementSibling;
        if (!errorElement || !errorElement.classList.contains('error-message')) {
            errorElement = document.createElement('div');
            errorElement.className = 'error-message';
            input.parentNode.insertBefore(errorElement, input.nextSibling);
        }
        errorElement.textContent = message;
        input.classList.add('invalid');
    }

    // Fonction pour effacer le message d'erreur d'un champ
    function clearError(input) {
        const errorElement = input.nextElementSibling;
        if (errorElement && errorElement.classList.contains('error-message')) {
            errorElement.remove();
        }
        input.classList.remove('invalid');
    }

    // Validation pour les champs contenant uniquement des chiffres (positifs) et max 9 chiffres
    function validateNumericInput(input) {
        const value = input.value.trim();
        if (!/^\d+$/.test(value)) {
            showError(input, 'Ce champ doit contenir uniquement des chiffres positifs.');
            return false;
        } else if (value.length > 9) {
            showError(input, 'Ce champ ne doit pas dépasser 9 chiffres.');
            return false;
        }
        clearError(input);
        return true;
    }

    // Validation pour la date de naissance
    function validateDateOfBirth(input) {
        const value = input.value.trim();
        const today = new Date();
        const dateOfBirth = new Date(value);
        const minDate = new Date(today.getFullYear() - 50, today.getMonth(), today.getDate());
        const maxDate = new Date(today.getFullYear() - 13, today.getMonth(), today.getDate());

        if (!value) {
            showError(input, 'Veuillez entrer une date de naissance.');
            return false;
        } else if (isNaN(dateOfBirth.getTime())) {
            showError(input, 'Format de date invalide.');
            return false;
        } else if (dateOfBirth < minDate || dateOfBirth > maxDate) {
            showError(input, `La date doit être comprise entre le ${minDate.toLocaleDateString()} et le ${maxDate.toLocaleDateString()} pour une inscription.`);
            return false;
        }
        clearError(input);
        return true;
    }

    // Gestion dynamique des listes déroulantes
    dropdowns.forEach(dropdown => {
        const input = dropdown.querySelector('input'); // Champ de saisie
        const optionsList = dropdown.querySelector('.options'); // Liste des options
        const options = [...optionsList.querySelectorAll('li')]; // Tableau des options

        // Masquer les options par défaut
        optionsList.style.display = 'none';

        // Afficher les options au clic sur le champ de saisie
        input.addEventListener('focus', function () {
            optionsList.style.display = 'block';
        });

        // Masquer les options si l'utilisateur clique ailleurs
        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target)) {
                optionsList.style.display = 'none';
            }
        });

        // Filtrer les options en fonction de la saisie
        input.addEventListener('input', function () {
            const searchTerm = input.value.toLowerCase();
            options.forEach(option => {
                if (option.textContent.toLowerCase().includes(searchTerm)) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        });

        // Gérer la sélection d'une option
        optionsList.addEventListener('click', function (e) {
            if (e.target.tagName === 'LI') {
                input.value = e.target.textContent; // Mettre à jour la valeur de l'input
                optionsList.style.display = 'none'; // Masquer les options après la sélection
            }
        });
    });

    // Ajouter des gestionnaires d'événements pour valider les champs en temps réel
    phoneInputs.forEach(input => {
        input.addEventListener('input', () => validateNumericInput(input));
    });

    amountInputs.forEach(input => {
        input.addEventListener('input', () => validateNumericInput(input));
    });

    dobInputs.forEach(input => {
        input.addEventListener('input', () => validateDateOfBirth(input));
    });

    // Validation avant soumission
    submitButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            const form = button.closest('form'); // Trouver le formulaire parent
            let isValid = true;

            // Valider uniquement les champs à l'intérieur du même formulaire
            const formPhoneInputs = form.querySelectorAll('[id^="phone"]');
            const formAmountInputs = form.querySelectorAll('[id^="amount"]');
            const formDobInputs = form.querySelectorAll('[id^="date_of_birth"]');

            formPhoneInputs.forEach(input => {
                if (!validateNumericInput(input)) {
                    isValid = false;
                }
            });

            formAmountInputs.forEach(input => {
                if (!validateNumericInput(input)) {
                    isValid = false;
                }
            });

            formDobInputs.forEach(input => {
                if (!validateDateOfBirth(input)) {
                    isValid = false;
                }
            });

            // Empêcher l'envoi si un champ est invalide
            if (!isValid) {
                e.preventDefault(); // Bloque l'envoi du formulaire
                alert('Veuillez corriger les erreurs avant de soumettre le formulaire.');
            }
        });
    });

    // Styles pour les messages d'erreur et les listes déroulantes
    const style = document.createElement('style');
    style.textContent = `
        .error-message {
            color: red;
            font-size: 0.85em;
            margin-top: 4px;
        }
        .invalid {
            border-color: red;
        }
        .dynamic-dropdown {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .dynamic-dropdown input {
            width: 100%;
            box-sizing: border-box;
        }
        .options {
            position: absolute;
            background: white;
            border: 1px solid #ccc;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            width: 100%;
            box-sizing: border-box;
            display: none; /* Masquer par défaut */
        }
        .options li {
            padding: 8px;
            cursor: pointer;
            list-style: none;
        }
        .options li:hover {
            background-color: #f0f0f0;
        }
    `;
    document.head.appendChild(style);
});




    </script>
</body>
</html>