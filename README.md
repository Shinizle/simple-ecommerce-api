## System Requirement
- Any Operation System that can run PHP Programs.
- Minimum PHP Version: 7.4.
- Minimum MySQL Version: 5.8.
- Composer 2 Installed.

## Installation Steps

Follow the instruction below to properly install this project on your local machine,

- Clone or download this repository to your local directory.
- Add or create .env file inside the directory project then copy and paste what is writen inside .env.example file given to your .env and customize with your own local setup environment.
- Open your terminal and go to the directory folder where you install this project.
- Run, "composer install"
- Run, "php artisan key:generate"
- Run, "php artisan migrate"
- Run, "php artisan passport:install"
- Run, "php artisan db:seed --class=RoleAndPermissionSeeder"
- Now you can run the program on your local machine with your local web server such as Laragon, Valet or by php artisan:serve.

## Solution of the Task Given

As far i know the summary of the task is to prevent negative inventories and prevent incidents from occuring again. So, my solutions are sparating the quantity of the product event e.g Flash Sale 12.12 Promotion Event and add limit to max 90% of the original quantity to the event and leave 10% of the stock to normal selling. For this case i have added 2 products APIs. 1 is related to event and another one is the original product with original price and all quantity.
- By Sparating the products to 2 APIs, The Administrators must re-check the quantity of the product before they are add it to Product Event.
- Even they are not, the maximum quantity allowed to add in Product Event is only 90% so if another missreported case happen, we can still use the 10% of the stock from the original product database.

## Postman Collection

- JSON Link: https://www.getpostman.com/collections/79637f5f322152a61cd3
- Open Postman -> Import -> Link Tab -> Paste link above then import.
- Edit the collection parent folder, select OAuth 2.0 for the Authorization.
- Paste the token generated from login or register to the authorization form or set in custom variable as shown below.

### Example Postman Setting
- Open Edit Menu Collection
![alt text](https://cdn.discordapp.com/attachments/493642537576431637/947894017994141726/unknown.png)

- Set Your Custom Variable
![alt text](https://cdn.discordapp.com/attachments/493642537576431637/947893826880688158/unknown.png)

- Set Auth Token From Variable
![alt text](https://cdn.discordapp.com/attachments/493642537576431637/947894267316150302/unknown.png)

- Tokens Are Obtained From Login Or Register
![alt text](https://cdn.discordapp.com/attachments/493642537576431637/947894451592908810/unknown.png)

