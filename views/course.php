{% include 'template.html' %}

<div id="main_container" class="col-sm-7">
	<div class="inside">
		<div class="top-inside">
			<h1>course number {{course.id}}, {{count_courses}} Students</h1>
			{% if admin.role_id == 1 or admin.role_id == 2 %}
			<a href="/college/course/edit/{{course.id}}"><button type="button" id="ttt" class="btn btn-secondary">Edit</button></a>
			{% endif %}
		</div>
		<hr>

		<div class="student-info">
			<div>
				<img src="/views/{{course.image_link}}" alt="{{course.name}}" width=150>
			</div>
			<div class="right-text">
				<h2>{{course.name}}</h2>
				<p>{{course.description}}</p>
			</div>
		</div>
		<hr>
		<h4>Students:</h4>
		{% for student in students_per_course %}
		<div class="text-box">
			<a href="/college/student/{{student.id}}">
				<div class="student-info">
					<div>
						<img src="/views/{{student.image_link}}" alt="{{student.name}}" width=95>
					</div>
		    		<div class="right-text">
			    		<p>{{student.name}}</p>
			    	</div>
		    	</div>
		    </a>
		</div>
		{% endfor %}
	</div>
</div>

</main>
	
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
</body>
</html>