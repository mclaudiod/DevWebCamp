<?php

    namespace Model;

    use Model\ActiveRecord;

    class Categorie extends ActiveRecord {
        protected static $table = "categories";
        protected static $dbColumns = ["id", "name"];
        
        public $id;
        public $name;
    }