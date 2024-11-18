# Test task: Order tracking system.

## Tech stack:
- PHP 8.3
- Laravel 11
- MariaDB
- Redis
- Nginx
- Docker

## Installation:
1. `git clone https://github.com/gorodyskiy/orders.git`
2. `chmod 777 orders && chmod -R 777 orders/storage && chmod -R 777 orders/bootstrap/cache`
3. `cd orders`
4. `yes | cp .env.example .env`
5. `docker compose up --build -d`
6. `docker exec app /bin/bash -c 'composer install ; php artisan migrate ; php artisan db:seed'`


## API requests:
**1. Register:**\
Host: `http://localhost/api`\
Endpoint: `/register`\
Method: `POST`\
Params: `name`, `email`, `password`, `password_confirmation`

**2. Login:**\
Host: `http://localhost/api`\
Endpoint: `/login`\
Method: `POST`\
Params: `email`, `password`

**3. Logout:**\
Host: `http://localhost/api`\
Endpoint: `/logout`\
Method: `POST`\
Authorization: `Bearer {token}`

**4. Create order:**\
Host: `http://localhost/api`\
Endpoint: `/orders`\
Method: `POST`\
Params: `product_name`, `amount`\
Authorization: `Bearer {token}`

**5. Update order:**\
Host: `http://localhost/api`\
Endpoint: `/orders/{id}`\
Method: `PUT`\
Params: `status_name`: [*new, inprogress, sent, delivered*]\
Authorization: `Bearer {token}`

**6. Delete order:**\
Host: `http://localhost/api`\
Endpoint: `/orders/{id}`\
Method: `DELETE`\
Authorization: `Bearer {token}`

**7. Get orders:**\
Host: `http://localhost/api`\
Endpoint: `/orders` or `/orders?page={num}`\
Method: `GET`\
Authorization: `Bearer {token}`

**8. Get order:**\
Host: `http://localhost/api`\
Endpoint: `/orders/{id}`\
Method: `GET`\
Authorization: `Bearer {token}`

**9. Export orders:**\
Host: `http://localhost/api`\
Endpoint: `/orders/export`\
Method: `GET`\
Authorization: `Bearer {token}`
