PRAGMA foreign_keys = on;
BEGIN TRANSACTION;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS projects;
DROP TABLE IF EXISTS tasks;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS images;
DROP TABLE IF EXISTS projectUsers;
CREATE TABLE users(id INTEGER PRIMARY KEY,username TEXT UNIQUE,password TEXT, email TEXT UNIQUE, apiKey TEXT);
CREATE TABLE projects(id INTEGER PRIMARY KEY, name TEXT,color TEXT, creator INTEGER REFERENCES users (id), categoryRef INTEGER REFERENCES categories(id));
CREATE TABLE tasks(id INTEGER PRIMARY KEY, projectRef INTEGER REFERENCES projects (id), information TEXT, priority INTEGER, dateDue INTEGER, isChecked INTEGER, assignedTo INTEGER REFERENCES users(id));
CREATE TABLE categories(id INTEGER PRIMARY KEY, title TEXT UNIQUE);
CREATE TABLE images (id INTEGER PRIMARY KEY,title VARCHAR NOT NULL);
CREATE TABLE projectUsers(projectRef INTEGER REFERENCES projects(id), userRef INTEGER REFERENCES users(id), permissions INTEGER);

COMMIT;
