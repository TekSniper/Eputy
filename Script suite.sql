create table postuler
(
num_cand int,
id_election int,
date_postuler date
)engine=innodb;
create table participer
(
num_cand int,
id_tour int
)engine=innodb;
create table creation_elec
(
id_creation int auto_increment primary key,
num_user int,
id_election int,
date_creation date
)engine=innodb;
create table score_candidat
(
id int auto_increment primary key,
id_score int,
num_cand int,
constraint fk_score_score_candidat foreign key(id_score) references score(id_score),
constraint fk_candidat_score_candidat foreign key(num_cand) references candidat(num_cand)
)engine=innodb;
create table utilisateur
(
    num_user int auto_increment PRIMARY KEY,
    prenom varchar(25),
    nom VARCHAR(25),
    identifiant varchar(25) unique not NULL,
    mot_de_passe varchar(25) not null,
    user_profile VARCHAR(15) not null
)engine=InnoDB;

alter table tour add constraint fk_election_tour foreign key(id_election) references election(id_election);
alter table postuler add constraint fk_candidat_postuler foreign key(num_cand) references candidat(num_cand);
alter table postuler add constraint fk_election_postuler foreign key(id_election) references election(id_election);
alter table participer add constraint fk_candidat_participer foreign key(num_cand) references candidat(num_cand);
alter table participer add constraint fk_tour_participer foreign key(id_tour) references tour(id_tour);
alter table score add constraint fk_tour_score foreign key(id_tour) references tour(id_tour);
alter table creation_elec add constraint fk_election_creation foreign key(id_election) references election(id_election);
alter table creation_elec add constraint fk_utilisateur_creation foreign key(num_user) references utilisateur(num_user);
alter table candidat add num_user int;
alter table candidat add constraint fk_utilisateur_candidat foreign key(num_user) references utilisateur(num_user);
