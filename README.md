# Distributor Board

A web based application to keep truck of delivery driver and packages

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

* PHP >= 7.1.3
* Node >= 6.x
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Ctype PHP Extension
* JSON PHP Extension
* [Composer](https://getcomposer.org/)


### Install

#### 1. Clone the source code or create new project.

```shell
git clone https://github.com/vafagh/Distributor-board.git
```


### 2. Set the basic config

```shell
cp .env.example .env
```

Edit the `.env` file and set the `database` and other config for the system after you copy the `.env`.example file.

### 2. Install the extended package dependency.

Install the `Laravel` extended repositories:

```shell
composer install -vvv
```

Compile the js code:

```shel
npm run dev

// OR

npm run watch

// OR

npm run production
```

### 3. Run the blog install command, the command will run the `migrate` command and generate test data.

```shell
php artisan migrate
```
### 4. (Optional) Run database seeder to have some demo data.

```shell
php artisan db:seed
```
### 5. Enable Google map API
This application uses this API. You need to enable them and your API to .env file to get the maps and map functions to work.
- Maps Static
- Maps JavaScript
- Geocoding API

## Built With

* [Laravel](https://laravel.com) - The PHP framework For Web Artisan
* [Bootstrap](https://getbootstrap.com/) - The most popular HTML, CSS, and JS library in the world.

## Contributing


## Versioning


## Authors


## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments
