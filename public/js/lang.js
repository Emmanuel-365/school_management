document.addEventListener("DOMContentLoaded", () => {
  const defaultLang = localStorage.getItem("language") || "en";
  setLanguage(defaultLang);

  const languageSelect = document.getElementById("language-select");
  const selectedFlag = document.getElementById("selected-flag");

  // Mettre à jour l'image du drapeau par défaut
  updateFlag(defaultLang);

  languageSelect.value = defaultLang;

  // Gérer les changements dans la liste déroulante
  languageSelect.addEventListener("change", (e) => {
    const selectedLang = e.target.value;
    setLanguage(selectedLang);
    updateFlag(selectedLang);
  });

  // Gestion du menu utilisateur
  const userInfo = document.querySelector(".user-info");
  if (userInfo) {
    userInfo.addEventListener("click", () => {
      userInfo.classList.toggle("active");
    });

    document.addEventListener("click", (e) => {
      if (!userInfo.contains(e.target)) {
        userInfo.classList.remove("active");
      }
    });
  }
});

function setLanguage(lang) {
  localStorage.setItem("language", lang);

  // Charger le fichier JSON correspondant
  fetch(`/translations/${lang}.json`)
    .then((response) => response.json())
    .then((translations) => {
      document.querySelectorAll("[data-translate]").forEach((element) => {
        const key = element.getAttribute("data-translate");
        if (translations[key]) {
          element.textContent = translations[key];
        }
      });

      document
        .querySelectorAll("[data-translate-placeholder]")
        .forEach((element) => {
          const key = element.getAttribute("data-translate-placeholder");
          if (translations[key]) {
            element.placeholder = translations[key];
          }
        });
    })
    .catch((error) => console.error("Error loading translations:", error));
}

function updateFlag(lang) {
  const languageSelect = document.getElementById("language-select");
  const selectedOption = languageSelect.querySelector(
    `option[value="${lang}"]`
  );
  const flagSrc = selectedOption.getAttribute("data-flag");
  const flagAlt = selectedOption.textContent.trim();

  // Mettre à jour le conteneur du drapeau
  const flagContainer = document.querySelector(".flag-container img");
  if (flagContainer) {
    flagContainer.src = flagSrc;
    flagContainer.alt = flagAlt;
  } else {
    const newFlagContainer = document.createElement("img");
    newFlagContainer.src = flagSrc;
    newFlagContainer.alt = flagAlt;
    newFlagContainer.id = "selected-flag";
    document.querySelector(".flag-container").appendChild(newFlagContainer);
  }
}