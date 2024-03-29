/* Example
CREATE TABLE "user" (
    id SERIAL PRIMARY KEY ,
    firstname VARCHAR NOT NULL ,
    lastname VARCHAR NOT NULL ,
    birthday date
);

INSERT INTO "user"(firstname, lastname, birthday) VALUES ('John', 'Doe', '1967-11-22');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Yvette', 'Angel', '1932-01-24');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Amelia', 'Waters', '1981-12-01');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Manuel', 'Holloway', '1979-07-25');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Alonzo', 'Erickson', '1947-11-13');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Otis', 'Roberson', '1995-01-09');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Jaime', 'King', '1924-05-30');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Vicky', 'Pearson', '1982-12-12)');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Silvia', 'Mcguire', '1971-03-02');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Brendan', 'Pena', '1950-02-17');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Jackie', 'Cohen', '1967-01-27');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Delores', 'Williamson', '1961-07-19');
*/

create table users (
	id_user serial primary key,
	firstname varchar not null,
	lastname varchar not null,
	pseudo varchar unique not null,
	year int not null,
	password varchar default 'default',
	mail varchar not null default 'null',
	bde int default 0 check(bde=0 or bde=1),
	president int default 0 check(president=0 or president=1)
);

create table associations (
	id_asso serial primary key,
	name varchar not null,
	president int references users(id_user),
	coeff_asso int not null default 1 check (coeff_asso<=100 and coeff_asso>0)
);

create table events (
	id_event serial primary key,
	name varchar not null,
	description_event varchar,
	date_ev date not null,
	id_asso int references associations(id_asso),
	coeff_event int default 1 check (coeff_event<=100 and coeff_event>0)
);

create table score (
	id_user int references users(id_user),
	id_event int references events(id_event),
	description_score varchar,
	notation int not null check(notation<=10 and notation>0),
	primary key (id_user,id_event)
);


create table pointsassos (
	id_user int references users(id_user),
	id_asso int references associations(id_asso),
	notation int not null check(notation<=10 and notation>0),
	proposition int not null check(proposition<=10 and proposition>0),
	primary key (id_user,id_asso)
);

create view pointsassos_prop as select id_user,id_asso,sum(a.point)/sum(a.coefficient) moyenne 
from (select id_asso,id_event,id_user, notation*coeff_event point, coeff_event coefficient from score join events using (id_event)) a 
group by id_asso,id_user;

create view leaderboard as select id_user,sum(a.point) moyenne 
from (select id_user,id_asso, notation*coeff_asso point, coeff_asso coefficient from pointsassos join associations using (id_asso)) a
group by a.id_user
order by moyenne asc;

insert into users (firstname,lastname,pseudo,year,president,mail) values ('Loïc','Dubard','Wikle',2018,1,'loic97429@gmail.com');
insert into users(firstname,lastname,pseudo,year,bde,president) values ('Quentin','Japhet','Samuh',2018,1,1);
insert into users(firstname,lastname,pseudo,year,bde,president) values ('Antoine','Boudinel','Boudi',2018,1,1);
insert into users(firstname,lastname,pseudo,year) values ('Corentin','Lafond','Tuareg',2017);
insert into users(firstname,lastname,pseudo,year) values ('Oscar','Pothier','Oskul',2018);
insert into users(firstname,lastname,pseudo,year) values ('Aurélien','Inacio','Prophet',2018);
insert into users(firstname,lastname,pseudo,year) values ('Maël','Martin','Kubat',2018);
insert into users(firstname,lastname,pseudo,year) values ('Alexis','Bourget','Polio',2018);
insert into users(firstname,lastname,pseudo,year) values ('Paul','Barbé','Agammon',2017);
insert into associations(name,president) values ('Securitiie',1);
insert into associations(name,president) values ('Vocaliise',2);
insert into associations(name,president) values ('BDE',3);
insert into associations(name,president) values ('Martiiale',2);
insert into associations(name,president) values ('Escalade',1);
insert into events(name,id_asso,coeff_event,date_ev) values ('reu',1,1,'2019-01-10'); 
insert into score(id_user,id_event,notation) values (1,1,10);
insert into pointsassos(id_user,id_asso,notation,proposition) values (1,1,9,10);
insert into pointsassos(id_user,id_asso,notation,proposition) values (3,1,7,10);
insert into pointsassos(id_user,id_asso,notation,proposition) values (2,2,8,10);

