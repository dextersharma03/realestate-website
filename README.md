# Real Estate Agent Ranking Website

Welcome to the Real Estate Agent Ranking Website project! This platform aims to provide a user-friendly environment for customers to evaluate and rank real estate agents based on their experiences. Users can search for agents, view profiles, read reviews, and contribute their feedback. 

## Table of Contents

- [Project Overview](#project-overview)
- [Project Structure](#project-structure)
- [Technologies Used](#technologies-used)
- [How It Works](#how-it-works)
- [Screenshots](#screenshots)
- [Getting Started](#getting-started)
- [Contributing](#contributing)

## Project Overview

The real estate industry relies heavily on customer satisfaction. This project addresses the challenge of providing transparent and reliable agent reviews, enhancing the overall real estate experience. Users can submit ratings and reviews, which contribute to an agent's overall rating. The project uses PHP and MySQL for backend logic and data storage, and HTML, CSS, and JavaScript for the user interface.

## Project Structure

The project follows a structured directory layout:

- `data/`: Contains the SQL database file.
- `inc/`: Holds the core application code.
  - `Entity/`: Defines classes like Agent, Rating, User, etc.
  - `Utility/`: Contains utility classes, including data access objects (DAOs) and other helper classes.
  - `config.inc.php`: Configuration settings for the application.
- `.gitignore`: Specifies files and directories to be ignored by Git.
- `README.md`: The main documentation you are reading right now.
- Other PHP files: Handle specific functionality, such as registration, login, and main pages.

## Technologies Used

- **PHP**: Server-side scripting language for application logic.
- **MySQL**: Database management system for storing and retrieving data.
- **HTML, CSS, JavaScript**: Front-end technologies for creating a user-friendly interface.
- **Bootstrap**: Front-end framework for responsive design.
- **Git**: Version control system for collaborative development.

## How It Works

The Real Estate Agent Ranking Website provides the following functionalities:

- **User Registration and Login**: Users can create accounts, log in securely, and access their profiles.
- **Agent Search and Profiles**: Users can search for agents and view agent reviews.
- **Submitting Ratings and Reviews**: Users can submit ratings and reviews for agents based on their experiences.
- **Overall Agent Rating**: The website calculates and displays the overall rating for each agent.

## Screenshots

Here are some screenshots of the Real Estate Agent Ranking Website:

![Screenshot 1](/screenshots/5.png)
*Login*

![Screenshot 2](/screenshots/6.png)
*Registration*

![Screenshot 3](/screenshots/4.png)
*Main page*

![Screenshot 5](/screenshots/2.png)
*Reviews page*

![Screenshot 4](/screenshots/1.png)
*Admin page*

## Getting Started

To run the project locally, follow these steps:

1. Clone the repository: `git clone https://github.com/dextersharma03/realestate-website.git`
2. Set up a local web server (e.g., XAMPP, WAMP, MAMP).
3. Import the database from `data/RealEstateReviews.sql`.
4. Configure database settings in `inc/config.inc.php`.
5. Access the project through the local server (e.g., `http://localhost/realestate-website`).

## Contributing

Contributions are welcome! If you find issues or want to enhance the project, feel free to submit pull requests.
