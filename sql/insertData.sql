-- Betroffene Tabellen leeren
    DROP TABLE IF EXISTS source;
    TRUNCATE TABLE fact;
-- ////////////////////////////////////////////////////

-- Tabelle source erstellen
    CREATE TABLE source (
        id CHAR(36) DEFAULT (UUID()) PRIMARY KEY,
        fact INTEGER NOT NULL REFERENCES fact(id),
        link VARCHAR(255) NOT NULL,
        creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
-- ////////////////////////////////////////////////////

-- Tabellen befüllen
    INSERT INTO fact (site, account, quote_by, comment, video_timestamp_start, video_timestamp_end)
    VALUES(
        (SELECT id FROM site WHERE shortenend_name_url='umweltverantwortungsinitiative'),
        (SELECT id FROM account WHERE name='Aussage'),
        (SELECT id FROM person WHERE name='Albert Rösti'),
        'Die Schweiz hat sehr viel getan in den letzten 20-30 Jahren, oder sogar schon vorher, damit wir heute sehr sauberes Wasser und eine gesunde Luft, wie in praktisch keinem anderen Land, haben.',
        289000, 302000
    );
    INSERT INTO fact (site, account, quote_by, comment, video_timestamp_start, video_timestamp_end)
    VALUES(
        (SELECT id FROM site WHERE shortenend_name_url='umweltverantwortungsinitiative'),
        (SELECT id FROM account WHERE name='Falsch'),
        NULL,
        'Laut dem Environmental Performance Index (EPI) des Yale Center for Environmental Law & Policy gehört die Schweiz beim Trinkwasser schon lange zu den Spitzenreitern. ',
        NULL, 302002
    );
    INSERT INTO fact (site, account, quote_by, comment, video_timestamp_start, video_timestamp_end)
    VALUES(
        (SELECT id FROM site WHERE shortenend_name_url='umweltverantwortungsinitiative'),
        (SELECT id FROM account WHERE name='Falsch'),
        NULL,
        'Im Jahr 2008 findet sich in der generellen Dokumentation des EPI eine volle Punktzahl für die Schweiz. Es wurde danach nicht immer voll gepunktet, aber in den aktuelleren Jahren (20, 22, 24) schon.',
        NULL, 302003
    );
    INSERT INTO fact (site, account, quote_by, comment, video_timestamp_start, video_timestamp_end)
    VALUES(
        (SELECT id FROM site WHERE shortenend_name_url='umweltverantwortungsinitiative'),
        (SELECT id FROM account WHERE name='Falsch'),
        NULL,
        'Dennoch kommt es immer wieder zu Grenzwertüberschreitungen etwa durch Pestizide. Rund ein Viertel der Haushalte in der Schweiz trank im Jahr 2024 belastetes Trinkwasser.',
        NULL, 302004
    );
    INSERT INTO fact (site, account, quote_by, comment, video_timestamp_start, video_timestamp_end)
    VALUES(
        (SELECT id FROM site WHERE shortenend_name_url='umweltverantwortungsinitiative'),
        (SELECT id FROM account WHERE name='Falsch'),
        NULL,
        'Bei der Sauberkeit der Gewässer trifft Röstis Aussage nicht zu. Badegewässer liegen unter dem EU-Durchschnitt. Laut einer Studie gilt auch der ökologische Zustand von Bächen bei nur 30% als gesund.',
        NULL, 302005
    );
    INSERT INTO fact (site, account, quote_by, comment, video_timestamp_start, video_timestamp_end)
    VALUES(
        (SELECT id FROM site WHERE shortenend_name_url='umweltverantwortungsinitiative'),
        (SELECT id FROM account WHERE name='Falsch'),
        NULL,
        'Bei der Luftqualität ist die Aussage falsch. Die Schweiz lag laut EPI im Jahr 2024 auf Platz 17 in der Luftverschmutzung.',
        NULL, 302006
    );
    INSERT INTO fact (site, account, quote_by, comment, video_timestamp_start, video_timestamp_end)
    VALUES(
        (SELECT id FROM site WHERE shortenend_name_url='umweltverantwortungsinitiative'),
        (SELECT id FROM account WHERE name='Falsch'),
        NULL,
        'Quellen: ',
        NULL, 302007
    );
    UPDATE fact 
    SET comment = CONCAT(comment, 'http://1fakten.ch/eck-', (SELECT id FROM fact WHERE video_timestamp_end=302000))
    WHERE video_timestamp_end = 302007;
    INSERT INTO source (fact, link)
    VALUES(
        (SELECT id FROM fact WHERE video_timestamp_end=302000),
        'https://epi.yale.edu/measure/2024/UWD'
    );
    INSERT INTO source (fact, link)
    VALUES(
        (SELECT id FROM fact WHERE video_timestamp_end=302000),
        'https://www.earthdata.nasa.gov/data/catalog?keyword=epi'
    );
    INSERT INTO source (fact, link)
    VALUES(
        (SELECT id FROM fact WHERE video_timestamp_end=302000),
        'https://www.srf.ch/sendungen/kassensturz-espresso/kassensturz/trinkwasser-verschmutzung-viele-kantone-wollen-nicht-sagen-wo-trinkwasser-belastet-ist'
    );
    INSERT INTO source (fact, link)
    VALUES(
        (SELECT id FROM fact WHERE video_timestamp_end=302000),
        'https://web.archive.org/web/20250126031432/https://www.bfs.admin.ch/bfs/de/home/statistiken/bevoelkerung/familien/haushalte.html'
    );
    INSERT INTO source (fact, link)
    VALUES(
        (SELECT id FROM fact WHERE video_timestamp_end=302000),
        'https://www.srf.ch/news/schweiz/eu-bericht-zur-wasserqualitaet-qualitaet-der-schweizer-badegewaesser-liegt-unter-eu-durchschnitt'
    );
    INSERT INTO source (fact, link)
    VALUES(
        (SELECT id FROM fact WHERE video_timestamp_end=302000),
        'https://www.srf.ch/news/schweiz/gefaehrdeter-lebensraum-vielen-schweizer-baechen-geht-es-schlecht'
    );

    INSERT INTO fact (site, account, quote_by, comment, video_timestamp_start, video_timestamp_end)
    VALUES(
        (SELECT id FROM site WHERE shortenend_name_url='umweltverantwortungsinitiative'),
        (SELECT id FROM account WHERE name='Aussage'),
        (SELECT id FROM person WHERE name='Albert Rösti'),
        'Wir müssten in den Bereichen Wohnen, Essen, Mobilität unseren Konsum in 10 Jahren um zwei Drittel reduzieren.',
        399000, 410000
    );

    INSERT INTO fact (site, account, quote_by, comment, video_timestamp_start, video_timestamp_end)
    VALUES(
        (SELECT id FROM site WHERE shortenend_name_url='umweltverantwortungsinitiative'),
        (SELECT id FROM account WHERE name='Aussage'),
        (SELECT id FROM person WHERE name='Albert Rösti'),
        'Mit dem Klima- und Innovationsgesetz, dem neuen C02-Gesetz, dem Gesetz zur Kreislaufwirtschaft und dem Gesetz zur nachhaltigen Stromversorgung wird sehr viel zum Umweltschutz gemacht.',
        684000, 720000
    );
    INSERT INTO fact (site, account, quote_by, comment, video_timestamp_start, video_timestamp_end)
    VALUES(
        (SELECT id FROM site WHERE shortenend_name_url='umweltverantwortungsinitiative'),
        (SELECT id FROM account WHERE name='Information'),
        NULL,
        'Rösti bezieht sich auf die in den Quellen genannte Gesetze.',
        NULL, 720002
    );
    INSERT INTO fact (site, account, quote_by, comment, video_timestamp_start, video_timestamp_end)
    VALUES(
        (SELECT id FROM site WHERE shortenend_name_url='umweltverantwortungsinitiative'),
        (SELECT id FROM account WHERE name='Information'),
        NULL,
        'Quellen: ',
        NULL, 720003
    );
    UPDATE fact 
    SET comment = CONCAT(comment, 'http://1fakten.ch/eck-', (SELECT id FROM fact WHERE video_timestamp_end=720000))
    WHERE video_timestamp_end = 720003;

    INSERT INTO fact (site, account, quote_by, comment, video_timestamp_start, video_timestamp_end)
    VALUES(
        (SELECT id FROM site WHERE shortenend_name_url='umweltverantwortungsinitiative'),
        (SELECT id FROM account WHERE name='Aussage'),
        (SELECT id FROM person WHERE name='Magdalena Erni'),
        'Der Klimawandel fordert in der Schweiz jährlich tausende von Menschenleben pro Jahr',
        757000, 763000
    );


-- ////////////////////////////////////////////////////