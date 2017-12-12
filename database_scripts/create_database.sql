PRAGMA foreign_keys = on;
BEGIN TRANSACTION;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS projects;
DROP TABLE IF EXISTS tasks;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS projectUsers;
CREATE TABLE users(id INTEGER PRIMARY KEY,username TEXT UNIQUE,password TEXT, email TEXT UNIQUE, apiKey TEXT, imageRef INTEGER);
CREATE TABLE projects(id INTEGER PRIMARY KEY, name TEXT,color TEXT, creator INTEGER REFERENCES users (id) ON DELETE CASCADE, categoryRef INTEGER REFERENCES categories(id) ON DELETE CASCADE);
CREATE TABLE tasks(id INTEGER PRIMARY KEY, projectRef INTEGER REFERENCES projects (id) ON DELETE CASCADE , information TEXT, priority INTEGER, dateDue INTEGER, isChecked INTEGER, assignedTo INTEGER REFERENCES users(id) ON DELETE CASCADE);
CREATE TABLE categories(id INTEGER PRIMARY KEY, title TEXT UNIQUE);
CREATE TABLE projectUsers(projectRef INTEGER REFERENCES projects(id) ON DELETE CASCADE, userRef INTEGER REFERENCES users(id) ON DELETE CASCADE, permissions INTEGER, PRIMARY KEY(projectRef,userRef));

COMMIT;

BEGIN TRANSACTION;
/** Password is 'admin'*/
INSERT INTO users (id,username,password,email,apiKey,imageRef) VALUES (1,"JoaoM","8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918","p@gmail.com","aasda",0);
INSERT INTO users (id,username,password,email,apiKey,imageRef) VALUES (2,"root","8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918","pa@gmail.com","aasdassdf",0);
INSERT INTO users (id,username,password,email,apiKey,imageRef) VALUES (3,"noob","8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918","pe@gmail.com","asddsadf",0);
INSERT INTO users (id,username,password,email,apiKey,imageRef) VALUES (4,"pedro","8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918","ped@gmail.com","assddsadf",0);
INSERT INTO users (id,username,password,email,apiKey,imageRef) VALUES (5,"miguel","8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918","miguel@gmail.com","asfddsadf",0);

INSERT INTO categories (id,title) VALUES (1,"SuperMarket");
INSERT INTO categories (id,title) VALUES (2,"Business");
INSERT INTO categories (id,title) VALUES (3,"School");

INSERT INTO projects (id,name,color,creator,categoryRef) VALUES (1,"Gordon","#ff0000",1,1);
INSERT INTO projects (id,name,color,creator,categoryRef) VALUES (2,"Moreno","#00ff00",2,1);
INSERT INTO projects (id,name,color,creator,categoryRef) VALUES (3,"Cochran","#0000ff",3,3);
INSERT INTO projects (id,name,color,creator,categoryRef) VALUES (4,"Cobb","#ff0000",4,2);
INSERT INTO projects (id,name,color,creator,categoryRef) VALUES (5,"Morales","#00ff00",2,1);
INSERT INTO projects (id,name,color,creator,categoryRef) VALUES (6,"Fowler","#0000ff",5,3);
INSERT INTO projects (id,name,color,creator,categoryRef) VALUES (7,"Ferguson","#ff0000",3,2);
INSERT INTO projects (id,name,color,creator,categoryRef) VALUES (8,"Navarro","#00ff00",1,1);

