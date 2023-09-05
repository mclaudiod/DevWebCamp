<?php

    namespace Model;

    use Model\ActiveRecord;

    class Register extends ActiveRecord {
        protected static $table = "registrations";
        protected static $dbColumns = ["id", "package_id", "payment_id", "token", "user_id", "gift_id"];
        
        public $id;
        public $package_id;
        public $payment_id;
        public $token;
        public $user_id;
        public $gift_id;
        
        public function __construct($args = []) {
            $this->id = $args["id"] ?? null;
            $this->package_id = $args["package_id"] ?? "";
            $this->payment_id = $args["payment_id"] ?? "";
            $this->token = $args["token"] ?? "";
            $this->user_id = $args["user_id"] ?? "";
            $this->gift_id = $args["gift_id"] ?? 1;
        }
    }