# Survey Management System
A comprehensive Laravel-based survey management application that allows users to create and manage surveys and questions with support for mass operations. Built with scalability in mind to handle up to 1 billion surveys.

## 🚀 Features
✅ Create, edit, and manage surveys

✅ Create, edit, and manage questions

✅ Assign questions to surveys

✅ Mass operations (assign multiple questions to surveys, delete multiple questions)

✅ Responsive design with Bootstrap

✅ Vanilla JavaScript for interactive features

✅ Dockerized development environment

✅ Optimized database for large datasets

## 📋 Prerequisites
Before you begin, ensure you have the following installed:

Docker Desktop (Download here)

Git (Download here)

Composer (Optional, for local development)

## ⚡ Quick Setup (Recommended)
Step 1: Clone the Repository
bash
git clone <your-repository-url>
cd survey-management-app
Step 2: Run the Automated Setup Script
bash
### Make the setup script executable (Linux/Mac)
chmod +x setup.sh

### Run the setup script
./setup.sh
Windows Users: If you're using Windows, run the setup commands manually:

bash
### Start Docker containers
./vendor/bin/sail up -d

### Wait for MySQL to be ready, then run:
./vendor/bin/sail composer install
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
Step 3: Access the Application
Once the setup completes, access the application at:

Main Application: http://localhost

MailHog (Email testing): http://localhost:8025

## 🔧 Manual Setup (Alternative)
If the automated script doesn't work, follow these steps:

Step 1: Start Docker Containers
bash
./vendor/bin/sail up -d
Step 2: Install PHP Dependencies
bash
./vendor/bin/sail composer install
Step 3: Generate Application Key
bash
./vendor/bin/sail artisan key:generate
Step 4: Run Database Migrations
bash
./vendor/bin/sail artisan migrate
Step 5: Seed Database (Optional)
bash
./vendor/bin/sail artisan db:seed
Step 6: Verify Installation
bash
./vendor/bin/sail artisan route:list
You should see all the routes listed without errors.

## 🌐 Available Services
The Docker environment includes:

Service	URL/Port	Purpose
Laravel Application	http://localhost	Main application
MySQL Database	Port 3306	Database
Redis Cache	Port 6379	Caching
MailHog	http://localhost:8025	Email testing (SMTP: Port 1025)

## 🗄️ Database Configuration
The application uses MySQL with the following credentials:

Host: mysql

Database: survey_app

Username: sail

Password: password

You can connect to the database using:

bash
./vendor/bin/sail mysql
Or use any MySQL client with:

Host: 127.0.0.1

Port: 3306

Username: sail

Password: password

Database: survey_app

## 📊 Sample Data
The database seeder creates:

10 sample surveys

50 sample questions

Random assignments between surveys and questions

You can reset the database with:

bash
./vendor/bin/sail artisan migrate:fresh --seed
## 🧪 Testing the Application
1. Create a Survey
Go to http://localhost/surveys

Click "Create New Survey"

Fill in the survey name

Select questions to include

Click "Create Survey"

2. Create a Question
Go to http://localhost/questions

Click "Create New Question"

Fill in question details (name, text, type)

Optionally assign to surveys

Click "Create Question"

3. Mass Operations
Go to http://localhost/questions

Select multiple questions using checkboxes

Use "Assign to Surveys" to assign them to multiple surveys

Use "Delete Selected" to delete multiple questions at once

## ❗ Troubleshooting
Common Issues
Port already in use:

bash
### Stop other services using port 80 or change APP_PORT in .env
APP_PORT=8080
### Docker not running:

Ensure Docker Desktop is running

Restart Docker if needed

### Permission errors:

bash
chmod -R 755 storage bootstrap/cache
### Database connection issues:

bash
./vendor/bin/sail down
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
### Container won't start:

bash
docker-compose down
docker-compose up -d --build
Reset Everything
### If you encounter issues, you can reset the entire environment:

bash
### Stop and remove containers
./vendor/bin/sail down

### Remove volumes (WARNING: This will delete all data)
docker volume rm survey-management-app_sail-mysql survey-management-app_sail-redis

### Start fresh
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed
## ⚡ Performance Features
This application is optimized for large datasets:

Database indexes on all foreign keys

Pagination for large result sets

Efficient query design

MySQL configuration optimized for large tables

Support for 1 billion+ surveys

## 📄 License
This project is created for the GuildQuality Developer Coding Exercise.