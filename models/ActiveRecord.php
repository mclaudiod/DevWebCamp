<?php
    namespace Model;

    class ActiveRecord {

        // Database

        protected static $db;
        protected static $table = '';
        protected static $dbColumns = [];

        public $id;

        // Alerts and Messages

        protected static $alerts = [];

        // Define the connection to the Database

        public static function setDB($database) {
            self::$db = $database;
        }

        public static function setAlert($type, $message) {
            static::$alerts[$type][] = $message;
        }

        // Validation

        public static function getAlerts() {
            return static::$alerts;
        }

        public function validate() {
            static::$alerts = [];
            return static::$alerts;
        }

        // Query SQL to create an object in Memory

        public static function querySQL($query) {

            // Query the database

            $result = self::$db->query($query);

            // Iterate the results

            $array = [];

            while($registry = $result->fetch_assoc()) {
                $array[] = static::createObject($registry);
            }

            // Liberate the memory

            $result->free();

            // Return the results

            return $array;
        }

        // Created the object in memory which is the same as the in the DB

        protected static function createObject($registry) {
            $object = new static;

            foreach($registry as $key => $value) {
                if(property_exists($object, $key)) {
                    $object->$key = $value;
                }
            }
            return $object;
        }

        // Identificate and link the atributes of the database

        public function atributes() {
            $atributes = [];
            foreach(static::$dbColumns as $column) {
                if($column === "id") continue;
                $atributes[$column] = $this->$column;
            }
            return $atributes;
        }

        // Sanitize the data before saving them in the DB

        public function sanitizeAtributes() {
            $atributes = $this->atributes();
            $sanitized = [];

            // Key is for the name of the variable and the value is for what is inside of it

            foreach($atributes as $key => $value) {
                $sanitized[$key] = self::$db->escape_string($value);
            }

            return $sanitized;
        }

        // Synchronize the object in memory with the changes realized by the user

        public function synchronize($args = []) {
            foreach($args as $key => $value) {
                if(property_exists($this, $key) && !is_null($value)) {
                    $this->$key = $value;
                }
            }
        }

        // Registries - CRUD

        public function save() {
            $result = '';
            if(!is_null($this->id)) {

                // Update

                $result = $this->update();
            } else {

                // Create

                $result = $this->create();
            }
            return $result;
        }

        // Lists all the registries

        public static function all($order = "DESC") {
            $query = "SELECT * FROM " . static::$table . " ORDER BY id {$order}";
            $result = self::querySQL($query);
            return $result;
        }

        // Search a registry for it's id

        public static function find($id) {
            $query = "SELECT * FROM " . static::$table . " WHERE id = {$id}";
            $result = self::querySQL($query);
            return array_shift($result);
        }

        // Obtain determined number of registries

        public static function get($quantity) {
            $query = "SELECT * FROM " . static::$table . " ORDER BY id DESC LIMIT " . $quantity;
            $result = self::querySQL($query);
            return $result;
        }

        // Paginate the registries

        public static function paginate($perPage, $offset) {
            $query = "SELECT * FROM " . static::$table . " ORDER BY id DESC LIMIT " . $perPage . " OFFSET " . $offset;
            $result = self::querySQL($query);
            return $result;
        }

        // Search a registry for it's column

        public static function where($column, $value) {
            $query = "SELECT * FROM " . static::$table . " WHERE {$column} = '{$value}'";
            $result = self::querySQL($query);
            return array_shift($result);
        }

        // Return the registries with an order

        public static function order($column, $order) {
            $query = "SELECT * FROM " . static::$table . " ORDER BY {$column} {$order}";
            $result = self::querySQL($query);
            return $result;
        }

        // Return the registries with an order and limited quantity

        public static function orderQuantity($column, $order, $quantity) {
            $query = "SELECT * FROM " . static::$table . " ORDER BY {$column} {$order} LIMIT {$quantity}";
            $result = self::querySQL($query);
            return $result;
        }

        // Search a registry for it's column with multiple options

        public static function whereArray($array = []) {
            $query = "SELECT * FROM " . static::$table . " WHERE ";

            foreach($array as $key => $value) {
                if($key == array_key_last($array)) {
                    $query .= " {$key} = '{$value}'";
                } else {
                    $query .= " {$key} = '{$value}' AND ";
                }
            }
            
            $result = self::querySQL($query);
            return $result;
        }

        // Get a total of registries

        public static function total($column = "", $value = "") {
            $query = "SELECT COUNT(*) FROM " . static::$table;

            if($column) {
                $query .= " WHERE {$column} = {$value}";
            }
            
            $result = self::$db->query($query);
            $total = $result->fetch_array();
            return array_shift($total);
        }

        // Get a total of registries with an array where

        public static function totalArray($array = []) {
            $query = "SELECT COUNT(*) FROM " . static::$table . " WHERE ";

            foreach($array as $key => $value) {
                if($key == array_key_last($array)) {
                    $query .= " {$key} = '{$value}'";
                } else {
                    $query .= " {$key} = '{$value}' AND ";
                }
            }
            
            $result = self::$db->query($query);
            $total = $result->fetch_array();
            return array_shift($total);
        }

        // Create a new registry

        public function create() {

            // Sanitize the data

            $atributes = $this->sanitizeAtributes();

            // Insert into the database
            
            // Join makes an string out of an array
            
            $query = "INSERT INTO " . static::$table . " (";
            $query .= join(", ", array_keys($atributes));
            $query .= ") VALUES ('";
            $query .= join("', '", array_values($atributes));
            $query .= "')";

            // return json_encode(["query" => $query]);
            
            $result = self::$db->query($query);
            return [
            'result' =>  $result,
            'id' => self::$db->insert_id
            ];
        }

        // Update a registry

        public function update() {

            // Sanitize the data

            $atributes = $this->sanitizeAtributes();

            $values = [];

            foreach($atributes as $key => $value) {
                $values[] = "{$key}='{$value}'";
            }

            // Insert into the database

            $query = "UPDATE " . static::$table . " SET ";
            $query .= join(", ", $values);
            $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "'";
            $query .= " LIMIT 1";

            $result = self::$db->query($query);
            return $result;
        }

        // Delete a registry

        public function delete() {
            $query = "DELETE FROM " . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
            $result = self::$db->query($query);
            return $result;
        }
    }