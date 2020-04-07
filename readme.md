## Install
1. Clone this repository
2. Run using docker `docker-compose up -d`
3. Configure your project settings in .env file
4. Install dependencies: composer `docker-compose exec php-cli php composer install`, npm `docker-compose exec node npm install`
5. Apply migrations `docker-compose exec php-cli php artisan:migrate` 
6. Extract your backend routes for frontend usage by command: `docker-compose exec php-cli php ziggy:generate`
7. Build frontend assets `docker-compose exec node npm run dev`

The project will be awailable by URL [localhost:8080](localhost:8080).

Mail server is by [localhost:8082](localhost:8082), you can use followed configs:
`MAIL_DRIVER=smtp
MAIL_HOST=mailer
MAIL_PORT=1025
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tcp`

### Websocket server
For conversations uses Socket.io server. You should init the server on your machine.

For init socket server, with docker call command:
`docker-compose exec node laravel-echo-server init`

Or on the server: `laravel-echo-server init`

> Previously you must install all npm dependencies `npm i`

And start the server, by command: 
`docker-compose exec node laravel-echo-server start` or manually `laravel-echo-server init`

After that, configure the websocket server in .env file

## Deploy
For deploying we use Capistrano

deploy configs located:
* stag (dev server) - config/deploy/staging.rb 
* prod (production server) - config/deploy/production.rb

For deploy:
* stag - `cap staging deploy`
* prod - `cap production deploy`
