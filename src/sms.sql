CREATE TABLE customer(
    uid INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(32) BINARY,
    userpassword VARCHAR(32) BINARY,
    realname VARCHAR(32),
    passport VARCHAR(32),
    email VARCHAR(64),
    phone VARCHAR(16),
    region VARCHAR(32)
);

CREATE TABLE reps(
    rid INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(32) BINARY,
    userpassword VARCHAR(32) BINARY,
    realname VARCHAR(32),
    email VARCHAR(64),
    phone VARCHAR(16),
    region VARCHAR(32),
    quota VARCHAR(32)
);

CREATE TABLE manager(
    mid INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(32) BINARY,
    userpassword VARCHAR(32) BINARY
);

CREATE TABLE orders(
    oid INT PRIMARY KEY AUTO_INCREMENT,
    customer VARCHAR(32),
    orderdate DATETIME,
    n95num VARCHAR(32),
    surgicalnum VARCHAR(32),
    surgicaln95num VARCHAR(32),
    amount VARCHAR(32),
    repsid VARCHAR(32),
    repsquota VARCHAR(32),
    orderstatus VARCHAR(32)
);
