DROP TABLE IF EXISTS "articles";
DROP SEQUENCE IF EXISTS articles_article_id_seq1;
CREATE SEQUENCE articles_article_id_seq1
INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

DROP TABLE IF EXISTS "users";
DROP SEQUENCE IF EXISTS users_user_id_seq1;
CREATE SEQUENCE users_user_id_seq1
INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."users"
(
    "user_id" integer DEFAULT nextval('users_user_id_seq1') NOT NULL,
    "user_name" character varying(255) NOT NULL,
    "user_pwd" character varying(255) NOT NULL,
    "user_email" character varying(255) NOT NULL,
    "user_permission" smallint DEFAULT '0' NOT NULL,
    CONSTRAINT "users_pkey" PRIMARY KEY ("user_id"),
    CONSTRAINT "users_user_name_key" UNIQUE ("user_name")
)
WITH (oids = false);

INSERT INTO "users"
    ("user_name", "user_pwd", "user_email", "user_permission")
VALUES
    ('Romain', '$2y$10$sDE5hEznlfKJvnMyaIv0KuMlb9fgTvr/SBq6ijj6.MHcpDWFcfv.G', 'romain@gmail.com', 2),
    ('Vadim', '$2y$10$rJCd5kRSw1pQcOb1On7V2O8jQfWvF7wyIBhJl/Sfd2Sk0ipcLqrKW', 'vadim@gmail.com', 1),
    ('Nabil', '$2y$10$mayp/jI.Isk3TISGY3Go3O.RWAz64IcLSsXyL2UDXcf9QglumtE9a', 'nabil@gmail.com', 1),
    ('Stéphanie', '$2y$10$SidP5tW6ueqv9UZDPdxUVuFB1mu3jWZYjxxTvKV776NHajlgSCuvO', 'stephanie@gmail.com', 1);


CREATE TABLE "public"."articles"
(
    "article_id" integer DEFAULT nextval('articles_article_id_seq1') NOT NULL,
    "article_title" character varying(255) NOT NULL,
    "article_content" text NOT NULL,
    "article_date" TIMESTAMP NOT NULL,
    "user_id" integer NOT NULL,
    CONSTRAINT "articles_pkey" PRIMARY KEY ("article_id"),
    CONSTRAINT "articles_user_id_fkey" FOREIGN KEY (user_id) REFERENCES users(user_id)
    NOT DEFERRABLE
)
    WITH
    (oids = false);

    INSERT INTO "articles"
        ("article_title", "article_content", "article_date", "user_id")
    VALUES
        ('Le café indonésien Kopi Luwak', 'Le kopi luwak est un café récolté dans les excréments d''une civette asiatique, le luwak (Paradoxurus hermaphroditus) de la famille des viverridés, du fait dune digestion quasi absente.

La civette consomme en effet les cerises du caféier, digérant leur pulpe mais pas leur noyau, qui se retrouve dans ses excréments. Dans le tube digestif du luwak, les sucs gastriques — composés denzymes qui divisent les chaînes de protéines en chaînes plus petites ou en acides aminés individuels — font subir une transformation bénéfique aux arômes des grains de café.

Il est produit essentiellement dans larchipel indonésien, à Sumatra, Java, Bali, Sulawesi, aux Philippines et dans le Timor oriental.', '2019-03-14', 1),
        ('Le café jamaïcain Blue Mountain', ' Le Jamaica Blue Mountain est un type de café obtenu à partir de caféiers cultivés dans les Blue Mountains, en
    Jamaïque. Les meilleurs lots se distinguent par leur saveur douce et peu amère. De fait, au cours des dernières décennies, le Jamaica Blue Mountain a joui dune réputation qui faisait de lui lun des cafés les plus chers et les plus recherchés au monde.', '2019-03-14', 1),
        ('Le Moka éthiopien', 'Les cafés éthiopiens étaient autrefois exportés depuis le Port de Mocha au Yémen dans la péninsule arabique. Doù le nom café Moka . Berceau du café, lEthiopie est réputé pour ses cafés Arabica et ses hauts plateaux (1500-2300 mètres) donnant au café des caractéristiques organoleptiques exceptionnelles (notamment en terme de complexité aromatique et de vivacité). 
La légende du café moka d’Ethiopie Lhistoire prétend que cest un berger du nom de Kaldi qui a découvert les vertus excitantes du café lorsquune de ses chèvres sest mise à faire des bonds après avoir mangé des cerises de café (vers le VIIIe siècle). La culture du café et son usage furent ensuite diffusés par les moines pour se maintenir éveillés pendant leurs longs offices. Au XVe siècle, le port de Mocha au Yemen fut créé. 
Cest de cet endroit que le café Ethiopien était exporté. Pendant longtemps, lEthiopie garda le monopole du marché.', '2019-03-14', 2),
        ('Le café Tanzanien Peaberry Coffee', 'Le peaberry est un grain de café rond, contrairement aux grains classiques qui contiennent deux grains côtes à côte, chacun avec un côté plat. La forme et la plus grande densité de ces grains leur permettent dêtre torréfiés de manière plus uniforme. Pour récolter les peaberry, un tri manuel rigoureux qui les séparent des grains ordinaires est indispensable, ce qui explique le cout élevé du café. 
Les grains de café Peaberry ont tendance à avoir une acidité plus vive, un corps moyen et des notes de cassonade et un fruité subtil. ', '2019-03-14', 2),
        ('Le café Kenyan AA Coffee', ' Le café kenyan AA est un café dont les graines sont parmi les plus grosses du pays. Elles sont triées manuellement par les agriculteurs, ce qui garantit des grains de très haute qualité et, donc, un café d exception. Le café Kenyan AA est caractérisé par une note de fruits sucrés, une acidité vineuse et un corps sirupeux qui vous laisseront un sourire après chaque tasse.', '2019-03-14', 3),
        ('le café bahia du brésil', 'Premier producteur et premier exportateur, le Brésil produit 25 % de l offre mondiale de café. Les deux tiers de sa production sont exporté.
C est également le premier pays consommateur de café dans le monde, devant les Etats-Unis.

C est en 1727 que le café a été introduit au Brésil par Francisco de Mello Palheta, sergent portugais, qui ramena des plants de Guyane.

Pour l anecdote, c’est suite à sa visite au gouverneur de Guyane qu il ramena quelques graines de café. L’histoire raconte que ces dernières furent données par la femme du gouverneur suite à leur courte aventure :-). Info ou intox, personne ne le sait vraiment !' , '2019-03-14', 3),
        ('Le café hawaiien Kona Coffee', 'Kona est le nom de l''île hawaiienne où est cultivé ce café de grande qualité. L''excellent microclimat de l''île, la terre volcanique fertile et l''équilibre parfait de pluie et de soleil offrent des conditions idéales pour le caféier. Généralement considéré comme un café torréfié moyen, la saveur naturelle des grains est préservée autant que possible, leur gout riche et lisse et leur faible acidité seront un excellent ajout à votre journée dès le matin.', '2019-03-14', 4),
        ('Le café Panama Esméralda Geisha', 'La Gesha , parfois appelée Geisha , est une variété de café qui serait originaire du village de Gesha en Éthiopie . Il est considéré comme produisant une tasse de café très aromatique et floral et la demande pour ce café a augmenté ces dernières années.

Il a été importé du Costa Rica au Panama dans la région de Boquete . Il a gagné en notoriété et en popularité en 2004, quand Hacienda La Esmeralda a participé à un concours avec beaucoup de Geisha qui s est révélé très inhabituel et distinct, attirant des prix record', '2019-03-14', 4);
