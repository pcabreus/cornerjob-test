A Coffee Stock for CornerJob
============================

Features
--------

1. Security based on user roles.
2. Using JWT to protect resources
3. CRUD of User by admin
4. CRUD of Coffee by admin
5. CRUD of Order by admin
6. List Coffees by customer
7. Buy Coffee by customer

Main Tools
----------

* Docker
* Symfony
* Api-Platform
* PhpUnit
* MySql
* Apache

Installing steps
---------------

1. Clone the project
    
    ~$ git clone https://github.com/pcabreus/cornerjob-test.git
    ~$ cd cornerjob/

2. Build and up docker (Used generic docker for sf4)

    ~/cornerjob$ docker-compose build
    ~/cornerjob$ docker-compose up -d

3. Go into the php container in order to set up the db and basic configs

    ~/cornerjob$ docker exec -it sf4_php bash
    cd 
    
4. Run symfony commands:

GO into the code:

    dev@xxx:/home/wwwroot/$ cd sf4

Install dependencies:
    
    dev@xxx:/home/wwwroot/sf4$ composer update

Load data:
    
    dev@xxx:/home/wwwroot/sf4$ php bin/console doctrine:schema:update --force
    dev@xxx:/home/wwwroot/sf4$ php bin/console doctrine:fixtures:load

Create secure keys:
    
    dev@xxx:/home/wwwroot/sf4$ mkdir config/jwt

Use phrase `secreto` for all (Just for the test ok!?):

    dev@xxx:/home/wwwroot/sf4$ openssl genrsa -out config/jwt/private.pem -aes256 4096
    dev@xxx:/home/wwwroot/sf4$ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

Run test:

    dev@xxx:/home/wwwroot/sf4$ php bin/phpunit
    

    