{% include 'template.html' %}

<div id="main_container" class="col-sm-7">
	<div class="top-inside">
		<h4>Edit Student</h4>
		<form action="/college/student/delete/{{student.id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');">
			<input type="submit" class="btn btn-secondery btn-sm" value="Delete">
		</form>
	</div>
	<form enctype="multipart/form-data" action="/college/student/{{student.id}}" method="POST" class="inside_form">
		<div class="top-inside">
			<h4></h4>
			<input type="submit" class="btn btn-primary" value="save">
		</div>
		<hr>
		<div class="form-group col-md-6">
			<label for="inputName">Name</label>
			<input type="text" class="form-control" name="student_name" value="{{student.name}}" required>
		</div>
		<div class="form-group col-md-6">
			<label for="inputPhone">Phone</label>
			<input type="number" class="form-control" name="student_phone" value="{{student.phone}}" required>
		</div>
    	<div class="form-group col-md-6">
      		<label for="inputEmail4">Email</label>
      		<input type="email" class="form-control" name="student_email" value="{{student.email}}" required>
		</div>
		<div class="form-check">
			<h4>Courses:</h4>

			{% for course in courses_2 %}
			<label for="course_name">
	    		<input type="checkbox" name="courses_id[]" value="{{course.id}}" {% for courseSt in courses_per_student %} {% if course.id == courseSt.id %} checked {% endif %}{% endfor %}>{{course.name}}
	    	</label>
	    	<br>
			{% endfor %}

		</div>

	  	<div class="input-group mb-3">
			<div class="input-group-prepend">
			 	<span class="input-group-text">Upload</span>
			</div>
			<div class="custom-file">
			    <input type="file"  id="inputGroupFile01" class="custom-file-input" name="student_img_link" value="{{course_img_link}}" accept="image/*" onchange="readURL(this);">
			    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
			</div>
		</div>
		<div>
			<img id="show_IMG" src="#" alt="image-file">
		</div>
	</form>
</div>
</main>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#show_IMG')
                    .attr('src', e.target.result)
					
                    .width(100);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>