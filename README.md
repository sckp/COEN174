# SCU Course Equivalency System

## About
Currently, every Santa Clara University (SCU) graduate student who wishes to waive courses is required to prove to their advisor that they have taken an equivalent course at another university. Individual faculty advisors sit down with the student, evaluate the evidence provided, then make a decision as to whether the SCU class can be waived. The evidence varies from case to case, but advisors ask for the course’s syllabus, textbooks, assignments, and may ask the student questions about the course.

What we hope to achieve, is a standardized and streamlined process in assessing whether two classes between SCU and another University are equivalent - specifically for courses within the department of computer engineering. This would ensure faculty will make more informed decisions by centralizing all previous information about courses from other universities which have/have not waived courses from SCU. By doing so we can normalize the verdicts provided when students are attempting to waive their SCU courses which would provide students and faculty with fewer contradictions and re-evaluations. Ultimately, the Course Equivalency application will save faculty and students valuable time when determining what kind of courses outside of SCU are able to waive courses at SCU.


## Deployment
This website is currently connected to a MySQL back-end with PHP being used as our "glue" language.

If you wish to adapt this project with your own MySQL database, simply create a file called `db_config.php` with the following contents
```php
<?php
$db_host = '__Address of MySQL Server__';
$db_user = '__Your Username__';
$db_pass = '__Your Password__';
$db_name = '__Your Database Name__';
?>
```


## NOTES:
 - All PHP files needs to be chmod 600
 - cgi-bin directory needs to be chmod 711
 - .htaccess file needs to be chmod 611
