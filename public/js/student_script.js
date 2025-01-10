document.getElementById("download-pdf").addEventListener("click", function () {
    const frontCard = document.querySelector(".carde-front");
    const backCard = document.querySelector(".carde-back");

    if (!frontCard || !backCard) {
        console.error("Les éléments de la carte sont introuvables !");
        return;
    }

    const pdf = new jspdf.jsPDF();

    // Capture de la face avant
    html2canvas(frontCard).then(canvas => {
        const imgData = canvas.toDataURL("image/png");
        pdf.addImage(imgData, "PNG", 10, 10, 190, 90);

        // Supprimer temporairement la rotation de la face arrière
        backCard.style.transform = "none";

        // Capture de la face arrière
        html2canvas(backCard).then(canvasBack => {
            const imgDataBack = canvasBack.toDataURL("image/png");
            pdf.addPage();
            pdf.addImage(imgDataBack, "PNG", 10, 10, 190, 90);

            // Réappliquer la rotation pour garder l'effet visuel
            backCard.style.transform = "rotateY(180deg)";

            // Téléchargement du fichier PDF
            pdf.save("carte_etudiant.pdf");
        }).catch(err => {
            console.error("Erreur lors de la capture de la face arrière :", err);

            // Réappliquer la rotation même en cas d'erreur
            backCard.style.transform = "rotateY(180deg)";
        });
    }).catch(err => {
        console.error("Erreur lors de la capture de la face avant :", err);
    });
});