# SCU Course Equivalency System
By Thomas Nguyen, JB Anderson, Sarah Pagnani  

What we hope to achieve, is a standardized and streamlined process in assessing whether two classes between SCU and another University are equivalent - specifically for courses within the department of computer engineering. This would ensure faculty will make more informed decisions by centralizing all previous information about courses from other universities which have/have not waived courses from SCU. By doing so we can normalize the verdicts provided when students are attempting to waive their SCU courses which would provide students and faculty with fewer contradictions and re-evaluations. Ultimately, the Course Equivalency application will save faculty and students valuable time when determining what kind of courses outside of SCU are able to waive courses at SCU.

## Assumptions
 - You have access to all the files of this project
 - You will be attempting to install this project at Santa Clara University’s Engineering Computing Center and have an existing account
 - Your name is Addison  


## Initial Environment Setup
#### Personal Webpage
1. Log into your SCU ECC account
2. Open your terminal
3. Activate your webpage by entering the following commands into your terminal one line at a time
```sh
webpage
1
yes
```  
4. Wait until your request is processed and approved. You can check your status by typing the command
```sh
5
```  
5. You can find out more about webpages at these links:
```
http://wiki.helpme.engr.scu.edu/index.php/Webpage
```
```
http://wiki.helpme.engr.scu.edu/index.php/Webpage-policy
```

#### MySQL Database
Email support@engr.scu.edu and ask to have a MySQL Database set up on your account


#### Configuring Your Database
After having requested for your MySQL Database, let's set up our table structure!

To get to the MySQL command prompt, follow the instructions found here ```http://wiki.helpme.engr.scu.edu/index.php/MySQL-5#Running```. If you are unsure of what your username and password is, refer to the ```preparation``` section of the link.

You should then see a prompt that looks like this
```bash
MySQL [sdb_<YOUR ECC USERNAME>]>
```

We will then create the necessary tables in our database. Copy and paste the following into your command prompt.
```sql
CREATE TABLE Advisors (
    advisor_id INTEGER,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255)
);

CREATE TABLE Equivalencies (
    equivalency_id INTEGER,
    scu_course_name VARCHAR(255),
    scu_course_abbrv VARCHAR(255),
    nonscu_university_name VARCHAR(255),
    nonscu_course_name VARCHAR(255),
    nonscu_course_abbrv VARCHAR(255),
    approved BIT,
    notes VARCHAR(255),
    last_modified VARCHAR(255)
);
```  


## Running the Course Equivalency System
#### Moving the Project Files
1. Log into your SCU ECC account on a linux machine
2. Open the file manager
3. Right Click on the zip folder `scu-course-equivalency.zip` then click on `Extract to...` and select your Desktop
4. Open your terminal
5. Run this command to move the project files to your webpages directory. Enter your username where specified in the command.
```sh
mv ~/Desktop/scu-course-equivalency/* /webpages/<YOUR ECC USERNAME>
```

#### Connecting to the Database
Navigate to your webpages directory by running the following command in your terminal
```bash
cd /webpages/<YOUR ECC USERNAME>
```
Create and edit a file called ```db_config.php``` by running the following command
```bash
vi db_config.php
```
To type any text into the screen, hit ```i``` on your keyboard to insert. Then type the following script seen below into your file and replace your username and student ID wherever specified.
```php
<?php
$db_host = 'dbserver.engr.scu.edu';
$db_user = '<YOUR ECC USERNAME>';
$db_pass = '<YOUR SCU STUDENT ID>';
$db_name = 'sdb_<YOUR ECC USERNAME>';
?>
```  
When done hit ```Esc``` to exit insert mode. run the command ```:wq``` to save and exit the file


## Security Precautions
#### CGI (Common Gateway Interface)
We will enable the common gateway interface to make sure that other users cannot view our sensitive files. If you want further reference, please refer to ```http://wiki.helpme.engr.scu.edu/index.php/Webpage#PHP-CGI```

Open your terminal and follow these instructions  

Create the directory /webpages/username/cgi-bin, create the ```php-cgi.cgi``` file, set that file's permissions, then open the file:
```sh
mkdir -p /webpages/<YOUR ECC USERNAME>/cgi-bin
touch /webpages/<YOUR ECC USERNAME>/cgi-bin/php-cgi.cgi
chmod a+x /webpages/<YOUR ECC USERNAME>/cgi-bin/php-cgi.cgi
vi /webpages/<YOUR ECC USERNAME>/cgi-bin/php-cgi.cgi
```

Hit ```i``` on your keyboard to enter insert mode. Then enter the following contents:
```sh
#!/bin/sh
exec $HTTP_SERVER_DIR/php-cgi "$@"
```

Create the ```.htaccess``` file and open it:
```sh
vi /webpages/<YOUR ECC USERNAME>/.htaccess
```

Hit ```i``` on your keyboard to enter insert mode. Then enter the following contents:
```sh
AddType application .php
Action application /~<YOUR ECC USERNAME>/cgi-bin/php-cgi.cgi
```

Then we want to set the correct file permissions for all the following files
```sh
chmod 644 /webpages/<YOUR ECC USERNAME>/*
chmod 600 /webpages/<YOUR ECC USERNAME>/*.php
chmod 644 /webpages/<YOUR ECC USERNAME>/.htaccess
chmod 711 /webpages/<YOUR ECC USERNAME>/cgi-bin
```


You should now be able to access your website at ```http://students.engr.scu.edu/~<YOUR ECC USERNAME>/```
Please refer to the user manual for any questions about website use
