# Time Balance

## Overview
A website that allows you to create events &amp; find friends and organize your time.

## Setup Guide

1. Install XAMPP
2. (You can optionaly install Wampserver if you have windows)
3. Open xampp and start mysql and apache services
4. Open your browser and go to `localhost/phpmyadmin`
5. Login with default username and password (username: `root`, password: ``)
6. Press on the `+new` link and create a database with name `time_balance`
7. Go to the Import tab in the top panel (on the right)
8. Click `choose a file` and choose the file under `./TimeBlance/db/time_balance.sql`
9. Press Go.
10. Navigate to `./TimeBlance/php/DB.php` and change the `DB::USERNAME` and `DB::PASSWORD` variables to your phpmyadmin username and password
11. Now copy the folder `./TimeBalance` to `C:/xampp/htdocs`
12. Back to your browser paste the following url: `localhost/TimeBalance`
