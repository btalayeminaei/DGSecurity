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
					<label for="givenname">First</label>
					<input type="text" id="givenname" required="required" value="{$givenname}" />
				</span>
				<span>
					<label for="sn">Last</label>
					<input type="text" id="sn" required="required" value="{$surname}" />
				</span>
				<span>
					<label for="displayname">Display name</label>
					<input type="text" id="displayname" value="{$displayname}" />
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
					<label for="telephonenumber">Office</label>
					<input type="text" id="telephonenumber" placeholder="+1 555 987-6543" value="{$telephonenumber}" />
				</span>
			</fieldset>
			<fieldset>
				<legend>Login credentials</legend>
				<span>
					<label for="cn">Username</label>
					<input type="text" id="cn" disabled="disabled" value="{$uid}" />
				</span>
				<span>
					<label for="userpassword">Password</label>
					<input type="password" id="userpassword" required="required" />
				</span>
				<span>
					<label for="repeatpassword">Repeat password</label>
					<input type="password" id="repeatpassword" required="required" />
				</span>
			</fieldset>
			<button type="submit">Save</button>
		</form>
	</body>
</html>
