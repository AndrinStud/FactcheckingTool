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
-- ////////////////////////////////////////////////////