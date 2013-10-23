<?php

namespace LimbXpress\Config\Database;

Class LiMongo extends \MongoCollection
{
    const DB_NAME = "LimbXpress";
    private $collectionName;

    public function __construct($collectionName) {
        $this->collectionName = $collectionName;
        return $this->initCollection();
    }

    private function initCollection() {
        $m = new \MongoClient();
        $db = $m->selectDB($this::DB_NAME);
        return parent::__construct($db, $this->collectionName);
    }
}