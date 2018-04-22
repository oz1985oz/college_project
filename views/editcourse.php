{% include 'template.html' %}

<div id="main_container" class="col-sm-7">
	<div class="top-inside">
		<h4>Edit Course</h4>
		<form action="/college/course/delete/{{course.id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');">
			{% if count_courses == 0 %}
			<div id="btns">
				<button class="btn btn-secondery">Delete</button>
			</div>
			{% endif %}
		</form>
	</div>
	<form enctype="multipart/form-data" action="/college/course/{{course.id}}" method="POST" class="inside_form">
		<div class="top-inside">
			<h4><!-- Edit Course --></h4>
				<input type="submit" class="btn btn-primary" value="save">
		</div>
		<hr>
		<div class="form-group col-md-6">
			<label for="inputName">Name</label>
			<input type="text" class="form-control" name="course_name" value="{{course.name}}" required>
		</div>
		<div class="form-group col-md-6">
			<label for="inputDescription">Description</label>
			<textarea class="form-control" name="course_description" cols="90" rows="5" required>{{course.description}}</textarea>
		</div>
	  	<div class="input-group mb-3">
			<div class="input-group-prepend">
			 	<span class="input-group-text">Upload</span>
			</div>
			<div class="custom-file">
				<input type="hidden" name="MAX_FILE_SIZE" value="400000" />
				<!-- Name of input element determines name in $_FILES array -->
				<!-- Send this file: <input name="course_img_link" type="file" onchange="readURL(this);"> -->
			    <input type="file"  id="inputGroupFile01" class="custom-file-input" name="course_img_link" accept="image/*" onchange="readURL(this);">
			    <label class="custom-file-label" name="course_img_link" for="inputGroupFile01">Choose file</label>
			</div>
		</div>
		<img id="show_IMG" src="#" alt="image-file">
	</form>
	<small>Total {{count_courses}} students taking this course</small>
</div>
</main>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- <script>
	if ({{count_courses}} === 0) {
		var btns = document.getElementById('btns');
		var addBtn = document.createElement('button');
		addBtn.classList.add('btn','btn2');
		// addBtn.classList.add('btn');
		// addBtn.classList.add('btn-secondary');
		addBtn.textContent = 'Delete';
		btns.appendChild(addBtn);
	}
</script> -->
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
</body>
</html>