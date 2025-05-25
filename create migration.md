php artisan make:migration xxxxxxx --path=database/migrations/tenant

docker exec -it laravel-app bash
php artisan tenants:migrate


Rodar refresh em todos tenants (rollback + migrate):

php artisan tenants:migrate-fresh

