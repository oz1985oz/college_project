<?php 

require 'lib/Student.php';
require 'lib/Course.php';
require 'lib/Admin.php';
require 'lib/DB.php';

#home
$app->get('/', function ($request, $response) {
	return $response->withRedirect('/college');
});

$app->get('/college', function ($request, $response) {
	// var_dump($_SESSION);
	$admin = Admin::inspect();
	$students = Student::getAll();
	$courses = Course::getAll();
	$stCount = count($students);
	$cuCount = count($courses);
	return $this->view->render($response, 'college.php', [
		'admin' => $admin,
		'stCount' => $stCount,
        'cuCount' => $cuCount,
        'students' => $students,
        'courses' => $courses
    ]);
});
#login
$app->get('/college/login', function ($request, $response) {
	return $this->view->render($response, 'login.html');
});
#logout
$app->get('/college/logout', function ($request, $response) {
	Admin::logout();
	return $response->withRedirect('/college/login');
});
#check-login
$app->post('/college/check-login', function ($request, $response) {
	$body = $request->getParsedBody();
	$errorsValidate = Admin::validateEmail($body['username']);
	if ($errorsValidate) {
		return $this->view->render($response, 'login.html',[
        'errorsValidate' => $errorsValidate
	    ]);
	}
	$adminLoggedin = Admin::checkLogin($body['username'], $body['password']);
	if ($adminLoggedin) {
		return $response->withRedirect('/college');
	} else {
		$error = "Error: Email or password is incorrect";
		return $this->view->render($response, 'login.html',[
        'error' => $error
	    ]);
	}
});
#show student
$app->get('/college/student/{student_id:\d+}', function ($request, $response, $args) {
	$admin = Admin::inspect();
	$student_id = $args['student_id'];
	$student = Student::getOne($student_id);
	$courses_per_student = [];
	$courses_per_student = Student::getCourses($student_id);
	$students = Student::getAll();
	$courses = Course::getAll();
	return $this->view->render($response, 'student.php', [
		'admin' => $admin,
        'student' => $student,
        'courses_per_student' => $courses_per_student,
        'students' => $students,
        'courses' => $courses
    ]);
});
#show course
$app->get('/college/course/{course_id:\d+}', function ($request, $response, $args) {
	$admin = Admin::inspect();
	$course_id = $args['course_id'];
	$course = Course::getOne($course_id);
	$students_per_course = [];
	$students_per_course = Course::getStudents($course_id);
	$students = Student::getAll();
	$courses = Course::getAll();
	$count_courses = count($students_per_course);
	return $this->view->render($response, 'course.php', [
		'admin' => $admin,
        'course' => $course,
        'students_per_course' => $students_per_course,
        'students' => $students,
        'courses' => $courses,
        'count_courses' => $count_courses
    ]);
});
#form new student
$app->get('/college/student/new', function ($request, $response) {
	$admin = Admin::inspect();
	$students = Student::getAll();
	$courses = Course::getAll();
	$courses_2 = Course::getAll();
	return $this->view->render($response, 'newstudent.php', [
		'admin' => $admin,
        'students' => $students,
        'courses' => $courses,
        'courses_2' => $courses_2
    ]);
});
#form edit student
$app->get('/college/student/edit/{student_id:\d+}', function ($request, $response, $args) {
	$admin = Admin::inspect();
	$student_id = $args['student_id'];
	$student = Student::getOne($student_id);
	$students = Student::getAll();	
	$courses_per_student = [];
	$courses_per_student = Student::getCourses($student_id);
	$courses = Course::getAll();
	$courses_2 = Course::getAll();
	return $this->view->render($response, 'editstudent.php', [
		'admin' => $admin,
        'student' => $student,
        'students' => $students,
        'courses_per_student' => $courses_per_student,
        'courses' => $courses,
        'courses_2' => $courses_2
    ]);
});
# edit student - PUT not working on SLIM
$app->post('/college/student/{student_id:\d+}', function ($request, $response, $args) {
	$admin = Admin::inspect();
	$body = $request->getParsedBody();
	$errorsValidates = Student::validates($body['student_name'], $body['student_email'], $body['student_phone']);
	if (array_filter($errorsValidates)) {
		return $this->view->render($response, 'errors.html',[
		'admin' => $admin,
        'errorsValidates' => $errorsValidates
	    ]);
	    die();
	}
	$student_id = $args['student_id'];
	$uploaddir = 'c:/xampp/htdocs/project2/views/IMG/students/';
	$uploadfile = $uploaddir . basename($_FILES['student_img_link']['name']);
	$student = Student::getOne($student_id);
	if (move_uploaded_file($_FILES['student_img_link']['tmp_name'], $uploadfile)) {
	    $img = "IMG\\students\\" . $_FILES['student_img_link']["name"];
	} else {
		$img = $student['image_link'];
	}
	Student::update($student_id, $body['student_name'], $body['student_phone'], $body['student_email'], $img);
	$courses_id = $body['courses_id'];
	Student::removeEnroll($student_id);
	foreach ($courses_id as $course_id) { #fix check box
		Student::enroll($course_id, $student_id);
	}
	return $response->withRedirect('/college/student/' . $student_id); 
});
#save student
$app->post('/college/student', function ($request, $response) {
	$admin = Admin::inspect();
	$body = $request->getParsedBody();
	$errorsValidates = Student::validates($body['student_name'], $body['student_email'], $body['student_phone']);
	if (array_filter($errorsValidates)) {
		return $this->view->render($response, 'errors.html',[
		'admin' => $admin,
        'errorsValidates' => $errorsValidates
	    ]);
	    die();
	}
	$uploaddir = 'c:/xampp/htdocs/project2/views/IMG/students/';
	$uploadfile = $uploaddir . basename($_FILES['student_img_link']['name']);
	if (move_uploaded_file($_FILES['student_img_link']['tmp_name'], $uploadfile)) {
	    echo "localhost:3000/college/student/{new_student_id}";
	} else {
		// header('Location: /college/student/new');
		die("Possible file upload attack!\n or pic is missing");
	}
	$new_student = new Student($body['student_name'], $body['student_phone'], $body['student_email'], "IMG\\students\\" . $_FILES['student_img_link']["name"]);
	$new_student_id = $new_student->save();
	$courses_id = $body['courses_id'];
	foreach ($courses_id as $course_id) {
		Student::enroll($course_id, $new_student_id);
	}
	return $response->withRedirect('/college/student/' . $new_student_id); 
});
#form new course
$app->get('/college/course/new', function ($request, $response) {
	$admin = Admin::inspect();
	Admin::salesNotAllowed($admin['role_id']);
	$students = Student::getAll();
	$courses = Course::getAll();
	return $this->view->render($response, 'newcourse.php', [
		'admin' => $admin,
        'students' => $students,
        'courses' => $courses,
    ]);
});
#form edit course
$app->get('/college/course/edit/{course_id:\d+}', function ($request, $response, $args) {
	$admin = Admin::inspect();
	Admin::salesNotAllowed($admin['role_id']);
	$course_id = $args['course_id'];
	$course = Course::getOne($course_id);
	$courses = Course::getAll();
	$students = Student::getAll();
	$students_per_course = Course::getStudents($course_id);
	$count_courses = count($students_per_course);
	return $this->view->render($response, 'editcourse.php', [
		'admin' => $admin,
        'course' => $course,
        'courses' => $courses,
        'students' => $students,
        'count_courses' => $count_courses,
    ]);
});
#save course
$app->post('/college/course', function ($request, $response) {
	$admin = Admin::inspect();
	Admin::salesNotAllowed($admin['role_id']);
	$body = $request->getParsedBody();
	$errorsValidates = Course::validates($body['course_name'], $body['course_description']);
	if (array_filter($errorsValidates)) {
		return $this->view->render($response, 'errors.html',[
		'admin' => $admin,
        'errorsValidates' => $errorsValidates
	    ]);
	    die();
	}
	$uploaddir = 'c:/xampp/htdocs/project2/views/IMG/courses/';
	$uploadfile = $uploaddir . basename($_FILES['course_img_link']['name']);
	if (move_uploaded_file($_FILES['course_img_link']['tmp_name'], $uploadfile)) {
	    echo "localhost:3000/college/course/{new_course_id}";
	} else {
		die("Possible file upload attack!\n or pic is missing");
	}
	$new_course = new Course($body['course_name'], $body['course_description'], "IMG\\courses\\" . $_FILES['course_img_link']["name"]);
	$new_course_id = $new_course->save();
	return $response->withRedirect('/college/course/' . $new_course_id); 
});
# edit course (PUT method not working on SLIM)
$app->POST('/college/course/{course_id:\d+}', function ($request, $response, $args) {
	$admin = Admin::inspect();
	Admin::salesNotAllowed($admin['role_id']);
	$body = $request->getParsedBody();
	$errorsValidates = Course::validates($body['course_name'], $body['course_description']);
	if (array_filter($errorsValidates)) {
		return $this->view->render($response, 'errors.html',[
		'admin' => $admin,
        'errorsValidates' => $errorsValidates
	    ]);
	    die();
	}
	$course_id = $args['course_id'];
	$course = Course::getOne($course_id);
	$uploaddir = 'c:/xampp/htdocs/project2/views/IMG/courses/';
	$uploadfile = $uploaddir . basename($_FILES['course_img_link']['name']);
	if (move_uploaded_file($_FILES['course_img_link']['tmp_name'], $uploadfile)) {
	    $img = "IMG\\courses\\" . $_FILES['course_img_link']["name"];
	} else {
		$img = $course['image_link'];
	}
	Course::update($course_id, $body['course_name'], $body['course_description'], $img);
	return $response->withRedirect('/college/course/' . $course_id); 
});
# delete student (DELETE method not working on SLIM)
$app->post('/college/student/delete/{student_id:\d+}', function ($request, $response, $args) {
	$admin = Admin::inspect();
	$body = $request->getParsedBody();
	$student_id = $args['student_id'];
	Student::removeEnroll($student_id);
	Student::delete($student_id);
	return $response->withRedirect('/college');
});
# delete course (DELETE method not working on SLIM)
$app->post('/college/course/delete/{course_id:\d+}', function ($request, $response, $args) {
	$admin = Admin::inspect();
	Admin::salesNotAllowed($admin['role_id']);
	$body = $request->getParsedBody();
	$course_id = $args['course_id'];
	Course::delete($course_id);
	return $response->withRedirect('/college');
	// return $response->withStatus(204);
});

