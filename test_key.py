import requests
import time
import base64
import hmac
import hashlib

# Remplacez ces valeurs par vos clés Gemini
API_KEY = "votre_cle_api"
API_SECRET = "votre_cle_secret"

# URL de l'API Gemini
API_URL = "https://api.gemini.com"
ENDPOINT = "/v1/account"

def test_gemini_api():
    try:
        # Préparer la charge utile
        payload = {
            "request": ENDPOINT,
            "nonce": int(time.time() * 1000)
        }

        # Encoder la charge utile en base64
        encoded_payload = base64.b64encode(json.dumps(payload).encode())

        # Générer la signature HMAC-SHA384
        signature = hmac.new(API_SECRET.encode(), encoded_payload, hashlib.sha384).hexdigest()

        # Préparer les en-têtes
        headers = {
            "Content-Type": "text/plain",
            "X-GEMINI-APIKEY": API_KEY,
            "X-GEMINI-PAYLOAD": encoded_payload.decode(),
            "X-GEMINI-SIGNATURE": signature
        }

        # Envoyer une requête POST
        response = requests.post(API_URL + ENDPOINT, headers=headers)

        # Vérifier la réponse
        if response.status_code == 200:
            print("La clé API est valide.")
            print("Réponse :", response.json())
        else:
            print(f"Échec : {response.status_code} - {response.json()}")

    except Exception as e:
        print("Une erreur s'est produite :", str(e))

# Tester la clé API
test_gemini_api()
