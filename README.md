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
- Consulter ses inscriptions sur `/profil`
- Modifier ses informations personnelles

### Administrateur `ROLE_ADMIN`

- Accéder au back-office `/admin`
- Créer, modifier, publier/dépublier, supprimer des événements (CRUD complet)
- Voir la liste des participants inscrits à un événement

---

## 🛠️ Stack technique

| Technologie         | Version   |
| ------------------- | --------- |
| PHP                 | 8.2+      |
| Symfony             | 7.x (LTS) |
| Doctrine ORM        | 3.x       |
| PostgreSQL ou MySQL | 15+ / 8.x |
| Bootstrap           | 5.3       |
| Twig                | 3.x       |

---

## ⚙️ Installation en local

### Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- **PHP 8.2+** — [https://www.php.net/downloads](https://www.php.net/downloads)
- **Composer** — [https://getcomposer.org](https://getcomposer.org)
- **MySQL** (via WAMP/XAMPP/Workbench) **ou PostgreSQL** — selon votre configuration
- **Symfony CLI** _(optionnel mais recommandé)_ — [https://symfony.com/download](https://symfony.com/download)
- **Git** — [https://git-scm.com](https://git-scm.com)

Vérifiez vos versions :

```bash
php -v
composer -V
symfony -V  # si Symfony CLI installé
```

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

> ⚠️ Si vous avez une erreur PHP version, vérifiez que PHP 8.2+ est bien utilisé : `php -v`

---

### 3. Configurer l'environnement

**Sur Mac/Linux :**

```bash
cp .env .env.local
```

**Sur Windows (CMD) :**

```cmd
copy .env .env.local
```

Ouvrez `.env.local` et modifiez la ligne `DATABASE_URL` selon votre base de données :

**PostgreSQL :**

```env
DATABASE_URL="postgresql://USER:PASSWORD@127.0.0.1:5432/securvent?serverVersion=15&charset=utf8"
```

**MySQL / MariaDB (Workbench, WAMP, XAMPP) :**

```env
DATABASE_URL="mysql://USER:PASSWORD@127.0.0.1:3306/securvent?serverVersion=8.0&charset=utf8mb4"
```

Remplacez `USER` et `PASSWORD` par vos identifiants.  
Par défaut sur WAMP/XAMPP : `USER=root`, `PASSWORD=` _(vide)_.

> ⚠️ **Ne committez jamais `.env.local`** — il contient vos secrets. Vérifiez que `.gitignore` l'exclut bien.

---

### 4. Activer l'extension PHP pour la base de données

Ouvrez votre fichier `php.ini` (chemin affiché par `php --ini`) et décommentez la ligne correspondante en retirant le `;` :

**Pour PostgreSQL :**

```ini
;extension=pdo_pgsql  →  extension=pdo_pgsql
;extension=pgsql      →  extension=pgsql
```

**Pour MySQL :**

```ini
;extension=pdo_mysql  →  extension=pdo_mysql
```

Redémarrez ensuite votre serveur PHP/WAMP/XAMPP.

Vérifiez que l'extension est active :

```bash
php -m | grep pdo
```

---

### 5. Créer la base de données

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

---

### 6. Charger les fixtures _(comptes de test + événements)_

Installez le bundle si ce n'est pas déjà fait :

```bash
composer require doctrine/doctrine-fixtures-bundle --dev
```

Puis chargez les données :

```bash
php bin/console doctrine:fixtures:load
```

Comptes créés par défaut :

| Rôle           | Email            | Mot de passe |
| -------------- | ---------------- | ------------ |
| Administrateur | `admin@test.com` | `Admin1234!` |
| Utilisateur    | `user1@test.com` | `User1234!`  |
| Utilisateur    | `user2@test.com` | `User1234!`  |

Les fixtures chargent également **50 événements** de démonstration (CTF, workshops, conférences, formations).

---

### 7. Lancer le serveur

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
- `.env.local` exclu du dépôt via `.gitignore`

---

## 🌐 API REST

Un endpoint public expose les événements à venir au format JSON :

```
GET /api/events
```

Retourne uniquement les événements publiés (`isPublished = true`) avec une date future. Les données sensibles (emails des participants) sont exclues via les groupes de sérialisation Symfony.

**Exemple de réponse :**

```json
[
    {
        "id": 1,
        "titre": "CTF Web Security Challenge",
        "description": "Capture The Flag orienté sécurité web...",
        "dateDebut": "2026-04-01T10:00:00+02:00",
        "capaciteMax": 50,
        "lieu": "Salle A — Campus Cyber, Paris"
    }
]
```

---

## 📁 Structure du projet

```
src/
├── Controller/
│   ├── Admin/              # Back-office (ROLE_ADMIN)
│   │   ├── DashboardController.php
│   │   └── EventController.php
│   ├── Front/              # Pages publiques & espace utilisateur
│   │   ├── HomeController.php
│   │   ├── EventController.php
│   │   └── ProfilController.php
│   └── Api/                # Endpoints REST
│       └── EventController.php
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
└── DataFixtures/
    ├── UserFixtures.php
    └── EventFixtures.php
templates/
├── admin/                  # Templates back-office
│   └── event/
│       ├── index.html.twig
│       ├── show.html.twig
│       ├── new.html.twig
│       ├── edit.html.twig
│       └── participants.html.twig
├── front/
│   ├── home/
│   │   └── index.html.twig
│   └── profil/
│       └── index.html.twig
├── security/
│   ├── login.html.twig
│   └── register.html.twig
└── base.html.twig
public/
└── css/
    ├── style.css           # Styles globaux (variables, navbar, hero, tables)
    └── admin-dashboard.css # Styles spécifiques au back-office
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
- La synchronisation Git entre branches a posé quelques problèmes de tracking (`--set-upstream`) et de conflits de merge.
- L'activation du driver PostgreSQL (`pdo_pgsql`) dans `php.ini` était requise et non documentée initialement.
- Les variables CSS personnalisées du `style.css` devaient être chargées avant `admin-dashboard.css` pour éviter des conflits de surcharge Bootstrap.

### Ce qui aurait pu être amélioré

- Mettre en place les entités et les noms de propriétés définitivement dès le début pour éviter les migrations correctives.
- Créer un template Twig partiel `_sidebar.html.twig` pour éviter la répétition de la sidebar dans chaque template admin.
- Ajouter des tests unitaires sur le repository et les contraintes de validation.
- Exclure `.env` du dépôt dès le début du projet.

### Ce qu'on aurait aimé ajouter

- Module de réinitialisation de mot de passe (email)
- Connexion OAuth via Google ou GitHub
- Internationalisation FR/EN
- Filtres par catégorie sur le catalogue d'événements
- Module de cartographie pour afficher l'itinéraire vers le lieu de l'événement
- Notifications par email lors d'une inscription à un événement

---

## 👥 Auteurs

Projet réalisé dans le cadre d'une évaluation Symfony — ESDI
