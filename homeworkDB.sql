create table utenti (
    username VARCHAR(255) NOT NULL PRIMARY KEY,
    pass  VARCHAR(255) NOT NULL,
    nome VARCHAR(255) NOT NULL,
    cognome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
);




create table published_post(
    utente VARCHAR(255),
    titolo  VARCHAR(255),
    anno INT,
    durata INT,
    descrizione VARCHAR(511),
    url_poster VARCHAR(511),
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nlike INT DEFAULT 0,
    FOREIGN KEY (utente) REFERENCES utenti(username) 

);



CREATE TABLE liked_post(
    id_post INT,
    username VARCHAR(255),
    FOREIGN KEY (id_post) REFERENCES published_post(id) ON DELETE CASCADE,
    FOREIGN KEY (username) REFERENCES utenti(username),
    PRIMARY KEY (id_post, username)  
); 

CREATE TRIGGER update_like
AFTER INSERT 
ON liked_post FOR EACH ROW
BEGIN
    UPDATE published_post SET nlike = nlike + 1 WHERE id = new.id_post;
END



CREATE TRIGGER remove_like
AFTER DELETE 
ON liked_post FOR EACH ROW
BEGIN
    UPDATE published_post SET nlike = nlike - 1 WHERE id = old.id_post;
END



/*Questa query conta il numero di post pubblicati*/
SELECT count(*) as numero_post_pubblicati
FROM utenti as U JOIN published_post as PP
ON U.username=PP.utente
WHERE U.username="MarRos";



/*Questa query conta il numero di like ricevuti*/
SELECT sum(PP.nlike) 
FROM published_post as PP
WHERE PP.utente="MarRos";


/*Questa query conta il numero di like messi*/
SELECT count(*) as numero_like_messi
FROM liked_post as U
WHERE U.username="MarRos";


CREATE TABLE pic_profile(
    username VARCHAR(255) PRIMARY KEY,
    picprofile longblob,
    FOREIGN KEY (username) REFERENCES utenti(username)
);


