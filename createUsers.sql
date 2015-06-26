use test;
drop table if exists users;
create table users(
    user_id integer not null primary key auto_increment,
    login varchar(25) not null unique,
    email varchar(50) not null unique,
    pwd varchar(50) not null,
    last_name varchar(25),
    first_name varchar(25)
);
