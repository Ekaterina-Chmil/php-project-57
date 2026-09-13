code-setup:
	composer install
	npm ci
	npm run build
	cp -n code-env code/.env || true

test:
	composer exec -- phpunit tests

start:
	php -S localhost:8000 -t public

lint:
	composer exec -- phpcs --standard=PSR12 src tests
