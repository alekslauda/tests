# Tests Solutions

Check below the steps for set up and play around with the project.

## Background

> Tests repo contains two tests for checking developer FE and BE knowledge. First one is the backend tests that from a given text file representing tree file structure one should parse and obtain all tree nodes and store them in DB. Second one is a simple CONTACT create form which one should validate on the FE and on the BE, and also store the resource if valid in the file system of the project and perform basic CRUD operations. One could not use any frameworks as Laravel, Symfony etc, and should handle those by himself.

## Installation

Open your terminal and type in

```sh
$ git clone git@github.com:alekslauda/tests.git
$ cd tests

## IF NO COMPOSER
## RUN THE FOLLOWING
####################################
$ cd ~/
$ wget https://getcomposer.org/composer.phar
$ php composer.phar [command]
####################################

$ composer install
$ composer dump-autoload
```

## IMPORTANT FILES

```text
tests
├── app
│   └── test-files
│       ├── file_structure.txt -> contains the representation of the file tree structure
│       ├── contacts.txt -> file will be created if not exsists after one play arround with the Tests Solution 2
|   └── sql
│       ├── tree_structure_table.sql -> required to store file paths in a DB so a search can be performed with the Tests Solution 1

```

## PLAY AROUND (Tests Solution 1)

* As mentioned above within the dir ```/test-files``` an example tree representation file exists, but one could use a external file as long as file exists.
* To use an external file, one should specify the path of the file, if not , the default one will be used
* within the project dir ```tests``` run the command ```php index.php``` to seed the database with tree nodes parsed from the default file 
* if one wants to use an external file, use the command as follows: ```php index.php --path="C:\Program Files\ExternalFile.txt"``` or ```php index.php --path="/Users/mojojojo/external_file.txt"```
* One should see an success message showing how many entries were inserted
* now, we have to start a server an see our solutions in action
* run ```php -S localhost:8000``` (NOTE THAT AN EXCEPTION WILL BE THROWN IF SERVER IS NOT THE GIVEN ONE(```loclahost:8000```))
* project web address should be: ```localhost:8000```
* after server is served, 
* one should open the browser and navigate to: ```http://localhost:8000``` and be placed on the home screen web page and can play arround with the solutions

## PLAY AROUND (Tests Solution 2)

* to start with Solution 2, one just have to serve the web server within the ```tests``` (project dir)
* one should open the browser and navigate to: ```http://localhost:8000```
