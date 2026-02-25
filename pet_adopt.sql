CREATE DATABASE pet_adoption;
USE pet_adoption;

--Store the information of Users
CREATE TABLE Users (
    User_id INT PRIMARY KEY AUTO_INCREMENT,
    Phone VARCHAR(20),
    Email VARCHAR(255) UNIQUE NOT NULL,
    Address TEXT,
    Password VARCHAR(255) NOT NULL,
    Name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--Store the information of Staff
CREATE TABLE Staff (
    Staff_id INT PRIMARY KEY AUTO_INCREMENT,
    Email VARCHAR(255) UNIQUE NOT NULL,
    Phone VARCHAR(20),
    Name VARCHAR(100) NOT NULL,
    Works_at VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--Store the information of Manager
CREATE TABLE Manager (
    Manager_id INT PRIMARY KEY AUTO_INCREMENT,
    Staff_id INT,
    Email VARCHAR(255),
    Phone VARCHAR(20),
    Name VARCHAR(100),
    Manages INT,
    FOREIGN KEY (Staff_id) REFERENCES Staff(Staff_id) ON DELETE CASCADE
);

--Store animal shelter locations and contact information
CREATE TABLE Shelter (
    Shelter_id INT PRIMARY KEY AUTO_INCREMENT,
    Manager_id INT,
    Shelter_name VARCHAR(255) NOT NULL,
    Address TEXT,
    Email VARCHAR(255),
    Phone VARCHAR(20),
    FOREIGN KEY (Manager_id) REFERENCES Manager(Manager_id) ON DELETE SET NULL
);

--Store the information of pets available for adoption, including their medical care status
CREATE TABLE Pets (
    Pet_id INT PRIMARY KEY AUTO_INCREMENT,
    Shelter_id INT,
    Species VARCHAR(100),
    Breed VARCHAR(100),
    Gender ENUM('Male', 'Female'),
    Pet_Name VARCHAR(100),
    DateOfBirth DATE,
    Color VARCHAR(50),
    Status ENUM('Available', 'Adopted', 'Pending', 'Medical Care') DEFAULT 'Available',
    Housed_at VARCHAR(255),
    FOREIGN KEY (Shelter_id) REFERENCES Shelter(Shelter_id) ON DELETE SET NULL
);

--Store the applications submitted by users for adopting pets, including their answers to application questions and the status of their applications
CREATE TABLE Application (
    App_id INT PRIMARY KEY AUTO_INCREMENT,
    Pet_id INT,
    User_id INT,
    Application_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    Status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    Answers TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Pet_id) REFERENCES Pets(Pet_id) ON DELETE CASCADE,
    FOREIGN KEY (User_id) REFERENCES Users(User_id) ON DELETE CASCADE
);

CREATE TABLE Reviews (
    Review_id INT PRIMARY KEY AUTO_INCREMENT,
    App_id INT,
    Shelter_id INT,
    Manager_id INT,
    Review_date DATE,
    Comments TEXT,
    Rating INT CHECK (Rating >= 1 AND Rating <= 5),
    FOREIGN KEY (App_id) REFERENCES Application (App_id) ON DELETE CASCADE,
    FOREIGN KEY (Shelter_id) REFERENCES Shelter(Shelter_id) ON DELETE SET NULL,
    FOREIGN KEY (Manager_id) REFERENCES Manager(Manager_id) ON DELETE SET NULL
);

--Track medical care for pets, including examination results and medication schedules
CREATE TABLE Med_Care (
    Med_id INT PRIMARY KEY AUTO_INCREMENT,
    Pet_id INT,
    Date_id DATE,
    Status VARCHAR(100),
    Med_examination TEXT,
    DateMeds DATE,
    FOREIGN KEY (Pet_id) REFERENCES Pets(Pet_id) ON DELETE CASCADE
);

--Manages appointments for pet visits and medical care
CREATE TABLE Schedules (
    Schedule_id INT PRIMARY KEY AUTO_INCREMENT,
    Med_id INT,
    User_id INT,
    Date DATE,
    Time TIME,
    Purpose VARCHAR(255),
    FOREIGN KEY (Med_id) REFERENCES Med_Care(Med_id) ON DELETE CASCADE,
    FOREIGN KEY (User_id) REFERENCES Users(User_id) ON DELETE CASCADE
);

--Links user to applicaitons they're associated with
CREATE TABLE Associated_with (
    User_id INT,
    App_id INT,
    association_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (User_id, App_id),
    FOREIGN KEY (User_id) REFERENCES Users(User_id) ON DELETE CASCADE,
    FOREIGN KEY (App_id) REFERENCES Application(App_id) ON DELETE CASCADE
);

--Tracks which users submitted which applications
CREATE TABLE Submits (
    User_id INT,
    App_id INT,
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (User_id, App_id),
    FOREIGN KEY (User_id) REFERENCES Users(User_id) ON DELETE CASCADE,
    FOREIGN KEY (App_id) REFERENCES Application(App_id) ON DELETE CASCADE
);

CREATE TABLE Manages (
    Manager_id INT,
    Shelter_id INT,
    start_date DATE,
    PRIMARY KEY (Manager_id, Shelter_id),
    FOREIGN KEY (Manager_id) REFERENCES Manager(Manager_id) ON DELETE CASCADE,
    FOREIGN KEY (Shelter_id) REFERENCES Shelter(Shelter_id) ON DELETE CASCADE
);

--Tracks which staff members work at which shelters and their positions
CREATE TABLE Works_at (
    Staff_id INT,
    Shelter_id INT,
    start_date DATE,
    position VARCHAR(100),
    PRIMARY KEY (Staff_id, Shelter_id),
    FOREIGN KEY (Staff_id) REFERENCES Staff(Staff_id) ON DELETE CASCADE,
    FOREIGN KEY (Shelter_id) REFERENCES Shelter(Shelter_id) ON DELETE CASCADE
);

--Tracks staff members are responsible for appointments
CREATE TABLE Appoints (
    Staff_id INT,
    Schedule_id INT,
    appointment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (Staff_id, Schedule_id),
    FOREIGN KEY (Staff_id) REFERENCES Staff(Staff_id) ON DELETE CASCADE,
    FOREIGN KEY (Schedule_id) REFERENCES Schedules(Schedule_id) ON DELETE CASCADE
);
