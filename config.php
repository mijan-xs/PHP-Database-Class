<?php
class Database
{
    public $connection;
    
    const DBHOST = 'localhost'; //database host name
    const DBUSER = 'root'; //database username
    const DBPASSWORD = ''; //database password
    const DBNAME = 'ajax'; //database name

    public function open_db()
    {
        $mysqli = new mysqli(self::DBHOST, self::DBUSER, self::DBPASSWORD, self::DBNAME);

        if ($mysqli->connect_errno) {
            die('Database Connection Failed' . $mysqli->error);
        }

        return $mysqli;
    }

    public function __construct()
    {
        return $this->connection = $this->open_db();
    }

    public function query($sql)
    {
        $query = $this->connection->query($sql, MYSQLI_STORE_RESULT);

        return $this->confirm_query($query);
    }

    private function confirm_query($query)
    {
        if (!$query) {
            die('Query failed' . $this->connection->error);
        }

        return $query;
    }

    /**
     * insert function
     *
     * This fuction will insert your data in database
     * You don't need to write any database column name 
     * you have to just pass your table name and VALUES array
     * Don't pass string you will be get an error
     *
     * @param string table_name This will be for your table name
     * @param array data   this will be your values data
     * @return void
     **/

    public function insert(string $table_name, array $data)
    {
        if ($table_name == '') {
            throw new Exception('Table name is missing');
        }
        if (!is_array($data)) {
            throw new Exception('$values is must be an array');
        }

        $query = $this->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . self::DBNAME . "' AND TABLE_NAME = '" . $table_name . "'");

        while ($row = $query->fetch_assoc()) {
            $results[] = $row['COLUMN_NAME'];
        }

        array_shift($results);

        $column = implode(',', $results);
        $data = implode('","', $data);
        $values = '"' . $data . '"';

        $sql = 'INSERT INTO ' . $table_name . '';
        $sql .= '(' . $column . ')';
        $sql .= 'VALUES(' . $values . ')';

        $query = $this->query($sql);

        return $query;
    }

    private function check_id(string $table_name, int $id)
    {
        $sql = 'SELECT username FROM ' . $table_name . ' WHERE id = ' . $id . '';
        $query = $this->query($sql);

        if ($query->num_rows == 1) {
            return true;
        }

        return false;
    }

    /**
     * Delete function
     *
     * This fuction will delete your data from database 
     * only you have to pass table name and id
     *
     * @param string table_name This will be for your table name
     * @param int id this will be your id
     * @return void
     **/
    public function delete(string $table_name, int $id)
    {

        if (!$this->check_id($table_name, $id)) {
            die('Sorry! ID ' . $id . ' is not exist in database');
        }

        $sql = 'DELETE FROM ' . $table_name . ' WHERE id = ' . $id . '';

        $query = $this->query($sql);

        return $query;
    }

    private function is_assoc($arr)
    {
        return is_array($arr) && array_values($arr) !== $arr;
    }


    /**
     * Update function
     *
     * This fuction will update your data from database 
     * For using update function you have to pass table name , table id and a assosiative array.
     * In assosiative array you have to pass pair data like ['fname'=>'Mijan']
     * fname will be your column name and Mijan will be your new update value  
     *
     * @param string table_name This will be for your table name.
     * @param int id this will be your id.
     * @param array update_data this will be assosiative array with colum and value.
     * @return void
     **/
    public function update(string $table_name, int $id, array $update_data)
    {
        if (!$this->check_id($table_name, $id)) {
            die('Sorry! ID ' . $id . ' is not exist in database');
        }

        $data   = [];
        if ($this->is_assoc($update_data)) {
            foreach ($update_data as $column => $value) {
                $data []= $column . ' = ' . '"' . $value . '" ';
            }
        }

        $data = implode(',',$data);

        $sql = 'UPDATE ' . $table_name . ' SET ' . $data . ' WHERE id = ' . $id . '';

        $query = $this->query($sql);

        return $query;
    }

    /**
     * read_by_id function
     *
     * This fuction will select your data from database
     * only you have to pass table name and id
     *
     * @param string table_name This will be for your table name
     * @param int id this will be your id
     * @return array You will be get an assosiative array
     **/
    public function read_by_id(string $table_name,int $id)
    {
        if (!$this->check_id($table_name, $id)) {
            die('Sorry! ID ' . $id . ' is not exist in database');
        }

        $sql = 'SELECT * FROM '.$table_name.' WHERE id = '.$id.'';
        $query = $this->query($sql);
        $results = $query->fetch_assoc();
        return $results;
    }

    /**
     * read_all function
     *
     * This fuction will select your all data from database.
     * only you have to pass table name
     *
     * @param string table_name This will be for your table name.
     * @return array You will be get an assosiative array
     **/
    public function read_all(string $table_name)
    {
        $sql = 'SELECT * FROM '.$table_name;
        $query = $this->query($sql);
        while($row = $query->fetch_array()){
            $results[] = $row;
        }
        return $results;
    }

     
}

$db = new Database();
