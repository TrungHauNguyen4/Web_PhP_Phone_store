# Phone Store REST API Documentation

## Base URL
All endpoints are relative to:
```
http://localhost:3000/api
```

## Authentication
Most endpoints require authentication. To authenticate, first use the `/auth/login` endpoint which sets a session cookie.

## Response Format
All responses are JSON with the following structure:

### Success Response
```json
{
  "success": true,
  "message": "Success message",
  "data": { /* data here */ }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message",
  "errors": [ /* optional error details */ ]
}
```

## Endpoints

---

## Authentication

### Register User
Register a new user account.

- **Endpoint**: `POST /auth/register`
- **Request Body**:
  ```json
  {
    "username": "johndoe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirm": "password123",
    "fullname": "John Doe"
  }
  ```
- **Response**:
  - 201: Registration successful
  - 422: Validation failed

---

### Login
Authenticate a user and start a session.

- **Endpoint**: `POST /auth/login`
- **Request Body**:
  ```json
  {
    "username": "johndoe",
    "password": "password123"
  }
  ```
- **Response**:
  - 200: Login successful, returns user data
  - 401: Invalid credentials

---

### Logout
End the user's session.

- **Endpoint**: `POST /auth/logout`
- **Response**:
  - 200: Logout successful

---

## Products

### Get Products
Get list of products with optional search and filter.

- **Endpoint**: `GET /products`
- **Query Parameters**:
  - `search` (optional): Search term (searches name, description, brand)
  - `brand` (optional): Filter by brand
- **Response**:
  ```json
  {
    "success": true,
    "message": "Success",
    "data": {
      "products": [ /* array of products */ ],
      "brands": [ /* array of available brands */ ]
    }
  }
  ```

---

### Get Product Detail
Get detailed information about a single product.

- **Endpoint**: `GET /products/:id`
- **URL Parameters**:
  - `id`: Product ID
- **Response**:
  - 200: Product details
  - 404: Product not found

---

## Cart

### Get Cart
Get current cart contents.

- **Endpoint**: `GET /cart`
- **Response**:
  ```json
  {
    "success": true,
    "message": "Success",
    "data": {
      "items": [ /* array of cart items */ ],
      "total": 1234567
    }
  }
  ```

---

### Add Item to Cart
Add a product to the cart.

- **Endpoint**: `POST /cart/items`
- **Request Body**:
  ```json
  {
    "product_id": 1,
    "quantity": 2
  }
  ```
- **Response**:
  - 200: Item added
  - 422: Invalid input

---

### Update Cart Item
Update quantity of an item in the cart.

- **Endpoint**: `PUT /cart/items/:productId`
- **URL Parameters**:
  - `productId`: Product ID
- **Request Body**:
  ```json
  {
    "quantity": 3
  }
  ```
- **Response**:
  - 200: Cart updated

---

### Remove Cart Item
Remove an item from the cart.

- **Endpoint**: `DELETE /cart/items/:productId`
- **URL Parameters**:
  - `productId`: Product ID
- **Response**:
  - 200: Item removed

---

## Orders

### Get Orders
Get list of orders for the authenticated user.

- **Endpoint**: `GET /orders`
- **Authentication Required**: Yes
- **Response**:
  ```json
  {
    "success": true,
    "message": "Success",
    "data": {
      "orders": [ /* array of orders */ ]
    }
  }
  ```

---

### Create Order (Checkout)
Create a new order from cart contents.

- **Endpoint**: `POST /orders`
- **Authentication Required**: Yes
- **Request Body**:
  ```json
  {
    "shipping_fullname": "John Doe",
    "shipping_phone": "0123456789",
    "shipping_email": "john@example.com",
    "shipping_address": "123 Main St, City",
    "payment_method": "transfer"
  }
  ```
- **Response**:
  - 201: Order created
  - 422: Validation failed or cart empty

---

### Get Order Detail
Get detailed information about an order.

- **Endpoint**: `GET /orders/:id`
- **Authentication Required**: Yes
- **URL Parameters**:
  - `id`: Order ID
- **Response**:
  - 200: Order details
  - 403: Forbidden (not your order)
  - 404: Order not found

---

## Users

### Get Profile
Get current user's profile information.

