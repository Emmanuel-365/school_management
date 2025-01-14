<?php

namespace App\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\GuzzleException;



class ChatbotGemini {
    private $apiKey;
    private $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';
    private $conversation = [];

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
        // Initialiser la conversation avec un message système
        $this->addToConversation('user', "Tu es un assistant pédagogique spécialisé dans l'orientation et le conseil aux étudiants. Tu dois fournir des conseils personnalisés basés sur les performances académiques des étudiants.");
    }

    private function addToConversation($role, $text) {
        $this->conversation[] = [
            "role" => $role,
            "parts" => [[
                "text" => $text
            ]]
        ];
    }

    public function getResponse($message, $studentData, $disableSSL = true) {
        try {
            // Ajouter le contexte de l'étudiant et la question à la conversation
            $contextMessage = $this->buildContextMessage($studentData);
            $this->addToConversation('user', $contextMessage . "\n\nQuestion: " . $message);
    
            // Configuration du client Guzzle
            $clientOptions = [
                'timeout' => 30,
                'http_errors' => false,
            ];
    
            // Désactiver la vérification SSL si demandé
            if ($disableSSL) {
                $clientOptions['verify'] = false;
            }
    
            $client = new Client($clientOptions);
    
            $response = $client->post($this->apiUrl . '?key=' . $this->apiKey, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'contents' => $this->conversation,
                ],
            ]);
    
            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();
    
            // Log de la réponse brute pour le débogage
            error_log("Réponse brute de Gemini: " . $responseBody);
    
            if ($statusCode !== 200) {
                throw new \Exception("Erreur API: Code $statusCode, Réponse: $responseBody");
            }
    
            // Tentative de décodage JSON
            $body = json_decode($responseBody, true);
    
            if (json_last_error() !== JSON_ERROR_NONE) {
                error_log("Erreur de décodage JSON: " . json_last_error_msg());
    
                if (!empty($responseBody)) {
                    // Extraction du texte si la réponse n'est pas du JSON valide
                    if (preg_match('/"text"\s*:\s*"([^"]+)"/', $responseBody, $matches)) {
                        $responseText = $matches[1];
                    } else {
                        // Si aucun pattern trouvé, on utilise la réponse brute
                        $responseText = strip_tags($responseBody);
                    }
                } else {
                    throw new \Exception("Réponse vide ou non valide de l'API");
                }
            } else {
                // Si c'est du JSON valide, on extrait le texte normalement
                $responseText = $body['candidates'][0]['content']['parts'][0]['text'] ?? null;
                file_put_contents('test.txt', $responseText);
                if ($responseText === null) {
                    throw new \Exception("Format de réponse inattendu ou contenu manquant dans la réponse JSON");
                }
            }
    
            // Nettoyer la réponse
            $responseText = $this->cleanResponse($responseText);

            // Ajouter la réponse à la conversation
            $this->addToConversation('model', $responseText);
    
            // Limiter la taille de l'historique de conversation
            if (count($this->conversation) > 10) {
                array_splice($this->conversation, 1, count($this->conversation) - 5);
            }
    
            return $responseText;
    
        } catch (\Exception $e) {
            error_log('Exception ChatbotGemini: ' . $e->getMessage());
            throw new \Exception("Erreur lors de la communication avec l'assistant: " . $e->getMessage());
        }
    }
    

    private function cleanResponse($text) {
        // Supprimer les caractères de contrôle et les balises HTML
        $text = strip_tags($text);
        $text = preg_replace('/[\x00-\x1F\x7F]/u', '', $text);
        
        // Supprimer les caractères d'échappement JSON
        $text = str_replace(['\\n', '\\r', '\\t'], ["\n", "\r", "\t"], $text);
        
        // Supprimer les guillemets au début et à la fin si présents
        $text = trim($text, '"');
        
        // Convertir les entités HTML
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        return trim($text);
    }

    private function buildContextMessage($studentData) {
        $context = "Contexte de l'étudiant:\n";
        $context .= "Nom: {$studentData['name']}\n";
        $context .= "Niveau: {$studentData['level']}\n";
        $context .= "Notes:\n";

        foreach ($studentData['grades'] as $grade) {
            $context .= "- {$grade['subject']}: {$grade['grade']}\n";
        }

        return $context;
    }

    public function resetConversation() {
        $this->conversation = [];
        $this->addToConversation('user', "Tu es un assistant pédagogique spécialisé dans l'orientation et le conseil aux étudiants. Tu dois fournir des conseils personnalisés basés sur les performances académiques des étudiants.");
    }
}