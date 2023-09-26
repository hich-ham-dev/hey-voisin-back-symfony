# Installation du projet

Après avoir cloné le repo vous devrez lancer les commandes suivantes :

## 1. Installer les dépendances du projet
```composer install``` pour installer toutes les dépendances du projet

## 2. Configurer la connexion à la base de données
***2.1*** Créer un fichier ```.env.local``` et y copier/coller le contenu du fichier ```.env``` (sera **.gitignore** par défaut contrairement au ```.env```).

***2.2*** Remplacez/décommentez la ligne **DATABASE_URL** correspondante à votre **SGBDR** (dans notre cas **MySQL/MariaDB**) par ```DATABASE_URL="mysql://hey_voisin:Yol@nde1985@127.0.0.1:3306/hey_voisin?serverVersion=10.6.12-MariaDB&charset=utf8mb4"``` pour donner les informations de connexion à la DB. 

Pour vérifier la version de **MariaDB** tapez ```sudo mysql -v``` dans votre terminal.

## 3. Création et remplissage de la base de données
***3.1*** Créez un user de base de données à l'aide de **Adminer** ou **PhpMyAdmin** avec comme nom ```hey_voisin``` et comme mot de passe ```Yol@nde1985```, donnez-lui tous les droits sur la DB ```hey_voisin```.   

***3.2*** Créez la base de données en lançant la commande ```php bin/console doctrine:database:create```.

***3.3*** Lancez la migration (les requêtes **SQL** générées par **Doctrine** l'ORM de **Symfony**) en lançant la commande ```php bin/console doctrine:migrations:migrate```.

Elle aura pour effet de générer les tables ainsi que leurs champs respectifs. 

***3.4*** Pour approvisionner notre base de données en données fictives, il vous suffira de lancer la commande ```php bin/console doctrine:fixtures:load```.
