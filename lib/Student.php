<?php 

class Student {
	private $student_name;
	private $student_phone;
	private $student_email;
	private $student_image_link;
	
	function __construct($student_name, $student_phone, $student_email, $student_image_link, $student_id = null) {
		$this->student_name = $student_name;
		$this->student_phone = $student_phone;
		// if (validateEmail($student_email)) {
		$this->student_email = $student_email;
		// }
		$this->student_image_link = $student_image_link;
		if (!is_null($student_id)) {
			$this->student_id = $student_id;
		}
	}
	public function getStudentById() {
		return $this->student_id;
	}

	public function save() {
		$stmt = DB::getConnection()->prepare("
			INSERT INTO students (name, phone, email, image_link) 
			VALUES (:student_name, :student_phone, :student_email, :student_image_link)
		");
		if ($stmt->errorCode()) {
			die($stmt->errorInfo()[0]);
		}
		$stmt->bindParam(':student_name', $this->student_name, PDO::PARAM_STR);
		$stmt->bindParam(':student_phone', $this->student_phone, PDO::PARAM_STR);
		$stmt->bindParam(':student_email', $this->student_email, PDO::PARAM_STR);
		$stmt->bindParam(':student_image_link', $this->student_image_link, PDO::PARAM_STR);
		$stmt->execute();

		$student_id = DB::getConnection()->lastInsertId();
		$this->student_id = $student_id;

		return $student_id;
	}

	public function update($student_id, $student_name, $student_phone, $student_email, $student_image_link) {
		$stmt = DB::getConnection()->prepare("
			UPDATE students
				SET name = :student_name, phone = :student_phone, email = :student_email, image_link = :student_image_link
			WHERE id = :student_id
		");
		$stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
		$stmt->bindParam(':student_name', $student_name, PDO::PARAM_STR);
		$stmt->bindParam(':student_phone', $student_phone, PDO::PARAM_STR);
		$stmt->bindParam(':student_email', $student_email, PDO::PARAM_STR);
		$stmt->bindParam(':student_image_link', $student_image_link, PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->errorCode() !== '00000') {
			die($stmt->errorInfo()[0]);
		}
	}

	public function delete($student_id) {
		$stmt = DB::getConnection()->prepare("
			DELETE FROM students
			WHERE id = :student_id
		");
		$stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->errorCode() !== '00000') {
			die($stmt->errorInfo()[0]);
		}
	}

	public static function getAll() {
		$stmt = DB::getConnection()->query("
			SELECT id, name, phone, email, image_link
			FROM students
			LIMIT 300
		");
		return $stmt->fetchAll();
	}
	
	public static function getOne($student_id) {
		$stmt = DB::getConnection()->prepare("
			SELECT id, name, phone, email, image_link
			FROM students
			WHERE id = :student_id
			LIMIT 1
		");
		$stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		return $result;
	}

	public static function getCourses($student_id) {
		$stmt = DB::getConnection()->prepare("
			SELECT courses.id, courses.name, courses.image_link
			FROM courses
			INNER JOIN enrollment ON courses.id = enrollment.course_id
			WHERE enrollment.student_id = :student_id
			LIMIT 100
		");
		$stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
	}

	public static function enroll($course_id, $student_id) {
		$stmt = DB::getConnection()->prepare("
			INSERT INTO enrollment (course_id, student_id) 
			VALUES (:course_id, :student_id)
		");
		$stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
		$stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
		$stmt->execute();
	}
	public static function removeEnroll($student_id) {
		$stmt = DB::getConnection()->prepare("
			DELETE FROM enrollment
			WHERE student_id = :student_id
		");
		$stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	public static function validateEmail ($email){
		$errors['email'] = [];
	    if ($email == '') {
	        $errors['email'][] = "Email field is required.";
	    }
	    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	        $errors['email'][] = " Email is not valid.";
	    }
	    if (count($errors['email']) > 0) {
	        return $errors['email'];
	    }
	}
	public static function validateName ($name){
		$errors['name'] = [];
	    if ($name == '') {
	        $errors['name'][] = "Name field is required.";
	    }
	    if (!preg_match("/^[A-Z][a-z]+$/", $name)) {
	        $errors['name'][] = " Name is not valid (pettern: Xx...).";
	    }
	    if (count($errors['name']) > 0) {
	        return $errors['name'];
	    }
	}
	public static function validatePhone ($phone){
		$errors['phone'] = [];
	    if ($phone == "") {
	        $errors['phone'][] = "Phone field is required.";
	    }
	    if (!preg_match("/^[0][1-9][0-9]{8}$/", $phone)) {
	        $errors['phone'][] = " Phone is not valid (pettern: 0xxxxxxxxx, numbers only, second digit cannot be '0').";
	    }
	    if (count($errors['phone']) > 0) {
	        return $errors['phone'];
	    }
	}
	public static function validates ($name, $email, $phone){
		$errors = [];
		$errors['name'] = self::validateName ($name);
		$errors['email'] = self::validateEmail ($email);
		$errors['phone'] = self::validatePhone ($phone);
		return $errors;
	}
}