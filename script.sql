DROP DATABASE IF EXISTS social_network;
CREATE DATABASE social_network CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
use social_network;

create table post(
id int not null primary key auto_increment,
content text,
time timestamp,
image varchar(200)

)engine=InnoDB;

create table comment(
  id int not null primary key auto_increment,
  content text,
  postID int,
  foreign key (postID) references post(id) on delete cascade
)engine=InnoDB;


insert into post (content) values ('Evo danas pada kiša opet :('), ('Jedem jagode.');
insert into comment (content,postID) values ('Komentar na tvoju kišu',1);
