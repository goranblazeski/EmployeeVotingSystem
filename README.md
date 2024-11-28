# EmployeeVotingSystem
IMPORTANT!!
The .php files must be stored in the HTDOCS folder located in the XAMPP directory
There are a total of 3 tables which I used in the code - these tables I could view with /phpmyadmin using XAMPP
-- Queries for the tables to allow test-cases --
EMPLOYEES

CREATE TABLE employees (employee_id INT AUTO_INCREMENT PRIMARY KEY,
employee_name VARCHAR(100) NOT NULL);
 
and to populate for testing

INSERT INTO employees(employee_name) 
VALUES ('John'), ('James’), ('Kate’), ('Jimmy’), (‘Sarah’), (‘Tim');

CATEGORIES

CREATE TABLE categories (category_id INT AUTO_INCREMENT PRIMARY KEY, category_name VARCHAR(100) NOT NULL UNIQUE );

and to populate with the categories

INSERT INTO categories (category_name) 
VALUES ('Makes Work Fun'), ('Team Player'), ('Culture Champion'), ('Difference Maker');

VOTES 

CREATE TABLE votes (vote_id INT AUTO_INCREMENT PRIMARY KEY, voter_id INT, nominee_id INT, category_id INT, comment TEXT, timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
FOREIGN KEY (voter_id) REFERENCES employees(employee_id), 
FOREIGN KEY (nominee_id) REFERENCES employees(employee_id), 
FOREIGN KEY (category_id) REFERENCES categories(category_id));

