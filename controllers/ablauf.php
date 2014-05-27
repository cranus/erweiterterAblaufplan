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
require_once dirname(__FILE__) . "/../models/seminaruser.php";

class ablaufController extends StudipController  {
    public function before_filter(&$action, &$args) {
//      PageLayout::setTitle('');
        $this->flash = Trails_Flash::instance();
        // set default layout
        $layout = $GLOBALS['template_factory']->open('layouts/base');
        $this->set_layout($layout);

    }

    public function __construct($dispatcher)
    {
        parent::__construct($dispatcher);
        $this->plugin = $dispatcher->plugin;
        Navigation::activateItem('/course/schedule/export');
    }

    function index_action($parm1 = false, $parm2 = false) {
        if(empty($parm1)) $semid = $_REQUEST["cid"];
            else $semid = $parm1;
        $this->semid = $semid;
        $this->sortierung = $this->getSortierung($semid);
        $this->termine = termine::findByrange_id($semid);
    }

    function gruppen_action($parm1 = false, $parm2 = false) {
        if(!$parm1) return false;
        $this->semid = $parm1;
        $this->sortierung = $this->getSortierung($parm1);
        $this->gruppen =  statusgruppen::findbyrange_id($parm1);
    }

    function dozent_action($parm1 = false, $parm2 = false) {
        if(empty($parm1)) return false;
        $this->semid = $parm1;
        $this->sortierung = $this->getSortierung($parm1);
        $dozenten =  seminaruser::findBySQL("Seminar_id = ? AND status = ?",array($this->semid, "dozent"));
        $this->dozenten = array();
        foreach($dozenten as $d) {
            $this->dozenten[] = User::find($d["user_id"]);
        }
    }

    function getSortierung($semid) {
        return "Gruppieren: <a href='".PluginEngine::GetURL("exportablaufplan", array(), 'ablauf/index/'.$semid)."'>Keine</a>  <a href='".PluginEngine::GetURL("exportablaufplan", array(), 'ablauf/dozent/'.$semid)."'>Dozent</a> <a href='".PluginEngine::GetURL("exportablaufplan", array(), 'ablauf/gruppen/'.$semid)."'>Gruppen</a>";
    }
} 