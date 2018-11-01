create table posts(
id int(11) not null auto_increment,
title varchar(123) not null,
content text not null,
create_at timestamp not null default current_timestamp,
PRIMARY key (id),
key create_at (create_at)
)engine=InnoDB default CHARSET=utf8;


insert into posts(title,content)values
('First post','This is a really interesting post'),
('Second post','This is a fascinating post'),
('Third post','This is a very informative post');