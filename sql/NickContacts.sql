CREATE TABLE NickContacts
(email varchar(100) not null,
 kind varchar(100) not null,
 contact varchar(100) not null,
 primary key (email, kind),
 foreign key (email) references Nicks (email) on delete cascade
 )