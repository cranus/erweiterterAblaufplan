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

class termin_related_persons extends SimpleORMap
{
    function __construct($id = null)
    {
        parent::__construct($id);
    }

    public static function ByUser_id($user_id)
    {
        $db = DBManager::get();
        $sql = "SELECT termin_related_persons.range_id FROM termin_related_persons ".
                "INNER JOIN termine on termine.termin_id = termin_related_persons.range_id ".
                "WHERE termin_related_persons.user_id = ?".
                "ORDER BY  termine.date ASC ";
        $preparation = $db->prepare($sql);
        $preparation->execute(array($user_id));
        return $preparation->fetchAll();
    }

} 