create table postuler
(
num_cand int candidat(num_cand),
id_election int,
date_postuler date
)engine=innodb;
create table participer
(
num_cand int candidat(nul_cand),
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