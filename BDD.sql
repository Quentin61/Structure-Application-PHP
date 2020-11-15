DROP DATABASE IF EXISTS STRUCTURE;

CREATE DATABASE IF NOT EXISTS STRUCTURE;
USE STRUCTURE;

CREATE TABLE `ST_USER`(
    `US_ID` varchar(15) NOT NULL,
    `US_LOGIN` varchar(32) NOT NULL,
    `US_PASSWORD` varchar(60) NOT NULL,
    `US_MAIL` varchar(80) NOT NULL,
    `US_NAME` varchar(25) NOT NULL,
    `US_TYPE` varchar(15) NOT NULL DEFAULT 'user'
);

ALTER TABLE `ST_USER` ADD CONSTRAINT USER_PR_KEY PRIMARY KEY (US_ID);