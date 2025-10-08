# Attendance Project

This repository contains an attendance management PHP project with frontend assets.

## Local setup

1. Copy `.env.example` to `.env` and update the values for your environment (do not commit `.env`).

2. Ensure you have PHP, Apache (or another web server) and MySQL installed.

3. Create the database and import `demo.sql` if you want the sample schema/data:

   mysql -u root -p demo < demo.sql

4. Place the project folder in your web server's document root (for example `/var/www/html/final_year_project`) or configure a virtual host pointing to this folder.

5. Start your web server and visit the app in the browser (e.g., http://localhost/final_year_project/).

## Notes
- Database connection reads values from environment variables: `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`.
- Large vendor assets are included under `assets/vendor/`. Consider using CDN versions or git LFS if this repo grows.
