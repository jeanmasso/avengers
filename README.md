# 📚 Avengers Symfony - Projet LP MIAW

Application web développée avec **Symfony 6.4** dans le cadre de la Licence Professionnelle MIAW.

## 📋 Description

Application de gestion de contenus comprenant :
- 📖 **Livres** : CRUD complet avec recherche et statistiques
- 🔖 **Marque-pages** : Gestion avec tags multiples
- ✍️ **Auteurs** : Base de données d'auteurs
- 🌿 **Faune & Flore** : Catalogue illustré (Le Cailloux)
- 👤 **Employés** : Formulaire avec adresse imbriquée

## 🛠️ Technologies utilisées

- **Framework** : Symfony 6.4
- **Base de données** : PostgreSQL 16
- **ORM** : Doctrine 3.x
- **Template Engine** : Twig
- **Frontend** : Bootstrap 5.3.3 + Stimulus
- **I18n** : Support français/anglais
- **PHP** : 8.2+

## 📦 Prérequis

Avant d'installer le projet, assurez-vous d'avoir :

- PHP 8.2 ou supérieur
- Composer
- PostgreSQL 16
- Symfony CLI (optionnel mais recommandé)
- Git

### Vérifier les versions

```bash
php -v
composer --version
psql --version
symfony check:requirements
```

## 🚀 Installation

### 1. Cloner le projet

```bash
git clone https://github.com/VOTRE_USERNAME/avengers_masso-jean.git
cd avengers_masso-jean
```

### 2. Installer les dépendances

```bash
composer install
```

### 3. Configurer la base de données

Créez un fichier `.env.local` à la racine du projet :

```bash
cp .env .env.local
```

Modifiez la ligne `DATABASE_URL` dans `.env.local` :

```env
# Pour PostgreSQL
DATABASE_URL="postgresql://username:password@127.0.0.1:5432/avengers_db?serverVersion=16&charset=utf8"

# Exemple avec les valeurs par défaut
DATABASE_URL="postgresql://postgres:password@127.0.0.1:5432/avengers_db?serverVersion=16&charset=utf8"
```

### 4. Créer la base de données

```bash
# Créer la base de données
php bin/console doctrine:database:create

# Exécuter les migrations
php bin/console doctrine:migrations:migrate

# Charger les données de test (optionnel)
php bin/console doctrine:fixtures:load
```

### 5. Lancer le serveur

Avec Symfony CLI :
```bash
symfony server:start
```

Ou avec le serveur PHP intégré :
```bash
php -S localhost:8000 -t public/
```

L'application est maintenant accessible sur : **http://localhost:8000**

## 📊 Structure de la base de données

### Tables principales

```sql
-- Livres
CREATE TABLE book (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    year INT,
    author_id INT REFERENCES author(id)
);

-- Auteurs
CREATE TABLE author (
    id SERIAL PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL
);

-- Marque-pages
CREATE TABLE bookmark (
    id SERIAL PRIMARY KEY,
    url VARCHAR(500) NOT NULL,
    comment TEXT,
    created_date TIMESTAMP NOT NULL
);

-- Tags (relation ManyToMany avec Bookmark)
CREATE TABLE tag (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Faune
CREATE TABLE faune (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    photo_url VARCHAR(500),
    description TEXT
);

-- Flore
CREATE TABLE flore (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    photo_url VARCHAR(500),
    description TEXT
);

-- Employés
CREATE TABLE employe (
    id SERIAL PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    adresse_id INT UNIQUE REFERENCES adresse(id)
);

-- Adresses
CREATE TABLE adresse (
    id SERIAL PRIMARY KEY,
    city VARCHAR(255) NOT NULL,
    country VARCHAR(255) NOT NULL
);
```

## 🎯 Fonctionnalités principales

### Livres
- Liste complète des livres
- Ajout/Modification de livres
- Recherche par première lettre du titre
- Recherche d'auteurs prolifiques (nombre minimum de livres)
- Statistiques (total de livres)
- Détail d'un livre

### Marque-pages
- Liste des marque-pages avec tags
- Ajout de marque-pages avec sélection multiple de tags
- Détail d'un marque-page

### Auteurs
- Liste des auteurs
- Ajout d'auteurs
- Détail d'un auteur avec nombre de livres

### Faune & Flore
- Affichage en grille de cartes avec images
- Descriptions détaillées

