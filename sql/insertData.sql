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

    
-- ////////////////////////////////////////////////////