create table utilisateur
(
num_user int auto_increment primary key,
prenom varchar(35),
nom varchar(35),
identifiant varchar(25) unique not null,
mot_de_passe varchar(25) not null,
user_profile varchar(15)
)engine=innodb;
create table candidat
(
num_cand int auto_increment primary key,
nom varchar(35),
postnom varchar(35),
prenom varchar(35),
email varchar(35),
telephone_1 varchar(20),
telephone_2 varchar(20),
telephone_3 varchar(20),
sexe char(1),
lieu_de_naissance varchar(35),
date_de_naissance date,
nationalite varchar(35),
profession varchar(35),
parti_politique varchar(50),
rue varchar(25),
numero varchar(6),
quartier varchar(25),
commune varchar(25),
ville varchar(25),
pays varchar(25),
score decimal(5,2)
)engine=innodb;
create table election
(
id_election int auto_increment primary key,
edition varchar(12),
date_election date
)engine=innodb;
create table tour
(
id_tour int auto_increment primary key,
designation varchar(9),
id_election int references election(id_election)
)engine=innodb;
create table postuler
(
num_cand int references candidat(num_cand),
id_election int references election(id_election),
date_postuler date
)engine=innodb;
create table participer
(
num_cand int references candidat(nul_cand),
id_tour int references tour(id_tour)
)engine=innodb;
create table creation_elec
(
id_creation int auto_increment primary key,
num_user int references utilisateur(num_user),
id_election int references election(id_election),
date_creation date
)engine=innodb;