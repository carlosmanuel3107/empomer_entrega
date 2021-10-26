# Empomer ![Tweet](https://img.shields.io/twitter/url/http/shields.io.svg?style=social&logo=twitter)

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

![Modelo físico de la BD Empomer](images/front/home.png)

Aplication Empomer : 

[Jack of all trades, master of none. Why Bootstrap Admin Templates suck.](https://medium.com/@lukaszholeczek/jack-of-all-trades-master-of-none-5ea53ef8a1f#.7eqx1bcd8)

CoreUI offers 6 versions: [Bootstrap](https://github.com/coreui/coreui-free-bootstrap-admin-template), [Angular](https://github.com/coreui/coreui-free-angular-admin-template), [Laravel](https://github.com/coreui/coreui-free-laravel-admin-template), [React.js](https://github.com/coreui/coreui-free-react-admin-template), [Vue.js](https://github.com/coreui/coreui-free-vue-admin-template), and [Vue.js + Laravel](https://github.com/coreui/coreui-free-vue-laravel-admin-template).

## Table of Contents

* [App Empomer](#app-empomer)
* [Functionalities](#functionalities)
* [Installation](#installation)
* [License](#license)
* [Support CoreUI Development](#support-coreui-development)
* [Physical model](#physical-model)
* [Models C4](#models-c4)
* [Empoemer API](#empoemer-api)
* [Empoemer Client](#empoemer-client)
* [Empoemer Developer](#empoemer-developer)

## App Empomer


> The application is made up of two parts, the Empomer API and the Empomer Client.
> The Empomer API was developed in Laravel 8 and uses MySQL as its database engine.
> The Empomer Client was developed in Vue.js 2 and Bootstrap 4 is used for the layouts. For the front part in the admin the CareUi template is used.


# Functionalities

> * Authentication system with user registration, login, password recovery and a view of the user profile.
>
> * Registration, update, deletion and list of clients.
>
> * Registration, update, deletion and
list of invoices.
>
> * Registration, update, deletion and list of offerings.
>
> * Registration, update, deletion and list of categories (service or product).
>
> * Add roles to the system (client role and admin role)

## Installation

``` bash
# clone the repo
$ git clone https://github.com/carlosmanuel3107/empomer_entrega.git

# go into app's directory
$ cd my-project/laravel

# install app's dependencies
$ composer install

# install app's dependencies
$ npm install
```

### If you choose SQLite

``` bash
# create database
$ touch database/database.sqlite
```
Copy file ".env.example", and change its name to ".env".
Then in file ".env" replace this database configuration:
* DB_CONNECTION=mysql
* DB_HOST=127.0.0.1
* DB_PORT=3306
* DB_DATABASE=empomer
* DB_USERNAME=root
* DB_PASSWORD=root

### Next step

``` bash
# in your app directory
# generate laravel APP_KEY
$ php artisan key:generate

# generate jwt secret
$ php artisan jwt:secret

# run database migration and seed
$ php artisan migrate:refresh --seed

```

```bash
# go to coreui directory
$ cd ../coreui

# install app's dependencies
$ npm install

```

### Test
``` bash
# test
$ php vendor/bin/phpunit
```

### If you need separate backend and frontend

``` bash
# back to laravel directory
$ cd ../laravel

# start local server
$ php artisan serve

$ cd ../coreui

$ npm run serve
```
Open your browser with address: [localhost:8080](localhost:8080)

If you need change backend adress go to file /coreui/src/main.js
And change line:
```js
Vue.prototype.$adress = 'http://127.0.0.1:8000'
```
## Copyright and license

copyright 2018 creativeLabs Łukasz Holeczek. Code released under [the MIT license](https://github.com/coreui/coreui-free-laravel-admin-template/blob/master/LICENSE).

## Physical model

![Modelo físico de la BD Empomer](images/bd.jpg)

## Models C4

### Context diagram

![Modelo físico de la BD Empomer](images/C4/diagrama_contexto.jpg)

### Container diagram

![Modelo físico de la BD Empomer](images/C4/diagrama_contenedor.jpg)

### Component diagram

![Modelo físico de la BD Empomer](images/C4/diagrama_componentes.jpg)

### Container diagram

![Modelo físico de la BD Empomer](images/C4/diagrama_contenedor.jpg)

### Component diagram

![Modelo físico de la BD Empomer](images/C4/diagrama_componentes.jpg)

## Empoemer API

### Categories

* Create category

![Create category](images/postman/categories/create.png)

* Update category

![Update category](images/postman/categories/update.png)

* Delete category

![ Delete category](images/postman/categories/delete.png)

* List categories

![List categories](images/postman/categories/list.png)

### Gifts

* Create gift

![Create gift](images/postman/gifts/create.png)

* Update gift

![Update gift](images/postman/gifts/update.png)

* Delete gift

![Delete gift](images/postman/gifts/delete.png)

* List gifts

![List gifts](images/postman/gifts/list.png)

### Customers

* Create customer

![Create customer](images/postman/customers/create.png)

* Update customer

![Update customer](images/postman/customers/update.png)

* Delete customer

![ Delete customer](images/postman/customers/delete.png)

* List customers

![List customers](images/postman/customers/list.png)

### Bills

* Create bill

![Create bill](images/postman/bills/create.png)

* Delete bill

![Delete bill](images/postman/bills/delete.png)

* List bills

![List bills](images/postman/bills/bills.png)

* List customer bills 

![List customer bills](images/postman/bills/bills_customer.png)


### Posts

* Create post

![Create posts](images/postman/post/create.png)

* Update post

![Update post](images/postman/post/update.png)

* Delete post

![Delete bill](images/postman/post/delete.png)

* List post

![List posts](images/postman/post/list.png)

## Empoemer Client

![1](images/front/1.png)

![2](images/front/2.png)

![3](images/front/3.png)

![4](images/front/4.png)

![5](images/front/5.png)

![6](images/front/6.png)

![7](images/front/7.png)

![8](images/front/8.png)

## Empoemer Developer

> Carlos Silva
