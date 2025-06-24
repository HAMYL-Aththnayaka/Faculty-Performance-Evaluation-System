# Faculty Evaluation System

---

## Author Information

**Name:** Aththanayaka HAMYL  
**Registration Number:** 2021ICT14  
**University:** University of Vavuniya  
**Faculty:** Faculty of Applied Science  
**Year:** 2nd Year BSc IT  

---

## Project Overview

The **Faculty Evaluation System** is a web-based application developed to streamline the process of evaluating faculty members and collecting student feedback at the University of Vavuniya. The system provides a secure and intuitive interface for students (evaluators) to submit evaluations and feedback, and for administrators to manage notices, users, and reports.

The system is designed with a focus on usability, security, and performance, employing PHP for server-side scripting and MongoDB as the NoSQL database for flexible data management.

---

## Key Features

- **User Authentication & Authorization**  
  Secure login and role-based access control for Evaluators and Admins.

- **Evaluation Submission**  
  Users can evaluate faculty based on various criteria such as Teaching, Research, Service, Communication Skills, and Use of Technology.

- **Feedback Collection**  
  Students provide detailed feedback with input validation and word count limits.

- **Notice Management**  
  Admins can create, view, and delete notices visible to all users.

- **User Management**  
  Admins can view, edit, and delete user profiles securely.

- **Dashboard & Reports**  
  Admin dashboard presents summary statistics including total evaluators, feedback counts, and notices.

- **Contact Us Form**  
  Collects user inquiries and messages securely stored in MongoDB.

---

## Technologies Used

| Technology       | Purpose                       |
|------------------|-------------------------------|
| PHP              | Backend server-side scripting |
| MongoDB          | NoSQL database                |
| HTML5 & CSS3     | Frontend structure and styling|
| JavaScript       | Dynamic UI elements           |
| MongoDB PHP Driver | Database connectivity        |

---

## Installation & Setup Instructions

1. **Clone the repository**

   ```bash
   git clone https://github.com/yourusername/Faculty-Evaluation-System.git
Install PHP and MongoDB

Ensure PHP (version 7.4 or later) is installed.

Install and run MongoDB (Community Edition).

Install PHP MongoDB extension

bash
Copy code
sudo pecl install mongodb
And enable it in your php.ini:

ini
Copy code
extension=mongodb.so
Configure database connection

Update the DB/connectionDB.php file with your MongoDB URI if different.

Deploy project

Place the project folder inside your web server root (e.g., XAMPP’s htdocs folder).

Start Apache and MongoDB services.

Access the application

Open a browser and navigate to:

bash
Copy code
http://localhost/Faculty-Evaluation-System/index.php
Project Structure
bash
Copy code

Faculty-Evaluation-System/
│
├── DB/                       # Database connection and authentication scripts
│   ├── connectionDB.php
│   ├── evaluationAuthentication.php
│   ├── addNoticeAuthentication.php
│   ├── feedbackValidation.php
│   ├── loginAuthentication.php
│   └── ...                  
│
├── css/                      # Stylesheets
│   └── style.css
│
├── reports/                  # Reporting features
│   └── report.php
│
├── index.php                 # Main user dashboard
├── login.php                 # Login page
├── logout.php                # Logout script
├── registration.php          # User registration page
├── reset_password.php        # Password reset page
├── add_notice.php            # Admin add notice page
├── contact_us.php            # Contact form page
├── evaluation_form.php       # Faculty evaluation form
├── feedback_form.php         # Student feedback form
├── dashboard_admin.php       # Admin dashboard overview
├── manage_user.php           # Admin user management
├── edit_user.php             # Edit user profiles
├── delete_feedback.php       # Feedback deletion script
├── delete_user.php           # User deletion script
├── deleteNotice.php          # Notice deletion script
└── README.md                 # Project documentation


-- Students/Evaluators can:

Register and login.

Submit faculty evaluations.

Provide detailed feedback.

View notices posted by the administration.

-- Administrators can:

Manage user accounts (edit/delete).

Post and manage notices.

View summary statistics on the dashboard.

Access reports on feedback and evaluations.

Security & Validation
Passwords are securely hashed using PHP’s password_hash() function.

-- All user inputs are sanitized to prevent XSS and injection attacks.

Session management ensures secure user authentication.

Form validation both client-side and server-side to maintain data integrity.

# Sample View

![image](https://github.com/user-attachments/assets/da6dc1d7-8ff2-4226-a3a3-5249bbe0a071)

![image](https://github.com/user-attachments/assets/188aac91-be6d-4d62-ab62-4fd94f0e31be)

![image](https://github.com/user-attachments/assets/5e8651a2-687d-4c90-b933-7c4e080fe5ca)

![image](https://github.com/user-attachments/assets/dd7a4e97-a416-4a79-9235-ea4c751eb5af)

![image](https://github.com/user-attachments/assets/117c2f4f-e7bb-4d3e-bb61-b65405bb8234)

![image](https://github.com/user-attachments/assets/8030d13e-43d9-4678-9427-81513ba312a6)

![image](https://github.com/user-attachments/assets/998e55d0-9083-4c65-9113-4fb7a32a63b3)

![image](https://github.com/user-attachments/assets/56cf2a15-374b-410d-a7b6-cc3f45979de3)

![image](https://github.com/user-attachments/assets/05bb22e7-319b-4dba-80ea-030990a2cce0)

![image](https://github.com/user-attachments/assets/b71929fd-da9e-4d3b-9bcc-5c4739a779d1)


# Future Improvements
Add email verification and password recovery workflows.

Integrate analytics dashboard with charts and graphs.

Implement role-based feature toggling with advanced permissions.

Mobile-friendly responsive design enhancements.

Expand feedback categories and add anonymous feedback option.

# Contact
For any questions, issues, or collaboration opportunities, please contact:

Aththanayaka HAMYL
Email: [aththanayakayasas@]
University of Vavuniya – Faculty of Applied Science

© 2025 Faculty Evaluation System – University of Vavuniya