- **Endpoint**: `GET /users/profile`
- **Authentication Required**: Yes
- **Response**:
  ```json
  {
    "success": true,
    "message": "Success",
    "data": {
      "user": { /* user data */ }
    }
  }
  ```

---

### Update Profile
Update current user's profile.

- **Endpoint**: `PUT /users/profile`
- **Authentication Required**: Yes
- **Request Body**:
  ```json
  {
    "fullname": "John Doe",
    "email": "john@example.com",
    "phone": "0123456789",
    "address": "123 Main St"
  }
  ```
- **Response**:
  - 200: Profile updated

---

### Change Password
Change current user's password.

- **Endpoint**: `PUT /users/password`
- **Authentication Required**: Yes
- **Request Body**:
  ```json
  {
    "current_password": "oldpassword",
    "new_password": "newpassword123",
    "password_confirm": "newpassword123"
  }
  ```
- **Response**:
  - 200: Password changed

---

## Admin Endpoints
All admin endpoints require the user to be an admin.

### Dashboard Statistics
Get dashboard overview statistics.

- **Endpoint**: `GET /admin/dashboard`
- **Authentication Required**: Yes (admin only)
- **Response**:
  ```json
  {
    "success": true,
    "message": "Success",
    "data": {
      "totalProducts": 10,
      "totalUsers": 5,
      "totalOrders": 20,
      "totalRevenue": 123456789
    }
  }
  ```

---

### Admin Products

#### Get All Products
Get all products including out of stock.

- **Endpoint**: `GET /admin/products`
- **Authentication Required**: Yes (admin only)

#### Create Product
Create a new product.

- **Endpoint**: `POST /admin/products`
- **Authentication Required**: Yes (admin only)
- **Request Body**:
  ```json
  {
    "name": "Product Name",
    "brand": "Brand",
    "cpu": "CPU Info",
    "bo_nho_trong": "Storage",
    "pin": "Battery",
    "price": 1000000,
    "quantity": 10,
    "description": "Product description",
    "image": "filename.jpg"
  }
  ```

#### Get Product
Get a single product.

- **Endpoint**: `GET /admin/products/:id`
- **Authentication Required**: Yes (admin only)

#### Update Product
Update an existing product.

- **Endpoint**: `PUT /admin/products/:id`
- **Authentication Required**: Yes (admin only)

#### Delete Product
Delete a product.

- **Endpoint**: `DELETE /admin/products/:id`
- **Authentication Required**: Yes (admin only)

---

### Admin Orders

#### Get All Orders
Get all orders.

- **Endpoint**: `GET /admin/orders`
- **Authentication Required**: Yes (admin only)

#### Get Order Detail
Get detailed order info.

- **Endpoint**: `GET /admin/orders/:id`
- **Authentication Required**: Yes (admin only)

#### Update Order Status
Update an order's status (pending/confirmed/shipped/completed/cancelled).

- **Endpoint**: `PUT /admin/orders/:id/status`
- **Authentication Required**: Yes (admin only)
- **Request Body**:
  ```json
  {
    "status": "confirmed"
  }
  ```

#### Delete Order
Delete an order.

- **Endpoint**: `DELETE /admin/orders/:id`
- **Authentication Required**: Yes (admin only)

---

### Admin Users

#### Get All Users
Get all users.

- **Endpoint**: `GET /admin/users`
- **Authentication Required**: Yes (admin only)

#### Get User
Get a single user.

- **Endpoint**: `GET /admin/users/:id`
- **Authentication Required**: Yes (admin only)

#### Update User
Update a user's info.

- **Endpoint**: `PUT /admin/users/:id`
- **Authentication Required**: Yes (admin only)

#### Reset User Password
Reset a user's password.

- **Endpoint**: `PUT /admin/users/:id/password`
- **Authentication Required**: Yes (admin only)
- **Request Body**:
  ```json
  {
    "new_password": "newpassword",
    "password_confirm": "newpassword"
  }
  ```

#### Delete User
Delete a user (cannot delete yourself).

- **Endpoint**: `DELETE /admin/users/:id`
- **Authentication Required**: Yes (admin only)

---

### Detailed Statistics
Get full statistics.

- **Endpoint**: `GET /admin/statistics`
- **Authentication Required**: Yes (admin only)

---

## Test Accounts
Use these accounts for testing:

### Admin
- Username: `admin`
- Password: `admin123`

### User
- Username: `user`
- Password: `user123`
