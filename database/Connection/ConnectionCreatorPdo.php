<?php

namespace DataBase\Connection;

use PDO;

class ConnectionCreatorPdo implements ConnectionCreatorInterface
{
  /**
   * It is responsible for creating connections
   * 
   * @return PDO
   */
  public static function createConnection(): PDO
  {
    try {
      $server = getenv('DB_SERVER');
      $host = getenv('DB_HOST');
      $database = getenv('DB_DATABASE');
      $stringConnection =  $server . ':host=' . $host . ';dbname=' . $database;

      $connection = new PDO(
        $stringConnection,
        getenv('DB_USER'),
        getenv('DB_PASSWORD')
      );
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      return $connection;
    } catch (\PDOException | \Error $e) {
      throw new \PDOException("erro com conexão do banco", 001);
    }
  }
}
