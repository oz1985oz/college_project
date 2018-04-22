<?php 

class Admin {
	private $admin_name;
	private $admin_role;
	private $admin_phone;
	private $admin_email;
	private $admin_password;
	private $admin_image_link;
	
	function __construct($admin_name, $admin_role, $admin_phone, $admin_email, $admin_password, $admin_image_link, $admin_id = null) {
		$this->admin_name = $admin_name;
		$this->admin_role = $admin_role;
		$this->admin_phone = $admin_phone;
		$this->admin_email = $admin_email;
		$this->admin_password = $admin_password;
		$this->admin_image_link = $admin_image_link;
		if (!is_null($admin_id)) {
			$this->admin_id = $admin_id;
		}
	}
	public function getAdminById() {
		return $this->admin_id;
	}

	public static function checkLogin ($email, $password) {
		$stmt = DB::getConnection()->prepare("
			SELECT id, name, role_id, phone, email, password, image_link
			FROM administrators
			WHERE email = :admin_email
			LIMIT 1
		");
		$stmt->bindParam(':admin_email', $email, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		if (password_verify($password, $result['password'])) {
			$_SESSION = $result;
			return $result['id'];
		}
	}

	public static function inspect() {
		if (isset($_SESSION['name']) && $_SESSION['id'] > 0) {
			$_SESSION['role'] = self::getRole($_SESSION['id']);
			return $_SESSION;
		} else {
			header("Location: /college/login");
			die("Not today my lovely hacker");
		}
	}

	public static function logout () {
		if (!isset($_SESSION)) {
			session_start();
		}
		session_destroy();
	}

	public function save() {
		$admin_password = password_hash($admin_password, PASSWORD_DEFAULT);
		$stmt = DB::getConnection()->prepare("
			INSERT INTO administrators (name, role_id, phone, email, password, image_link) 
			VALUES (:admin_name, :admin_role, :admin_phone, :admin_email, :admin_password, :admin_image_link)
		");
		if ($stmt->errorCode()) {
			die($stmt->errorInfo()[0]);
		}
		$stmt->bindParam(':admin_name', $this->admin_name, PDO::PARAM_STR);
		$stmt->bindParam(':admin_role', $this->admin_role, PDO::PARAM_INT);
		$stmt->bindParam(':admin_phone', $this->admin_phone, PDO::PARAM_STR);
		$stmt->bindParam(':admin_email', $this->admin_email, PDO::PARAM_STR);
		$stmt->bindParam(':admin_password', $this->admin_password, PDO::PARAM_STR);
		$stmt->bindParam(':admin_image_link', $this->admin_image_link, PDO::PARAM_STR);
		$stmt->execute();

		$admin_id = DB::getConnection()->lastInsertId();
		$this->admin_id = $admin_id;

		return $admin_id;
	}

	public function update($admin_id, $admin_name, $admin_role, $admin_phone, $admin_email, $admin_password, $admin_image_link) {
		$admin_password = password_hash($admin_password, PASSWORD_DEFAULT);
		$stmt = DB::getConnection()->prepare("
			UPDATE administrators
				SET name = :admin_name, role_id = :admin_role ,phone = :admin_phone, email = :admin_email, password = :admin_password, image_link = :admin_image_link
			WHERE id = :admin_id
		");
		$stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
		$stmt->bindParam(':admin_name', $admin_name, PDO::PARAM_STR);
		$stmt->bindParam(':admin_role', $admin_role, PDO::PARAM_INT);
		$stmt->bindParam(':admin_phone', $admin_phone, PDO::PARAM_STR);
		$stmt->bindParam(':admin_email', $admin_email, PDO::PARAM_STR);
		$stmt->bindParam(':admin_password', $admin_password, PDO::PARAM_STR);
		$stmt->bindParam(':admin_image_link', $admin_image_link, PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->errorCode() !== '00000') {
			die($stmt->errorInfo()[0]);
		}
	}

	public function delete($admin_id) {
		$stmt = DB::getConnection()->prepare("
			DELETE FROM administrators
			WHERE id = :admin_id
		");
		$stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->errorCode() !== '00000') {
			die($stmt->errorInfo()[0]);
		}
	}

	public static function getAll() {
		$stmt = DB::getConnection()->query("
			SELECT adm.id, adm.name, adm.role_id, adm.phone, adm.email, adm.password, adm.image_link, roles.role
			FROM roles
			INNER JOIN administrators adm ON roles.id = adm.role_id
			LIMIT 300
		");
		return $stmt->fetchAll();
	}
	
	public static function getOne($admin_id) {
		$stmt = DB::getConnection()->prepare("
			SELECT id, name, role_id, phone, email, password, image_link
			FROM administrators
			WHERE id = :admin_id
			LIMIT 1
		");
		$stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		return $result;
	}

	public static function getRole($admin_id) {
		$stmt = DB::getConnection()->prepare("
			SELECT roles.role
			FROM roles
			INNER JOIN administrators ON roles.id = administrators.role_id
			WHERE administrators.id = :admin_id
			LIMIT 100
		");
		$stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		return $result['role'];
	}
	public static function salesNotAllowed ($role_id) {
		if ($role_id == 3) {
			// header("Location: /college");
			die("Not today my lovely hacker.");
		}
	}
	public static function countOwners($role_id = 1) {
		$stmt = DB::getConnection()->query("
			SELECT COUNT(role_id)
			FROM administrators
			WHERE role_id = $role_id;
		");
		return $stmt->fetch();
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