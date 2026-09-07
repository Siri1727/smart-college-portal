# 🎓 Smart College Portal

A web-based college management system designed to simplify academic activities such as **attendance management, notice sharing, student achievement tracking, and certificate verification**.

The system provides separate role-based interfaces for **Students, Faculty, and Certificate Verifiers**, allowing each user to access features relevant to their responsibilities.

---

## 📌 Project Overview

Managing academic information using manual records or multiple disconnected platforms can make it difficult for students and faculty to access important information efficiently.

This project was developed as an **academic mini project by a team of four members**.

The **Smart College Portal** provides a centralized platform where:

* Students can monitor their attendance and achievements.
* Faculty can mark attendance and publish notices.
* Certificate verifiers can review and verify certificates uploaded by students.

The portal is developed using **PHP, MySQL, HTML, CSS, and JavaScript** and can be run locally using **XAMPP and phpMyAdmin**.

---

## ✨ Features

### 🎓 Student Module

Students can:

* 🔐 Login using their registration number and password
* 👤 View and manage their profile
* 📊 View subject-wise attendance
* 📅 Filter attendance by date or date range
* 📢 View notices relevant to their branch and year
* 🔔 Receive an indication when new notices are available
* 🏆 Add achievements
* 📄 Upload certificates and awards
* 📋 View previously uploaded achievements
* ✅ Check the verification status of submitted certificates

---

### 👨‍🏫 Faculty Module

Faculty members can:

* 🔐 Login using faculty credentials
* 👤 Access their faculty profile
* 📝 Mark student attendance
* 📢 Post academic notices and announcements
* 🎯 Send notices to relevant students
* 📜 View previously posted notices
* ✏️ Edit posted notices
* 🗑️ Delete notices
* 🚪 Securely logout from the system

---

### ✅ Certificate Verifier Module

Certificate verifiers can:

* 🔐 Login through a dedicated verifier account
* 📊 View the certificate verification dashboard
* 📄 View certificates uploaded by students
* ⏳ Monitor pending certificates
* ✅ View verified certificates
* 🔎 Filter certificates based on achievement type and date
* 📥 Access uploaded certificate files
* ✔️ Verify student certificates
* 👤 Manage their profile

---

## 🏆 Achievement Management

Students can maintain a digital record of their achievements inside the portal.

Supported achievement categories include:

* Internship
* Hackathon
* Workshop
* Certification
* Seminar
* Sports
* Cultural
* Placement
* Other achievements

Students can provide the achievement title, date, description, type, and supporting certificate.

The submitted certificate can then be reviewed by an authorized **Certificate Verifier**.

---

## 📊 Attendance Management

The attendance module allows faculty members to record student attendance while students can monitor their attendance through their dashboard.

Students can view:

* Subject name
* Total periods held
* Total periods attended
* Attendance percentage

Attendance reports can also be filtered using options such as:

* Till Today
* This Month
* Custom Date Range

This helps students continuously monitor their attendance instead of depending on manually maintained records.

---

## 📢 Notice Management

Faculty members can publish academic notices through the portal.

Notices can be delivered based on student information such as **branch and year**, helping ensure that announcements reach the appropriate students.

Students can access notices from their dashboard, and the portal provides a notification indicator when unread notices are available.

Faculty members can also manage their notice history by viewing, editing, or deleting previously published notices.

---

## 🔐 Role-Based Access

The portal supports three different user roles:

| Role                   | Main Responsibilities                            |
| ---------------------- | ------------------------------------------------ |
| 🎓 Student             | View attendance, notices and manage achievements |
| 👨‍🏫 Faculty          | Mark attendance and manage notices               |
| ✅ Certificate Verifier | Review and verify student certificates           |

PHP sessions are used to maintain user login information and restrict access to role-specific pages.

---

## 🛠️ Technology Stack

| Technology | Purpose                       |
| ---------- | ----------------------------- |
| HTML5      | Web page structure            |
| CSS3       | Styling and user interface    |
| JavaScript | Client-side interaction       |
| PHP        | Server-side application logic |
| MySQL      | Database management           |
| XAMPP      | Local Apache and MySQL server |
| phpMyAdmin | MySQL database administration |

---

## 📁 Project Structure

