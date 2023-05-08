# Blogging-Website
A blogging website with CRUD operations which includes various functionalities for registered user.

# Key Features : 
* Create/Delete/Edit Blogs.
* A dynamic Image slider.
* Register as a user.
* Search articles based on category

# Repository Structure
* partials - contains all the repetitve code.
* static
  * css - contains all the css files.
  * js - contains all the js files.
  * images - contains all the images used in the project.
  * scc - contains all the scss code.
* uploads - contains all the images used in dyanmic slider.
* Rest of the files are different components of the website into different files.

# Setup
# 1. Clone the project in the directory where you want to setup the project.
```
https://github.com/RChaubey16/Blogging-Website.git
```

# 2. Setup Virtual Host

* Setup virtual host for the project. You can refer to [this](https://www.digitalocean.com/community/tutorials/how-to-set-up-apache-virtual-hosts-on-ubuntu-16-04) to setup vhost for apache in linux.
* In the .conf file specify DocumentRoot ```path/to/folder/index.php```. Note: ```path/to/folder/``` the path which contains clone of the project.
  
# 3. Create a database
* Create a database in phpmyadmin named ```blogsite``` to store all the blog-related details.
* Open the newly created database and import the ```blogsite.sql``` file provided with the repo. (this file contains all the table structures and so on).

# 4. Create a config file.
* Place a file named "config.php" in the project directory, with the following info : 
```
<?php 

$database = [
    'host' => 'DB_hostname',
    'username' => 'DB_username',
    'password' => 'DB_password',
    'database' => 'DB_name',
];

$email = [
    'myEmail' => 'your-email',
    'myPass' => 'your-email-password',
];

?>
```
# 5. Technologies Used.
  HTML, SASS, PHP and MYSQL


# Contributors
* [RChaubey16](https://github.com/RChaubey16) (Ruturaj Chaubey).
* [Libbna](https://github.com/Libbna/) (Libbna Mathew)
* [vbadkar](https://github.com/vbadkar/) (Vivek Badkar)
