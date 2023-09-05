<?php

    namespace Model;

    use Model\ActiveRecord;

    class Package extends ActiveRecord {
        protected static $table = "packages";
        protected static $dbColumns = ["id", "name"];
        
        public $id;
        public $name;
    }