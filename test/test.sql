INSERT INTO customer (username, userpassword, realname, passport, email, phone, region) VALUES
("user1", "123456", "jlk", "1357","my@qq.com", "13089", "China"),
("user2", "123456", "sdf", "1357","SDA@qq.com", "13089", "China"),
("user3", "123456", "sdaf", "1357","gfd@qq.com", "13089", "China"),
("user4", "123456", "jdf", "2466","yyou@qq.com", "1239", "America"),
("user5", "123456", "jsf", "2345","sf@qq.com", "2344", "Japan"),
("user6", "123456", "jaf", "2345","sdf@qq.com", "2344", "UK");

INSERT INTO manager (username, userpassword) VALUES(
    "manager", "123456"
);

INSERT INTO reps (username, userpassword, realname, email, phone, region, quota) VALUES
("reps1", "123456", "sff", "fads@qq.com", "23457", "China", "4000"),
("reps2", "123456", "gsf", "sd@qq.com", "23457", "America", "-5000"),
("reps3", "123456", "ewr", "das@qq.com", "23457", "Japan", "20000"),
("reps4", "123456", "ASF", "fsa@qq.com", "23457", "UK", "20000"),
("reps5", "123456", "DSF", "gdd@qq.com", "23457", "China", "20000");

INSERT INTO orders(customer, orderdate, n95num, surgicalnum, surgicaln95num, amount, repsid, repsquota, orderstatus) VALUES
("user1", "2020-05-18 16:55:53", "1000", "10000", "5000", "27000", "1", "4000", "Sold"),
("user4", "2020-05-18 16:55:53", "10000", "10000", "5000", "45000", "2", "-5000", "Sold");
