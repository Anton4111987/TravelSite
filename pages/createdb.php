<?
    include_once("functions.php");
    $link = connect();
 
    $ct1 = "create table countries(
        id int not null auto_increment primary key,
        country varchar(64) not null unique
    )";
 
    $ct2 = "create table cities(
        id int not null auto_increment primary key,
        city varchar(64) not null,
        countryid int,
        foreign key(countryid) references countries(id) on delete cascade,
        ucity varchar(128),
        unique index ucity(city, countryid)
    )";
 
    $ct3 = "create table hotels(
        id int not null auto_increment primary key,
        hotel varchar(64),
        cityid int,
        foreign key(cityid) references cities(id) on delete cascade,
        stars int,
        rate int,
        cost decimal(10,2),
        info varchar(1024)
    )";
 
    $ct4 = "create table images(
        id int not null auto_increment primary key,
        imagepath varchar(255),
        hotelid int,
        foreign key(hotelid) references hotels(id) on delete cascade
    )";
 
    $ct5 = "create table roles(
        id int not null auto_increment primary key,
        role varchar(32)
    )";
 
    $ct6 = "create table users(
        id int not null auto_increment primary key,
        login varchar(32) unique,
        pass varchar(128),
        email varchar(128),
        roleid int,
        foreign key(roleid) references roles(id) on delete cascade,
        avatar mediumblob,
        discount int
    )";

    if ($link->query($ct1)) {
        echo "Таблица Countries успешно создана";
    } else {
        echo "Ошибка: " . $link->error;
    }
     
    if ($link->query($ct2)) {
        echo "Таблица Cities успешно создана";
    } else {
        echo "Ошибка: " . $link->error;
    }
     
    if ($link->query($ct3)) {
        echo "Таблица Hotels успешно создана";
    } else {
        echo "Ошибка: " . $link->error;
    }
     
    if ($link->query($ct4)) {
        echo "Таблица Images успешно создана";
    } else {
        echo "Ошибка: " . $link->error;
    }
     
    if ($link->query($ct5)) {
        echo "Таблица Roles успешно создана";
    } else {
        echo "Ошибка: " . $link->error;
    }
     
    if ($link->query($ct6)) {
        echo "Таблица Users успешно создана";
    } else {
        echo "Ошибка: " . $link->error;
    }
     
    $link->close();

?>