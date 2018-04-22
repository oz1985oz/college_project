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
		<form enctype="multipart/form-data" action="/college/administrator/add" method="POST" class="inside_form">
			<div class="top-inside">
				<h4>Add administrator</h4>
				<input type="submit" class="btn btn-primary" value="save">
			</div>
			<hr>
			<div class="form-group col-md-6">
				<label for="inputName">Name</label>
				<input type="text" class="form-control" name="administrator_name" placeholder="Name" required>
			</div>
			<div class="form-group col-md-6">
				<label for="inputName">Phone</label>
				<input type="number" class="form-control" name="administrator_phone" placeholder="Phone" required>
			</div>
			<div class="form-group col-md-6">
				<label for="inputName">Email</label>
				<input type="email" class="form-control" name="administrator_email" placeholder="Email" required>
			</div>
			<div class="form-group col-md-6">
				<label for="inputName">Password</label>
				<input type="password" class="form-control" name="administrator_password" placeholder="Password" required>
			</div>
			<div class="form-group col-md-6">
				<label for="inputName">Role</label>
				<select name="role_id" id="role" class="custom-select" required>
					<option selected>Choose role</option>
					{% if countOwner < 1 %}
					<option value="1">Owner</option>
					{% endif %}
					<option value="2">Manager</option>
					<option value="3">Sales</option>
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
				    <input type="file"  id="inputGroupFile01" class="custom-file-input" name="administrator_img_link" accept="image/*" onchange="readURL(this);" required>
				    <label class="custom-file-label" name="administrator_img_link" for="inputGroupFile01">Choose file</label>
				</div>
			</div>
		<img id="show_IMG" src="#" alt="image-file">
		</div>
		</form>
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