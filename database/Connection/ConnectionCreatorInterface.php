<?php

namespace DataBase\Connection;

use PDO;

interface ConnectionCreatorInterface
{
  /**
   * It is responsible for creating connections
   *
   * @return PDO
   */
  public static function createConnection(): PDO;
}
