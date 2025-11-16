<?php
require_once __DIR__ . '/BaseDao.php';

class UsersDao extends BaseDao {

    protected $table_name;

    public function __construct()
    {
        $this->table_name = "users";
        parent::__construct($this->table_name);
    }

    public function get_by_email($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }
}

?>
