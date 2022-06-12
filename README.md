### <sub align="center">Author: <a href="https://github.com/makhmudovazeez">Makhmudov Azizbek</a> <azeezmakhmudov@gmail.com></sub>

## Task

Clone the project:
```` 
git clone https://github.com/makhmudovazeez/rest-api.git
````

Go to folder and install dependencies:
```` 
composer install
````

#### Clone .env.example and rename to .env after that setup databases connection

I created commands with Makefile. If you have Windows operation system, please open the powershell run this command:
````
choco install make
````

Next, create a database ````make db_create```` (```php bin/console doctrine:database:create```)

Then, create a migration file ```make migration``` (```php bin/console make:migration``` )

Migrate the file with ```make migrate``` (```php bin/console doctrine:migrations:migrate```)

For uploading data to database I prepare fixtures classes ```make fixtures_load```

Finally, you can upload exchange rates by ```make command_rates``` (```php bin/console doctrine:fixtures:load```)

Serve ```symfony server:start``` the application and follow the link <a href="http://127.0.0.1:8000/api/crypto">Crypto api<a>

