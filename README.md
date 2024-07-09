# yii-backend-assignment
 Blog webapp with user authentication built with yii

Yii Web Programming Framework
=============================

 1. Make sure you web server is running and Create a database named "blogsite"
 2. modify database configuration (myblog/protected/config/main.php file to match you server settings. Default configuration is set to username: 'root' and password as " "
INSTALLATION/SETUP METHOD 1
---------------------------
        On command line, from the root of the project, type in the following commands:

            $ cd <projectDirectory>/myblog                (Linux)
              cd <projectDirectory>\myblog                 (Windows)

            $ php yiic.php migrate          (Linux) #Run the migration to set up database tables and create a test user
              yiic migrate              (Windows)


INSTALLATION/SETUP METHOD 2
        1. Make sure you web server is running and Create a database named "blogsite"
        2. import the sql database file from the database folder

Visit http://<hostname>/<projectDirectory>/myblog #replace <projectDirectory> with the project root directory
            TEST ACCOUNT:
                    username: admin
                    password:admin
REQUIREMENTS
------------

    The minimum requirement by Yii is that your Web server supports
    PHP 5.1.0 or above. Yii has been tested with Apache HTTP server
    on Windows and Linux operating systems.

    Please access the following URL to check if your Web server reaches
    the requirements by Yii, assuming "YiiPath" is where Yii is installed:

        http://hostname/YiiPath/requirements/index.php

