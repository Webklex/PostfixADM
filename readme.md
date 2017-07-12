# postfixADM

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

## !!!ATTENTION!!!
This is a pre alpha version. There are several things that might break or even don't work at all.

### Currently known Issues
- Update is broken and currently a bit spooky. Don't even try it ;)
- Missing translations (Lots of german parts are remaining. But I would say round about 80% - 90% are translated)
- Uncommented code sections
- The code is not optimized.
- No setup guide (documentation) for the quota service
- Typos and weird translations
- Official website still offline (Also no active @postfixadm.com mail - please use github[at]webklex.com for now)
- And probably some more... But besides that it works like a charm :)

## Getting started

#### The easy way
Download the newest version at: [https://www.postfixadm.com](https://www.postfixadm.com) and unzip the 
content to where ever you want it to be.

#### The other way
If you like you can build your own installation package from this source:
``` bash
$ git clone https://github.com/Webklex/postfixadm.git
$ cd postfixadm
$ composer install
$ php artisan update --init
```

## Development
Copy the file ```gulp.env.example``` to ```gulp.env``` and edit the containing variables.
Now you can install the development components:
``` bash
$ npm install
$ bower install
```
You can bake everything together with the ```gulp``` command. If you want to develop a bit more fluent 
just use ```gulp watch``` instead.

## Contributing

Thank you for considering contributing to postfixADM! 
The contribution guide will be added later ;)

## Security Vulnerabilities

If you discover a security vulnerability within postfixADM, please send an 
e-mail to me at security@postfixadm.com. All security vulnerabilities will be promptly addressed.

## License

postfixADM is open-sourced software and licensed under [MIT](http://opensource.org/licenses/MIT).
