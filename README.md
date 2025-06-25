<h1>About</h1>
<h3># 📝 Todo App with Subtasks and Authentication</h3>
<p>This is a simple and intuitive **Todo App** that allows users to register and log in, create tasks, and manage subtasks under each task. It’s ideal for organizing your work or personal to-do lists efficiently.</p>

<h3>## 🔧 Features</h3>

- 🔐 **Authentication**
  - User Registration
  - User Login & Logout
  - Secure session/token-based authentication

- ✅ **Task Management**
  - Create, read, update, and delete tasks
  - Track progress of individual subtasks
  - Attach tags and filter by tag

- 🧩 **Subtask Management**
  - Create, read, update, and delete subtasks under each main task
---

## 🚀 Tech Stack

| Frontend      | Backend        | Database   | Auth         |
|---------------|----------------|------------|--------------|
| Vue           | Laravel        | MySQL      | Session-based |


---

## ⚙️ Setup Instructions

### 🔧 Backend (Laravel)

1. **Navigate to the backend folder & Install dependencies:**
```bash
cd backend
composer install
```
2. **Create environment file:**
```bash
cp .env.example .env
```
3. **Generate app key:**
```bash
php artisan key:generate
```
4. **Run migrations & Start the serve:**
```bash
php artisan migrate
php artisan serve
```

### 💻 Frontend (Vue)
1. **Navigate to the frontend folder:**
```bash
cd frontend
```
2. **Install dependencies & Start the dev server:**
```bash
npm install
npm run dev
```
