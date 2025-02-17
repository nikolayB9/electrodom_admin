## electrodom_admin

This is the backend part of the application, which includes the admin panel and API for the frontend part - [electrodom_shop](https://github.com/WrSr12/electrodom_shop).

### About

ElectroDom is a pet project of an online store for the sale of supposedly electrical goods. The backend is executed on
Laravel, the frontend on VueJS.

### Used in the project

- Laravel 11.31
- AdminLTE 3.2.0
- Bootstrap 4.6

### Setup

```
composer install

php artisan key:generate
php artisan migrate --seed
php artisan serve
```

### Using

After migration to the database using seeder, the administrator and user accounts are available:

```
login: admin@mail.ru
password: 123123123

login: user@mail.ru
password: 123123123
```
