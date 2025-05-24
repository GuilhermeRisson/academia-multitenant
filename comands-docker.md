up:
	docker-compose up -d --build

down:
	docker-compose down -v

restart:
	docker-compose down -v && docker-compose up -d --build

bash:
	docker exec -it laravel-app bash

mysql:
	docker exec -it mysql bash

migrate:
	docker exec -it laravel-app php artisan migrate

seed:
	docker exec -it laravel-app php artisan db:seed

migrate-seed:
	docker exec -it laravel-app php artisan migrate --seed

rollback:
	docker exec -it laravel-app php artisan migrate:rollback

composer-install:
	docker exec -it laravel-app composer install

npm-install:
	docker exec -it laravel-app npm install

npm-build:
	docker exec -it laravel-app npm run build

logs:
	docker-compose logs -f --tail=100

node:
	docker exec -it node bash
	npm run dev