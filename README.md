# Blog_OPCR

## Code quality

## Table of contents

*  [General info](#general-info)
*  [Features](#features)
*  [Development environment](#development-environment)
*  [Install on local](#install-on-local)
*  [Install dependencies](#install-dependencies)

## General info

Project : Develop a professional blog using PHP, MVC architecture and and Twig. Include all users access and admin gestion.

## Features

### Front : users access

*  Homepage : display all posts ordered by latest. Can found a pdf CV and all social networs links.
*  Register / login page
*  Profile page : simple profile page for all registered users
*  Contact page : contact form for any question or subject
*  Blog posts page : post with comments

### Back : admin access

*  Admin pages : includes all CRUD actions

## Development environment

*  PHP 8.1.10
*  Mysql
*  Composer

## Install on local

1. Clone the repo on your local webserver : [Repository](https://github.com/mataxelle/Blog_OPCR.git).

2. Make sure you have Php and composer on your computer.

3. Create a .env file at the root of your project, same level as .env.exemple, and configure the appropriate values for your blog to run.

```
#Database standard parameters

DBHOST='localhost'
DBDATABASE='blog_opcr'
DBUSERNAME='root'
DBPASSWORD=''
```
4. Create a database and import the blog_opcr.sql file.

5. Try to connect as an admin with : `admin@hotmail.com` `azertyuiop`

## Install dependencies

Run the following command to install the dependencies : 

*  `composer install`
