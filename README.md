# 👋🏼Hey, Voisin ! - API Symfony

<p align="center">
  <img src="assets/img/LogoHeyVoisinNoBG.png" alt="Logo Hey Voisin" width="200">
</p>
<p align="center">
  <img src="assets/img/TitleHeyVoisinNoBG.png" alt="Text Hey Voisin">
</p>

Bienvenue sur **Hey, voisin !**, votre plateforme communautaire dédiée au partage d'offres et de demandes de services de proximité. Ce projet utilise **Symfony 7** et **PHP 8.4** pour le backend de l'application ainsi que pour le back-office.
>**Note importante :** Ce dépôt contient uniquement l'API backend et le backoffice de l'application. La partie frontend du frontoffice est actuellement en cours de développement dans un dépôt séparé et sera bientôt disponible.

## 📚 Table des matières

- [🚀 Fonctionnalités](#-fonctionnalités)
- [🛠️ Technologies Utilisées](#️-technologies-utilisées)
- [📦 Installation](#-installation)
  - [Méthode 1 : Installation manuelle (pile LAMP)](#méthode-1--installation-manuelle-pile-lamp)
  - [Méthode 2 : Installation avec Docker](#méthode-2--installation-avec-docker)
- [🧪 Données de test (fixtures)](#-données-de-test-fixtures)
- [📜 Licence](#-licence)

## 🚀 Fonctionnalités

- 📄 Publier des offres ou des demandes d'entraide
- 🔍 Rechercher des annonces par catégorie ou localisation
- 👥 Gérer les profils utilisateurs
- 🔒 Authentification et autorisations sécurisées

## 🛠️ Technologies Utilisées

- **Langage principal** : PHP 8.4 / Symfony 7
- **Frontend backoffice** : Twig + TailwindCSS
- **Base de données** : MySQL
- **Autres outils** :
  - Composer pour la gestion des dépendances
  - Doctrine ORM pour la gestion des entités

## 📦 Installation

Vous pouvez installer et exécuter ce projet de deux manières :
- En local avec une **pile LAMP** pour les développeurs ayant déjà un environnement configuré
- Avec **Docker** pour une configuration rapide et portable

### Méthode 1 : Installation manuelle

#### Prérequis
- PHP >= 8.4
- Composer
- Serveur web (Apache, Nginx, etc.)
- Base de données (MySQL, PostgreSQL)

#### Environnements

##### Linux (LAMP)
- Installez Apache, MySQL et PHP via votre gestionnaire de paquets
- Exemple pour Ubuntu/Debian : 
  ```bash
  sudo apt update
  sudo apt install apache2 mysql-server php8.4 php8.4-mysql php8.4-xml php8.4-intl php8.4-mbstring
  ```

##### macOS (MAMP)
- Option 1 : Installez [MAMP](https://www.mamp.info/)
- Option 2 : Utilisez Homebrew :
  ```bash
  brew install php mysql
  ```

##### Windows (WAMP)
- Option 1 : Installez [XAMPP](https://www.apachefriends.org/)
- Option 2 : Installez [WampServer](https://www.wampserver.com/en/)
- Option 3 : Installez [Laragon](https://laragon.org/)

#### Étapes d'installation

```bash
git clone https://github.com/hich-ham-dev/hey-voisin-back-symfony.git
cd hey-voisin-back-symfony
composer install
```

- Configurez vos variables d'environnement dans le fichier `.env.local`
- Créez la base de données et exécutez les migrations :

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

- Lancez le serveur de développement Symfony :

```bash
symfony serve
```

Accédez à l'application : 👉 https://localhost:8000

### Méthode 2 : Installation avec Docker

#### Prérequis
- Docker
- Docker Compose

#### Étapes

```bash
git clone https://github.com/hich-ham-dev/hey-voisin-back-symfony.git
cd hey-voisin-back-symfony
docker-compose up --build
```

Une fois les conteneurs lancés, l'application sera accessible à l'adresse suivante :
- HTTPS uniquement : 👉 https://localhost:443

>⚡ **Remarque sur la sécurité** : Par défaut, l'application n'expose que le port HTTPS (8443) pour garantir que toutes les communications sont chiffrées. Ce port peut être personnalisé en modifiant la variable d'environnement `HTTPS_PORT` dans votre fichier `.env`.

>⚡ **Recommandation** : Si vous n'avez pas d'environnement local configuré ou souhaitez gagner du temps, nous vous recommandons d'utiliser **Docker**. La méthode manuelle reste disponible pour ceux qui préfèrent travailler directement sur leur pile LAMP.

## 🧪 Données de test (fixtures)

Pour faciliter le développement et les tests, vous pouvez **peupler la base de données** avec des données de démonstration :

| Rôle | Email | Mot de passe |
|------|-------|-------------|
| Administrateur | admin@gmail.com | admin |
| Modérateur | moderator@gmail.com | moderator |
| Utilisateurs randomisés | (emails générés automatiquement) | user |

### Chargement des fixtures

**Installation locale (pile LAMP)**
```bash
php bin/console doctrine:fixtures:load
```

**Installation avec Docker**
```bash
docker-compose exec php bin/console doctrine:fixtures:load
```

>⚡ **Astuce** : Si vous utilisez Docker, pensez à exécuter les commandes Symfony **dans le conteneur PHP** à l'aide de `docker-compose exec php`.

>⚠️ **Attention** : cette commande **efface toutes les données existantes** dans la base de données avant de recréer les nouvelles.

## 📜 Licence

Projet sous licence MIT.
