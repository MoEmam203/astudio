# **Astudio API**

Astudio is a **Laravel-based API** that provides a robust **time tracking and project management system**. It includes **user authentication, project management, time sheet logging**, and a **flexible filtering system** with **dynamic attributes (EAV Model)**.

---

## **🚀 Features**
✅ **User Authentication** (Register, Login, Logout with Laravel Passport)  
✅ **Project Management** (CRUD operations, user assignment)  
✅ **Timesheet Logging** (Track time spent on projects)  
✅ **Dynamic Attributes for Projects** (EAV Model)  
✅ **Flexible Filtering System** (Filter projects based on regular and dynamic attributes)  
✅ **RESTful API with Validation & Error Handling**

---

# **📌 Setup Instructions**

### **🔹 Prerequisites**
Ensure you have the following installed:
- **PHP 8.1+**
- **Composer**
- **MySQL or MariaDB**
- **Laravel 10+**
- **Postman or any API testing tool (for testing)**

---

### **🔹 Installation Steps**

#### **1️⃣ Clone the repository**
```bash
git clone https://github.com/MoEmam203/astudio
cd astudio
```

#### **2️⃣ Install dependencies**
```bash
composer install
```

#### **3️⃣ Set up environment variables**
Copy the example environment file:
```bash
cp .env.example .env
```
Generate a new application key:
```bash
php artisan key:generate
```

#### **4️⃣ Configure the database**
Edit the `.env` file to match your database configuration:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=astudio
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

#### **5️⃣ Run Migrations and Seeders**
```bash
php artisan migrate --seed
```
This will **create the necessary database tables and insert seed data**.

#### **6️⃣ Install Laravel Passport**
```bash
php artisan passport:install
```

#### **7️⃣ Clear Cache and Restart Server**
```bash
php artisan config:clear
php artisan cache:clear
php artisan serve
```

---
# **📖 API Documentation**

You can find the API documentation with all the available endpoints and response examples at the following link:  
[Astudio API Documentation](https://documenter.getpostman.com/view/10948469/2sAYdoFSyo)

---

## **📌 Test Credentials**
Use this test account:

**Default User:**
```
Email: astudio@test.com
Password: password
```

---