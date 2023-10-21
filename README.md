#  Api-Bookmark

## Auteur
Vasseur Lucas

## Création et utilisation d'[API](https://api-platform.com/docs)

Ce module a pour objectif de présenter les API web, tant d'un point de vue de l'utilisation, de l'exploitation ou de la mise en place.

Dans cette optique, vous allez utiliser API Platform pour mettre en place une API exposant des données, puis vous interagirez avec ces données au travers de requêtes.

## Installation/Configuration

### Installation par [Composer](https://getcomposer.org/doc/)

Lancer `composer install` pour installer [PHP Coding Standards Fixer](https://cs.symfony.com/) et le configurer dans PhpStorm (le fichier `.php-cs-fixer.php` contient les règles personnalisées basées sur la recommandation [PSR-12](https://www.php-fig.org/psr/psr-12/))

### Configurer PhpStorm

Configurer l'intégration de PHP Coding Standards Fixer dans PhpStorm en fixant le jeu de règles sur `Custom` et en désignant `.php-cs-fixer.php` comme fichier de configuration de règles de codage.

## Serveur Web local

### Lancez le serveur Web local avec cette commande :
```bash
composer start
```

### Test le cs fixer :
```bash
composer test:cs
```

### Applique le cs fixer :
```bash
composer fix:cs
```

### Déclenche le script `test:cs`:
```bash
test
```

### Génération de la base de données :
```bash
composer db
```

Lance :
- `php bin/console doctrine:database:drop --force --if-exists` : Destruction forcée de la base de données
- `php bin/console doctrine:database:create` : Création de la base de données
- `php bin/console doctrine:migrations:migrate --no-interaction` : Application des migrations successives sans questions interactives
- `php bin/console doctrine:fixtures:load --no-interaction` : Génération des données factices sans questions interactives



## Style de codage
Le code suit la recommandation [PSR-12](https://www.php-fig.org/psr/psr-12/) : 
- il peut être contrôlé avec `composer test:cs` 
- il peut être reformaté automatiquement avec `composer fix:cs`
