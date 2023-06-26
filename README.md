# GuepardoSys - Gerenciador de Produtos e Pedidos

(WIP) App para gerenciamento de produtos, categorias e pedidos de marketplaces e afins.

![alt text](https://github.com/dougkusanagi/guepardosys-hub/blob/main/docs/screenshot-themes.png?raw=true)

## Install

1. Clone repository

```shell
git clone https://github.com/dougkusanagi/guepardosys-hub
```

2. Install composer dependencies

```shell
composer install
```

3. Make a copy of .env.example and rename to .env

```shell
cp .env.example .env
```

4. Create a database and adjust the env variables according

5. Run migrations

```shell
php artisan migrate:fresh --seed
```

or use this for create many product examples

```shell
php artisan migrate:fresh --seed --seeder=CompleteSeeder
```

3. Install node dependencies

```shell
yarn install
```

4. Build vue resources

```shell
yarn build
```

## Example credencials are:

```
login: example@email.com
password: password
```
