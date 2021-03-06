# simple-inventory
Application is build using PHP backend, Angular frontend and MySQL database.

# PHP Backend
Backend should be used using some kind of PHP service, if you are using your own computer, then you can use XAMPP (https://www.apachefriends.org/index.html).
Put all files in \htdocs\inventoryApplication. and start apache service

# Database
 To initialize the database import warehouse.db into MySQL. If you are using XAMPP  you can use PHPMyAdmin to create a new database and import tables using warehouse.db , or run code that is in that file. Don't forget to setup your host, database name, username and password in Api/config/database.php file.

# Angular Application

This project was generated with [Angular CLI](https://github.com/angular/angular-cli) version 8.3.5.


## Prerequisites
- [Node.js](https://nodejs.org) >= 8.9.x - Node.js is a JavaScript runtime
  - `node -v`
- [npm](https://www.npmjs.com) >= 6.9 - Node.js Package Manager
  - `npm -v`
- TypeScript >= 3.5.3
  - `npm install -g typescript`
- [Angular CLI](https://github.com/angular/angular-cli) - Angular Command Line Interface
  - `npm install -g @angular/cli`
- [Now CLI](https://www.npmjs.com/package/now) - Now Command Line Interface is universal serverless single command deployment
  - `npm install -g now`

## Development server

Run `ng serve` for a dev server. Navigate to `http://localhost:4200/`. The app will automatically reload if you change any of the source files.

## Code scaffolding

Run `ng generate component component-name` to generate a new component. You can also use `ng generate directive|pipe|service|class|guard|interface|enum|module`.

## Build

Run `ng build` to build the project. The build artifacts will be stored in the `dist/` directory. Use the `--prod` flag for a production build.

## Running unit tests

Run `ng test` to execute the unit tests via [Karma](https://karma-runner.github.io).

## Running end-to-end tests

Run `ng e2e` to execute the end-to-end tests via [Protractor](http://www.protractortest.org/).

## Further help

To get more help on the Angular CLI use `ng help` or go check out the [Angular CLI README](https://github.com/angular/angular-cli/blob/master/README.md).
