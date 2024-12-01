
# **Application Laravel Test**

Cette application Laravel est containerisée avec Docker pour une expérience de développement et de déploiement fluide.

---

## **Fonctionnalités**
- Configuration Docker pré-configurée (Nginx, PHP-FPM, MySQL, PhpMyAdmin)
- Authentification basée sur Sanctum pour les APIs REST
- Fonctions CRUD avec recherche et filtrage avancés

---
- Le fichier collection des API's pour POSTMAN est disponible sur ce [lien](https://drive.google.com/file/d/1Lvy-NlTthzuAsnUd8qM0segbWIZ-nCH_/view?usp=drive_link).
---

## **Prérequis**
Avant de déployer cette application, assurez-vous d'avoir les éléments suivants installés sur votre système :

### **1. Installation de Docker**
- La plateforme Docker peut être installée sur Windows, Mac ou Linux à partir de leur site web.
- Install [Docker](https://docs.docker.com/install/).
- Install [Docker Compose](https://docs.docker.com/compose/install/).

Une fois installée, elle s'exécutera en tant que processus en arrière-plan, et les versions peuvent être vérifiées en ligne de commande :

```bash
docker --version
docker-compose --version
```

Assurez-vous que les versions s'affichent correctement.

---

## **Installation et Configuration**

Suivez ces étapes pour cloner et déployer l'application :

### **1. Cloner le Dépôt**
Exécutez la commande suivante pour cloner le dépôt localement :

```bash
git clone https://github.com/essaidProfil/ebo-laravel-test.git
```

Accédez au répertoire du projet :

```bash
cd ebo-laravel-test
```

### **2. Construire les Conteneurs Docker**
Allez dans le dossier de configuration Docker :

```bash
cd ebo-laravel-test
```

Puis, construisez les conteneurs :

```bash
docker-compose build
```

Cette étape créera tous les conteneurs nécessaires pour l'application.

### **3. Démarrer les Conteneurs**
Une fois la construction terminée, démarrez les conteneurs en mode détaché :

```bash
docker-compose up -d
```

### **4. Vérifier les Conteneurs Actifs**
Vérifiez si tous les conteneurs sont en cours d'exécution :

```bash
docker ps
```

Vous devriez voir les conteneurs suivants :
- **nginx** (pour le serveur de l'application Laravel)
- **phpmyadmin** (interface pour la base de données)
- **database** (base de données MySQL)
- **laravel-store** (application Laravel avec PHP-FPM)

---

## **Accéder à l'Application**

### **Application Laravel**
Accédez à [http://localhost:8080](http://localhost:8080) pour voir l'application Laravel.

### **PhpMyAdmin**
Accédez à [http://localhost:8081](http://localhost:8081) pour voir PhpMyAdmin. Utilisez les identifiants suivants :
- **Serveur** : `db`
- **Nom d'utilisateur** : `root`
- **Mot de passe** : `password`

- **Base de données** : `ebodb`

### **API Endpoints**
Vous pouvez tester les endpoints API avec des outils comme Postman ou cURL. Consultez le fichier `routes/api.php` pour voir les endpoints disponibles.

---

## **Configuration de la Base de Données**
Pour configurer la base de données :
1. Lancez les migrations pour créer les tables nécessaires :

   ```bash
   docker exec -it laravel-store php artisan migrate
   ```

2. Si applicable, remplissez la base de données avec des données d'exemple :

   ```bash
   docker exec -it laravel-store php artisan db:seed
   ```

---

## **Arrêter l'Application**
Pour arrêter l'application, exécutez :

```bash
docker-compose down
```

---

## **Dépannage**
- Assurez-vous que Docker est en cours d'exécution et à jour.
- Consultez les journaux pour détecter d'éventuelles erreurs :

  ```bash
  docker logs <nom_du_conteneur>
  ```

- Vérifiez les paramètres du fichier `.env` (base de données et URL de l'application).
- Si les problèmes persistent, reconstruisez les conteneurs :

  ```bash
  docker-compose build --no-cache
  ```

---

## **Instructions de déploiement Laravel**
Pour installer Laravel, veuillez suivre les étapes suivantes :

1. **Créer la base de données et les tables** :  
   Pour créer la base de données et les tables nécessaires, exécutez la commande suivante dans votre terminal :
   ```bash
   php artisan migrate
   ```
   ou bien 
   ```bash
   docker-compose exec app php artisan migrate
   ```

2. **Générer des données de test (Optionnel)** :  
   Si vous souhaitez générer des données de test (fake data) pour tester l'application, exécutez :
   ```bash
   docker-compose exec app php artisan migrate:fresh --seed
   ```

3. **Outils**:
   - Si vous souhaitez afficher les ROUTEs disponible 
   ```bash
   php artisan route:list
   ```
   Ou bien
   ```bash
   docker-compose exec app php artisan route:list
   ```
   - Pour supprimer la cache ROUTE
   ```bash
    php artisan route:clear
   ```
   Ou bien
   ```bash
   docker-compose exec app php artisan route:clear
   ```
      Vous pouvez accéder à l'application via l'adresse `http://localhost:8080`.

---

## **Contributions**
N'hésitez pas à forker le dépôt et à soumettre une pull request pour des améliorations ou des corrections.

---

## **Licence**
Ce projet est sous licence [MIT](https://opensource.org/licenses/MIT).

---
