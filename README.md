# Virlab-Mobile-Backend
Backend code for Virlab Mobile

## Endpoints

### Register

- **URL:** `/auth/register`
- **Method:** `POST`
- **Request Body:**
  ```json
  {
    "username": "testusername",
    "email": "testemail@mail.com",
    "password": "testpassword"
  }
  ```
- **Response:**
  ```json
  {
    "message": "Registration successful.",
    "token": "your-jwt-token"
  }
  ```

### Login

- **URL:** `/auth/login`
- **Method:** `POST`
- **Request Body:**
  ```json
  {
    "email": "testemail@mail.com",
    "password": "testpassword"
  }
  ```
- **Response:**
  ```json
  {
    "message": "Login successful.",
    "token": "your-jwt-token",
    "user": {
      "id": 1,
      "username": "testusername",
      "email": "testemail@mail.com",
      "role": "user"
    }
  }
  ```

### Delete Account

- **URL:** `/auth/delete`
- **Method:** `DELETE`
- **Headers:**
  ```http
  Authorization: Bearer your-jwt-token
  ```
- **Response:**
  ```json
  {
    "message": "Account deleted successfully."
  }
  ```

### Get User Score

- **URL:** `/user/score`
- **Method:** `GET`
- **Headers:**
  ```http
  Authorization: Bearer your-jwt-token
  ```
- **Response:**
  ```json
  {
    "status": 200,
    "message": "User score retrieved successfully",
    "data": {
      "user_id": 1,
      "user_score": 100
    }
  }
  ```

### Update User Score

- **URL:** `/user/score/update`
- **Method:** `POST`
- **Headers:**
  ```http
  Authorization: Bearer your-jwt-token
  ```
- **Request Body:**
  ```json
  {
    "user_score": 150
  }
  ```
- **Response:**
  ```json
  {
    "status": 200,
    "message": "User score updated successfully",
    "data": {
      "user_id": 1,
      "user_score": 150
    }
  }
  ```
