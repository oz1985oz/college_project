<?php 

class Course {
	private $course_name;
	private $course_description;
	private $course_img_link;
	
	function __construct($course_name, $course_description, $course_img_link, $course_id = null) {
		$this->course_name = $course_name;
		$this->course_description = $course_description;
		$this->course_img_link = $course_img_link;
		if (!is_null($course_id)) {
			$this->course_id = $course_id;
		}
	}
	public function getCourseById() {
		return $this->course_id;
	}

	public function save() {
		$stmt = DB::getConnection()->prepare("
			INSERT INTO courses (name, description, image_link) 
			VALUES (:course_name, :course_description, :course_img_link)
		");
		if ($stmt->errorCode()) {
			die($stmt->errorInfo()[0]);
		}
		$stmt->bindParam(':course_name', $this->course_name, PDO::PARAM_STR);
		$stmt->bindParam(':course_description', $this->course_description, PDO::PARAM_STR);
		$stmt->bindParam(':course_img_link', $this->course_img_link, PDO::PARAM_STR);
		$stmt->execute();

		$course_id = DB::getConnection()->lastInsertId();
		$this->course_id = $course_id;

		return $course_id;
	}

	public function update($course_id, $course_name, $course_description, $course_img_link) {
		$stmt = DB::getConnection()->prepare("
			UPDATE courses
				SET name = :course_name, description = :course_description, image_link =:course_img_link
			WHERE id = :course_id
		");
		$stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
		$stmt->bindParam(':course_name', $course_name, PDO::PARAM_STR);
		$stmt->bindParam(':course_description', $course_description, PDO::PARAM_STR);
		$stmt->bindParam(':course_img_link', $course_img_link, PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->errorCode() !== '00000') {
			die($stmt->errorInfo()[0]);
		}
	}

	public function delete($course_id) {
		$stmt = DB::getConnection()->prepare("
			DELETE FROM courses
			WHERE id = :course_id
		");
		$stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->errorCode() !== '00000') {
			die($stmt->errorInfo()[0]);
		}
	}

	public static function getAll() {
		$stmt = DB::getConnection()->query("
			SELECT id, name, description, image_link
			FROM courses
			LIMIT 300
		");
		return $stmt->fetchAll();
	}
	
	public static function getOne($course_id) {
		$stmt = DB::getConnection()->prepare("
			SELECT id, name, description, image_link
			FROM courses
			WHERE id = :course_id
			LIMIT 1
		");
		$stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		return $result;
	}

	public static function getStudents($course_id) {
		$stmt = DB::getConnection()->prepare("
			SELECT students.id, students.name, students.image_link
			FROM students
			INNER JOIN enrollment ON students.id = enrollment.student_id
			WHERE enrollment.course_id = :course_id
			LIMIT 100
		");
		$stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
	}
	public static function validateName ($name){
		$errors['name'] = [];
	    if ($name == '') {
	        $errors['name'][] = "Name field is required.";
	    }
	    if (!preg_match("/^[-a-z0-9,\/()&:. ]*[a-z][-a-z0-9,\/()&:. ]*$/i", $name)) {
	        $errors['name'][] = "Name is not valid.";
	    }
	    if (count($errors['name']) > 0) {
	        return $errors['name'];
	    }
	}
	public static function validateDescription ($description){
		$errors['description'] = [];
	    if ($description == '') {
	        $errors['description'][] = "Description field is required.";
	    }
	    if (!preg_match("/^(.|\s)*[a-zA-Z]+(.|\s)*$/", $description)) {
	        $errors['description'][] = " Description is not valid.";
	    }
	    if (count($errors['description']) > 0) {
	        return $errors['description'];
	    }
	}
	public static function validates ($name, $description){
		$errors = [];
		$errors['name'] = self::validateName ($name);
		$errors['email'] = self::validateDescription ($description);
		return $errors;
	}
}