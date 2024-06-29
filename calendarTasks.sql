CREATE DATABASE CALENDAR;
USE CALENDAR;

CREATE TABLE Tasks (
	id_task INT PRIMARY KEY AUTO_INCREMENT,
	description_task VARCHAR(50) NOT NULL,
    date_hour_task DATETIME NOT NULL,
    status_task VARCHAR(20) NOT NULL,
    CONSTRAINT ck_status_task CHECK(status_task IN("Pendiente", "En proceso", "Completado"))
    );