-- SQL Updates for Pet Adoption Database
-- run this after importing pet_adopt.sql

USE pet_adoption;

-- add bio column to Users table
ALTER TABLE Users ADD COLUMN Bio TEXT AFTER Address;

-- add password column to Staff table
ALTER TABLE Staff ADD COLUMN Password VARCHAR(255) NOT NULL DEFAULT 'staff123' AFTER Name;

-- add password column to Manager table
ALTER TABLE Manager ADD COLUMN Password VARCHAR(255) NOT NULL DEFAULT 'admin123' AFTER Name;

-- Create Application table
CREATE TABLE IF NOT EXISTS Application (
    Application_id INT PRIMARY KEY AUTO_INCREMENT,
    Pet_id INT,
    User_id INT,
    Application_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    Status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    Answers TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Pet_id) REFERENCES Pets(Pet_id) ON DELETE CASCADE,
    FOREIGN KEY (User_id) REFERENCES Users(User_id) ON DELETE CASCADE
);

-- Create ShelterAppointment table
CREATE TABLE IF NOT EXISTS ShelterAppointment (
    Appointment_id INT PRIMARY KEY AUTO_INCREMENT,
    Shelter_id INT,
    User_name VARCHAR(100) NOT NULL,
    User_email VARCHAR(255) NOT NULL,
    User_phone VARCHAR(20),
    Appointment_date DATE NOT NULL,
    Appointment_time TIME NOT NULL,
    Note TEXT,
    Status ENUM('Pending', 'Confirmed', 'Cancelled', 'Completed') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Shelter_id) REFERENCES Shelter(Shelter_id) ON DELETE CASCADE
);

-- Create CareLogs table for pet care tracking
CREATE TABLE IF NOT EXISTS CareLogs (
    Log_id INT PRIMARY KEY AUTO_INCREMENT,
    Pet_id INT NOT NULL,
    Staff_id INT,
    Activity_type ENUM('Feeding', 'Exercise', 'Medication', 'Grooming', 'Vet Visit', 'Other') NOT NULL,
    Activity_date DATE NOT NULL,
    Activity_time TIME NOT NULL,
    Description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Pet_id) REFERENCES Pets(Pet_id) ON DELETE CASCADE,
    FOREIGN KEY (Staff_id) REFERENCES Staff(Staff_id) ON DELETE SET NULL
);

INSERT INTO Users (Name, Email, Password, Phone, Address, Bio) VALUES
('Bob', 'bob@example.com', 'user123', '(66) 123-4567', '123 Main St, Bangkok, Thailand', 'Animal lover with experience'),
('Smith', 'smith@example.com', 'user123', '(66) 234-5678', '456 Park Ave, Bangkok, Thailand', 'First time pet owner');

-- Staff
INSERT INTO Staff (Name, Email, Password, Phone, Works_at) VALUES
('Johnson', 'john@example.com', 'staff123', '(66) 345-6789', 'Bangkok Shelter'),
('Mike', 'mike@example.com', 'staff123', '(66) 456-7890', 'Bangkok Shelter');

-- Manager
INSERT INTO Manager (Name, Email, Password, Phone, Manages) VALUES
('Admin', 'admin@example.com', 'admin123', '(66) 567-8901', 1);

-- Shelter
INSERT INTO Shelter (Shelter_name, Address, Email, Phone, Manager_id) VALUES
('Bangkok Pet Shelter', '789 Sukhumvit Rd, Bangkok, Thailand', 'info@bangkokshelter.com', '(66) 678-9012', 1);

INSERT INTO Pets (Pet_Name, Species, Breed, Gender, DateOfBirth, Color, Status, Shelter_id) VALUES
('Max', 'Dog', 'Golden Retriever', 'Male', '2020-03-15', 'Golden', 'Available', 1),
('Whiskers', 'Cat', 'Domestic Shorthair', 'Female', '2021-06-20', 'Gray', 'Available', 1),
('Buddy', 'Dog', 'Labrador', 'Male', '2019-08-10', 'Black', 'Available', 1),
('Luna', 'Cat', 'Siamese', 'Female', '2022-01-05', 'Cream', 'Available', 1),
('Charlie', 'Dog', 'German Shepherd', 'Male', '2020-11-12', 'Brown/Black', 'Available', 1),
('Mittens', 'Cat', 'Persian', 'Female', '2021-04-18', 'White', 'Available', 1),
('Coco', 'Bird', 'Parakeet', 'Female', '2023-02-14', 'Blue', 'Available', 1),
('Melon', 'Capybara', 'Standard', 'Male', '2019-05-20', 'Brown', 'Available', 1);

INSERT INTO CareLogs (Pet_id, Staff_id, Activity_type, Activity_date, Activity_time, Description) VALUES
(1, 1, 'Feeding', '2026-02-19', '08:00:00', 'Morning meal - dry food and water'),
(1, 1, 'Exercise', '2026-02-19', '10:00:00', '30-minute walk in the park'),
(2, 2, 'Feeding', '2026-02-19', '08:30:00', 'Wet food breakfast'),
(3, 1, 'Medication', '2026-02-19', '09:00:00', 'Administered flea medication');

COMMIT;
