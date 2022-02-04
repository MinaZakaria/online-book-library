
# Online Book Library API

Online Book Library is an API for borrowing books online.
You can request to Borrow any book for certain time period.
There are alot of Book Categories in the Library and you can add any category to your favourite to be notified when adding a book in this category

# Technologies used

- This application uses [Laravel Sail](https://laravel.com/docs/8.x/sail). a built-in solution for running your Laravel project using Docker. To get started, you only need to install [Docker Desktop](https://www.docker.com/products/docker-desktop).
- This application uses `MySQL` DB Connection as a primary Database.
- This application uses `Redis` as a Queue Connection. The Queue used for sending Notifications to users
- By Laravel Scheduler. This applcation could send notifications at certain times during the day to users
- instead of sending real notifications we Log them in files in our storage directory. you can find them in `./storage/app/`:
```sh
NewBookNotifications.txt,
ReminderBefore1hBorrowingBook.txt,
ReminderBefore6hReturningBook.txt,
ReminderBefore24hReturningBook.txt,
JobsFailed.txt
```

# Local Build
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
- any artisan|php|composer command should be run using sail
- Add `.env` file By copying `.env.example` using
    ```sh
    cp .env.example .env
    ```
- Generate app key using
    ```sh
    sail artisan key:generate
    ```
- Generate `jwt` secret key using
    ```sh
    sail artisan jwt:secret
    ```

## DB Connection
- You may connect to the MySQL instance within your application by setting your `DB_HOST` environment variable within your application's `.env` file to `mysql`.
- To connect to your application's MySQL database from your local machine, you may use a graphical database management application such as `TablePlus`. By default, the MySQL database is accessible at `localhost` port `3306`.
- Your default DB user DB_USERNAME is `sail` and password is `password`

- If not already exists, you need to create the database schema through `TablePlus`. Make sure the database name is the same as the one you provide in `.env` file

- Run migrations With Seeds using
    ```sh
    sail artisan migrate:fresh --seed
    ```

## Redis Connection
- You may connect to the Redis instance within your application by setting your `REDIS_HOST` environment variable within your application's `.env` file to `redis`.
- To connect to your application's Redis database from your local machine, you may use a graphical database management application such as `TablePlus`. By default, the Redis database is accessible at `localhost` port `6379`.
- Default password for redis is `null`

## Start other processes
- update .env Queue variables
    ```
    QUEUE_CONNECTION=redis
    REDIS_QUEUE=notifications
    ```
- Start laravel queue worker to listen to your `notifications` queue using
    ```sh
    sail artisan queue:work redis --tries=3 --backoff=3 --queue=notifications
    ```
- Start Laravel Scheduler using
    ```sh
    sail artisan schedule:work
    ```

# Testing app
Use postman collection & environment variables in `./postman` directory to test the app.

# Notifications in real life
In real life we could use Amazon SNS Service for sending the real notifications to the users

## New book added to the category
- We can create a topic for each category in the create category API
- When someone add category to favourite we should subscribe him to the topic of this category
- When adding new book to the category, We will only send the BookAddedEvent to this topic.
- Anyone subscribed to this category will receive a notification with the BoodAddedEvent data.

## Reminders of Borrowing and Returning Books
- We can create a topic for each user in the register API
- we should subscribe the user to his topic each time he login
- When reminder should be sent, We will only send the Reminder data to this user topic.
- User will receive a notification with the Reminder data.