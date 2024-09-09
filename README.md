# Laravel ToDo App

This project is used to practice REST API with Laravel.
Although the project is simple, it is a good example to understand the basics of REST API.
We'll be progressing gradually and adding more features to the project.
The system will be monolithic at the moment, utilizing RESTFUL standards.

The current project will utilize Laravel, PostgreSQL, and Postman.

## Process Documentation

### Initializing laravel project

1. Creating Laravel project using composer
```bash
composer create-project laravel/laravel todo-app-laravel
```

2. Creating `todolist` user and database in PostgreSQL
```sql
CREATE USER todolist WITH PASSWORD 'todolist';

CREATE DATABASE todolist OWNER todolist;

GRANT ALL PRIVILEGES ON DATABASE todolist TO todolist;
-- or
ALTER DATABASE todolist OWNER TO todolist;
```

## Preview (Alur Program)

1. Login
   ![sign in page](images/r-signin.png)
2. Register
   ![register page](images/r-register.png)
3. Registering
   ![registering](images/r-registering.png)
4. Logging in
   ![logging in](images/r-loggingin.png)
5. Redirected to TODO page
   ![todo page](images/r-todo-page.png)
6. Creating new TODO
   ![creating new todo](images/r-creating-new-todo.png)
7. New TODO created
   ![New TODO created](images/r-new-todo-created)
8. Toggling TODO status
   ![toggling todo](images/r-toggling-todo.png)
   ![toggled a todo](images/r-toggled-todo.png)
9. Deleting a TODO:
   ![deleting a todo](images/r-deleting-todo.png)
   ![deleted a todo](images/r-deleted-todo.png)
10. Logout (to login page)
    ![logout](images/r-logout.png)
11. Logged as another user
    ![as another user](images/r-as-another-user.png)
