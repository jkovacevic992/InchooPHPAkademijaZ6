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
  post int
)engine=InnoDB;

alter table comment add foreign key (post) references post(id);



insert into post (content) values ('Evo danas pada kiša opet :('), ('Jedem jagode.');
insert into comment (content,post) values ('Komentar na tvoju kišu',1);
