Documentation Technique
Application de gestion de réservations immobilières

(Test technique – Développement Laravel)

1. Contexte du projet

Cette application a été développée dans le cadre d’un test technique.
Elle permet de gérer un catalogue de biens immobiliers ainsi que les réservations associées.

L’objectif principal était de concevoir une application proprement structurée, respectant les bonnes pratiques Laravel, avec :

une séparation claire des responsabilités,

une logique métier cohérente,

une interface utilisateur fonctionnelle,

et un panneau d’administration complet.

2. Stack technique

Le projet s’appuie sur les technologies suivantes :

Laravel : framework principal (architecture MVC, routing, ORM Eloquent).

Laravel Breeze : gestion de l’authentification.

Livewire : interaction dynamique côté interface (formulaire de réservation).

Filament : panneau d’administration.

TailwindCSS : mise en forme et design.

MySQL / SQLite : base de données relationnelle.

Le choix de ces outils permet d’obtenir une application rapide à développer tout en restant robuste et maintenable.

3. Fonctionnalités implémentées
3.1 Consultation des propriétés

Liste des propriétés disponibles.

Page de détail avec description complète et tarif par nuit.

Composants Blade réutilisables pour l’affichage des cartes.

3.2 Authentification

Via Laravel Breeze :

Inscription

Connexion / Déconnexion

Gestion du profil utilisateur

Protection des routes via middleware auth

3.3 Réservation d’un bien

Le système de réservation est implémenté avec Livewire afin d’éviter les rechargements de page.

Fonctionnalités :

Sélection des dates d’arrivée et de départ.

Calcul automatique du nombre de nuits.

Calcul du montant total.

Validation métier :

Dates obligatoires

Date de départ postérieure à la date d’arrivée

Vérification de non-chevauchement avec des réservations existantes

Seuls les utilisateurs authentifiés peuvent réserver.

3.4 Tableau de bord utilisateur

Confirmation de connexion.

Affichage des dernières réservations effectuées.

3.5 Interface d’administration

Accessible via /admin.

Fonctionnalités :

CRUD complet des propriétés.

Gestion des réservations.

Accès restreint par **rôles** : seuls les utilisateurs ayant le rôle **admin** peuvent accéder à `/admin`. Les autres reçoivent une erreur 403.

Système de rôles (évolutif) :
- Table **roles** (name, label) et table pivot **role_user** (user_id, role_id) : un utilisateur peut avoir plusieurs rôles.
- Rôles par défaut : `admin` (Administrateur), `utilisateur` (Utilisateur). D’autres rôles peuvent être ajoutés dans Filament.
- Méthode sur le modèle User : `$user->hasRole('admin')`.

Gestion dans le panneau Filament :
- **Administration > Utilisateurs** : liste, création et édition des comptes ; champ **Rôles** (multi-sélection) pour attribuer les rôles (dont Administrateur).
- **Administration > Rôles** : liste, création et édition des rôles (name, label). Permet d’ajouter de nouveaux rôles pour de futures évolutions.
- Commande pour donner le rôle admin à un utilisateur :  
  `php artisan user:make-admin email@exemple.com`

L’interface est générée avec Filament, permettant une gestion rapide et sécurisée des données.

4. Modélisation des données

L’application repose sur trois entités principales :

User

Gérée par Laravel.

Relation **rôles** : many-to-many avec la table **roles** (pivot `role_user`). Méthode `hasRole(string $name)` pour vérifier un rôle. Le rôle `admin` donne accès au panneau Filament (/admin).

Relation : un utilisateur possède plusieurs réservations.

Role

Nom (identifiant technique) et libellé (affichage). Relation many-to-many avec User.

Property

Représente un bien immobilier.

Relation : une propriété possède plusieurs réservations.

Booking

Associe un utilisateur à une propriété.

Contient les dates de séjour.

Inclut des attributs calculés :

nombre de nuits

prix total

Les clés étrangères sont configurées avec suppression en cascade afin de garantir l’intégrité des données.

5. Architecture et organisation

Le projet respecte la structure standard Laravel :

Controllers pour la logique HTTP.

Models pour la logique métier.

Vues Blade pour le rendu.

Composants Livewire pour l’interactivité.

Ressources Filament pour l’administration.

La logique métier (calculs, validations spécifiques) est centralisée autant que possible dans les modèles ou composants dédiés afin de garder des contrôleurs légers.

6. Installation

Installer les dépendances :

composer install
npm install

Configurer le fichier .env.

Migrer la base :

php artisan migrate --seed

Après la première migration, donner les droits admin à un utilisateur (ex. celui créé avec `php artisan make:filament-user`) :

php artisan user:make-admin user@test.gmail

Lancer le projet :

npm run dev
php artisan serve

Application accessible sur :
http://localhost:8000
Admin : http://localhost:8000/admin

7. Points d’attention techniques

Validation des conflits de dates côté serveur.

Calcul dynamique du montant total via Livewire.

Structure conforme aux conventions Laravel.

Code organisé pour faciliter l’évolution (ex : ajout futur de gestion de disponibilité, paiement, etc.).

8. Améliorations possibles

Dans un contexte de production, les évolutions suivantes pourraient être envisagées :

Tests automatisés (Feature / Unit tests).

Gestion avancée des disponibilités.

Système de paiement intégré.

Gestion des rôles (admin / utilisateur standard).

Pagination des propriétés.

Optimisation des performances (index DB, cache).

Conclusion

Ce projet démontre :

Une bonne maîtrise de l’écosystème Laravel.

La mise en place d’une logique métier cohérente.

Une structuration propre du code.

La capacité à produire une application fonctionnelle et administrable dans un cadre contraint (test technique).