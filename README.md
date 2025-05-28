# 📚 Library System

A web-based Library Management System developed for BSIT 3E CC-106. This application facilitates the management of books, borrowers, and lending activities within a library setting.

## 🛠️ Technologies Used

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL

## 📁 Project Structure

library-system/  
   • assets/        # Static assets like images, CSS, and JavaScript files  
   • config/        # Configuration files (e.g., database connection)  
   • database/      # SQL scripts for database setup  
   • includes/      # Reusable PHP components (e.g., headers, footers)  
   • pages/         # Main PHP pages for different functionalities  
   • scripts/       # JavaScript scripts for dynamic behaviors  
   • index.php      # Entry point of the application  
   • LICENSE        # Licensing information defining terms of use and distribution  
   • README.md      # Project documentation  


## 🚀 Installation and Setup

### Prerequisites

- **Web Server**: [XAMPP](https://www.apachefriends.org/index.html) or [WAMP](https://www.wampserver.com/en/) (includes Apache, PHP, and MySQL)
- **Browser**: Modern web browser (e.g., Chrome, Firefox)

### Steps

1. **Clone the Repository**

   ```bash
   git clone https://github.com/Rampy11/library-system.git

2. **Move to Web Server Directory**

   * For XAMPP:

     * Move the `library-system` folder to `C:\xampp\htdocs\`
   * For WAMP:

     * Move the `library-system` folder to `C:\wamp\www\`

3. **Import the Database**

   * Open **phpMyAdmin** (usually at `http://localhost/phpmyadmin/`)
   * Create a new database (e.g., `library_db`)
   * Import the SQL script:

     * Navigate to the `database/` directory in the project
     * Import the provided `.sql` file to set up the necessary tables and data

4. **Configure Database Connection**

   * Open the `config/` directory
   * Locate the database configuration file (e.g., `db_config.php`)
   * Update the database credentials to match your setup:

     ```php
     <?php
     $host = 'localhost';
     $user = 'root';
     $password = '';
     $database = 'library_db';
     ?>
     ```

5. **Run the Application**

   * Start the Apache and MySQL services via your web server control panel
   * Open your browser and navigate to:

     ```
     http://localhost/library-system/
     ```
     ## 📸 Screenshots
     ![image](https://github.com/user-attachments/assets/485e99ff-6d56-4116-a92d-de23e7553165)
     ![image](https://github.com/user-attachments/assets/6ca7e3c6-fda3-46f6-890c-fb8a9656c91c)
     ![image](https://github.com/user-attachments/assets/a3e8f5bd-1cca-4d55-bb8b-6fdf404fc0df)
     ![image](https://github.com/user-attachments/assets/8e72aaf0-65e8-4a37-8c87-5facda54c186)
     ![image](https://github.com/user-attachments/assets/934c908c-4bba-4459-a618-c586f89fc506)
     ![image](https://github.com/user-attachments/assets/dc8615ea-4157-42a9-81be-3d01218be4a3)

     ## 📄 License

     This project is licensed under the [MIT License](LICENSE).

     ## 📬 Contact

     Developed by: John Steven A. Macapañas | Charles V. Abaigar | Cathylyn J. Abueva | Charles Glenn D. Avila | Leo A. Gabrino
