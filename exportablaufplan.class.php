<?php
require 'bootstrap.php';
//require_once 'vendor/trails/trails.php';
/**
 * exportablaufplan.class.php
 *
 * ...
 *
 * @author  johannes.stichler@hfwu.de
 * @version 0.1a
 */

class exportablaufplan extends \StudIPPlugin implements \StandardPlugin {

    public function __construct() {
        parent::__construct();
        if(Seminar_Perm::get_perm() == "dozent" OR Seminar_Perm::get_perm() == "root") {
            $navigation = new AutoNavigation(_('erweiterter Ablaufplan'));
            $navigation->setURL(PluginEngine::GetURL($this, array(), 'ablauf'));
            if(\Navigation::hasItem('/course/schedule')) \Navigation::addItem('/course/schedule/export', $navigation);
        }
    }

    public function initialize () {

    }

    public function getTabNavigation($course_id) {
        return array();
    }

    public function getNotificationObjects($course_id, $since, $user_id) {
        return array();
    }

    public function getIconNavigation($course_id, $last_visit, $user_id) {
       
    }

    public function getInfoTemplate($course_id) {

    }

    public function perform($unconsumed_path) {
        $this->setupAutoload();
        $dispatcher = new Trails_Dispatcher(
            $this->getPluginPath(),
            rtrim(PluginEngine::getLink($this, array(), null), '/'),
            'show'
        );
        $dispatcher->plugin = $this;
        $dispatcher->dispatch($unconsumed_path);
    }

    private function setupAutoload() {
        if (class_exists("StudipAutoloader")) {
            StudipAutoloader::addAutoloadPath(__DIR__ . '/models');
        } else {
            spl_autoload_register(function ($class) {
                include_once __DIR__ . $class . '.php';
            });
        }
    }
}
