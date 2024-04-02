FROM mariadb:latest

# Copy the SQL script to the docker-entrypoint-initdb.d directory
COPY ./m183_lb2.sql /docker-entrypoint-initdb.d/init.sql

EXPOSE 3306