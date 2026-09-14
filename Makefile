setup:
	composer install
	cp -n .env.example .env || true
	php artisan key:generate
	npm install
	npm run build
	php artisan migrate --force

code-setup:
	composer install
	cp -n .env.example .env || true
	php artisan key:generate
	npm install
	npm run build

start:
	php artisan serve --host=0.0.0.0 --port=$(PORT)

test:
	php artisan test

lint:
	composer exec phpcs -- --standard=PSR12 app tests
