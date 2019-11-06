# Requirements
Most requirements are listed in `composer.json` file

But to be sure, you will need:
- Apache web server

- PHP version 7.3 or above

- Mysql server

# Installation

### 1. Clone this repository

`git clone https://github.com/neverlose-lv/rss_feed.git`

### 2. Create 2 (two) databases
-   for project
-   for project tests

### 3. Configure database urls
You should edit two files:
`.env` and `.env.test`
and change the 
`DATABASE_URL` string to connect to the databases you have created

### 4. Run the next commands
```
composer install
doctrine:migrations:migrate
doctrine:migrations:migrate --env=test
```

### 5. Configure Apache web server
Set `DocumentRoot` to point `/public` directory

Allow to override settings via `.htaccess` file

### Notes

If you meet any problems, feel free to contact me via e-mail:
volk333 [at] gmail [dot] com

# Running Tests
`./bin/phpunit`

### Tests coverage
```
Code Coverage Report:       
  2019-11-06 22:35:15       
                            
 Summary:                   
  Classes: 100.00% (8/8)    
  Methods: 100.00% (38/38)  
  Lines:   100.00% (127/127)

\App\Controller::App\Controller\RSSFeedController
  Methods: 100.00% ( 6/ 6)   Lines: 100.00% ( 37/ 37)
\App\Controller::App\Controller\RegistrationController
  Methods: 100.00% ( 2/ 2)   Lines: 100.00% ( 22/ 22)
\App\Controller::App\Controller\SecurityController
  Methods: 100.00% ( 2/ 2)   Lines: 100.00% (  6/  6)
\App\DataFixtures::App\DataFixtures\UserFixtures
  Methods: 100.00% ( 2/ 2)   Lines: 100.00% ( 10/ 10)
\App\Entity::App\Entity\TheRegisterCoUkSoftwareHeadlinesFeed
  Methods: 100.00% (13/13)   Lines: 100.00% ( 19/ 19)
\App\Entity::App\Entity\User
  Methods: 100.00% (10/10)   Lines: 100.00% ( 15/ 15)
\App\Form::App\Form\RegistrationFormType
  Methods: 100.00% ( 2/ 2)   Lines: 100.00% ( 16/ 16)
\App\Repository::App\Repository\UserRepository
  Methods: 100.00% ( 1/ 1)   Lines: 100.00% (  2/  2)
```
### Notes

Please, kindly ignore the next warning, running PHP Unit:

```
Remaining direct deprecation notices (1)

  1x: The "Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder" class is deprecated since Symfony 4.3, use "Symfony\Component\Security\Core\Encoder\NativePasswordEncoder" instead.
    1x in RSSFeedControllerTest::setUp from App\Tests\Functional\Controller
```

It is related to to symfony Password Encoder, which was changed to `bcrypt` from `auto`.
It was changed because on my local environment occurs a Segmentation Fault 11, which can be fixed, by installing another version of PHP, what I'm not going to do right now...
