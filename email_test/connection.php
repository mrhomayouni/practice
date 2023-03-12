<?php


class database
{

    public static $conn = "";

    public function __construct()
    {

        try {
            self::$conn = new PDO("mysql:host=" . "localhost" . ";dbname=" . "test3", "root", "");
            // set the PDO error mode to exception
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();

        }
    }

    // select('select * from users');
    // select('select * from users where id = ?', [2]);
    public static function select(string $sql, array $values = null)
    {

        try {
            $stmt = self::$conn->prepare($sql);
            if ($values == null) {
                $stmt->execute();
            } else {
                $stmt->execute($values);
            }
            $result = $stmt;
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


    // insert('users', ['username', 'password', 'age'], ['hassank2', '1234', 30]);
    public static function insert($tableName, $fields, $values)
    {
//        var_dump("INSERT INTO " . $tableName . " (" . implode(',', $fields) . ") VALUES ( :" . implode(',:', $fields) . " );");
//        exit();
        try {
            // 'username' => 'hassank2', 'password' => '1234', 'age' => 30
            $stmt = database::$conn->prepare("INSERT INTO " . $tableName . "(" . implode(', ', $fields) . ") VALUES ( :" . implode(', :', $fields) . " );");
            $stmt->execute(array_combine($fields, $values));
            return database::$conn->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // update('users', 2, ['username', 'password'], ['alik2', 12345]);
    public static function update($tableName, $f_where, $v_where, $fields, $values)
    {

        $sql = "UPDATE " . $tableName . " SET";
        foreach (array_combine($fields, $values) as $field => $value) {
            if ($value) {
                $sql .= " `" . $field . "` = ? ,";
            } else {
                $sql .= " `" . $field . "` = NULL ,";

            }
        }
        $sql = trim($sql, ",");
        $sql .= " WHERE $f_where = ?";
        try {
            $stmt = database::$conn->prepare($sql);
            $stmt->execute(array_merge(array_filter(array_values($values)), [$v_where]));
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }


    }

    // delete('users', 2);
    public static function delete($tableName, $fild, $value)
    {
        $sql = "DELETE FROM " . $tableName . " WHERE $fild = ? ;";
        try {
            $stmt = database::$conn->prepare($sql);
            $stmt->execute([$value]);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function query_run(string $sql, array $params = [])
    {
        // first connect to database in db class
        $stmt = database::$conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }


}

