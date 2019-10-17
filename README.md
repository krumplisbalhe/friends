# FriendTimacy friendsmanager - http://friendtimacy.rita.wtf/

## Back-end

start XAMPP app

General -> Start


Services -> Apache -> Start


Services -> MySQL -> Start


Network -> Localhost:8080 -> Enable


Volumes -> Mount

PHP Myadmin and your database is now accessible here: http://localhost:8080/phpmyadmin/

And you can see the data coming from the database like so: http://localhost:9000/api/api-get-current-user.php

Make sure, that the connect.php file contains the right database credentials. When developing, on local, you can use it as is, but when deploying, the connect file has to contain the right username, password and database name. You can get this information from namecheap's Cpanel -> Databases -> MySQL Databases:
```
$sUserName = 'root';
$sPassword = '';
$sConnection = "mysql:host=localhost; dbname=friendsapp; charset=utf8mb4";
```

## Front-end

open the "friends" folder in your editor (careful, make sure that this friends project folder is the one living in the lampp -> htdocs, that we "created" with mounting before)

using terminal, navigate to "frontend" folder
```
npm run serve
```

The application is now accessible here: http://localhost:9000/


### Compiles and minifies for production
```
npm run build
```
