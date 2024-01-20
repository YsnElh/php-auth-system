# PHP Authentication System

## Step 1: Import Database

- Import the provided SQL file (`auth_php.sql`) into your local MySQL database.

## Step 2: Configure Database Connection

- Open the file `includes/dbh.inc.php`.
- Modify the variables within this file to match your local database settings.

## Step 3: Configure Session Settings

- Open the file `includes/config_session.inc.php`.
- Change the value on line 9 based on your domain name. If you are using localhost, you can leave it as is.
- Adjust the value on line 10 based on the name of the folder where this project is located.

## Step 4: Set Environment Variables

- Open the file `includes/env.inc.php`.
- Modify the `APP_URL` variable based on your domain name. If you are using localhost, you can leave it as is.

Feel free to reach out if you encounter any issues or need further assistance!

## About

This PHP Authentication System provides secure authentication using the MVC (Model-View-Controller) pattern. It is designed to offer a robust and reliable solution for user authentication in web applications.
