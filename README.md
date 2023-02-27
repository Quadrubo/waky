# WOL-Client

A web based Wake-on-LAN Server for managing servers in your home network!

## Getting Started

These instructions will give you a copy of the project up and running on
your local machine for development and testing purposes. See deployment
for notes on deploying the project on a live system.

### Prerequisites

These instructions are focused on running the project with Docker. Docker and Docker Compose need to be installed on your system to proceed. This project assumes you will be using [Laravel Sail](https://laravel.com/docs/9.x/sail) as your development environment.

I also assume that you [configured the sail alias](https://laravel.com/docs/9.x/sail#configuring-a-shell-alias). If not, just replace `sail` with `./vendor/bin/sail` while installing.

### Installing

First clone the project to your local system.

```
git clone https://github.com/Quadrubo/wol-client
```

[Install the composer dependencies](https://laravel.com/docs/9.x/sail#installing-composer-dependencies-for-existing-projects) using Laravel Sail.

Start the container.

```
sail up
```

Copy the environment file.

```
cp .env.dev .env
```

Generate the app key.

```
sail artisan key:generate
```

Run the database migrations.

```
sail artisan migrate
```

Seed the database.

```
sail artisan db:seed --class DevelopmentSeeder
```

Running the scheduler.  
_The scheduler is responsible for starting the jobs in regular intervals._

```
sail artisan schedule:work
```

Running the queue.  
_The queue is responsilbe for executing the jobs like pinging the computers._

```
sail artisan queue:work
sail artisan queue:work --queue notifications
```

Install the npm dependencies.

```
sail npm install
```

Start the vite development environment.

```
sail npm run dev
```

You should now be able to access the site on `http://localhost`. 2 test users have been created for you.

| Username | E-Mail            | Password |
| -------- | ----------------- | -------- |
| admin    | admin@admin.admin | admin123 |
| user     | user@user.user    | user1234 |

The admin user has access to the admin panel and can create computers. The user user has no specific permissions.

You can access the admin panel at `/admin`.

### Project Structure

The project is a pretty simple Laravel app. The admin panel is built using [Filament](https://github.com/filamentphp/filament). The rest of the site was scaffolded with [Laravel Jetstream](https://github.com/laravel/jetstream) and is using the [Inertia Stack](https://jetstream.laravel.com/2.x/stacks/inertia.html).

There is also the [TODO.md](TODO.md) file, filled with stuff that is left to do.

### Usage

#### Discord Webhook Notifications

Discord Webhook Notification support is build in. Just create a webhook on your discord server and set the `DISCORD_WEBHOOK_URL` variable in your `.env` file.  
This sends you notifications when a computer switches from no to one or one to no users.

## Running the tests

```
sail test
```

## Deployment

To deploy this on a live system, you **should not** use Laravel Sail.  
I also had trouble getting it to run with Docker, because the Wake-on-LAN magic packet wouldn't route out of the container. If you find a way to run this within Docker I'd gladly accept a Pull Request with a compose file.

In production, I currently just run this with `php8.2-fpm`, `nginx` and a `mariadb` database. Please check the Laravel documentation on [Deployment](https://laravel.com/docs/9.x/deployment) for more details.

Build the vite production environment.

```
npm run build
```

## Built With

-   [Laravel](https://github.com/laravel/framework) - Framework

## Contributing

All contributions are welcome! Just fork the project. [Setup the development environment](#installing) and create a branch for your fix or feature :)

## Authors

-   **Quadrubo**
-   **[Billie Thompson](https://github.com/PurpleBooth)** - _Provided [README Template](https://github.com/PurpleBooth/a-good-readme-template)_

See also the list of
[contributors](https://github.com/Quadrubo/wol-client/graphs/contributors)
who participated in this project.

## License

This project is licensed under the [MIT License](LICENSE.md).
