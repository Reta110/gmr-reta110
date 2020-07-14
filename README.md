## GMR

GMR test.

## Installation

- Clone this repository
- Execute on console:
	- composer install
- Edit dot env file with the DB config
- Run on console
	- php artisan migrate:refresh --seed
	- php artisan passport:install (And copy the second client id)
- Migrate the "Postman collection" file to postman
	- Copy de passport client_id at the "/oauth/token" endpoints

That's it. :)
