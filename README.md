﻿# Simple API Documentation

basic API for managing products using PHP and MySQL.

## Endpoints

### Display Products

- **Endpoint:** `/products`
- **Method:** GET
- **Description:** Retrieve a list of all products.

### Add Product

- **Endpoint:** `/products`
- **Method:** POST
- **Description:** Add a new product to the database. The product details should be sent in JSON format in the request body.
```
    { 
        "name": "new product",
        "size": 5 ,
        "is_available": true
    }
```
### Delete Product

- **Endpoint:** `/products`
- **Method:** DELETE
- **Description:** Delete a product from the database. The product to delete should be specified in JSON format in the request body.


