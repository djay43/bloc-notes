# Bloc notes - Gestion de tâches sous Symfony

Développement d'une application de gestion de tâches sous Symfony 4.

## Installation

Composer et npm sont requis pour l'installation de ce projet.

```bash
composer install
npm install
yarn encore dev
```


## Usage

Mettre en place la base de données

```bash
php bin/console doctrine:database:create && php bin/console doctrine:migrations:migrate --no-interaction
```

Pour une génération de tâches aléatoires lancez les fixtures:

```bash
php bin/console doctrine:fixtures:load --no-interaction
```


## Contributions

Les Pull Requests sont les bienvenues. Pour des requêtes importantes, merci d'ouvrir une issue afin que l'on puisse discuter des possibilités d'évolutions.
