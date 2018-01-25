<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 19/12/2017
 * Time: 16:07
 */

namespace MIG\Model;


abstract class Table
{
    protected $db;
    protected $table;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function fetchAll()
    {
        $query = "select * from {$this->table}";
        return $this->db->query($query);
    }

    public function find($id)
    {
        $query = "select * from {$this->table} WHERE id=:id";
        $execute = $this->db->prepare($query);
        $execute->bindParam(":id",$id);
        $execute->execute();
        return $execute->fetch(\PDO::FETCH_ASSOC);
    }

}