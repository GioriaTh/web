# Disaster Relief Management — Web App

![PHP](https://img.shields.io/badge/PHP-backend-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-database-4479A1?logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-maps-F7DF1E?logo=javascript&logoColor=black)
![Docker](https://img.shields.io/badge/Docker-MySQL-2496ED?logo=docker&logoColor=white)

> University team project, forked from [AtaQou/web](https://github.com/AtaQou/web).

A web platform that coordinates humanitarian aid after a disaster. Citizens request supplies,
administrators manage inventory and announcements, and rescuers pick up and deliver tasks on a live map.

## Features

**Administrator**
- Manage item categories and inventory (manual entry or JSON import)
- Create announcements for needed items
- Create rescuer accounts
- Map of the base, vehicles, requests and offers
- Statistics page

**Rescuer**
- Map view with base location and open tasks
- Accept, complete or cancel tasks
- Update vehicle location

**Citizen**
- Register with location
- Submit requests for items and track their status
- Offer items in response to announcements

## Repository structure

```
web/
├── docker_compose.yml        # MySQL container (port 3310)
├── db_init.txt               # SQL schema: users, vehicles, categories, inventory, ...
├── ER_SCHEMA.pdf             # entity-relationship diagram
├── web.pdf                   # project specification
└── web/
    ├── index.php
    ├── includes/             # DB connection + role access checks
    ├── assets/style.css
    └── pages/
        ├── admin/            # item management, announcements, rescuers, map, stats
        ├── rescuer/          # rescuer map & tasks
        └── citizen/          # registration, requests & offers
```

## Getting started

Requirements: Docker, PHP 8 with `pdo_mysql`.

```bash
git clone https://github.com/GioriaTh/web.git
cd web

# 1. Start MySQL (root / root, port 3310)
docker compose -f docker_compose.yml up -d

# 2. Create the schema
docker exec -i web-mysql mysql -uroot -proot < db_init.txt

# 3. Serve the app
php -S localhost:8000 -t web
```

Open <http://localhost:8000>. Connection settings are in `web/includes/db_connect.php`.

## Notes

- Credentials are development defaults (`root` / `root`) — change them before deploying anywhere.
- `pages/citizen/register.php` stores the password as entered; it should use `password_hash()` /
  `password_verify()`.
- `index.php` uses `$pdo`, but `db_connect.php` creates `$conn`.

## Team

Developed as a team project. Original repository: [AtaQou/web](https://github.com/AtaQou/web).
My fork: [GioriaTh](https://github.com/GioriaTh).
