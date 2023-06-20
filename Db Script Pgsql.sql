
create table candidat
(
num_cand serial,
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
profession varchar(45),
parti_politique varchar(50),
rue varchar(35),
numero varchar(6),
quartier varchar(35),
commune varchar(35),
ville varchar(45),
pays varchar(45),
CONSTRAINT pk_candidat PRIMARY KEY(num_cand)
);
create table utilisateur
(
    num_user serial,
    prenom varchar(25),
    nom VARCHAR(25),
    identifiant varchar(25) unique not NULL,
    mot_de_passe varchar(25) not null,
    user_profile VARCHAR(15) not null,
    CONSTRAINT pk_utilisateur PRIMARY KEY(num_user)
);
create table election
(
id_election serial,
num_user int,
edition varchar(12),
date_election date,
CONSTRAINT pk_candidat PRIMARY KEY(id_election)
);
create table tour
(
id_tour serial,
designation varchar(9),
id_election int,
CONSTRAINT pk_candidat PRIMARY KEY(id_tour)
);
create table score
(
id_score serial,
id_tour int,
valeur decimal(5,2),
CONSTRAINT pk_candidat PRIMARY KEY(id_score)
);
create table postuler
(
num_cand int,
id_election int,
date_postuler date
);
create table participer
(
num_cand int,
id_tour int
);
create table score_candidat
(
id int auto_increment primary key,
id_score int,
num_cand int,
constraint fk_score_score_candidat foreign key(id_score) references score(id_score),
constraint fk_candidat_score_candidat foreign key(num_cand) references candidat(num_cand)
);





alter table tour add constraint fk_election_tour foreign key(id_election) references election(id_election);
alter table postuler add constraint fk_candidat_postuler foreign key(num_cand) references candidat(num_cand);
alter table postuler add constraint fk_election_postuler foreign key(id_election) references election(id_election);
alter table participer add constraint fk_candidat_participer foreign key(num_cand) references candidat(num_cand);
alter table participer add constraint fk_tour_participer foreign key(id_tour) references tour(id_tour);
alter table score add constraint fk_tour_score foreign key(id_tour) references tour(id_tour);
alter table election add constraint fk_utilisateur_election foreign key(id_election) references election(id_election);



