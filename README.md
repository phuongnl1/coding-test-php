## Get Started

This guide will walk you through the steps needed to get this project up and running on your local machine.

### Prerequisites

Before you begin, ensure you have the following installed:

- Docker
- Docker Compose

### Building the Docker Environment

Build and start the containers:

```
docker-compose up -d --build
```

### Installing Dependencies

```
docker-compose exec app sh
composer install
```

### Database Setup

Set up the database:

```
bin/cake migrations migrate
```

Run command line below to create an example admin user:

```
bin/cake migrations seed --seed UsersSeed
```

### Accessing the Application

The application should now be accessible at http://localhost:34251. The system will be redirect to http://localhost:34251/user/login page. You can login with email as `admin@example.com` and password is `admin123`.

## How to check

I have implemented all APIs related to articles, users and like article. Please import all APIs into Postman from `Betamind.API-Collection.json` file. Currently, we are applying the Headless technology for this project.

### Authentication

I have implemented all APIs related to login, and they are protected by tokens.

| Title                          | Endpoints            | Remark                                                    |
| ------------------------------ | -------------------- | ----------------------------------------------------------|
| Retrieve All Users (GET)       | /users.json          | Can only be used by all users.                            |
| Create an User (POST)          | /users.json          | Can only be used by authenticated users.                  |
| User login (POST)              | /users/login.json    | Can only be used by all users.                            |
| Delete an User (DELETE)        | /articles/{id}.json  | Can only be used by authenticated users.                  |

I've also implemented a login page where users can log in to manage articles. When a user clicks the login button, the system calls the user login API and returns the token if the login is successful. We use this token for calling the Articles APIs via the header with Authorization Bearer Token. It aims to secure APIs.

And The `logout` link will destroy the token and redirect to login page again.

### Article Management

I have implemented all APIs related to articles, and they are protected by tokens. Most APIs are designed for authenticated users. Additionally, CRUD features have been implemented, including an Article List page, Create New Article page, and Edit Article page. All pages utilize AJAX calls to Article APIs for content management, authenticated via tokens.

| Title                          | Endpoints            | Remark                                                    |
| ------------------------------ | -------------------- | ----------------------------------------------------------|
| Retrieve All Articles (GET)    | /articles.json       | Can only be used by authenticated users.                            |
| Retrieve a Single Article (GET)| /articles/{id}.json  | Can only be used by all users.                            |
| Create an Article (POST)       | /articles.json       | Can only be used by authenticated users.                  |
| Update an Article (PUT)        | /articles/{id}.json  | Can only be used by authenticated users.   |
| Delete an Article (DELETE)     | /articles/{id}.json  | Can only be used by authenticated users.   |

### Like Feature

The same behaivior I have implemented all APIs related to like a article, and they are protected by tokens. User can click like button on Article list page then the status Like will be update derectly on page by AJAX calling.

| Title                          | Endpoints            | Remark                                                    |
| ------------------------------ | -------------------- | ----------------------------------------------------------|
| Retrieve All Likes (GET)       | /likes.json          | Can only be used by all users.                            |
| Like a Article (POST)          | /likes.json          | Can only be used by authenticated users.                  |