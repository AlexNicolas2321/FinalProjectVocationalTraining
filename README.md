# VitalCare — Clinic Management System

VitalCare is a full-stack web application developed as my Final Project for the
Vocational Training in Web Development program.

The project simulates the management of a medical clinic and focuses on
role-based access, separation of responsibilities, appointment management,
patient management and administrative processes.

The application uses **Symfony** for the backend and **Angular** for the frontend,
with a relational **MySQL** database.

---

## Main Features

- User authentication and role-based access.
- Different interfaces and permissions depending on the user's role.
- Patient and user management.
- Appointment creation, consultation and management.
- Treatment management by doctors.
- Administrative management of users and roles.
- Invoice generation and management.
- PDF document generation.
- Email delivery of generated invoices.
- Statistical information for administrators.
- Integration with external services.
- Dockerized development environment.

---

## Roles and Responsibilities

One of the main focuses of VitalCare is the separation of responsibilities
between the different users of the system.

### Patient

Patients can access the functionalities related to their own activity within
the clinic.

- View and manage appointments.
- Access appointment history.
- Access the available clinic services.
- Use additional health-related functionalities.

### Receptionist

Reception staff are responsible for the operational management of appointments
and patients.

- View patients.
- Search patient information.
- View and manage appointments.
- Modify appointment information.

### Doctor

Doctors have access to the medical information required for their work.

- View assigned patients.
- View appointments.
- Manage treatments.
- Consult information related to their patients.

### Administrator

Administrators have access to the management functions of the platform.

- Create and manage users.
- Create and manage roles.
- Assign permissions and roles.
- Access statistical information.
- Perform administrative operations.

This structure was designed so that each type of user only has access to the
operations required for their responsibilities.

---

## Architecture

The project is divided into three main parts:

### Backend — Symfony

The Symfony backend contains the application's business logic and handles:

- Authentication and authorization.
- API endpoints.
- Database access.
- User and role management.
- Appointment management.
- Treatment management.
- Invoice generation.
- Communication with external services.

### Frontend — Angular

Angular provides the client-side interface and communicates with the backend.

The available views and actions change depending on the authenticated user's
role.

### Database — MySQL

The relational database stores the main entities required by the application,
including users, roles, patients, doctors, appointments, treatments and invoices.

---

## Security

Authentication and protected API access are handled using JWT.

The application combines authentication with role-based authorization so that
different users have access to different operations depending on their
responsibilities.

This was particularly important in the project because patients, doctors,
receptionists and administrators interact with the same system but require
different levels of access.

---

## Invoice Workflow

VitalCare includes an invoice workflow connected to the appointment management
system.

The application can:

1. Manage the information required for the invoice.
2. Generate the corresponding document in PDF format.
3. Send the generated invoice to the client by email.

PDF generation is implemented using **Dompdf**, while the backend handles the
email delivery process.

---

## Additional Functionality

The application also includes additional functionality such as:

- Administrative statistics.
- Nutrition-related information.
- Sports and calorie information.
- Translation support.
- Email integration.

These functionalities were implemented using external libraries and services
integrated with the backend.

---

## Technologies

### Backend
- PHP
- Symfony
- REST API
- JWT
- Doctrine

### Frontend
- Angular
- TypeScript
- HTML
- CSS
- Bootstrap

### Database
- MySQL

### Tools and Libraries
- Docker
- Docker Compose
- Composer
- Dompdf
- Mail integration
- External APIs

---

## Project Structure

```text
FinalProjectVocationalTraining/
│
├── Angular/          # Frontend application
├── Symfony/          # Backend and business logic
├── bbdd/             # Database files
├── documentation/    # Project documentation
├── Dockerfile
├── docker-compose.yml
├── composer.json
└── README.md
