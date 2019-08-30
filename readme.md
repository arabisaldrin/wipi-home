## wiPi-Home Admin

A simple freeradius [Captive portal](https://github.com/aaldrin23/wipi-portal) management system made with Laravel 5.8,Vuejs and Vuetify

This project was inspired by [Kupiki-hostpot](https://github.com/Kupiki) for raspberry-pi

Kupiki-hostpot is awesome but suddenly I run into an issue so just decided to configure my rpi and create an admin and portal app on my own for home use


### Features

* Simple Authentication
* Operators Management
* Plans, Vouchers and Users/Client Management
* Dashboard with beautiful graphs made from [chart.js](https://www.chartjs.org/)
* Some websockets functionality such as logout event, voucher used event notification using [laravel-websockets server](https://github.com/beyondcode/laravel-websockets) 

### Screenshots

Login Page
![Dashboard](https://raw.githubusercontent.com/aaldrin23/wipi-home/master/screenshots/screencapture-wipi-home-test-login-2019-08-30-23_18_54.png)

Dashboard
![Dashboard](https://raw.githubusercontent.com/aaldrin23/wipi-home/master/screenshots/screencapture-wipi-home-test-2019-08-30-23_19_15.png)

[See others](https://github.com/aaldrin23/wipi-home/tree/master/screenshots)


### Requirements
* laravel 5.8
* Mysql server ^5.7
* Composer
* Nodejs ^8
* Freeradius database


### Development
```
> npm install  
> npm run hot  
```
```
> composer install 
> php artisan migrate:install 
> php artisan migrate 
> php artisan serve 
``` 
```
> php artisan websockets:serve
```

### Found bugs or issue?
Just fix it your self! just kidding XD


### Notes
Make sure to provide your own vouchers printing method  
I used [Jasper report](https://community.jaspersoft.com/) (server and studio), just check it out

Don't forget the [wiPi-portal](https://github.com/aaldrin23/wipi-portal)