#administration page
$app->get('/college/administrator', function ($request, $response) {
	$admin = Admin::inspect();
	Admin::salesNotAllowed($admin['role_id']);
	$administrators = Admin::getAll();
	$count = count($administrators);
	// var_dump($administrators);
	return $this->view->render($response, 'administrator.php', [
		'admin' => $admin,
        'administrators' => $administrators,
        'count' => $count
    ]);
});
#form new admin
$app->get('/college/administrator/new', function ($request, $response) {
	$admin = Admin::inspect();
	Admin::salesNotAllowed($admin['role_id']);
	$countOwner = Admin::countOwners();
	$countOwner = ($countOwner["COUNT(role_id)"]);
	$administrators = Admin::getAll();
	return $this->view->render($response, 'newadmin.php', [
		'admin' => $admin,
        'administrators' => $administrators,
        'countOwner' => $countOwner
    ]);
});
#form edit admin
$app->get('/college/administrator/{administrator_id:\d+}', function ($request, $response, $args) {
	$admin = Admin::inspect();
	Admin::salesNotAllowed($admin['role_id']);
	$administrator_id = $args['administrator_id'];
	$editSelfManager = ($administrator_id == $admin['id'] && $admin['role_id'] == 2) ? false : true;
	$administrator = Admin::getOne($administrator_id);
	$administrators = Admin::getAll();
	return $this->view->render($response, 'editadmin.php', [
		'admin' => $admin,
		'editSelfManager' => $editSelfManager,
        'administrator' => $administrator,
        'administrators' => $administrators
    ]);
});
#add admin
$app->post('/college/administrator/add', function ($request, $response) {
	$admin = Admin::inspect();
	Admin::salesNotAllowed($admin['role_id']);
	$body = $request->getParsedBody();
	$errorsValidates = Admin::validates($body['administrator_name'], $body['administrator_email'], $body['administrator_phone']);
	if (array_filter($errorsValidates)) {
		return $this->view->render($response, 'errors.html',[
		'admin' => $admin,
        'errorsValidates' => $errorsValidates
	    ]);
	    die();
	}
	$uploaddir = 'c:/xampp/htdocs/project2/views/IMG/administrators/';
	$uploadfile = $uploaddir . basename($_FILES['administrator_img_link']['name']);
	if (move_uploaded_file($_FILES['administrator_img_link']['tmp_name'], $uploadfile)) {
	    echo "localhost:3000/college/administrator/{new_administrator_id}";
	} else {
		die("Possible file upload attack!\n or pic is missing");
	}
	$new_administrator = new Admin($body['administrator_name'], $body['role_id'], $body['administrator_phone'], $body['administrator_email'], $body['administrator_password'], "IMG\\administrators\\" . $_FILES['administrator_img_link']["name"]);
	$new_administrator_id = $new_administrator->save();
	return $response->withRedirect('/college/administrator'); 
});
#adit admin
$app->post('/college/administrator/{administrator_id:\d+}/edit', function ($request, $response, $args) {
	$admin = Admin::inspect();
	Admin::salesNotAllowed($admin['role_id']);
	$body = $request->getParsedBody();
	$errorsValidates = Admin::validates($body['administrator_name'], $body['administrator_email'], $body['administrator_phone']);
	if (array_filter($errorsValidates)) {
		return $this->view->render($response, 'errors.html',[
		'admin' => $admin,
        'errorsValidates' => $errorsValidates
	    ]);
	    die();
	}
	$administrator_id = $args['administrator_id'];
	if ($administrator_id == $admin['id'] && $admin['role_id'] == 2 && $body['role_id'] != 2) {
		die("Not today my lovely Hacker");
	}
	if ($admin['role_id'] != 1 && $body['role_id'] == 1) {
		die("Not today my lovely Hacker");
	}
	$administrator = Admin::getOne($administrator_id);
	$uploaddir = 'c:/xampp/htdocs/project2/views/IMG/administrators/';
	$uploadfile = $uploaddir . basename($_FILES['administrator_img_link']['name']);
	if (move_uploaded_file($_FILES['administrator_img_link']['tmp_name'], $uploadfile)) {
	    $img = "IMG\\administrators\\" . $_FILES['administrator_img_link']["name"];
	} else {
		$img = $administrator['image_link'];
	}
	Admin::update($administrator_id, $body['administrator_name'], $body['role_id'], $body['administrator_phone'], $body['administrator_email'], $body['administrator_password'], $img);
	return $response->withRedirect('/college/administrator'); 
});
# delete admin (DELETE method not working on SLIM)
$app->post('/college/administrator/{administrator_id:\d+}/delete', function ($request, $response, $args) {
	$admin = Admin::inspect();
	Admin::salesNotAllowed($admin['role_id']);
	$administrator_id = $args['administrator_id'];
	$administrator = Admin::getOne($administrator_id);
	$body = $request->getParsedBody();
	if ($admin['role_id'] != 1 && $administrator['role_id'] == 1) {
		die("Not today my lovely Hacker");
	}
	if ($administrator_id == $admin['id'] && $admin['role_id'] == 2) {
		die("Not today my lovely Hacker");
	}
	Admin::delete($administrator_id);
	return $response->withRedirect('/college/administrator');
});