/** project 1  */
INSERT INTO projectUsers VALUES (1,1,1);
INSERT INTO projectUsers VALUES (1,2,1);
INSERT INTO projectUsers VALUES (1,4,1);
INSERT INTO projectUsers VALUES (1,5,1);
/** project 2  */
INSERT INTO projectUsers VALUES (2,2,1);
INSERT INTO projectUsers VALUES (2,5,1);
INSERT INTO projectUsers VALUES (2,3,1);
/** project 3  */
INSERT INTO projectUsers VALUES (3,3,1);
INSERT INTO projectUsers VALUES (3,5,1);
INSERT INTO projectUsers VALUES (3,1,1);
INSERT INTO projectUsers VALUES (3,4,1);
/** project 4  */
INSERT INTO projectUsers VALUES (4,2,1);
INSERT INTO projectUsers VALUES (4,4,1);
/** project 5  */
INSERT INTO projectUsers VALUES (5,2,1);
INSERT INTO projectUsers VALUES (5,4,1);
INSERT INTO projectUsers VALUES (5,1,1);
INSERT INTO projectUsers VALUES (5,5,1);
/** project 6  */
INSERT INTO projectUsers VALUES (6,3,1);
INSERT INTO projectUsers VALUES (6,4,1);
INSERT INTO projectUsers VALUES (6,1,1);
/** project 7  */
INSERT INTO projectUsers VALUES (7,3,1);
INSERT INTO projectUsers VALUES (7,4,1);
INSERT INTO projectUsers VALUES (7,5,1);
/** project 8  */
INSERT INTO projectUsers VALUES (8,1,1);
INSERT INTO projectUsers VALUES (8,5,1);
INSERT INTO projectUsers VALUES (8,3,1);
INSERT INTO projectUsers VALUES (8,2,1);


INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (1,1,"Ipsum Corp",1,1514149200,0,2);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (2,2,"Metus Aenean Sed Corporation",1,1513188000,0,2);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (3,3,"Magna Et Associates",1,1513191600,0,5);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (4,4,"Neque Et Nunc Inc",1,1513195200,0,2);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (5,5,"Nunc Sit Foundation",1,1513198800,0,1);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (6,6,"Sem Industries",1,1513202400,0,4);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (7,7,"Tellus Suspendisse Sed Consulting",1,1513206000,0,5);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (8,8,"Phasellus Vitae Industries",1,1513184400,0,1);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (9,1,"Vivamus Consulting",1,1513180800,0,1);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (10,2,"Nulla Vulputate Limited",1,1513292400,0,2);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (11,3,"Eu Ligula Company",1,1513267200,0,1);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (12,4,"Natoque LLC",1,1513346400,0,4);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (13,5,"Quis Pede Foundation",1,1513353600,0,1);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (14,6,"Curae; Phasellus Limited",1,1513368000,0,3);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (15,7,"Vulputate LLC",1,1513285200,0,5);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (16,8,"Dui Company",1,1513278000,0,5);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (17,1,"Tempus Mauris Limited",1,1513260000,0,1);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (18,3,"Quisque Consulting",1,1513242000,0,3);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (19,2,"Orci Lacus Vestibulum Foundation",1,1513328400,0,5);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (20,5,"Malesuada Augue Ltd",1,1513350000,0,4);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (21,1,"Tellus Lorem Eu Associates",1,1513443600,0,4);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (22,2,"Sodales Nisi PC",1,1513447200,0,5);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (23,3,"Aenean Euismod LLP",1,1513454400,0,3);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (24,4,"Lorem PC",1,1513411200,0,2);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (25,8,"Rutrum Company",1,1513504800,0,3);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (26,6,"Tortor Company",1,1513508400,0,1);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (27,7,"Ad Litora Torquent Associates",1,1513512000,0,4);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (28,8,"In Lobortis Tellus Associates",1,1513526400,0,3);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (29,5,"Phasellus In PC",1,1513533600,0,5);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (30,2,"A Corp",1,1513540800,0,3);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (31,3,"Aliquam Corp",1,1513548000,0,4);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (32,2,"Pede Incorporated",1,1513551600,0,3);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (33,3,"Tempus Non Company",1,1513630800,0,1);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (34,4,"Consequat Limited",1,1513634400,0,2);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (35,1,"Vehicula Aliquet Libero Limited",1,1513587600,0,5);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (36,1,"Ante Maecenas Mi LLP",1,1513598400,0,4);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (37,5,"Dolor Dolor PC",1,1513684800,0,2);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (38,6,"Dapibus Foundation",1,1513692000,0,4);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (39,7,"Euismod Foundation",1,1513699200,0,3);
INSERT INTO tasks (id,projectRef,information,priority,dateDue,isChecked,assignedTo) VALUES (40,8,"Orci Lacus Vestibulum Limited",1,1513717200,0,2);

COMMIT;

.exit
