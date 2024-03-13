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

Create a admin user:

```
bin/cake migrations seed --seed UsersSeed
```

### Accessing the Application

The application should now be accessible at http://localhost:34251

## How to check

### Authentication

TODO: pls summarize how to check "Authentication" bahavior

### Article Management

TODO: pls summarize how to check "Article Management" bahavior

### Like Feature

TODO: pls summarize how to check "Like Feature" bahavior
