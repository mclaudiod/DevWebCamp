<?php

    namespace Model;

    use Model\ActiveRecord;

    class EventSchedule extends ActiveRecord {
        protected static $table = "events";
        protected static $dbColumns = ["id", "categorie_id", "day_id", "hour_id"];
        
        public $id;
        public $categorie_id;
        public $day_id;
        public $hour_id;
    }