## Getting Started

### Docker
This project store docker images. Download docker application to your machine if you don't have it. Open your terminal:

    cd /path/to/your_project_folder
    docker-compose up -d --build

## Crearte .env

    cp .env.example .env
### App setup
    
    composer up

### Composer and Node
Make composer install:

    docker-compose exec app composer install
   
Make composer install:

    docker-compose exec app npm install

###SWAGGER 
Create:

    docker-compose exec app php artisan l5-swagger:generate

    or

    composer generate-doc
Documentation Url

    http://localhost/api/v1

### Passport init

    docker-compose exec app php artisan key:generate
    docker-compose exec app php artisan passport:instal

### Code style and test
You can check code style and test locally:

    docker-compose exec app composer check

### DB
Migration:

    docker-compose exec app php artisan migrate

Seeding:

    docker-compose exec app php artisan db:seed

