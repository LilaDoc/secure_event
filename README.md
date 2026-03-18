# 🔐 SecurEvent

Plateforme web de gestion et de réservation de conférences, CTF _(Capture The Flag)_ et workshops autour de la **cybersécurité**.

Développée avec **Symfony 7 (LTS)**, elle suit les principes de _Security by Design_ : protection CSRF, hachage Argon2id, contrôle d'accès strict par rôles, protection contre les injections SQL via Doctrine ORM.

---

## 📋 Fonctionnalités

### Visiteur (non authentifié)

- Consulter la page d'accueil et le catalogue des événements à venir
- Voir la fiche détaillée d'un événement
- Créer un compte

### Participant `ROLE_USER`

- Se connecter à son espace personnel
- S'inscrire à un événement (si des places sont disponibles)
- Consulter ses inscriptions sur `/profile/mes-evenements`
- Modifier ses informations personnelles

### Administrateur `ROLE_ADMIN`

- Accéder au back-office `/admin`
- Créer, modifier, publier/dépublier, supprimer des événements (CRUD complet)
- Voir la liste des participants inscrits à un événement

---

## 🛠️ Stack technique

| Technologie     | Version   |
| --------------- | --------- |
| PHP             | 8.2+      |
| Symfony         | 7.x (LTS) |
| Doctrine ORM    | 3.x       |
| MySQL / MariaDB | 8.x       |
| Bootstrap       | 5.3       |
| Twig            | 3.x       |

---

## ⚙️ Installation en local

### Prérequis

- PHP 8.2+
- Composer
- MySQL / MariaDB
- Symfony CLI _(optionnel mais recommandé)_

---

### 1. Cloner le dépôt

```bash
git clone https://github.com/LilaDoc/secure_event.git
cd secure_event
```

---

### 2. Installer les dépendances

```bash
composer install
```

---

### 3. Configurer l'environnement

Copie le fichier d'exemple et édite-le :

```bash
cp .env .env.local
```

Modifie la ligne `DATABASE_URL` dans `.env.local` :

```env
DATABASE_URL="mysql://USER:PASSWORD@127.0.0.1:3306/securvent?serverVersion=8.0"
```

Remplace `USER` et `PASSWORD` par tes identifiants MySQL.

---

### 4. Créer la base de données

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

---

### 5. Charger les fixtures _(compte admin + données de test)_

```bash
php bin/console doctrine:fixtures:load
```

Compte administrateur créé par défaut :

| Champ        | Valeur               |
| ------------ | -------------------- |
| Email        | `admin@securvent.fr` |
| Mot de passe | `Admin1234!`         |

---

### 6. Lancer le serveur

Avec la Symfony CLI :

```bash
symfony server:start
```

Ou avec PHP natif :

```bash
php -S localhost:8000 -t public/
```

L'application est accessible sur [http://localhost:8000](http://localhost:8000)

---

## 🔒 Sécurité

- Mots de passe hachés avec **Argon2id** (algorithme par défaut de Symfony)
- **Login throttling** — blocage après 3 tentatives échouées (1 minute)
- **Tokens CSRF** sur tous les formulaires et actions de suppression
- Contrôle d'accès via `#[IsGranted('ROLE_ADMIN')]` sur toutes les routes `/admin`
- Requêtes **100% via Doctrine ORM** — aucune requête SQL concaténée
- Auto-échappement Twig actif — protection XSS native

---

## 🌐 API REST

Un endpoint public expose les événements à venir au format JSON :

```
GET /api/events
```

Retourne uniquement les événements publiés (`isPublished = true`) avec une date future. Les données sensibles (emails des participants) sont exclues via les groupes de sérialisation Symfony.

---

## 📁 Structure du projet

```
src/
├── Controller/
│   ├── Admin/          # Back-office (ROLE_ADMIN)
│   ├── Front/          # Pages publiques
│   └── Api/            # Endpoints REST
├── Entity/
│   ├── User.php
│   ├── Event.php
│   └── Reservation.php
├── Form/
│   ├── EventFormType.php
│   └── RegistrationFormType.php
├── Repository/
│   ├── EventRepository.php
│   └── UserRepository.php
templates/
├── admin/              # Templates back-office
├── event/              # Templates événements
├── security/           # Login / Register
└── base.html.twig
public/
└── css/
    └── admin-dashboard.css
```

---

## 📝 PostMortem

### Ce qui s'est bien passé

- La mise en place du système de rôles et des restrictions d'accès avec Symfony Security a été rapide et claire grâce aux attributs PHP `#[IsGranted]`.
- Le formulaire de création d'événements avec validation côté serveur (contraintes Symfony) fonctionne bien et couvre tous les cas d'erreur.
- L'utilisation de Doctrine ORM et du QueryBuilder a permis d'éviter toute injection SQL sans effort particulier.

### Difficultés rencontrées

- La gestion des routes Symfony avec des paramètres dynamiques (`{id}`) a causé des conflits avec les routes nommées (`/event/new` vs `/event/{id}`), résolus en ajoutant `requirements: ['id' => '\d+']`.
- Le renommage de propriétés dans l'entité (`place` → `lieu`, `nom` → `titre`) en cours de développement a nécessité des migrations et des mises à jour dans tous les templates Twig.
- La synchronisation Git entre branches a posé quelques problèmes de tracking (`--set-upstream`).

### Ce qui aurait pu être amélioré

- Mettre en place les entités et les noms de propriétés définitivement dès le début pour éviter les migrations correctives.
- Créer un template Twig partiel `_sidebar.html.twig` pour éviter la répétition de la sidebar dans chaque template admin.
- Ajouter des tests unitaires sur le repository et les contraintes de validation.

### Ce qu'on aurait aimé ajouter

- Module de réinitialisation de mot de passe (email)
- Connexion OAuth via Google ou GitHub
- Internationalisation FR/EN
- Filtres par catégorie sur le catalogue d'événements
- Module de cartographie pour afficher l'itinéraire vers le lieu de l'événement

---

## 👥 Auteurs

Projet réalisé dans le cadre d'une évaluation Symfony — ESDI
