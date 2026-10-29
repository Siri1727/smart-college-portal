# 🎓 Smart College Portal

Smart College Portal is a web-based college management application developed to centralize important academic activities, including student attendance tracking, faculty notices, student achievement management, and certificate verification.

The application provides role-based access for students, faculty members, and certificate verifiers, allowing each user to access the features relevant to their responsibilities.

## 📌 Project Overview

Managing attendance, academic announcements, and student certificates through separate manual processes can be time-consuming. Smart College Portal brings these activities together in one web application, making academic information easier to manage and access.

This project was developed as a team academic mini-project.

## ✨ Key Features

### 🎓 Student Module
- Log in using student credentials.
- View and manage profile information.
- Monitor subject-wise attendance and attendance percentages.
- Filter attendance records by date range.
- View notices relevant to the student's branch and year.
- Add achievements and upload supporting certificates.
- Track certificate verification status.

### 👨‍🏫 Faculty Module
- Access the faculty dashboard and profile.
- Mark and manage student attendance.
- Publish academic notices for the relevant branch and year.
- View previously published notices.
- Edit or delete notices.

### ✅ Certificate Verifier Module
- Access a dedicated certificate verification dashboard.
- Review certificates uploaded by students.
- View pending and verified certificates.
- Filter certificate records.
- Verify submitted student certificates.

## 📊 Attendance Management

The attendance module allows faculty members to record student attendance and enables students to monitor their attendance.

Students can view attendance details such as:
- Subject name
- Total periods conducted
- Periods attended
- Attendance percentage

Attendance reports can be filtered by today, the current month, or a custom date range.

## 🏆 Student Achievement Management

Students can maintain digital records of achievements such as internships, hackathons, workshops, certifications, seminars, sports, cultural activities, and placements.

Students can submit achievement details and upload supporting certificates for review by an authorized certificate verifier.

## 📢 Notice Management

Faculty members can publish academic announcements for specific student branches and years. Students can view relevant notices through the portal, while faculty members can manage their previously published notices.

## 🔐 Role-Based Access

The application supports three primary roles:

| Role | Responsibilities |
|---|---|
| Student | View attendance and notices; manage achievements and certificates |
| Faculty | Mark attendance and manage academic notices |
| Certificate Verifier | Review and verify student certificates |

PHP sessions are used to maintain login sessions and restrict access to role-specific pages.

## 🛠️ Technology Stack

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Local Development Environment:** XAMPP
- **Database Administration:** phpMyAdmin

## ⚙️ Run the Project Locally

### Prerequisites
- XAMPP
- Git
- A web browser

### Setup Steps

1. Start **Apache** and **MySQL** from the XAMPP Control Panel.
2. Open the XAMPP `htdocs` directory.
3. Clone this repository:

   ```bash
   git clone https://github.com/Siri1727/smart-college-portal.git
   ```

4. Ensure the project folder is available at:

   ```text
   C:\xampp\htdocs\smart-college-portal
   ```

   If the cloned folder name differs from the folder name expected by the application, adjust the folder name or local URL accordingly.

5. Create and configure the MySQL database named `college_portal` using phpMyAdmin. The required database tables must also be created or imported.
6. Configure your local database credentials in the database connection file. **Do not commit passwords or other sensitive information to GitHub.**
7. Open the application in your browser using the matching local folder name, for example:

   `http://localhost/smart-college-portal/login.php`

> **Note:** The database and institutional/student records are not included in this repository. You must configure the required database schema before running the application.

## 🎯 Project Objectives

- Digitize essential college academic activities.
- Reduce dependence on manual records.
- Make attendance information easier for students to access.
- Improve academic communication between faculty and students.
- Maintain student achievement records digitally.
- Provide a structured certificate verification workflow.
- Centralize academic activities through role-based dashboards.

## 🚀 Future Enhancements

- Improve the interface for mobile devices.
- Strengthen authentication and database security.
- Add attendance shortage alerts and reporting.
- Enhance email notifications.
- Introduce additional attendance analytics.

## 👥 Project Contribution

This is a team-developed academic mini-project. The portal includes student, faculty, and certificate verification workflows. Individual contributions can be documented separately according to the work completed by each team member.

## 📌 Repository

**GitHub:** https://github.com/Siri1727/smart-college-portal

## 📄 Project Status

**Under development.** Further improvements to the interface, attendance functionality, and other modules are planned.

