<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="static/css/details.css">
		<title></title>
	</head>
	<body>
		<div class="logout">
			<a href="/logout">Log out</a>
		</div>
		<h1>Edit details</h1>
		{if isset($message) }
		<div class="saved">{$message}</div>
		{/if}
		<img src="static/img/default.jpg" alt="Default photo" width="128" height="128" />
		<form action="/details" method="post">
			<fieldset>
				<legend>Name</legend>
				<span>
					<label for="givenname">First</label>
					<input type="text" name="givenname" required="required" disabled="disabled" value="{$details.givenname}" />
				</span>
				<span>
					<label for="sn">Last</label>
					<input type="text" name="sn" required="required" disabled="disabled" value="{$details.surname}" />
				</span>
				<span>
					<label for="displayname">Display name</label>
					<input type="text" name="displayname" value="{$details.displayname}" />
				</span>
			</fieldset>
			<fieldset>
				<legend>Position</legend>
				<span>
					<label for="title">Title</label>
					<input type="text" name="title" required="required" placeholder="Regional Manager" value="{$details.title}" />
				</span>
			</fieldset>
			<fieldset>
				<legend>Email addresses</legend>
				<span>
					<label for="mail">Primary</label>
					<input type="email" name="mail" disabled="disabled" value="{$details.mail}" />
				</span>
			</fieldset>
			<fieldset>
				<legend>Phone numbers</legend>
				<span>
					<label for="mobile">Mobile</label>
					<input type="text" name="mobile" placeholder="+1 555 123-4567" value="{$details.mobile}" />
				</span>
				<span>
					<label for="telephonenumber">Office</label>
					<input type="text" name="telephonenumber" placeholder="+1 555 987-6543" value="{$details.telephonenumber}" />
				</span>
			</fieldset>
			<fieldset>
				<legend>Login credentials</legend>
				<span>
					<label for="cn">Username</label>
					<input type="text" name="cn" disabled="disabled" value="{$details.uid}" />
				</span>
				<span>
					<label for="userpassword">Password</label>
					<input type="password" name="userpassword" />
				</span>
				<span>
					<label for="repeatpassword">Repeat password</label>
					<input type="password" name="repeatpassword" />
				</span>
			</fieldset>
			<button type="submit">Save</button>
		</form>
	</body>
</html>
