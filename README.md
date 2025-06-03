# Reimbursement System

The Online Reimbursement System is a web application designed to simplify the process of submitting, tracking, and approving reimbursements at PT Jasanet Mitra Networking Indonesia. Employees can easily submit claims, and the finance team can efficiently review and process them.

---

## 🚀 Technology Stack

- **Backend:** Laravel 10  
- **Database:** MySQL  
- **Frontend:** Blade Template (Laravel 10)  
- **Authentication:** Laravel Auth  
- **Role & Permission:** Spatie Laravel Permission  

---

## ⚙️ Installation

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL
- Node.js & npm (for frontend assets)

### Installation Steps

1. **Clone the Repository**
    ```bash
    git clone https://github.com/arifjsn/reimbursement.git
    cd reimbursement
    ```

2. **Install Backend Dependencies**
    ```bash
    composer install
    ```

3. **Configure Environment**
    ```bash
    cp .env.example .env
    # Edit the .env file and adjust your database configuration
    ```

4. **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

5. **Migrate Database & Seeders**
    ```bash
    php artisan migrate
    php artisan db:seed
    ```

6. **Link Storage**
    ```bash
    php artisan storage:link
    ```

7. **Run the Application**
    ```bash
    php artisan serve
    ```
    The application will be available at [http://localhost:8000](http://localhost:8000)

---

## 📝 Main Features

- **User Authentication:** Login, logout, and profile management
- **Reimbursement Submission:** Add, edit, delete, and view reimbursement details
- **Proof Upload:** Upload image files as proof of expenses
- **Reimbursement List:** View all reimbursements submitted by the user
- **Approval & Status:** Reimbursement status (requested, claimed, rejected)
- **Role Management:** Access control based on roles (user, admin, finance)
- **Notifications:** Success/error messages for every action

---

## 📄 Usage

- **Employee:** Submit reimbursement claims, upload proof, and track status
- **Admin/Manager/Finance:** Review, approve/reject, process claims, and manage users, roles, and activity logs

---

## 📧 Contact

Arif JSN  
📧 [arifjasanet@gmail.com](mailto:arifjasanet@gmail.com)

---

**License:** MIT License