<?php

    namespace Model;

    use Model\ActiveRecord;

    class Gift extends ActiveRecord {
        protected static $table = "gifts";
        protected static $dbColumns = ["id", "name"];
        
        public $id;
        public $name;

        
        public function __construct($args = []) {
            $this->id = $args["id"] ?? null;
            $this->name = $args["name"] ?? "";
        }
    }