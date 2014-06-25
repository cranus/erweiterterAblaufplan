<?php
/**
 * Datei ist Teil neo-exportablauf
 * Erstellt von: johannes.stichler
 * Datum: 20.05.14
 * The MIT License (MIT)
 *
 * Copyright (c) 2013 Johannes Stichler
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */



class termine extends SimpleORMap
{
    function __construct($id = null)
    {
        //$this->db_table = 'termine';
        parent::__construct($id);
    }


    static function OhneDozenten($semid) {
        if(empty($semid)) return "Fehler";
        $db = DBManager::get();
        $sql = "SELECT * FROM termine WHERE range_id = ? AND termin_id NOT IN (SELECT range_id FROM  termin_related_persons)";
        $preparation = $db->prepare($sql);
        $preparation->execute(array($semid));
        return $preparation->fetchAll();
    }

    static function OhneGruppe($semid) {
        if(empty($semid)) return "Fehler";
        $db = DBManager::get();
        $sql = "SELECT * FROM termine WHERE range_id = ? AND termin_id NOT IN (SELECT termin_id FROM  termin_related_groups) ORDER BY  termine.date ASC";
        $preparation = $db->prepare($sql);
        $preparation->execute(array($semid));
        return $preparation->fetchAll();
    }


} 