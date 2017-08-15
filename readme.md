# postfixADM
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)

## About postfixADM
postfixADM is a modern postfix management tool. It is designed to work with almost any setup that is 
based on postfix, dovecot and mysql.

**Some of the key features are:**
- Easy web installation and setup
- Fully responsive
- Database mapping
- Supports over 22 crypto algorithms
- Mailbox management
- Alias management
- Domain management
- Optional Quota-Service
- User management & ACL
- System updater integrated
- English and German language supported

**Based on:**
- Laravel 5.4
- AngularJS 1.6
- Angular Material

**Requirements:**
- MySQL 
- PHP 5.6
- Apache2 or Nginx 1.6
- doveadm (dovecot-core)

**Developed and compiled with:**
- Gulp
- Bower
- Composer
- NPM / NodeJS

Fore more information please visit: [https://www.postfixadm.com](https://www.postfixadm.com)

### Screenshots
![Installer General](https://www.webklex.com/wp-content/uploads/installer_general.png)
![Installer Databse mapping](https://www.webklex.com/wp-content/uploads/installer_database.png)

## Getting started

#### The easy way
Download the newest version at: [https://www.postfixadm.com/download](https://www.postfixadm.com/download) and unzip the 
content to where ever you want it to be.

#### The other way
If you like you can build your own installation package from this source:
``` bash
$ git clone https://github.com/Webklex/postfixadm.git
$ cd postfixadm
$ composer install
$ php artisan update --init
$ cp gulp.env.example gulp.env
```
Open ```gulp.env``` and enter your environment name and development domain.
``` bash
$ npm install
$ bower install
$ gulp && gulp watch
```

## Optional: Quota service
If you like you can enable a quota service which allows you to keep an eye on your mailbox quota usage.
Please refer to [https://www.postfixadm.com/wiki/setup/quota_service](https://www.postfixadm.com/wiki/setup/quota_service)
for more details.

## Development
Copy the file ```gulp.env.example``` to ```gulp.env``` and edit the containing variables.
Now you can install the development components:
``` bash
$ npm install
$ bower install
```
You can bake everything together with the ```gulp``` command. If you want to develop a bit more fluent 
just use ```gulp watch``` instead.

### Currently known Issues
- Missing or weird translations (please let me know if you find any - you'll get a cookie as well).
- Uncommented code sections.
- The code is not optimized.
- (inactive @postfixadm.com mail addresses - please use github[at]webklex.com for now)
- And probably some more... But besides that it works like a charm :)


## Contributing

Thank you for considering contributing to postfixADM! 
The contribution guide will be added later ;)

## Security Vulnerabilities

If you discover a security vulnerability within postfixADM, please send an 
e-mail to me at security@postfixadm.com. All security vulnerabilities will be promptly addressed.

## License

postfixADM is open-sourced software and licensed under [MIT](http://opensource.org/licenses/MIT).

[ico-version]: https://img.shields.io/packagist/v/Webklex/PostfixADM.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/Webklex/PostfixADM/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/Webklex/PostfixADM.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Webklex/PostfixADM.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/Webklex/PostfixADM.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/Webklex/PostfixADM
[link-travis]: https://travis-ci.org/Webklex/PostfixADM
[link-scrutinizer]: https://scrutinizer-ci.com/g/Webklex/PostfixADM/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/Webklex/PostfixADM
[link-downloads]: https://packagist.org/packages/Webklex/PostfixADM
[link-author]: https://github.com/webklex