CREATE TABLE customer_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    payment_status VARCHAR(255),
    reference VARCHAR(255),
    name VARCHAR(255),
    phone VARCHAR(20),
    order_number VARCHAR(255),
    amount DECIMAL(10, 2),
    payment_description TEXT,
    pickup_location varchar(255),
    payment_date DATETIME
);


CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_title VARCHAR(255) NOT NULL,
    book_author VARCHAR(255) NOT NULL,
    book_price DECIMAL(10, 2) NOT NULL,
    book_image VARCHAR(255) NOT NULL,
    book_quantity varchar(255) NOT NULL
);

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20),
    profile_picture VARCHAR(255)
);

CREATE TABLE Transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    payment_status VARCHAR(255),
    name VARCHAR(255),
    order_number VARCHAR(255),
    reference VARCHAR(255),
    amount DECIMAL(10, 2),
    payment_description TEXT,
    pickup_location varchar(255),
    pickup_status varchar(255) DEFAULT 'incomplete',
    payment_date DATETIME
);