```text
smart_college_portal/
│
├── images/                         # Images and uploaded resources
├── src/                            # Additional project resources
│
├── login.php                       # Main login page
├── logout.php                      # Logout functionality
│
├── dashboard.php                   # Student dashboard
├── profile.php                     # Student profile
├── edit_profile.php                # Edit student profile
│
├── attendance.php                  # Student attendance report
├── mark_attendance.php             # Faculty attendance page
├── save_attendance.php             # Save attendance data
│
├── notice_board.php                # Student notice board
├── post_notice.php                 # Faculty posts notices
├── faculty_notice_history.php      # Faculty notice history
├── edit_notice.php                 # Edit notices
├── delete_notice.php               # Delete notices
│
├── add_achievement.php             # Upload student achievements
├── view_achievements.php           # View student achievements
│
├── faculty_dashboard.php           # Faculty dashboard
├── faculty_profile.php             # Faculty profile
├── edit_faculty_profile.php        # Edit faculty profile
│
├── certificate_dashboard.php       # Certificate dashboard
├── verifier_dashboard.php          # Certificate verifier dashboard
├── verify_certificate.php          # Certificate verification
├── verify_certificates.php         # View certificates for verification
├── certificate_profile.php         # Verifier profile
├── edit_certificate_profile.php    # Edit verifier profile
├── certificate_logout.php          # Verifier logout
│
├── db_connect.php                  # Database connection
├── send_mail.php                   # Email functionality
├── style.css                       # Main stylesheet
├── script.js                       # JavaScript functionality
│
└── .gitignore
```

---

## ⚙️ Installation and Setup

### 1. Install XAMPP

Install XAMPP and start:

```text
Apache
MySQL
```

---

### 2. Clone the Repository

Open a terminal inside the XAMPP `htdocs` directory and run:

```bash
git clone https://github.com/pedagadimanojna/smart_college_portal.git
```

Or download the repository as a ZIP file and extract it into:

```text
C:\xampp\htdocs\
```

The resulting folder should look like:

```text
C:\xampp\htdocs\smart_college_portal
```

---

### 3. Configure the Database

The application uses a MySQL database named `college_portal`.

> **Note:** The database is not included in this repository because it contains private institutional and student data.

The database should be configured locally using **MySQL/phpMyAdmin**.

The default local database configuration used by the project is:

```text
Host     : localhost
Username : root
Password : [empty]
Database : college_portal
```

If your MySQL configuration is different, update the database credentials in `db_connect.php` accordingly.

A demo database containing sample data may be added in a future version.

---

### 4. Run the Project

Make sure **Apache** and **MySQL** are running in XAMPP.

Then open:

```text
http://localhost/smart_college_portal/login.php
```

The Smart College Portal login page should appear.

---

## 🔄 Basic Workflow

```text
                         SMART COLLEGE PORTAL
                                  │
                                Login
                                  │
              ┌───────────────────┼───────────────────┐
              │                   │                   │
           Student             Faculty        Certificate Verifier
              │                   │                   │
       ┌──────┼──────┐      ┌─────┼─────┐       Review Certificates
       │      │      │      │           │                │
 Attendance Notices Achievement Attendance  Notices   Verify/Approve
                     │
              Upload Certificate
                     │
                     └──────────────────────────────►
                         Certificate Verification
```

---

## 🎯 Objectives

The main objectives of the Smart College Portal are:

* Digitize important college academic activities
* Reduce dependency on manual record keeping
* Provide students with easy access to attendance information
* Improve communication between faculty and students
* Maintain student achievements digitally
* Provide a structured certificate verification process
* Provide role-based access to different users
* Centralize important academic information in a single portal

---

## 🚀 Future Enhancements

The project can be extended with practical enhancements such as:

* 📱 **Responsive Design** – Improve the portal for easy use on mobile phones and tablets.
* 📧 **Email Notifications** – Notify students about important notices and certificate verification updates.
* 📊 **Attendance Analytics** – Provide simple attendance statistics and alerts for students with low attendance.
* 🔒 **Enhanced Security** – Improve authentication using password hashing and secure database queries.

---

## 💡 Advantages

* Centralized academic information
* Easy attendance monitoring
* Faster communication through digital notices
* Digital maintenance of student achievements
* Dedicated certificate verification workflow
* Separate dashboards based on user roles
* Reduced paperwork
* Easy access to academic information

---

## 👥 Project Team

The **Smart College Portal** was developed as an academic mini project by a team of four members.

- **P. Manojna**
- **P. Siri**
- **Spurthi**
- **M. Divya**
---

## 📌 Repository

**Smart College Portal**

[github.com/pedagadimanojna/smart_college_portal](https://github.com/pedagadimanojna/smart_college_portal)

---

## 📄 Project Status

🚧 **Currently under development**

Additional modules, security improvements, and user-interface enhancements can be integrated in future versions.

---

⭐ If you find this project useful, consider giving the repository a star.
