[2026-03-26 20:01:45] === New registration request ===
[2026-03-26 20:01:45] Raw input received - {"firstName":"Sita","lastName":"Shah","email":"sita123@gmail.com","phone":"98656235","education":"Diploma","dob":"2002-02-12","password":"Sita@123","confirmPassword":"Sita@123"}
[2026-03-26 20:01:45] Processing registration for: sita123@gmail.com
[2026-03-26 20:01:45] PDO connection successful
[2026-03-26 20:01:45] Students table exists: Yes
[2026-03-26 20:01:45] Duplicate email found: sita123@gmail.com, ID: 2
[2026-03-26 20:03:45] === New registration request ===
[2026-03-26 20:03:45] Raw input received - {"firstName":"Sita","lastName":"Shah","email":"sita123@gmail.com","phone":"98656235","education":"Diploma","dob":"2003-07-11","password":"Sita@123","confirmPassword":"Sita@123"}
[2026-03-26 20:03:45] Processing registration for: sita123@gmail.com
[2026-03-26 20:03:45] PDO connection successful
[2026-03-26 20:03:45] Students table exists: Yes
[2026-03-26 20:03:45] Duplicate email found: sita123@gmail.com, ID: 2
[2026-03-26 20:05:08] === New registration request ===
[2026-03-26 20:05:08] Raw input received - {"firstName":"lita","lastName":"Shah","email":"lita123@gmail.com","phone":"98656235","education":"Diploma","dob":"2003-07-11","password":"Lita@123","confirmPassword":"Lita@123"}
[2026-03-26 20:05:08] Processing registration for: lita123@gmail.com
[2026-03-26 20:05:08] PDO connection successful
[2026-03-26 20:05:08] Students table exists: Yes
[2026-03-26 20:05:08] Email is unique
[2026-03-26 20:05:09] Password hashed successfully
[2026-03-26 20:05:09] Available columns: id, first_name, last_name, email, password, phone, dob, education, is_verified, created_at
[2026-03-26 20:05:09] SQL Query: INSERT INTO students (first_name, last_name, email, password, phone, dob, education, is_verified, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
[2026-03-26 20:05:09] Values: Array
(
    [0] => lita
    [1] => Shah
    [2] => lita123@gmail.com
    [3] => $2y$12$tHdtoPATXEFqNCr4b.g2YeSloyrRu0XSlWEy/nK9wRG2M6hnvVoW2
    [4] => 98656235
    [5] => 2003-07-11
    [6] => Diploma
    [7] => 1
)

[2026-03-26 20:05:09] Student registered successfully with ID: 3
