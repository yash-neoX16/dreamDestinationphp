CREATE DATABASE IF NOT EXISTS dreamdestination;
USE dreamdestination;

-- Admins table
CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL
);

INSERT INTO admins (name, email, password_hash) VALUES
('Super Admin', 'admin@example.com', 'admin');

-- Countries table
CREATE TABLE IF NOT EXISTS countries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  photo VARCHAR(255)
);

INSERT INTO countries (name, description, photo) VALUES
('India', 'A land of diverse culture and heritage.', 'india.png'),
('France', 'Famous for Eiffel Tower and art culture.', 'france.png');

-- Places table
CREATE TABLE IF NOT EXISTS places (
  id INT AUTO_INCREMENT PRIMARY KEY,
  country_id INT NOT NULL,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  photo VARCHAR(255),
  FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE
);

INSERT INTO places (country_id, name, description, photo) VALUES
(1, 'Taj Mahal', 'A world wonder in Agra, India.', 'tajmahal.jpg'),
(2, 'Eiffel Tower', 'Iconic landmark of Paris, France.', 'effiel.jpg');
