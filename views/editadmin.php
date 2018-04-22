{% include 'header.html' %}

<main id="all_info" class="row">
	<nav id="administrators_list" class="col-sm-3">
		<div class="top-side">
			<h3>Administrators</h3>
			<a href="/college/administrator/new"><i class="far fa-plus-square" style="font-size: 2rem; color: #333"></i></a>
		</div>
		{% for administrator in administrators %}
		<div class="card">
			<a href="/college/administrator/{{administrator.id}}">
				<div class="administrator-info">
					<div>
						<img src="/views/{{administrator.image_link}}" alt="{{administrator.name}}" class="pics">
					</div>
					<div class="right-text">
						<p>{{administrator.name}}, {{administrator.role}}</p>
						<p>{{administrator.phone}}</p>
					</div>
				</div>
			</a>
		</div>
		{% endfor %}
	</nav>
	<div id="main_container" class="col-sm-9">
		{% if not (admin['role_id'] == 2 and administrator['role_id'] == 1) %}
		<div class="top-inside">
			<h4>Edit administrator</h4>
			<form action="/college/administrator/{{administrator.id}}/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');">
				{% if editSelfManager %}
				<div id="btns">
					<button class="btn btn-secondery">Delete</button>
				</div>
				{% endif %}
			</form>
		</div>
		<form enctype="multipart/form-data" action="/college/administrator/{{administrator.id}}/edit" method="POST" class="inside_form">
			<div class="top-inside">
				<h4><!-- Edit administrator --></h4>
				<input type="submit" class="btn btn-primary" value="save">
			</div>
			<hr>
			<div class="form-group col-md-6">
				<label for="inputName">Name</label>
				<input type="text" class="form-control" name="administrator_name" value="{{administrator.name}}" required>
			</div>
			<div class="form-group col-md-6">
				<label for="inputName">Phone</label>
				<input type="number" class="form-control" name="administrator_phone" value="{{administrator.phone}}" required>
			</div>
			<div class="form-group col-md-6">
				<label for="inputName">Email</label>
				<input type="email" class="form-control" name="administrator_email" value="{{administrator.email}}" required>
			</div>
			<div class="form-group col-md-6">
				<label for="inputName">Password</label>
				<input type="password" class="form-control" name="administrator_password" value="" required>
			</div>
			<div class="form-group col-md-6">
				<label for="inputName">Role</label>
				<select name="role_id" id="role" class="custom-select" value="{{administrator.role_id}}" required>
					{% if administrator.role_id == 1 %}
					<option {% if administrator.role_id == 1 %} selected {% endif %} value="1">Owner</option>
					{% endif %}
					<option {% if administrator.role_id == 2 %} selected {% endif %} value="2">Manager</option>
					{% if editSelfManager %}
					<option {% if administrator.role_id == 3 %} selected {% endif %} value="3">Sales</option>
					{% endif %}
				</select>
			</div>
			<div class="input-group mb-3">		
				<div class="input-group-prepend">
				 	<span class="input-group-text">Upload</span>
				</div>
				<div class="custom-file">
					<input type="hidden" name="MAX_FILE_SIZE" value="400000" />
					<!-- Name of input element determines name in $_FILES array -->
					<!-- Send this file: <input name="administrator_img_link" type="file" onchange="readURL(this);"> -->
				    <input type="file"  id="inputGroupFile01" class="custom-file-input" name="administrator_img_link" accept="image/*" onchange="readURL(this);">
				    <label class="custom-file-label" name="administrator_img_link" for="inputGroupFile01">Choose file</label>
				</div>
			</div>
		<img id="show_IMG" src="#" alt="image-file">
		</div>
		</form>
		{% endif %}
		{% if admin['role_id'] == 2 and administrator['role_id'] == 1 %}
		<h4 class="text-warning">You are not allowed to see owner information!</h4>
		{% endif %}
	</div>

</main>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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