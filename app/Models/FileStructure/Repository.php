<?php

namespace app\Models\FileStructure;

class Repository {

  protected $PDO;

  const TABLE_NAME = 'tree_structure';

  const TREE_STRUCTURE_TABLE_QUERY = SQL_ROOT . DIRECTORY_SEPARATOR . 'tree_structure_table.sql';

  public function __construct()
  {
    $this->PDO = new \PDO("sqlite:" . PROJECT_ROOT . "/database.sql");
    $this->PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  }

  public function createTable()
  {
    $this->PDO->query(file_get_contents(self::TREE_STRUCTURE_TABLE_QUERY));
  }

  public function dropTable()
  {
    $this->PDO->exec(sprintf('DROP TABLE IF EXISTS %s', self::TABLE_NAME));
  }

  public function getPDO()
  {
    return $this->PDO;
  }

  public function fetchAllForTerm($term)
  {
    $sql=sprintf('SELECT * FROM `%s` WHERE `fullpath` LIKE :keyword;', self::TABLE_NAME);
    $q=$this->PDO->prepare($sql);
    $q->bindValue(':keyword','%'.$term.'%');
    $q->execute();

    return $q->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function bulkInsert($data)
  {
    $this->dropTable();
    $this->createTable();

    $sql[] = 'INSERT INTO ' . self::TABLE_NAME . ' (fullpath)';
    
    $sql[] = ' VALUES ';

    foreach ($data as $key => $value) {

      $comma = $key !== count($data) - 1 ? ',' : ';';
      $sql[] = '(:' . $key . ')' . $comma;
    }

    $query = $this->PDO->prepare(implode('', $sql));

    foreach ($data as $key => $value) {
      $query->bindValue(':' . $key, $value);
    }


    $query->execute();

    $insert = $query->rowCount();

    if ($insert) {
        return $insert;
    }

    throw new \RuntimeException('Insert Failed');
  }
}
