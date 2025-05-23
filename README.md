
# 🛠️ Plan de Maintenance – Site Web Laravel

## 🔍 Objectif
Ce document décrit le plan de maintenance technique du site web, afin d'assurer sa stabilité, sécurité, performance et évolutivité dans le temps.

---

## 🗓️ 1. Maintenance Préventive

| Fréquence | Tâches |
|-----------|--------|
| Hebdo     | 🔹 Vérification des erreurs dans les logs (`storage/logs/laravel.log`)  
🔹 Test API (Postman ou tests automatisés)  
🔹 Sauvegarde base de données |
| Mensuelle | 🔹 Mise à jour des dépendances (`composer update`, `npm update`)  
🔹 Audit sécurité (`php artisan security:check`, dépendances, tokens)  
🔹 Vérification des certificats SSL |
| Trimestrielle | 🔹 Revue du code obsolète / nettoyage  
🔹 Tests de charge (performance)  
🔹 Réindexation base de données (si nécessaire) |

---

## 🧪 2. Maintenance Corrective

| Étape        | Détails |
|--------------|---------|
| Détection    | Système de log Laravel + alertes manuelles par les utilisateurs |
| Priorisation | 🔸Critique (downtime, paiement, auth) / 🔹Mineure (UI, texte, etc.) |
| Intervention | Correction via branches Git dédiées (hotfixes) |
| Déploiement  | Test sur environnement local/staging > Merge > Déploiement prod |
| Suivi        | Rédaction d’un changelog dans `/docs/CHANGELOG.md` |

---

## 🔐 3. Maintenance Sécuritaire

| Fréquence | Tâches |
|-----------|--------|
| Hebdo     | 🔹 Vérification tokens expirés  
🔹 Vérification activité suspecte |
| Mensuelle | 🔹 Mise à jour Laravel + dépendances de sécurité  
🔹 Analyse vulnérabilités (`npm audit`, `composer audit`) |
| À l’événement | 🔹 Révocation et renouvellement de clés API / Tokens si suspicion |

---

## 🗃️ 4. Sauvegardes

| Type             | Fréquence   | Emplacement                      |
|------------------|-------------|----------------------------------|
| Base de données  | Quotidienne | Stockée sur S3 ou serveur externe |
| Fichiers (images, uploads) | Hebdomadaire | Stockage cloud ou FTP sécurisé |
| Code (Git)       | À chaque push | GitHub / GitLab (`main`, `dev`) |

---

## 🔄 5. Maintenance Évolutive

| Type                | Détail |
|---------------------|--------|
| Nouvelles fonctionnalités | Ajout par sprint (GitHub Projects, Trello, Notion…) |
| Refactoring         | Optimisation du code Laravel (Controllers, Models, Repositories) |
| Amélioration UI/UX  | Application des retours utilisateurs (front, API REST) |

---

## ⚠️ 6. Procédure en cas de panne

1. Identifier la panne via logs ou alertes
2. Notifier l’équipe (Slack/Discord/email)
3. Activer la page maintenance (`503.blade.php`)
4. Corriger sur env. local → staging → prod
5. Documenter la panne (`/docs/incidents.md`)

---

## 📁 Dossiers utiles

- `storage/logs/` → logs Laravel
- `docs/` → changelogs, incidents, notices techniques
- `.env` → fichier de configuration sensible
- `database/backups/` → backups BDD (automatisés)

---

## ✅ Outils recommandés

- Laravel Telescope ou LogViewer (logs)
- GitHub Actions / Forge / Envoyer (déploiement)
- Postman (tests API)
- Mailtrap (tests d'emails)
- Sentry ou Bugsnag (tracking d’erreurs)

---

🗂️ Dernière mise à jour : 23/05/2025
