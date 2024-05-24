default:

lint:
	./vendor/bin/sail php ./vendor/bin/pint

test:
	./vendor/bin/sail php ./vendor/bin/pint

lint-test:
	./vendor/bin/sail php ./vendor/bin/pint && ./vendor/bin/sail php artisan test

migrate:
	./vendor/bin/sail artisan migrate:fresh

migrate-seed:
	./vendor/bin/sail artisan migrate:fresh && ./vendor/bin/sail artisan db:seed

doc:
	./vendor/bin/sail npm run doc