### Système multilingue
- Support français (par défaut)
- Support anglais
- URLs préfixées par la locale : `/fr/books` ou `/en/books`

## 🔧 Commandes utiles

### Base de données

```bash
# Créer une nouvelle migration
php bin/console make:migration

# Appliquer les migrations
php bin/console doctrine:migrations:migrate

# Charger les fixtures
php bin/console doctrine:fixtures:load

# Afficher le statut des migrations
php bin/console doctrine:migrations:status

# Exécuter une requête SQL
php bin/console doctrine:query:sql "SELECT * FROM book"
```

### Développement

```bash
# Vider le cache
php bin/console cache:clear

# Lister toutes les routes
php bin/console debug:router

# Vérifier la configuration
php bin/console debug:config

# Créer un controller
php bin/console make:controller

# Créer une entité
php bin/console make:entity
```

### Tests

```bash
# Lancer tous les tests
php bin/phpunit

# Lancer un test spécifique
php bin/phpunit tests/Controller/BookControllerTest.php
```

## 📁 Structure du projet

```
avengers_masso-jean/
├── assets/              # Fichiers JavaScript et CSS
├── bin/                 # Exécutables (console, phpunit)
├── config/              # Configuration Symfony
│   ├── packages/        # Configuration des bundles
│   └── routes/          # Routes
├── migrations/          # Migrations de base de données
├── public/              # Point d'entrée web
│   ├── index.php
│   └── favicon.svg
├── src/
│   ├── Controller/      # Contrôleurs
│   ├── Entity/          # Entités Doctrine
│   ├── Form/            # Types de formulaires
│   ├── Repository/      # Repositories Doctrine
│   └── DataFixtures/    # Données de test
├── templates/           # Templates Twig
│   ├── base.html.twig
│   ├── book/
│   ├── bookmark/
│   ├── author/
│   ├── faune/
│   ├── flore/
│   └── employe/
├── translations/        # Fichiers de traduction (fr, en)
├── var/                 # Cache et logs
└── vendor/              # Dépendances Composer
```

## 🌐 Routes principales

| Route | Méthode | Description |
|-------|---------|-------------|
| `/` | GET | Redirection vers la page d'accueil |
| `/{_locale}` | GET | Page d'accueil |
| `/{_locale}/books` | GET | Liste des livres |
| `/{_locale}/books/{bookId}` | GET | Détail d'un livre |
| `/{_locale}/books/search/{letter}` | GET | Recherche par lettre |
| `/{_locale}/books/authors/{minBooks}` | GET | Auteurs prolifiques |
| `/{_locale}/books/statistics` | GET | Statistiques |
| `/{_locale}/bookmarks` | GET | Liste des marque-pages |
| `/{_locale}/bookmarks/{bookmarkId}` | GET | Détail d'un marque-page |
| `/{_locale}/authors` | GET | Liste des auteurs |
| `/{_locale}/faune` | GET | Catalogue faune |
| `/{_locale}/flore` | GET | Catalogue flore |

## 🎨 Personnalisation

### Modifier le favicon

Le favicon est situé dans `public/favicon.svg`. Vous pouvez le remplacer par votre propre icône.

### Modifier les couleurs

Les couleurs sont gérées par Bootstrap 5.3.3. Pour personnaliser :
1. Créez un fichier CSS dans `assets/styles/`
2. Importez-le dans `templates/base.html.twig`

### Ajouter des traductions

Modifiez les fichiers :
- `translations/messages.fr.yaml` (français)
- `translations/messages.en.yaml` (anglais)

## 🐛 Dépannage

### Erreur de connexion à la base de données

Vérifiez que :
- PostgreSQL est démarré : `brew services list` (macOS) ou `systemctl status postgresql` (Linux)
- Les identifiants dans `.env.local` sont corrects
- La base de données existe : `psql -l`

### Erreur 500 après installation

```bash
# Vider le cache
php bin/console cache:clear

# Vérifier les permissions
chmod -R 777 var/
```

### Les assets ne se chargent pas

```bash
# Regénérer les assets
php bin/console asset-map:compile
```

## 👨‍💻 Auteur

**Jean Masso**
- Projet réalisé dans le cadre de la LP MIAW
- Année 2024-2025

## 📄 Licence

Ce projet est un projet éducatif réalisé dans le cadre d'une formation.

## 🙏 Remerciements

- Symfony pour le framework
- Doctrine pour l'ORM
- Bootstrap pour l'interface utilisateur