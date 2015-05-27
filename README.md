dmv_symfony
===========

A Symfony implementation of the DMV Waiting In Line app at https://github.com/davidwdan/DMVApp

This example uses a SQLite database and Symfony's web server, neither are appropriate for production but this approach
has the app up and running in less than 2 minutes.

System Requirements
===================

You need to have the following installed on your system:

* composer
* bower
* PHP 5.4+

Installation
============

After cloning this repo, execute the following commands

    composer install
    cd web && bower install && cd ..
    app/console doctrine:schema:update --force
    app/console server:start 127.0.0.1:8000
    app/console thruway:process start
    
You can append a & to the final command to run it in the background.  Obviously, you can use a different port when 
starting the web server, or configure it using nginx or apache.


Usage
=====

* Open http://127.0.0.1:8000/app_dev.php/ in your browser
* Get in line, using the windows at the bottom of the screen
* Click on "Next" in the upper left (clerk window) to advance the number being served.

Any of the windows can be opened with the buttons at the bottom, this makes it easier to see the javascript debugger.


    
    
