# Armarius CMS

## Local

### Requirements

This project has a few requirements you should be aware of before installing:

* Laravel Framework 10.0+
* Vite 5 & Vue.js 3
* Node.js & NPM

### Installing

Clone the repository using:

```
git clone https://gitlab.com/slym-io/[PROJECT_NAME]
```

Install all dependencies listed on *package.json* using:

```
npm install
```

Install all dependencies listed on *composer.json* using:

```
php composer.phar install
```

Create the *.env* file using *.env.example* and generate the key using:

```
php artisan key:generate
```

Launch migrations using:

```
php artisan migrate
```

### Updating

Pull repository using:

```
git pull 
```

Update installation using:
```
php composer.phar local
```

## Built With

* [Laravel](https://laravel.com/) - PHP framework
* [Composer](https://getcomposer.org/) - PHP Package Manager
* [Vue.js](https://vuejs.org) - JS Package Manager
* [Vite](https://vitejs.dev) - JS Generation Tool
* [NPM](https://www.npmjs.com/) - JS Package Manager
