CREATE DATABASE auto_db;

use auto_db;


CREATE TABLE users(
    user_id int NOT NULL AUTO_INCREMENT,
    email VARCHAR(128),
    pass CHAR(48),
    PRIMARY key(user_id)
);

CREATE TABLE autos(
    auto_id int NOT NULL AUTO_INCREMENT,
    make VARCHAR(128),
    model VARCHAR(128),
    year int,
    mileage int,
    user_id int,
    PRIMARY KEY (auto_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);