up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down-clear docker-pull docker-build docker-up app-init
test: manager-test
test-coverage: manager-test-coverage
test-unit: manager-test-unit
test-unit-coverage: manager-test-unit-coverage

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

app-init:
	app-composer-install app-assets-install app-wait-db app-migrations

app-composer-install:
	docker-compose run --rm php-cli composer install

assets-watch:
	docker-compose exec node npm run watch

assets-dev:
	docker-compose exec node npm run dev

app-assets-install:
	docker-compose run --rm node yarn install
	docker-compose run --rm node npm rebuild node-sass

app-wait-db:
	until docker-compose exec -T mysql pg_isready --timeout=0 --dbname=app ; do sleep 1 ; done

app-migrations:
	docker-compose run --rm php-cli php artisan:migrate --no-interaction

queue-listen:
	docker-compose exec php-cli php artisan queue:work --daemon

socket-init:
	docker-compose exec node laravel-echo-server init

socket-start:
	docker-compose exec node laravel-echo-server start --force
