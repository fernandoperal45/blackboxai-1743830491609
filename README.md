
Built by https://www.blackbox.ai

---

```markdown
# Shipping History Tracker

## Project Overview
The Shipping History Tracker is a web application designed to manage and track shipping records. Users can create an account, log in, and search for shipping history records based on customer purchase orders and comments. The application uses a MySQL database to store user credentials and shipping data securely.

## Installation
To set up the Shipping History Tracker locally, follow these steps:

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/shipping-history-tracker.git
   cd shipping-history-tracker
   ```

2. Set up the database:
   - Create a MySQL database and update the connection details in `config.php`.
   - Run the `setup_database.php` to create the necessary tables and insert sample data:
     ```bash
     php setup_database.php
     ```

3. Ensure you have PHP and a web server (like Apache or Nginx) installed and configured to serve the application files.

## Usage
1. Navigate to the application in your web browser:
   ```
   http://localhost/shipping-history-tracker/index.php
   ```
2. Register for a new account by filling in the required fields on the registration page.
3. Log in with your email and password.
4. Use the dashboard to search for shipping records by entering customer PO numbers and comments.

## Features
- User registration and authentication
- Secure password storage using hashing
- Ability to search for shipping records using various criteria
- A responsive UI designed with Tailwind CSS
- Admin user created during setup for easy initial access

## Dependencies
This project requires the following:
- PHP 7.2 or higher
- PDO extension for MySQL
- Tailwind CSS (included via CDN)
- A MySQL database

## Project Structure
The project contains the following files and directories:
```
/
├── config.php                # Database configuration and connection handling
├── index.php                 # Login page
├── register.php              # User registration page
├── dashboard.php             # Main dashboard for logged-in users
├── logout.php                # Logout script
├── setup_database.php        # Script to create database tables and initial data
└── uploads                   # Directory for file uploads (can be used for additional features)
```

## Security Notice
Ensure to delete the `setup_database.php` file after setting up the database to avoid exposing sensitive information and configurations.

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
```