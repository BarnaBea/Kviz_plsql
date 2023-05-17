--------------------------------------------------------
--  File created - hétfõ-május-01-2023   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Trigger CHECK_JATEK_BELEPVE
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "BARNAB"."CHECK_JATEK_BELEPVE" 
BEFORE UPDATE OF jatek_azonosito ON felhasznalo
FOR EACH ROW
DECLARE
    v_jatek_belepve NUMBER;
    v_jatek_letszam NUMBER;
BEGIN
    -- Ha a jatek_azonosito NULL értékre lesz állítva, ellenõrizzük, hogy a játék belepve oszlopa nem nagyobb, mint a játék letszáma oszlopa
    IF :NEW.jatek_azonosito IS NOT NULL THEN
        SELECT belepve, letszam INTO v_jatek_belepve, v_jatek_letszam
        FROM jatek
        WHERE azonosito = :NEW.jatek_azonosito;

        IF v_jatek_belepve > v_jatek_letszam THEN
            -- Ha a feltétel teljesül, akkor visszautasítjuk a módosítást
            RAISE_APPLICATION_ERROR(-20000, 'A játék belepve oszlopa nagyobb, mint a játék letszáma oszlopa.');
        END IF;
    END IF;
END;
/
ALTER TRIGGER "BARNAB"."CHECK_JATEK_BELEPVE" ENABLE;
--------------------------------------------------------
--  DDL for Trigger DECREASE_JATEK_BELEPVE
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "BARNAB"."DECREASE_JATEK_BELEPVE" 
AFTER UPDATE OF jatek_azonosito ON felhasznalo
FOR EACH ROW
BEGIN
    IF :OLD.jatek_azonosito IS NOT NULL AND :NEW.jatek_azonosito IS NULL THEN
        UPDATE jatek SET belepve = belepve - 1 WHERE azonosito = :OLD.jatek_azonosito;
    END IF;
END;
/
ALTER TRIGGER "BARNAB"."DECREASE_JATEK_BELEPVE" ENABLE;
--------------------------------------------------------
--  DDL for Trigger ELETKOR_ELLENORZES
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "BARNAB"."ELETKOR_ELLENORZES" 
BEFORE INSERT ON FELHASZNALO
FOR EACH ROW
DECLARE
    eletkor EXCEPTION;
BEGIN
    IF :new.eletkor < 15 THEN
        RAISE eletkor;
    END IF;
EXCEPTION
    WHEN eletkor THEN
    RAISE_APPLICATION_ERROR(-20001, 'Az új felhasználó által megadott érték kevesebb, mint 15!');
END;
/
ALTER TRIGGER "BARNAB"."ELETKOR_ELLENORZES" ENABLE;
--------------------------------------------------------
--  DDL for Trigger INCREMENT_JATEK_BELEPVE
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "BARNAB"."INCREMENT_JATEK_BELEPVE" 
AFTER UPDATE ON felhasznalo
FOR EACH ROW
BEGIN
    UPDATE jatek
    SET belepve = belepve + 1
    WHERE azonosito = :NEW.jatek_azonosito;
END;
/
ALTER TRIGGER "BARNAB"."INCREMENT_JATEK_BELEPVE" ENABLE;
--------------------------------------------------------
--  DDL for Trigger KERDES_SZOVEG_EGYEDI
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "BARNAB"."KERDES_SZOVEG_EGYEDI" 
BEFORE INSERT ON KERDES
FOR EACH ROW
DECLARE
    szoveg_count INTEGER;
    duplikacio EXCEPTION;
BEGIN
    SELECT COUNT(*) INTO szoveg_count
    FROM kerdes
    WHERE szoveg = :new.szoveg;

    IF szoveg_count > 0 THEN
        RAISE duplikacio;
    END IF;
EXCEPTION
    WHEN duplikacio THEN
    RAISE_APPLICATION_ERROR(-20001, 'hiba!');
END;
/
ALTER TRIGGER "BARNAB"."KERDES_SZOVEG_EGYEDI" ENABLE;
--------------------------------------------------------
--  DDL for Trigger KERDES_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "BARNAB"."KERDES_TRG" 
BEFORE INSERT ON KERDES 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT KERDES_SEQ4.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;
/
ALTER TRIGGER "BARNAB"."KERDES_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger VALASZOL_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "BARNAB"."VALASZOL_TRG" 
BEFORE INSERT ON VALASZOL 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT VALASZOL_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;
/
ALTER TRIGGER "BARNAB"."VALASZOL_TRG" ENABLE;
