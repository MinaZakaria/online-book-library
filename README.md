
## Online Book Library API

Online Book Library is an API for borrowing books online.
You can add Categories to your favourite and get notifications when adding a book in this category

You can request to Borrow any book for certain time period.

# Local Build
- This application uses [Laravel Sail](https://laravel.com/docs/8.x/sail). a built-in solution for running your Laravel project using Docker. To get started, you only need to install [Docker Desktop](https://www.docker.com/products/docker-desktop).
- Clone the project using
    ```sh
    git clone git@github.com:MinaZakaria/online-book-library.git
    ```
- Navigate to the app directory using
    ```sh
    cd online-book-library
    ```
- Install Composer Dependencies (including Sail) using
    ```sh
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v $(pwd):/var/www/html \
        -w /var/www/html \
        laravelsail/php81-composer:latest \
        composer install --ignore-platform-reqs
    ```
- Start Laravel Sail using
    ```sh
    ./vendor/bin/sail up -d
    ```
    The first time you run the Sail up command, Sail's application containers will be built on your machine. This could take several minutes.
- Now you should have 3 running containers (laravel.test which is the primary app, mysql, redis). You can verify using
    ```sh
    docker ps
    ```
- If anything went wrong please upgrade your Docker to version 20.10
- add alias to `./vendor/bin/sail` using
    ```sh
    alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
    ```
    Now you can use any command like `sail up` instead of `./vendor/bin/sail up`
- any artisan/php/composer command should be run using sail
- Add `.env` file By copying `.env.example` using
    ```sh
    cp .env.example .env
    ```
- Generate app key using
    ```sh
    sail artisan key:generate
    ```
- Configure `.env` file.
- you must create the database for the migrations to run manually by logging in to the mysql database through MySQL Workbench or TablePlus. Make sure the database name is the same as the one you provide in .env file
- Run migrations With Seeds using
    ```sh
    sail artisan migrate:fresh --seed
    ```
- Start laravel queue worker to listen to your `notifications` queue using
    ```sh
    sail artisan queue:work redis --tries=3 --backoff=3 --queue=notifications
    ```
- Start Laravel Scheduler using
    ```sh
    sail artisan schedule:work
    ```
- use postman collection & environment variables in `./postman` directory to test the app.
