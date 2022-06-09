## Galactic
## Technology
This project was built with Laravel PHP while PHPCS and PHPStan are setup and configured in the codebase as static analysis tool to ensure clean, good code quality and uniform standards across the codebase following the PSR12 coding style guildlines.

- To run PHPCS configuration against the codebase locally, run the command *./vendor/bin/phpcs*
- To run PHPStan configuration against the codebase locally, run the command *./vendor/bin/phpstan analyse*


## Installation
- Clone the project to your local machine by running this command *composer install*
- Run the command *composer install*
- Run the command *php artisan key:generate*
- If .env file diesn't exist, run the command *cp .env.example .env*
- In the .env file, update the necessary information to allow connection to a database
- Run the command *php artisan migrate --seed*


The [Postman Documentation](https://documenter.getpostman.com/view/19466434/Uz5MFZ9u) link to view the endpoints request and response.