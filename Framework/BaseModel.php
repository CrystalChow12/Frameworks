<?php

namespace Framework;
use Framework\Framework;
use PDO;

abstract class BaseModel {

  protected PDO $db;

  public function __construct() {
    $this->db = Framework::getInstance()->getDatabase()->getConnection();
  }
  
}
