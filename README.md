# Fullstack Challenge 🏅 2021 - Space Flight News

> This is a challenge by [Coodesh](https://coodesh.com/)

[Test this app](https://coodesh-challenge-backend.herokuapp.com/)

## Stack and libs

-   PHP Laravel
-   MySQL (heroku - JawsDB)
-   Frontend can be found [here](https://github.com/cpcm94/coodesh-frontend)

## Installation and Setup

Clone this project, install all dependencies with composer up

### Heroku

This backend is deployed using [Heroku](www.heroku.com), with the Add-ons:

-   JawsDB MySQL
-   Heroku Scheduler

Heroku Scheduler is used to run a [Laravel Queue'd Job](https://laravel.com/docs/9.x/queues#running-the-queue-worker), every 9am updating the database with any new article.

Configuring environment variables in your Heroku app are the same ones required to setup on your `.env` file

## Env

Now you need to add and configure the `.env` file. A example env file can be found in the project directory as `.env.example`:

All these informations should be found inside your JawsDB add-on

| Variable      | Description               |
| ------------- | ------------------------- |
| DB_CONNECTION | Type of database          |
| DB_HOST       | Address for the hosted DB |
| DB_PORT       | Which port to use         |
| DB_DATABASE   | Name of the DB            |
| DB_USERNAME   | Username to access DB     |
| DB_PASSWORD   | Password to access DB     |

### Running Locally

To run the project run php artisan serve.

### Populating your JawsDB

After setting up your `.env` file and starting the project locally, run the following command:

```
php artisan db:seed ArticleSeeder
```

The command will fetch all articles from the Space Flight News API

## .gitignore

/node_modules
/public/hot
/public/storage
/vendor
.env
.env.backup
.phpunit.result.cache
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
/.idea
/.vscode
