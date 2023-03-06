# OnlineJobs PH PHP Developer Test

Project Requirements

1. Using bootstrap and php (vanilla). Create a one pager blog.
2. Using PHP and MySQL, create the following features:
  - Public user can add comments only. 
  - Admin user can add/edit/delete comment(s).
  - You should showcase how you can use jquery (vue is a bonus)
  - Add a readme instructions for configurations 
  - Compress all source code and sql file into 1 file and submit
----------

# Getting started

## Architecture

----------
1. MVC Framework
1. Model Based ORM
1. OOP

## Installation

Clone the repository

    git clone https://github.com/deepfaith/onlinejobsph1-exam.git

Switch to the repo folder

    cd onlinejobsph1-exam

Modify the config file in app/config

    nano config.php

Configure Database

    #--------------------------------------------------------------------
    # DATABASE
    #--------------------------------------------------------------------
    
    // DB Config
    define('DB_HOST', 'db');
    define('DB_USER', 'root');
    define('DB_PASS', 'root');
    define('DB_NAME', 'codetest');

Configure Site Info

    /**
    #--------------------------------------------------------------------
    # SITE INFO
    #--------------------------------------------------------------------
    */
    
    // App Root
    define('APPROOT', dirname(dirname(__FILE__)));
    // URL Root
    define('URLROOT', 'http://lms.elearnified.local/codetest');
    // Site Name
    define('SITENAME', 'Coding Test');

Modify the .htaccess in the public directory

    <IfModule mod_rewrite.c>
      Options -Multiviews
      RewriteEngine On
      RewriteBase /YOUR_ROOT_DIRECTORY_FOLDERNAME/public
      RewriteCond %{REQUEST_FILENAME} !-d
      RewriteCond %{REQUEST_FILENAME} !-f
      RewriteRule  ^(.+)$ index.php?url=$1 [QSA,L]
    </IfModule>

Import the database (the file can be found in the database directory)

    mysqldump -d -u username_user -p username_dbname > mysqlfilw.sql 

Navigate the homepage using the webbrowser and login using the admin credentials

    email: admin@admin.com
    password: 12345678
