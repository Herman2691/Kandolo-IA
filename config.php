<?php
/* ============================================================
   KANDOLO AI — CONFIGURATION PRIVÉE (SERVEUR UNIQUEMENT)
   ------------------------------------------------------------
   Ce fichier n'est JAMAIS envoyé au navigateur : il est lu côté
   serveur par api/chat.php. Le client ne voit donc jamais la clé.
   Le .htaccess bloque aussi son accès direct par HTTP.

   ⚙️  À FAIRE APRÈS L'UPLOAD SUR HOSTINGER :
   1. Remplace COLLE_TA_CLE_MISTRAL_ICI par ta vraie clé Mistral.
   2. Ajuste les limites de tokens selon ton budget.
   3. Vérifie que le dossier /data est inscriptible (chmod 755 ou 775).
   ============================================================ */

// 🔑 Ta clé API Mistral (https://console.mistral.ai → API Keys)
define('MISTRAL_API_KEY', '12KNMk7awqMccaVqbPEC5B5HUlPVYKBL');

// Plafond de tokens PAR REQUÊTE (taille max d'une réponse).
// La génération automatique des 20 agents a besoin d'environ 8000.
define('MAX_TOKENS_PER_REQUEST', 8000);

// Quota QUOTIDIEN de tokens PAR CLIENT (identifié par adresse IP).
// Remis à zéro chaque jour (UTC). Ajuste selon ce que tu veux payer.
define('DAILY_TOKEN_LIMIT', 50000);

// Nombre max de requêtes par minute par client (anti-martèlement).
define('RATE_LIMIT_PER_MINUTE', 20);

// Emplacement de la base SQLite qui compte la consommation.
// Doit être inscriptible par le serveur. Protégé par data/.htaccess.
define('DB_PATH', __DIR__ . '/data/usage.sqlite');

// Endpoint Mistral (ne pas changer sauf raison précise).
define('MISTRAL_ENDPOINT', 'https://api.mistral.ai/v1/chat/completions');
