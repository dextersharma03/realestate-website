-- DROP the database if it exists
DROP DATABASE IF EXISTS RealEstateReviews;
-- CREATE THE DATABASE
CREATE DATABASE RealEstateReviews;
-- SHOW DATABASES;
-- Use the database
USE RealEstateReviews;
DROP TABLE IF EXISTS AreaExpertise;
-- Create the AreaExpertise Table 
CREATE TABLE AreaExpertise (
    AreaExpertiseID INT PRIMARY KEY AUTO_INCREMENT,
    AreaExpertiseShortName TINYTEXT NOT NULL,
    AreaExpertiseLongName TINYTEXT NOT NULL
);
DROP TABLE IF EXISTS Agent;
-- Create the Agent Table
CREATE TABLE Agent (
    AgentID INT PRIMARY KEY AUTO_INCREMENT,
    AreaExpertiseID INT NULL,
    FirstName TINYTEXT NOT NULL,
    LastName TINYTEXT NOT NULL,
    Email VARCHAR(50) NOT NULL,
    CONSTRAINT FOREIGN KEY (AreaExpertiseID) REFERENCES AreaExpertise(AreaExpertiseID) ON UPDATE CASCADE ON DELETE CASCADE
);
DROP TABLE IF EXISTS Agent_AreaExpertise;
CREATE TABLE Agent_AreaExpertise(
    -- Create an intersection table between AreaExpertise and Agent
    AgentID INT NOT NULL,
    AreaExpertiseID INT NOT NULL,
    CONSTRAINT FOREIGN KEY (AreaExpertiseID) REFERENCES AreaExpertise(AreaExpertiseID) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT FOREIGN KEY (AgentID) REFERENCES Agent(AgentID) ON UPDATE CASCADE ON DELETE CASCADE
);
DROP TABLE IF EXISTS User;
-- Create a User table
CREATE TABLE User(
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName TINYTEXT NOT NULL,
    LastName TINYTEXT NOT NULL,
    Email VARCHAR(50) NOT NULL,
    Username VARCHAR(25) NOT NULL,
    Password VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS Rating;
-- Create a Rating table
CREATE TABLE Rating(
    RatingID INT PRIMARY KEY AUTO_INCREMENT,
    AgentID INT NOT NULL,
    AreaExpertiseID INT NOT NULL,
    UserID INT NOT NULL,
    Date Date,
    Rating INT NOT NULL,
    Review VARCHAR(255),
    CONSTRAINT FOREIGN KEY (AgentID) REFERENCES Agent(AgentID) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT FOREIGN KEY (AreaExpertiseID) REFERENCES AreaExpertise(AreaExpertiseID) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT FOREIGN KEY (UserID) REFERENCES User(UserID) ON UPDATE CASCADE ON DELETE CASCADE
);
SHOW TABLES;
-- INSERT AreaExpertise values
INSERT INTO AreaExpertise (AreaExpertiseShortName, AreaExpertiseLongName)
VALUES ('Residential Sale ', 'Residential Properties'),
    ('Commercial Sale ', 'Commercial Properties and Designs'),
    ('Rental Sale ', 'Rental Studios and Properties');
-- INSERT Agent values
INSERT INTO Agent(AreaExpertiseID, FirstName, LastName, Email)
VALUES (
        '1',
        'John',
        'Smith',
        'johnsmith@realtor.ca'
    ),
    (
        '3',
        'Bob',
        'Harley',
        'bobharley@realtor.ca'
    ),
    (
        '2',
        'Peter',
        'Smith',
        'petersmith@realtor.ca'
    ),
    (
        '3',
        'Michael',
        'Luther',
        'michael@realtor.ca'
    );
-- INSERT Agent_AreaExpertise values
INSERT INTO Agent_AreaExpertise (AgentID, AreaExpertiseID)
VALUES ('1', '3'),
    ('2', '3'),
    ('1', '2'),
    ('3', '1'),
    ('4', '2');
-- INSERT User Table values
INSERT INTO User(FirstName, LastName, Email, Username, Password)
VALUES (
        'sam',
        'smith',
        'samsmith@realtor.ca',
        'sam_smith',
        '$2y$10$NlMmMmcHG1/n3jsqsYwjp.Mb/K898fW/Bl/Cq0Y1bfNtHdsTMkxpi'
    ),
    (
        'johnie',
        'walker',
        'johniewalkerk@realtor.ca',
        'johnie_walker',
        '$2y$10$LKJHv5.t5a5JbxIq37rkSuU5Qmdoqtj3QDsdGCvuND/E8F0GzXT.S'
    ),
    (
        'admin',
        'admin',
        'admin@realtor.ca',
        'admin',
        '$2y$10$lz/s7koSPErK1WWp2OcIRuN687hpKJMl4ANt0XQMCEbfNhVkPFc9S'
    );
-- INSERT Rating Table values
INSERT INTO Rating(
        AgentID,
        AreaExpertiseID,
        UserID,
        Date,
        Rating,
        Review
    )
VALUES ('1', '2', '1', '2021-02-14', '5', 'Awesome experience with this agent.'),
    ('2', '3', '2', '2020-02-14', '3', 'The deal was closed and we got a really good price, all thanks to agent abilities.'),
    ('3', '1', '1', '2022-03-12', '3', 'We had good experience with the agent, very professional.'),
    ('4', '2', '2', '2023-01-13', '3', 'Good but needs improvement in communication.'),
    ('1', '3', '2', '2023-08-16', '4', 'Very Good, we closed the deal efficiently.');