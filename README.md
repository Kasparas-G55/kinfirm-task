# Project Development Setup

1. Configure environment file:
    > Make .env file by copying .env.example

2. Installing composer dependecies:
    > composer install

3. Installing node modules:
    > npm install

4. Building front-end with Vite:
    > npm run build

5. Create SQLite database and migrate database:
    > php artisan migrate

6. Generate app key:
    > php artisan key:generate

7. Run app:
    > composer run dev

*More commands below for populating the database.*

## Commands

- `php artisan app:sync:products`

    Dispatches a job that retrieves `products` and stores it in the database. *(Products that don't exist inside `products.json`, get deleted)*

- `php artisan app:sync:stocks`

    Simple command that gets `stocks` and stores it in the database. *(Stock gets added only if a `product` with the same `SKU` exists.)*
