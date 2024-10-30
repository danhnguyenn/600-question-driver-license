<?php
class Question
{
    private $conn;

    // question properties

    public $id_question;
    public $title;
    public $question_a;
    public $question_b;
    public $question_c;
    public $question_d;
    public $question_correct;

    // connect db
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read db
    public function read()
    {
        $query = "SELECT * FROM question as q ORDER BY q.id_question DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    //show data
    public function show()
    {
        $query = "SELECT * FROM question WHERE id_question=? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_question);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id_question = $row["id_question"];
        $this->title = $row["title"];
        $this->question_a = $row["question_a"];
        $this->question_b = $row["question_b"];
        $this->question_c = $row["question_c"];
        $this->question_d = $row["question_d"];
        $this->question_correct = $row["question_correct"];


        return $stmt;
    }

    // Create
    public function create()
    {
        $query = "INSERT INTO question SET title=:title, question_a=:question_a, question_b=:question_b, question_c=:question_c, question_d=:question_d, question_correct=:question_correct";
        $stmt = $this->conn->prepare($query);

        // Xử lý dữ liệu
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->question_a = htmlspecialchars(strip_tags($this->question_a));
        $this->question_b = htmlspecialchars(strip_tags($this->question_b));
        $this->question_c = htmlspecialchars(strip_tags($this->question_c));
        $this->question_d = htmlspecialchars(strip_tags($this->question_d ?? ''));
        $this->question_correct = htmlspecialchars(strip_tags($this->question_correct));

        // Gán tham số
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':question_a', $this->question_a);
        $stmt->bindParam(':question_b', $this->question_b);
        $stmt->bindParam(':question_c', $this->question_c);
        $stmt->bindParam(':question_d', $this->question_d);
        $stmt->bindParam(':question_correct', $this->question_correct);

        // Thực thi câu truy vấn
        if ($stmt->execute()) {
            return true;
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "SQLSTATE Error Code: " . $errorInfo[0] . "\n";
            echo "Driver-specific Error Code: " . $errorInfo[1] . "\n";
            echo "Driver-specific Error Message: " . $errorInfo[2] . "\n";
            return false;
        }
    }

    // Update
    public function update()
    {
        $query = "UPDATE question 
                  SET title=:title, 
                       question_a=:question_a, 
                       question_b=:question_b, 
                       question_c=:question_c, 
                       question_d=:question_d, 
                       question_correct=:question_correct 
                  WHERE id_question =:id_question
        ";
        $stmt = $this->conn->prepare($query);

        // Xử lý dữ liệu
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->question_a = htmlspecialchars(strip_tags($this->question_a));
        $this->question_b = htmlspecialchars(strip_tags($this->question_b));
        $this->question_c = htmlspecialchars(strip_tags($this->question_c));
        $this->question_d = htmlspecialchars(strip_tags($this->question_d ?? ''));
        $this->question_correct = htmlspecialchars(strip_tags($this->question_correct));


        // Gán tham số
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':question_a', $this->question_a);
        $stmt->bindParam(':question_b', $this->question_b);
        $stmt->bindParam(':question_c', $this->question_c);
        $stmt->bindParam(':question_d', $this->question_d);
        $stmt->bindParam(':question_correct', $this->question_correct);
        $stmt->bindParam(':id_question', $this->id_question);


        // Thực thi câu truy vấn
        if ($stmt->execute()) {
            return true;
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "SQLSTATE Error Code: " . $errorInfo[0] . "\n";
            echo "Driver-specific Error Code: " . $errorInfo[1] . "\n";
            echo "Driver-specific Error Message: " . $errorInfo[2] . "\n";
            return false;
        }
    }

    // Delete
    public function delete()
    {
        $query = "DELETE FROM question WHERE id_question =:id_question";
        $stmt = $this->conn->prepare($query);

        // Xử lý dữ liệu
        $this->id_question = htmlspecialchars(strip_tags($this->id_question));

        // Gán tham số
        $stmt->bindParam(':id_question', $this->id_question);


        // Thực thi câu truy vấn
        if ($stmt->execute()) {
            return true;
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "SQLSTATE Error Code: " . $errorInfo[0] . "\n";
            echo "Driver-specific Error Code: " . $errorInfo[1] . "\n";
            echo "Driver-specific Error Message: " . $errorInfo[2] . "\n";
            return false;
        }
    }
}
