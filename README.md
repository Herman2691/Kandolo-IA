# KANDOLO AI — Plateforme d'Intelligence Artificielle Personnelle

> Interface de chat IA avancée, mono-fichier, fonctionnant entièrement dans le navigateur.  
> Design multi-thème · Rendu Markdown complet · Dictée vocale · 20 modèles Mistral AI.

---

## Aperçu

KANDOLO AI est une application web **single-page** (un seul fichier `index.html`) qui connecte l'utilisateur aux modèles **Mistral AI** via leur API officielle. Toutes les données (conversations, agents, mémoire) sont stockées **localement dans le navigateur** — aucun serveur, aucun backend requis.

---

## Fonctionnalités principales

### Modèles disponibles (20)

| Catégorie | Modèles |
|---|---|
| **Frontier** | Mistral Omega (Large 2512), Mistral Zenith (Medium 2508) |
| **Code** | CodeForge (Codestral 2508) |
| **Dev full-stack** | DevMind Ultra (Devstral 2512), DevPulse Medium, DevSpark Lite |
| **Raisonnement** | MagiCore (Magistral Medium), MagiSwift (Magistral Small) |
| **Performance** | MiniTitan 14B, MicroGenius 8B, NanoMind 3B |
| **Contexte long** | Mistral Equinox (375k tokens), Mistral Nova (375k tokens) |
| **Flash / Économique** | Mistral Flash, CreatiFlow |
| **Open Source** | Nemo OpenCore |
| **Vision** | Pixtral 12B, Pixtral Large (analyse d'images) |
| **Audio** | Voxtral Echo, Voxtral Sonic (transcription) |

---

### Trois thèmes visuels

| Thème | Description |
|---|---|
| **◈ CYBER** (défaut) | Fond noir profond, grille cyan, accents terracotta `#da7756` |
| **◈ MIDNIGHT** | Fond brun sombre chaleureux, coral `#e08a63`, atmosphère nocturne |
| **◈ LIGHT** | Surfaces neutres claires, accents coral `#c8603c`, inspiré shadcn/ui |

Le thème est persisté dans IndexedDB et synchronisé entre desktop et mobile.

---

### Rendu Markdown complet
Les réponses de l'assistant sont rendues en **Markdown riche** via **marked.js** (GFM activé) et assainies par **DOMPurify**. Éléments supportés : titres H1–H4, paragraphes, listes ordonnées/non-ordonnées, blocs de code avec coloration, tableaux, citations, liens, gras/italique, séparateurs.

---

### Dictée vocale
Un bouton microphone (`🎤`) dans la zone de saisie permet de dicter un message à voix haute. L'état d'enregistrement actif est indiqué visuellement (bordure rouge).

---

### Pièces jointes
Le bouton `📎` permet de joindre :
- **Images** → transmises aux modèles Pixtral Vision
- **Fichiers audio** → transmis aux modèles Voxtral
- **PDF** → transmis en contexte

---

### Système d'agents
- Création d'agents personnalisés (nom, rôle, instructions, style, contexte initial)
- Styles de réponse : concis · détaillé · formel · créatif · pédagogique
- Règles d'interdiction par agent
- Priorité mémoire configurable par agent (1 à 5)
- Édition et suppression des agents existants

---

### Mémoire globale
- Souvenirs persistants entre les conversations
- Injection automatique des souvenirs pertinents dans le contexte
- Scoring de pertinence par mots-clés et tags
- Ajout manuel ou depuis n'importe quel message (`⬡ MÉMO`)

---

### Gestion des conversations
- Historique complet via **IndexedDB** (avec repli automatique sur `localStorage`)
- Archives avec recherche plein-texte
- Marquage en favoris (★)
- Titrage automatique des chats
- Indicateur de remplissage du contexte en temps réel (%)
- Bouton de défilement rapide vers le bas

---

### Import / Export de données
- Export JSON complet (conversations + agents + mémoire)
- Import avec aperçu avant restauration (drag & drop ou sélection)
- Suppression totale des données locales

---

### Interface
- Mode mobile avec menu burger (4 rangées d'actions)
- Notation des réponses (1 à 5 étoiles)
- Copie d'un message en un clic
- Export PDF via impression navigateur
- Notifications toast non-intrusives

---

## Installation

Aucune installation requise. Ouvrez simplement `index.html` dans un navigateur moderne.

```bash
# Option 1 — ouverture directe
open index.html

# Option 2 — serveur local (recommandé, évite les restrictions CORS)
python3 -m http.server 8080
# puis ouvrir http://localhost:8080
```

> **Note navigation privée / `file://`** : si IndexedDB est indisponible, l'application bascule automatiquement sur `localStorage` (clé `kandolo_store`) avec un timeout de sécurité à 2,5 secondes — aucune perte de données, aucun blocage.

---

## Configuration de la clé API

1. Ouvrez l'application.
2. Cliquez sur **`⬡ API KEY`** dans la barre supérieure.
3. Entrez votre clé API Mistral AI (disponible sur [console.mistral.ai](https://console.mistral.ai)).
4. Cliquez sur **`ENREGISTRER ET ACTIVER`**.

La clé est stockée en cookie (365 jours) avec un fallback `localStorage`. Elle ne quitte jamais votre navigateur.

> **Mode hébergé** : la version déployée sur serveur masque automatiquement l'UI de gestion de clé API — celle-ci est alors injectée côté serveur.

---

## Architecture

```
index.html (fichier unique ~4 000 lignes)
├── CSS
│   ├── Design System KANDOLO (variables, animations, grille)
│   ├── Theme: cyber (dark default)
│   ├── Theme: light  (shadcn/ui × coral)
│   └── Theme: midnight (dark warm)
├── HTML
│   ├── Header (modèle, agent, thème, statut API)
│   ├── Zone de chat
│   ├── Zone de saisie (voix, pièce jointe, textarea, envoi)
│   ├── Panneaux flottants (archives, mémoire)
│   └── Modals (API key, agents, données, wizard)
└── JavaScript (vanilla, sans framework)
    ├── MODELS[]              — 20 modèles Mistral avec métadonnées
    ├── state{}               — État applicatif en mémoire
    ├── db                    — IndexedDB + fallback localStorage
    ├── memory                — Mémoire globale avec scoring de pertinence
    ├── renderMsgContent()    — Markdown via marked.js + DOMPurify
    ├── buildSystemPrompt()   — Assemblage du prompt (agent + mémoire)
    ├── sendMessage()         — Appel API Mistral (streaming SSE)
    └── UI handlers           — Thèmes, voix, modals, archives, mobile
```

---

## Dépendances CDN

| Bibliothèque | Version | Rôle |
|---|---|---|
| Bootstrap | 5.3.3 | Grille et utilitaires CSS |
| marked | 12.0.2 | Rendu Markdown → HTML |
| DOMPurify | 3.1.6 | Sanitisation HTML (anti-XSS) |
| Google Fonts | — | Inter · JetBrains Mono |

---

## Stockage local

| Store IndexedDB | Contenu |
|---|---|
| `chats` | Conversations (messages, titre, date) |
| `agents` | Agents personnalisés |
| `settings` | Modèle actif, thème |
| `global_memory` | Souvenirs persistants |

---

## Sécurité

- Toutes les données restent **localement dans le navigateur**.
- La clé API n'est transmise qu'à `api.mistral.ai`, jamais à un tiers.
- Les réponses HTML sont systématiquement **assainies par DOMPurify**.
- Aucune télémétrie, aucun tracking.

---

## Compatibilité

| Environnement | Support |
|---|---|
| Chrome / Edge 90+ | ✅ Complet |
| Firefox 88+ | ✅ Complet |
| Safari 15+ | ✅ Complet |
| Navigation privée | ✅ Via fallback localStorage |
| Mobile iOS / Android | ✅ Interface adaptée, burger menu |
| Ouverture `file://` | ✅ Via fallback localStorage |

---

## Crédits

- Design : KANDOLO Design System — couleur signature terracotta `#da7756`
- IA : [Mistral AI](https://mistral.ai) (API officielle)
- Version interne : *KANDOLO AI Platform v3.0*
