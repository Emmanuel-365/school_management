<?php

require_once 'vendor/autoload.php';

use setasign\SetaPDF\Signer\Module\Pkcs12File;
use setasign\SetaPDF\Signer\Signer;
use setasign\SetaPDF\Signer\Module\OpenSsl;

// Chemin vers les fichiers
$pdfFile = 'mon_document.pdf';  // PDF d'origine
$signedPdfFile = 'document_signe.pdf';  // PDF final signé
$certificateFile = 'mon_certificat.pfx';  // Certificat numérique (format PKCS#12)
$certificatePassword = 'mon_mot_de_passe';  // Mot de passe du certificat

// Charger le fichier PDF
$writer = new \SetaPDF_Core_Writer_File($signedPdfFile);
$document = \SetaPDF_Core_Document::loadByFilename($pdfFile, $writer);

// Configurer le module de signature avec le certificat
$module = new Pkcs12File($certificateFile, $certificatePassword);

// Instancier le signataire
$signer = new Signer($document);
$signer->sign($module);

echo "Le document a été signé et sauvegardé sous : $signedPdfFile";
