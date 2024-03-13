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

Run command line below to create a admin user:

```
bin/cake migrations seed --seed UsersSeed
```

### Accessing the Application

The application should now be accessible at http://localhost:34251. The system will be redirect to http://localhost:34251/user/login page then you can login with email as `admin@example.com` and password is `admin123`

## How to check

I have implemented all APIs related to articles, users and like article. Please import all APIs into Postman form Betamind.`API-Collection.json`

### Authentication

TODO: pls summarize how to check "Authentication" bahavior

### Article Management

I have implemented all APIs related to articles, and they are protected by tokens.

| Title                          | Endpoints            | Remark                                                    |
| ------------------------------ | -------------------- | ----------------------------------------------------------|
| Retrieve All Articles (GET)    | /articles.json       | Can only be used by all users.                            |
| Retrieve a Single Article (GET)| /articles/{id}.json  | Can only be used by all users.                            |
| Create an Article (POST)       | /articles.json       | Can only be used by authenticated users.                  |
| Update an Article (PUT)        | /articles/{id}.json  | Can only be used by authenticated article writer users.   |
| Delete an Article (DELETE)     | /articles/{id}.json  | Can only be used by authenticated article writer users.   |

### Like Feature

TODO: pls summarize how to check "Like Feature" bahavior
