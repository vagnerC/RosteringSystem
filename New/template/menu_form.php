<form action="" method="post" role="form" class="contactForm">
	<div class="form-row">
		<div class="form-group col-md-4">
			<input type="text" name="username" id="username" class="form-control"  placeholder="Username" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
			<div class="validation"></div>
		</div>
		
		<div class="form-group col-md-4">
			<input type="password" name="password" id="password" class="form-control"  placeholder="Password" data-rule="email" data-msg="Please enter a valid email" />
			<div class="validation"></div>
		</div>
		
		<div class="form-group col-md-2">
			<button class="form-control" type="submit">Login</button>
		</div>
	</div>
</form>