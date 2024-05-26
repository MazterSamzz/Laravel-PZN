-- Create Categories Table
create table categories
(
    id varchar(100) not null primary key,
    name varchar(100) not null,
    description text,
    created_at timestamp
) engine innodb;

desc categories

-- Create Counters Table
create table Counters
(
    id varchar(100) not null primary key,
    counter int not null default 0,
) engine innodb;

-- Insert Counter Data
insert into counters(id, counter) values ('sample', 0);

-- Select Counter Data
select * from counters

-- Create Products Table
create table products
(
    id varchar(100) not null primary key,
    name varchar(100) not null,
    description text null,
    price int not null,
    category_id varchar(100) not null,
    created_at timestamp not null DEFAULT current_timestamp,
    constraint fk_category_id foreign key (category_id) references categories (id)
) engine innodb;

select * from products