document.addEventListener("DOMContentLoaded", () => {
    const defaultLang = localStorage.getItem("language") || "en";
    setLanguage(defaultLang);
  
    // Gérer les changements dans la liste déroulante
    const languageSelect = document.getElementById("language-select");
    languageSelect.value = defaultLang; // Sélectionne la langue enregistrée
    languageSelect.addEventListener("change", (e) => {
      const selectedLang = e.target.value;
      setLanguage(selectedLang);
    });
  });
  
  function setLanguage(lang) {
    // Stocker la langue choisie dans le localStorage
    localStorage.setItem("language", lang);
  
    // Charger le fichier JSON correspondant
    fetch(`translations/${lang}.json`)
      .then(response => response.json())
      .then(translations => {
        // Appliquer les traductions aux éléments ayant l'attribut data-translate
        document.querySelectorAll("[data-translate]").forEach(element => {
          const key = element.getAttribute("data-translate");
          if (translations[key]) {
            element.textContent = translations[key];
          }
        });
  
        // Appliquer les traductions pour les placeholders
        document.querySelectorAll("[data-translate-placeholder]").forEach(element => {
          const key = element.getAttribute("data-translate-placeholder");
          if (translations[key]) {
            element.placeholder = translations[key];
          }
        });
      })
      .catch(error => console.error("Error loading translations:", error));
  }

  // Gérer le menu déroulant utilisateur
  const userInfo = document.querySelector(".user-info");
  userInfo.addEventListener("click", () => {
    userInfo.classList.toggle("active");
  });

  // Fermer le menu déroulant utilisateur en cliquant à l'extérieur
  document.addEventListener("click", (e) => {
    if (!userInfo.contains(e.target)) {
      userInfo.classList.remove("active");
    }
  });