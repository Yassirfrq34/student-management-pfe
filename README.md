1️⃣ Récupérer le code
Ouvre un terminal dans ton dossier de travail et lance : git clone [COLLE TON LIEN GITHUB ICI]

2️⃣ Installer le Backend (Laravel)
Ouvre le dossier du projet dans le terminal et lance :

composer install (Pour télécharger les librairies PHP)

cp .env.example .env (Pour créer ton fichier de configuration)

php artisan key:generate (Pour sécuriser l'app)

3️⃣ Configurer la Base de Données (Important !)
Ouvre XAMPP et lance Apache + MySQL.

Va sur phpMyAdmin et crée une nouvelle base de données vide nommée : student_management.

Reviens dans le terminal et lance : php artisan migrate (Ça va créer automatiquement les tables users, students et subjects).

4️⃣ Lancer le Frontend (React)
Ouvre un deuxième terminal (ne ferme pas le premier) et lance :

npm install (Pour télécharger React)

npm run dev (Pour lancer le serveur Vite)

5️⃣ Tester l'application
Dans le premier terminal, lance : php artisan serve

Va sur : http://127.0.0.1:8000

⚠️ Astuce pour être Admin : Si tu crées un compte, tu seras "Étudiant" par défaut (tu ne verras pas les boutons Modifier/Supprimer). Pour devenir Admin :

Inscris-toi sur le site.

Va dans phpMyAdmin > table users.

Modifie ton utilisateur et change la colonne role de "student" à "admin".

Déconnecte-toi et reconnecte-toi.
