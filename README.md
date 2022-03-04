<h1>BookLand</h1>

<h3>Project Setup </h3>

<p>    1. cp .env.example .env </p>
<p>    2. docker-compose -f docker-compose.yml --env-file .docker-env up --build -d </p>
<p>    3. docker-compose exec app composer install </p>
<p>    4. docker-compose exec app php artisan key:generate </p>
<p>    5. docker-compose exec app php artisan jwt:secret </p>
<p>    6. docker-compose exec app php artisan migrate </p>
<p>    7. docker-compose exec app php artisan db:seed </p>

Done.

You can see book list on http://localhost/api/v1/client/book

<h3>Usage of Project</h3>

<h4> POINTS: </h4>

<p> () You have to log in as author to <b> create</b> a book.</p>
<p> () You have to log in as publisher to <b> publish </b> a book </p>
 
<h4>Usage</h4>

in postman folder, The are postman collection and environment. You can Import it in postman. There are APIs to create book, publish book and etc..
