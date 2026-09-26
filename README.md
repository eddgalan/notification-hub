# Notification Hub

Notification Hub is a Laravel API for dispatching notifications through different channels. The current Docker setup runs the application with PHP 8.4 and Apache, exposing Laravel through the `public/` directory.

## Requirements

- Docker
- Docker Compose
- Git

Optional, only if you need to build frontend assets outside Docker:

- Node.js
- npm

## Docker Services

The project includes one Docker service:

| Service | Container | Purpose | URL |
| --- | --- | --- | --- |
| `notification-hub` | `notification-hub` | PHP 8.4 + Apache | `http://localhost:8088` |

The container mounts the project directory into `/var/www/html`, so code changes on your machine are reflected inside the container.

## Installation With Docker

Clone the repository and enter the project directory:

```sh
git clone <repository-url>
cd notification-hub
```

Create the environment file:

```sh
cp .env.example .env
```

Build and start the container:

```sh
docker compose up -d --build
```

Install PHP dependencies inside the container:

```sh
docker compose exec notification-hub composer install
```

Generate the Laravel application key:

```sh
docker compose exec notification-hub php artisan key:generate
```

Create the SQLite database file if it does not exist:

```sh
docker compose exec notification-hub touch database/database.sqlite
```

Run the database migrations:

```sh
docker compose exec notification-hub php artisan migrate
```

The application should now be available at:

```txt
http://localhost:8088
```

## Environment

The default `.env.example` uses SQLite:

```dotenv
DB_CONNECTION=sqlite
QUEUE_CONNECTION=database
```

For local Docker usage, update `APP_URL` to match the exposed port:

```dotenv
APP_URL=http://localhost:8088
```

Because the queue uses the database driver, make sure migrations have been executed before dispatching notification jobs.

## Queue Worker

Notification dispatching uses queued jobs. Start a worker in a separate terminal:

```sh
docker compose exec notification-hub php artisan queue:work
```

For development, you can stop the worker with `Ctrl+C`.

## Useful Docker Commands

Start the application:

```sh
docker compose up -d
```

Stop the application:

```sh
docker compose down
```

Open a shell inside the container:

```sh
docker compose exec notification-hub bash
```

Run Artisan commands:

```sh
docker compose exec notification-hub php artisan <command>
```

Run tests:

```sh
docker compose exec notification-hub php artisan test
```

Format PHP code:

```sh
docker compose exec notification-hub vendor/bin/pint
```

View Laravel logs:

```sh
docker compose exec notification-hub tail -f storage/logs/laravel.log
```

## API Endpoints

The application exposes these API routes:

| Method | Endpoint | Name |
| --- | --- | --- |
| `POST` | `/api/login` | `login` |
| `POST` | `/api/v1/notifications/dispatch` | `v1.notifications.dispatch` |

The notification dispatch endpoint is protected with Sanctum authentication.

Example notification payload:

```json
{
    "event_type": "USER_WELCOME",
    "channels": [
        "email",
        "telegram"
    ],
    "payload": {
        "user_id": "1",
        "email": "dev@example.com",
        "message": "Bienvenido a Notification Hub"
    }
}
```

cURL:

```bash
curl --location 'http://localhost:8088/api/v1/notifications/dispatch?XDEBUG_SESSION_START=PHPSTORM' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer ' \
--data-raw '{
"event_type": "USER_WELCOME",
"channels": [
"email",
"telegram"
],
"payload": {
"user_id": "1",
"email": "dev@example.com",
"message": "Bienvenido a Notification Hub"
}
}'
```

## Xdebug

The Docker image installs Xdebug because `docker-compose.yml` builds with:

```yaml
args:
    INSTALL_XDEBUG: "true"
```

The Xdebug configuration is located at:

```txt
docker/xdebug.ini
```

By default it uses `host.docker.internal`, which works on Docker Desktop for macOS and Windows. For Linux, update the file to use the Docker bridge IP shown in the existing comment.

## Troubleshooting

If the app shows an error about a missing application key, run:

```sh
docker compose exec notification-hub php artisan key:generate
```

If database tables are missing, run:

```sh
docker compose exec notification-hub php artisan migrate
```

If queued notifications are not being processed, make sure the queue worker is running:

```sh
docker compose exec notification-hub php artisan queue:work
```

If dependencies are missing after cloning or rebuilding the container, run:

```sh
docker compose exec notification-hub composer install
```
