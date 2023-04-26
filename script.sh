#!/bin/bash

# Génère les migrations à partir de la base de données
php artisan migrate:generate

# Exécute les migrations pour créer les tables dans la base de données
php artisan migrate

# Génère les modèles, les contrôleurs, les factories et les seeders pour toutes les tables de la base de données
php artisan make:model --all

# Exécute les factories pour peupler la base de données avec des données d'exemple
php artisan db:seed
