# Allt om aktier (all about stocks)

[![Build Status](https://travis-ci.org/almrooth/allt-om-aktier.svg?branch=master)](https://travis-ci.org/almrooth/allt-om-aktier)
[![Build Status](https://scrutinizer-ci.com/g/almrooth/allt-om-aktier/badges/build.png?b=master)](https://scrutinizer-ci.com/g/almrooth/allt-om-aktier/build-status/master)

The final project for the course "ramverk 1" at Blekinge Tekniska Högskola.

This is a kind of social networking site where users can register and ask, answer and comment on questions.

## Install

To install your own version of the site follow the steps below.

### Clone
Clone the repo to a directory
```
git clone https://github.com/almrooth/allt-om-aktier.git
```

### Composer update
Run composer update to install all dependencies
```
composer update
```

### Database
Make sure you have a MYSQL-database installed.

Run the SQL-code in `sql/setup.sql` to setup the database tables and insert default user `doe/doe` and `admin/admin`.

Rename `database_template.php` to `database.php`.

Edit the file so as to enable connection to your database.

### htaccess
Edit the htaccess file to suit your install. 
```
htdocs/.htaccess
```

### Views
To change the styling and look of the site feel free to edit all the files in the `view` directory.