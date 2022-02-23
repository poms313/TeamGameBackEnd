# Technical Requirements

Technical Requirements o for computer for run the project:

Composer:
https://getcomposer.org/download/

Symfony:
https://symfony.com/doc/current/setup.html

GitHub:
https://docs.github.com/en/repositories/creating-and-managing-repositories/cloning-a-repository


## Step 1 - Install the project

in command prompt:
`git clone https://github.com/poms313/testHumansix`


then:
`composer install` 

 fichier .env du projet, et modifier la variable d'environnement selon vos paramètres :
        

### Step 2 - Create database

change the database url in .env with your parameters:
#DATABASE_URL="mysql://{userName}:{$password}@{127.0.0.1:3306 or other}/{databaseName}?{serverVersion}"

or create local .env by using 
`composer dump-env prod`


then, add entity to the database:
`symfony console doctrine:database:create`,
`php bin/console make:migration`,
`php bin/console doctrine:migrations:migrate`


###### Step 3 - start

For startoing the project, write:
`symfony server:start`

It run on: http://127.0.0.1:8000/

Or, it's actualy deploy on http://team-game.pommine-fillatre.com + 
- list all players: /list/all/players
- get one player: /get/player/{id}
- modify player: /modify/player/{formData}
- create game: /game/create
- game result: /game/result/{formData}
