# Deploying to Render

This application runs on Render as a Docker-based PHP/Apache web service and uses an external MySQL database. Render does not provide managed MySQL databases.

## 1. Push the project to GitHub

Create a GitHub repository and push this project to its default branch. Do not commit database passwords, `.env` files, or provider credentials.

## 2. Create an external MySQL database

Choose a managed MySQL provider that allows connections from Render. Create a database and database user, and note its hostname, port, database name, username, and password. Allow inbound connections from Render as required by that provider, and enable TLS if the provider requires it.

Import `database/oprtfolio.sql` into the new database using the provider's import tool or a MySQL client. The SQL script creates `portfolio_db`; if your provider does not allow `CREATE DATABASE`, create the database first and import the table definitions and sample data into it.

## 3. Create the Render web service

In Render, select **New > Blueprint**, connect the GitHub repository, and apply the `render.yaml` Blueprint. The requested Render service name is `nayishimantesamuel`; if Render accepts that name and it is available, the site will be served at `https://nayishimantesamuel.onrender.com`.

This is a Render subdomain, not a separately registered custom domain. Using `nayishimantesamuel.com` (or another custom domain) requires registering that domain and adding it in Render's Custom Domains settings.

Set these service environment variables in Render's Environment settings:

| Variable | Value |
| --- | --- |
| `DB_HOST` | MySQL provider hostname |
| `DB_PORT` | MySQL provider port (usually `3306`) |
| `DB_NAME` | Database name |
| `DB_USER` | Database username |
| `DB_PASSWORD` | Database password |

Keep the password in Render's environment settings, not in source files. If the MySQL provider requires a client certificate or a provider-specific TLS setting, configure that according to the provider's PHP/MySQL connection instructions before deployment.

For a provider that requires a CA certificate, add its public CA certificate file to the project (for example, `certs/mysql-ca.pem`) and set `DB_SSL_CA` in Render to its absolute container path (for that example: `/var/www/html/certs/mysql-ca.pem`). The connection code enables TLS and certificate verification when this variable is set.

## 4. Verify deployment

Wait for the Render build and deploy to finish, then open the service URL. Render checks `/health.php`; this only confirms the PHP web process is responding. Also verify the home page, projects/services pages, contact form, and `/login.php` so you know the external database connection is working.

The service is configured on Render's free plan. Free services can spin down when idle, so the first request after inactivity may take longer.
