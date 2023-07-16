# Waky

## Introduction

A web based Wake-on-LAN Server for managing servers in your home network!

### Why would I use this?

The main use for Waky is to be able to manage computers/servers in your home.

#### Collaboration

I manage a shared server which a few other people, including myself, use.
To make sure the server doesn't waste electricity, one can "use" the server to block others from shutting it down. The last person to have the server in use can then shutdown the server once they're finished.

## Getting Started

To install Waky you can use the provided Docker images.

### Install with Docker Compose

```yml
version: '3'
services:
    waky:
        container_name: waky
        environment:
            - PUID=1000
            - PGID=1000
            - APP_URL=http://localhost
            - TZ=Europe/Berlin
        volumes:
            - '/etc/localtime:/etc/localtime:ro'
            - './data/config:/config' # Directory for sqlite database & .env
            - './data/ssl/web:/etc/ssl/web' # Directory for ssl certificates
        image: 'ghcr.io/quadrubo/waky:latest'
        network_mode: host
        restart: unless-stopped
```

Run `docker compose up` to start the application.

You can now login to your instance with the user below. Once authenticated, it is recommended to change your email and password.

| Username          | Password |
| ----------------- | -------- |
| admin@example.com | password |

**Warning:** This account will be recreated if there are no users in the system.

## Contributing

These instructions will give you a copy of the project up and running on
your local machine for development and testing purposes. See deployment
for notes on deploying the project on a live system.

### Prerequisites

These instructions are focused on running the project with Docker. Docker and Docker Compose need to be installed on your system to proceed. This project assumes you will be using [Laravel Sail](https://laravel.com/docs/9.x/sail) as your development environment.

I also assume that you [configured the sail alias](https://laravel.com/docs/9.x/sail#configuring-a-shell-alias). If not, just replace `sail` with `./vendor/bin/sail` while installing.

### Installing

First clone the project to your local system.

```
git clone https://github.com/Quadrubo/waky
```

[Install the composer dependencies](https://laravel.com/docs/9.x/sail#installing-composer-dependencies-for-existing-projects) using Laravel Sail.

Start the container.

```
sail up
```

Copy the environment file.

```
cp .env.sail.example .env
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

The project is a pretty simple Laravel app. The admin panel is built using [Filament](https://github.com/filamentphp/filament).

### Usage

#### Discord Webhook Notifications

Discord Webhook Notification support is build in. Just create a webhook on your discord server and set the `DISCORD_WEBHOOK_URL` variable in your `.env` file.  
This sends you notifications when a computer switches from no to one or one to no users.

## Running the tests

```
sail test
```

## Built With

-   [Laravel](https://github.com/laravel/framework) - Framework

## Contributing

All contributions are welcome! Just fork the project. [Setup the development environment](#installing) and create a branch for your fix or feature :)

## Authors

-   **Quadrubo**
-   **[Billie Thompson](https://github.com/PurpleBooth)** - _Provided [README Template](https://github.com/PurpleBooth/a-good-readme-template)_

See also the list of
[contributors](https://github.com/Quadrubo/waky/graphs/contributors)
who participated in this project.

## License

This project is licensed under the [GNU Affero General Public License v3.0](LICENSE.md).
