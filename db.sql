SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE SCHEMA equipmentinventory;

CREATE TABLE user(
	user_id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	employee_id int(11) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(60) NOT NULL,
    status tinyint(1) NOT NULL DEFAULT '0',
    role tinyint(1) NOT NULL DEFAULT '0',
    date_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE equipment_type(
	equipment_type_id int(11) NOT NULL,
    equipment_name VARCHAR(255) NOT NULL,
    description text
);

CREATE TABLE equipment(
	equipment_id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    equipment_type_id int(11) NOT NULL,
    brand VARCHAR(50),
    model VARCHAR(50),
    acquired_date date NOT NULL,
    current_location_id int(11) NOT NULL,
    serial_number VARCHAR(50),
    mr_no VARCHAR(50),
    person_accountable_id int(11) NOT NULL,
    remarks text
);

CREATE TABLE equipment_transfer_history(
	equipment_transfer_history_id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	equipment_id int(11) NOT NULL,
	date_of_transfer date NOT NULL,
    transfer_person_accountable_id int(11) NOT NULL,
    transfer_location_id int(11) NOT NULL
)