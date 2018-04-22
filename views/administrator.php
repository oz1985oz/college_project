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
	
	<div id="main_container" class="col-sm-8">
		<div class="top-inside">
			<h4>Number of administrators: {{count}}</h4>
		</div>
	</div>

</main>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>