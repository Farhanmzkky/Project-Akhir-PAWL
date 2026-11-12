# EcoQuest (plogeeLite)

## Setup
1. git clone https://github.com/rayhanarzet/Project-Akhir-PAWL.git
2. cd Project-Akhir-PAWL
3. composer install
4. copy .env.example .env   (Mac/Linux: cp .env.example .env)
5. php artisan key:generate
6. Buat database `ecoquest` di HeidiSQL
7. php artisan migrate
8. php artisan serve