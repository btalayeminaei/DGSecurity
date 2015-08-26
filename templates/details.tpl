<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="static/css/details.css">
		<title></title>
	</head>
	<body>
		<h1>Edit details</h1>
		<img src="static/img/default.jpg" alt="Default photo" width="128" height="128" />
		<form>
			<fieldset>
				<legend>Name</legend>
				<span>
					<label for="givenName">First</label>
					<input type="text" id="givenName" required="required" value="{$givenName}" />
				</span>
				<span>
					<label for="sn">Last</label>
					<input type="text" id="sn" required="required" value="{$surname}" />
				</span>
				<span>
					<label for="displayName">Display name</label>
					<input type="text" id="displayName" value="{$displayName}" />
				</span>
			</fieldset>
			<fieldset>
				<legend>Position</legend>
				<span>
					<label for="title">Title</label>
					<input type="text" id="title" required="required" placeholder="Regional Manager" value="{$title}" />
				</span>
			</fieldset>
			<fieldset>
				<legend>Email addresses</legend>
				<span>
					<label for="mail">Primary</label>
					<input type="email" id="mail" disabled="disabled" value="{$mail}" />
				</span>
			</fieldset>
			<fieldset>
				<legend>Phone numbers</legend>
				<span>
					<label for="mobile">Mobile</label>
					<input type="text" id="mobile" placeholder="+1 555 123-4567" value="{$mobile}" />
				</span>
				<span>
					<label for="telephoneNumber">Office</label>
					<input type="text" id="telephoneNumber" placeholder="+1 555 987-6543" value="{$telephoneNumber}" />
				</span>
			</fieldset>
			<fieldset>
				<legend>Login credentials</legend>
				<span>
					<label for="cn">Username</label>
					<input type="text" id="cn" disabled="disabled" value="{$uid}" />
				</span>
				<span>
					<label for="userPassword">Password</label>
					<input type="password" id="userPassword" required="required" />
				</span>
				<span>
					<label for="repeatPassword">Repeat password</label>
					<input type="password" id="repeatPassword" required="required" />
				</span>
			</fieldset>
			<button type="submit">Save</button>
		</form>
	</body>
</html>
