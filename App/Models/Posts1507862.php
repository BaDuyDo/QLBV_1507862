<?php


namespace App\Models;

use App\Auth;
use PDO;
use Core\Model;

class Posts1507862 extends Model
{
    public $errors = [];
    private $db = null;

    public function __construct($data = [])
    {
        if ($this->db == null) {
            $this->db = static::getDB();
        }
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function getAllPosts1507862($search)
    {
        $sql = $search
            ? "select posts.*, users.name as `username` from posts inner join users on users.id = posts.user_id 
                where posts.title like :search"
            : "select posts.*, users.name as `username` from posts inner join users on users.id = posts.user_id";
        $db = self::getDB();
        $stmt = $db->prepare($sql);
        if ($search) {
            $search = "%" . $search . "%";
            console.log($search);
            $stmt->bindParam(':search', $search);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function delete1507862($id)
    {
        $sql = "delete FROM posts WHERE id=:id";
        $db = self::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        return true;
    }

    public static function findById1507862($id)
    {
        $sql = "SELECT * FROM posts WHERE id=:id";
        $db = self::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        return $stmt->fetchObject();
    }

    public function savePost1507862()
    {
        /*date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        $str_date = "$date";*/
        $this->validateSave();
        $sql = $this->id
            ? "update posts set title=:title, description=:description, content=:content where id=:id"
            : "insert into posts(title, description, content, user_id) values (:title, :description, :content, :user_id)";
        if (empty($this->errors)) {
            $stmt = $this->db->prepare($sql);
            if ($this->id) {
                $stmt->bindParam(':id', $this->id);
            } else {
                $stmt->bindParam(':user_id', Auth::getUser()->id);
            }
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':content', $this->content);
           /* if ($this->id){$stmt->bindParam(':update_date', $str_date);}*/

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            $stmt->execute();
            return true;
        }
        return false;
    }

    private function validateSave()
    {
        if ($this->title == "") {
            $this->errors[] = "title is required";
        }
        if ($this->description == null) {
            $this->errors[] = "description is required";
        }
        if ($this->content == null) {
            $this->errors[] = "content is required";
        }
    }
}