setup:
	@make build
	@make up 
	@make composer-update
build:
	docker-compose build --no-cache --force-rm
stop:
	docker-compose stop
up:
	docker-compose up -d
composer-update:
	docker exec netflix-clone bash -c "composer update"
data:
	docker exec netflix-clone bash -c "php artisan migrate:refresh --seed"
	docker exec netflix-clone bash -c "php artisan db:create-triggers"
	docker exec netflix-clone bash -c "php artisan db:create-users"


