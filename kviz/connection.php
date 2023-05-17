<?php

class OracleConnection
{
    public $conn;

    function __construct()
    {
        $this->conn = oci_connect('barnab', 'ppowe8', 'localhost/XE', 'AL32UTF8');
        if (!$this->conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    function getData($sql)
    {
        $stid = oci_parse($this->conn, $sql);
        if (!$stid) {
            $e = oci_error($this->conn);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        //oci_free_statement($stid);
        return oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
    }

    function setData($sql)
    {
        //echo $sql;
        $stid = oci_parse($this->conn, $sql);
        if (!$stid) {
            $e = oci_error($this->conn);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        oci_free_statement($stid);
    }

    function regisztral($felhasznalonev, $jelszo, $eletkor, $jatekazon)
    {
        error_reporting(0);
        $sql = "INSERT INTO Felhasznalo (felhasznalonev, jelszo, eletkor, jatek_azonosito) VALUES (:felhasznalonev, :jelszo, :eletkor, :jatek_azonosito)";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ':felhasznalonev', $felhasznalonev);
        oci_bind_by_name($stmt, ':jelszo', $jelszo);
        oci_bind_by_name($stmt, ':eletkor', $eletkor);
        oci_bind_by_name($stmt, ':jatek_azonosito', $jatekazon);
        $result = oci_execute($stmt);
        error_reporting(E_ALL);
        if (!$result) {
            return "hiba";
        } else {
            return "";
        }
    }

    function  sajat_kerdesek_lekerese($felhasznalo)
    {
        $sql = "SELECT id, szoveg, valasz1, valasz2, valasz3, helyes_valasz, nehezseg FROM KERDES WHERE felhasznalo_id = :felhasznalo ORDER BY nehezseg ASC";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ':felhasznalo', $felhasznalo);
        oci_execute($stmt);
        $kerdeseim = array();
        while ($row = oci_fetch_assoc($stmt)) {
            $kerdeseim[] = $row;
        }
        return $kerdeseim;
    }

    function insert_question($kerdes, $valaszok, $temakorok, $nehezseg, $pont_id, $felhasznalo_id)
    {
        error_reporting(0);
        $stmt = oci_parse($this->conn, 'INSERT INTO KERDES (szoveg, valasz1, valasz2, valasz3, helyes_valasz, nehezseg, pont_id, felhasznalo_id) VALUES (:kerdes,:valasz1, :valasz2, :valasz3, :helyes_valasz, :nehezseg, :pont_id, :felhasznalo_id)');

        oci_bind_by_name($stmt, ':kerdes', $kerdes);
        oci_bind_by_name($stmt, ':valasz1', $valaszok["valasz1"]);
        oci_bind_by_name($stmt, ':valasz2', $valaszok["valasz2"]);
        oci_bind_by_name($stmt, ':valasz3', $valaszok["valasz3"]);
        oci_bind_by_name($stmt, ':helyes_valasz', $valaszok["helyes_valasz"]);
        oci_bind_by_name($stmt, ':nehezseg', $nehezseg);
        oci_bind_by_name($stmt, ':pont_id', $pont_id);
        oci_bind_by_name($stmt, ':felhasznalo_id', $felhasznalo_id);
        if (oci_execute($stmt)) {
        } else {
            $error = oci_error($stmt);
            if ($error['code'] == -20001) {
                return "hiba";
            } else {
                return "hiba";
            }
        }

        error_reporting(E_ALL);
        $sql = "SELECT * FROM KERDES WHERE ROWNUM <= 1 ORDER BY id DESC";
        $stmt = oci_parse($this->conn, $sql);
        oci_execute($stmt);
        $utolso_sor = oci_fetch_array($stmt);
        for ($i = 0; $i < count($temakorok); $i++) {
            $insertSql = "INSERT INTO KERDES_TEMAKOR (KERDES_ID, TEMAKOR_ID) VALUES (:KERDES_ID, :TEMAKOR_ID)";
            $insertStmt = oci_parse($this->conn, $insertSql);
            oci_bind_by_name($insertStmt, ':KERDES_ID', $utolso_sor["ID"]);
            $ideiglenes_temakorid = $this->get_temakor_id($temakorok[$i]);
            oci_bind_by_name($insertStmt, ':TEMAKOR_ID', $ideiglenes_temakorid);
            oci_execute($insertStmt);
        }
    }

    function get_question($id)
    {
        $stmt = oci_parse($this->conn, 'SELECT * FROM KERDES WHERE ID = :id');
        oci_bind_by_name($stmt, ':id', $id);
        oci_execute($stmt);

        $kerdesadatok = array();
        while ($row = oci_fetch_assoc($stmt)) {
            $kerdesadatok[] = $row;
        }

        return $kerdesadatok;
    }

    function update_question($id, $szoveg, $valaszok, $nehezseg)
    {
        print_r($nehezseg);
        $sql = 'BEGIN kerdes_modositas(:p_id, :p_szoveg, :p_valasz1, :p_valasz2, :p_valasz3, :p_helyes_valasz, :p_nehezseg); END;';
        $stmt = oci_parse($this->conn, $sql);

        oci_bind_by_name($stmt, ':p_id', $id);
        oci_bind_by_name($stmt, ':p_szoveg', $szoveg);
        oci_bind_by_name($stmt, ':p_valasz1', $valaszok["valasz1"]);
        oci_bind_by_name($stmt, ':p_valasz2', $valaszok["valasz2"]);
        oci_bind_by_name($stmt, ':p_valasz3', $valaszok["valasz3"]);
        oci_bind_by_name($stmt, ':p_helyes_valasz', $valaszok["helyes_valasz"]);
        oci_bind_by_name($stmt, ':p_nehezseg', $nehezseg);


        oci_execute($stmt);
    }

    function delete_question($id)
    {
        $sql = 'BEGIN kerdes_torles(:p_id); END;';
        $stmt = oci_parse($this->conn, $sql);

        oci_bind_by_name($stmt, ':p_id', $id);

        $success = oci_execute($stmt);
        if (!$success) {
            $error = oci_error($stmt);
            throw new Exception($error['message']);
        }
    }

    function delete_felhasznalo($felhasznalonev)
    {
        $sql = 'BEGIN felhasznalo_torles(:p_felhasznalonev); END;';
        $stmt = oci_parse($this->conn, $sql);

        oci_bind_by_name($stmt, ':p_felhasznalonev', $felhasznalonev);

        $success = oci_execute($stmt);
        if (!$success) {
            $error = oci_error($stmt);
            throw new Exception($error['message']);
        }
    }

    function get_temakor_id($temakor)
    {
        $stmt = oci_parse($this->conn, "SELECT * FROM TEMAKOR WHERE temakor_megnevezese = :temakor");
        oci_bind_by_name($stmt, ':temakor', $temakor);

        oci_execute($stmt);
        $temakor_tomb = oci_fetch_array($stmt);
        return $temakor_tomb["ID"];
    }

    function utolso_jatek_id()
    {
        $query = "DECLARE
                    TYPE jatekok IS TABLE OF JATEK%ROWTYPE;
                    jatekom jatekok;
                    utolso JATEK%ROWTYPE;
                BEGIN
                    SELECT * BULK COLLECT INTO jatekom FROM JATEK ORDER BY azonosito ASC;
                    utolso := jatekom(jatekom.LAST);
                    :utolso_jatek := utolso.azonosito;
                    dbms_output.put_line(utolso.azonosito);
                END;";

        $stmt = oci_parse($this->conn, $query);

        $azonosito = "";
        oci_bind_by_name($stmt, ":utolso_jatek", $azonosito);

        oci_execute($stmt);

        return $azonosito;
    }

    function jatek_letrehozas($azonosito, $nev, $letszam, $kerdesekszama, $nehezseg)
    {
        $stmt = oci_parse($this->conn, 'INSERT INTO JATEK (azonosito, nev, letszam, kerdesek_szama, nehezseg) VALUES (:azonosito, :nev, :letszam, :kerdesekszama, :nehezseg)');

        oci_bind_by_name($stmt, ':azonosito', $azonosito);
        oci_bind_by_name($stmt, ':nev', $nev);
        oci_bind_by_name($stmt, ':letszam', $letszam);
        oci_bind_by_name($stmt, ':kerdesekszama', $kerdesekszama);
        oci_bind_by_name($stmt, ':nehezseg', $nehezseg);

        oci_execute($stmt);
    }

    function jatekok_kiiratasa()
    {
        $sql = "BEGIN :result := get_jatek_adat(); END;";

        $stmt = oci_parse($this->conn, $sql);
        $result = oci_new_cursor($this->conn);
        oci_bind_by_name($stmt, ":result", $result, -1, OCI_B_CURSOR);
        oci_execute($stmt);
        oci_execute($result);

        $cursor = oci_new_cursor($this->conn);
        $stid = oci_parse($this->conn, 'BEGIN :cursor := get_jatek_darabszamok(); END;');
        oci_bind_by_name($stid, ':cursor', $cursor, -1, OCI_B_CURSOR);
        oci_execute($stid);
        oci_execute($cursor);

        $tmp = [];
        $c = [];
        while (($row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            $tmp[$row["AZONOSITO"]]["azonosito"] = $row["AZONOSITO"];
            $tmp[$row["AZONOSITO"]]["nev"] = $row["NEV"];
            $tmp[$row["AZONOSITO"]]["letszam"] = $row["LETSZAM"];
            $tmp[$row["AZONOSITO"]]["belepett_jatekosok"] = 0;
            $tmp[$row["AZONOSITO"]]["kerdesek_szama"] = $row["KERDESEK_SZAMA"];
            $tmp[$row["AZONOSITO"]]["nehezseg"] = $this->convertNehezseg($row["NEHEZSEG"]);
        }
        while (($row = oci_fetch_array($cursor, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            $tmp[$row["JATEK_AZONOSITO"]]["belepett_jatekosok"] = $row["DB"];
        }


        return $tmp;
    }
    function convertNehezseg($nehezseg)
    {
        switch ($nehezseg) {
            case '1':
                return "Alap";
                break;
            case '2':
                return "Normal";
                break;
            default:
                return "Nehéz";
                break;
        }
    }
    function jatekba_belepes($jatek_azonosito, $felhasznalonev)
    {
        $sql = oci_parse($this->conn, 'UPDATE FELHASZNALO SET JATEK_AZONOSITO = :jatekazon WHERE FELHASZNALONEV = :nev');

        oci_bind_by_name($sql, ':jatekazon', $jatek_azonosito);
        oci_bind_by_name($sql, ':nev', $felhasznalonev);

        oci_execute($sql);
    }


    function kerdesek_lekeres($jatek_id)
    {
        $sql = "SELECT kerdesek_szama as ksz, nehezseg as lvl FROM JATEK WHERE azonosito = :jatekid";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ':jatekid', $jatek_id);
        oci_execute($stmt);

        $row = oci_fetch_array($stmt, OCI_ASSOC);
        $kerdesek_szama = $row['KSZ'];
        $nehezseg = $row['LVL'];

        $kerdes_query = "SELECT id, szoveg, valasz1, valasz2, valasz3, helyes_valasz, nehezseg, pont_id 
                FROM (SELECT * FROM KERDES WHERE nehezseg = :jatek_nehezseg ORDER BY dbms_random.value) WHERE ROWNUM <= :jatek_kerdesek_szama";
        $kerdes_stmt = oci_parse($this->conn, $kerdes_query);
        oci_bind_by_name($kerdes_stmt, ':jatek_nehezseg', $nehezseg);
        oci_bind_by_name($kerdes_stmt, ':jatek_kerdesek_szama', $kerdesek_szama);
        oci_execute($kerdes_stmt);

        // az eredmény kiolvasása
        $kerdesek = array();
        while ($row = oci_fetch_assoc($kerdes_stmt)) {
            $kerdesek[] = $row;
        }

        return $kerdesek;
    }

    function valaszok_feltoltese($felhasznalonev, $valaszok)
    {
        foreach ($valaszok as $valasz => $adat) {
            $sql = "DECLARE
                    helyes_valasz KERDES.helyes_valasz%TYPE;
                    helyesseg VALASZOL.helyesseg%TYPE;
                BEGIN
                    SELECT helyes_valasz INTO helyes_valasz FROM KERDES WHERE id = :kerdes_id;
                    IF :valasz = helyes_valasz THEN
                        helyesseg := 1;
                    ELSE
                        helyesseg := 0;
                    END IF;
                    INSERT INTO VALASZOL (felhasznalo_id, kerdes_id, helyesseg)
                    VALUES (:felhasznalonev, :kerdes_id, helyesseg);
                END;";
            $stmt = oci_parse($this->conn, $sql);

            oci_bind_by_name($stmt, ':felhasznalonev', $felhasznalonev);
            oci_bind_by_name($stmt, ':kerdes_id', $valasz);
            oci_bind_by_name($stmt, ':valasz', $adat);
            oci_execute($stmt);
        }
    }
    function hozzarendel_feltoltes($jatekid, $kerdesid)
    {
        $sql = "BEGIN
            INSERT INTO HOZZARENDEL (jatek_azonosito, kerdes_id) VALUES (:jatekid, :kerdesid);
        END;";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ':jatekid', $jatekid);
        oci_bind_by_name($stmt, ':kerdesid', $kerdesid);
        oci_execute($stmt);
    }

    function valaszok_visszakerese($felhasznalonev, $jatekid)
    {
        $sql = "SELECT *
        FROM (
        SELECT v.felhasznalo_id, v.helyesseg, k.szoveg, k.id
        FROM VALASZOL v
        JOIN KERDES k ON v.kerdes_id = k.id
        WHERE v.felhasznalo_id = :felhasznalonev
        ORDER BY v.id DESC)
        WHERE ROWNUM <= (SELECT kerdesek_szama FROM JATEK WHERE azonosito = :jatekazon)";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ':felhasznalonev', $felhasznalonev);
        oci_bind_by_name($stmt, ':jatekazon', $jatekid);
        oci_execute($stmt);

        $valaszok = array();
        while ($row = oci_fetch_assoc($stmt)) {
            $valaszok[] = $row;
        }
        foreach ($valaszok as $key => $value) {

            if ($value["HELYESSEG"] == 1) {
                $this->pontszerzes($value["FELHASZNALO_ID"], $value["ID"]);
            }
        }

        return $valaszok;
    }
    function pontszerzes($felhasznalonev, $kerdesid)
    {
        $sql = "INSERT INTO MEGSZEREZ (felhasznalo_id, pont_id)
        SELECT F.felhasznalonev, P.id
        FROM FELHASZNALO F
        JOIN KERDES K ON F.felhasznalonev = :felhasznalonev
        JOIN PONT P ON P.id = K.nehezseg
        WHERE K.id = :kerdesid";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ':felhasznalonev', $felhasznalonev);
        oci_bind_by_name($stmt, ':kerdesid', $kerdesid);
        oci_execute($stmt);
    }
    function jatekbol_kilepes($felhasznalonev)
    {
        $sql = "UPDATE FELHASZNALO SET jatek_azonosito = NULL WHERE felhasznalonev = :felh";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":felh", $felhasznalonev);
        oci_execute($stmt);
    }

    function osszpont($felhasznalonev)
    {
        $osszpont = 0;
        $sql = "BEGIN :pontok := GET_FELHASZNALO_OSSZPONT(:felhasznalonev); END;";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":pontok", $osszpont, 1000000);
        oci_bind_by_name($stmt, ":felhasznalonev", $felhasznalonev);
        oci_execute($stmt);
        return $osszpont;
    }

    function helyes_valaszok_temakorokszerinti_rangsora()
    {
        $sql = "SELECT felhasznalo, temakor, helyes_valaszok
        FROM helyes_valaszok_rank
        WHERE rank_helyes_valaszok = 1
        ORDER BY temakor ASC";
        $stmt = oci_parse($this->conn, $sql);
        oci_execute($stmt);
        $valaszok = array();
        while ($row = oci_fetch_assoc($stmt)) {
            $valaszok[] = $row;
        }
        return $valaszok;
    }
    function helyes_valaszok_eletkor_szerint()
    {
        $sql = "SELECT * FROM pontok_eletkor_szerint";
        $result = oci_parse($this->conn, $sql);
        oci_execute($result);
        $valaszok = array();
        while ($row = oci_fetch_assoc($result)) {
            $valaszok[] = $row;
        }
        return $valaszok;
    }

    function eletkor_ranglista($min, $max)
    {
        $sql = "BEGIN :pontok := eletkor_szerinti_ranglista(:min, :max); END;";

        $stmt = oci_parse($this->conn, $sql);
        $pontok = oci_new_cursor($this->conn);

        oci_bind_by_name($stmt, ':pontok', $pontok, -1, OCI_B_CURSOR);

        oci_bind_by_name($stmt, ":min", $min, 1000000);
        oci_bind_by_name($stmt, ":max", $max, 1000000);
        oci_execute($stmt);
        oci_execute($pontok);
        $rows = array();
        while (($row = oci_fetch_array($pontok, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            $rows[] = $row;
        }
        return $rows;
    }

    function kerdesekszama_temakorszerint()
    {
        $sql = "SELECT tk.temakor_megnevezese, COUNT(*) AS kerdesek_szama
        FROM temakor tk
        JOIN kerdes_temakor kt ON tk.id = kt.temakor_id
        JOIN kerdes k ON kt.kerdes_id = k.id
        GROUP BY tk.temakor_megnevezese
        ORDER BY kerdesek_szama ASC";

        $stmt = oci_parse($this->conn, $sql);

        oci_execute($stmt);

        $rows = array();
        while (($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            $rows[] = $row;
        }
        return $rows;
    }

    function legnehezebb_kerdesek()
    {
        $sql = "SELECT k.szoveg, 
        COUNT(*) AS valaszok_szama, 
        SUM(CASE WHEN v.helyesseg = 0 THEN 1 ELSE 0 END) AS helytelen_valaszok_szama
        FROM kerdes k 
        JOIN valaszol v ON k.id = v.kerdes_id 
        GROUP BY k.szoveg 
        HAVING COUNT(*) > 0 
        ORDER BY SUM(CASE WHEN v.helyesseg = 0 THEN 1 ELSE 0 END) / COUNT(*) DESC 
        FETCH FIRST 1 ROWS ONLY";

        $stmt = oci_parse($this->conn, $sql);

        oci_execute($stmt);

        $rows = array();
        while (($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            $rows[] = $row;
        }
        return $rows;
    }

    function legnepszerubb_jatekok()
    {
        $sql = "SELECT j.azonosito, j.nev, COUNT(*) / j.kerdesek_szama as darabszam
        FROM jatek j
        JOIN hozzarendel h ON j.azonosito = h.jatek_azonosito
        GROUP BY j.azonosito, j.nev, j.kerdesek_szama 
        ORDER BY darabszam DESC";

        $stmt = oci_parse($this->conn, $sql);

        oci_execute($stmt);

        $rows = array();
        while (($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            $rows[] = $row;
        }
        return $rows;
    }

    function feltoltott_kerdesekszama($felhasznalo)
    {
        $sql = "SELECT COUNT(*) as bekuldott_kerdesek_szama FROM kerdes WHERE felhasznalo_id = :felhasznalonev";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":felhasznalonev", $felhasznalo);
        oci_execute($stmt);
        $rows = array();
        while (($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            $rows[] = $row;
        }
        return $rows;
    }
    
    function helyes_valaszok_aranya($felhasznalo)
    {
        $sql = "SELECT CASE 
        WHEN COUNT(*) = 0 THEN null 
        ELSE COUNT(CASE WHEN helyesseg = 1 THEN 1 END) / COUNT(*) 
        END AS eredmeny 
        FROM VALASZOL 
        WHERE felhasznalo_id = :felhasznalonev";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":felhasznalonev", $felhasznalo);
        oci_execute($stmt);

        $rows = array();
        while (($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            $rows[] = $row;
        }

        return $rows;
    }
    function __destruct()
    {
        oci_close($this->conn);
    }
}
