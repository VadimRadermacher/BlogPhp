DROP TABLE IF EXISTS "articles";
DROP SEQUENCE IF EXISTS articles_article_id_seq;
CREATE SEQUENCE articles_article_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

DROP TABLE IF EXISTS "users";
DROP SEQUENCE IF EXISTS users_user_id_seq;
CREATE SEQUENCE users_user_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."users" (
    "user_id" integer DEFAULT nextval('users_user_id_seq') NOT NULL,
    "user_name" character varying(255) NOT NULL,
    "user_pwd" character varying(255) NOT NULL,
    "user_email" character varying(255) NOT NULL,
    "user_permission" smallint DEFAULT '0' NOT NULL
) WITH (oids = false);

INSERT INTO "users" ("user_id", "user_name", "user_pwd", "user_email", "user_permission") VALUES
(49,	'jm',	'$2y$10$UkrTAYy6LLx5NECESg47le8k/nPEMtaIVfQZwbUzNFzoGrqj..a1y',	'vise@vise.jm',	'0'),
(50,	'nabil',	'$2y$10$bQdWTIaNzH1NTyUPkHTyuuhCBuDiGSNNOKA0mTBd8krr583ZyUbhq',	'nabil@gmail.com',	'0'),
(51,	'sfmjksdjfsd',	'$2y$10$Y3TdYRGffgDlzEfvie/6.ebGM1gqecyhLZvTJHTh80H/sa7lrQXby',	'vise@vise.jm',	'0'),
(52,	'dqssd',	'$2y$10$tGpJ9HhAqAvg8XJ6C5TVCuSDel/FrWhw8wnBdXUCv/6Y22bMaRfNK',	'nabil@gmail.com',	'0'),
(53,	'qsdqd',	'$2y$10$/IHd5iXCB6.hjt1vfdwyBe9VcJ.4MIDC1QyegUNeEnSC5OJVtde72',	'vise@vise.jm',	'0'),
(54,	'wxcwxc',	'$2y$10$8..XW2kI0ZHJtbPwt9bEXOTjHv1IxHiDsmVbOP70pTFaqQrQryvaa',	'wwxc@ssdsd',	'0'),
(55,	'bicky',	'$2y$10$pjjCngLVwC2ckYQKhAurj.ys5EEEOf4imvf7ZrYvP.kIYVoRtAcOW',	'vise@vise.jm',	'0'),
(56,	'bicky2',	'$2y$10$hJltOGaq9Bw9aR0lwtanXeG8sSI9V6og6m8M.7zYpT2y5UapqbvnS',	'vise@vise.jm',	'0'),
(57,	'romain',	'$2y$10$RHVXJ4CpBjZdvYstA8K63OqWBANX0e8MhpEcWr3qNSbhITiozkmfW',	'romain_omg',	2),
(58,	'sdfssd',	'$2y$10$4baWJeJvI7zr8Y2gG.b.0eWdH32CmvAEef5eJcZA.3qQtyh7FN6G.',	'vise@vise.jm',	'0'),
(59,	'sdffdssdffsdsdf',	'$2y$10$.raVhpqzC1klEi2sTOquYOFga..Btr.MGu0GyiZpI2koD1nkYgkOG',	'sdfdssdfsfd@sqjkqsdl',	'0');

CREATE TABLE "public"."articles" (
    "article_id" integer DEFAULT nextval('articles_article_id_seq') NOT NULL,
    "article_title" character varying(255) NOT NULL,
    "article_content" text NOT NULL,
    "author_id" integer NOT NULL,
    "article_date" date NOT NULL
) WITH (oids = false);

INSERT INTO "articles" ("article_id", "article_title", "article_content", "author_id", "article_date") VALUES
('0',	'skldkhqsdj',	'<sqkldjqsmkfqnkldjsqsdmkljqmlsdkqj',	'0',	'0453-04-23'),
(1,	'sldkljsdhfsnqmq',	'ksldjsmkqcn qnsdkjsqsmklqsj',	'0',	'1987-01-12'),
(2,	'sqmlskqù',	'sdkldsjqsmklxnqseuizdjqmskldqsjk',	'0',	'1942-02-15'),
(3,	'qdmlqsqsdlqsdmù',	'ldkqskqsdjùldcnqqeriyruinu',	'0',	'1969-06-23'),
(4,	'skldjzo^kx;ck,scpjspj,j,csj,k',	'ucrnqfvunhhhcdpfchsdjdmlqkcns',	'0',	'1979-04-02'),
(5,	'cdj,mqscsmjkl',	'wksdjmoizedjqsmkl,cqmklsjdqskmld',	'0',	'1989-01-13');