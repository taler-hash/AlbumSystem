# Album System

### Teck Stacks
1. Laravel v12
2. Vue 3
3. Typescript
4. Mysql
5. Docker

#### Prerequisites
1. Docker
2. Git

### Installation
1. Download all the necessary prerequisites
2. After downloading clone the applcation `https://github.com/taler-hash/AlbumSystem.git`
3. Download the [.env](https://drive.google.com/file/d/1z_LDvC2jkgNIZm4Zayb0cis34OWKiJ3p/view?usp=drive_link ".env") and after downloading rename it to .env
4. After renaming copy the .env to the `AlbumSystem/server`
5. From that directory open terminal and run this command `docker compose up --build`
to build the containers
6. after building open terminal from the same directory and run this command `docker compose exec server sh -c "composer install && php artisan migrate:fresh --seed" && docker compose exec client sh -c "npm install && npm run build"` to build the front end assets and migrate the data
7. After running the command you can now access the application via browser `http://127.0.0.1`

### Paths
1. /login
2. /register
3. /albums


### PS
1. Developed by: Jurie Tylier Pedrogas
2. Developed time : 20hrs