# API Documentation

## Set Key

> $ php artisan key:generate

## Run migrations and seed

Everything needed is inside the project

> $ php artisan migrate --seed

This project has seeders for the tables so it can be ready out of the box.

## Endpoints

> $ php artisan route:list

Following Laravel conventions

GET       Retrieves items (or item if specified) <br>
POST      Create a new record <br>
PUT       Updates record <br>
DELETE    Deletes record <br>
 
## Authentication

> POST /api/login

Will return a token to use as a Bearer

## Policies and persmissions

Every action has its own policy on /app/Policies that authorize or deny the action

## Scheduled tasks

There is a scheduled task to make notifications, this is in /app/Console/Commands, the task can be executed manually or automatically running the Laravel schedule worker

> $ php artisan schedule:work

## Testing

There are some Feature/Unit tests to ensure the quality of the project.

> php artisan test

ALl tests are executed on Memory DB.

