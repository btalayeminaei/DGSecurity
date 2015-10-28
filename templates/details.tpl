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
		<form>
			<fieldset>
				<legend>Name</legend>
				<span>
					<label for="givenname">First</label>
					<input type="text" id="givenname" required="required" value="{$details.givenname}" />
				</span>
				<span>
					<label for="sn">Last</label>
					<input type="text" id="sn" required="required" value="{$details.surname}" />
				</span>
				<span>
					<label for="displayname">Display name</label>
					<input type="text" id="displayname" value="{$details.displayname}" />
				</span>
			</fieldset>
			<fieldset>
				<legend>Position</legend>
				<span>
					<label for="title">Title</label>
					<input type="text" id="title" required="required" placeholder="Regional Manager" value="{$details.title}" />
				</span>
			</fieldset>
			<fieldset>
				<legend>Email addresses</legend>
				<span>
					<label for="mail">Primary</label>
					<input type="email" id="mail" disabled="disabled" value="{$details.mail}" />
				</span>
			</fieldset>
			<fieldset>
				<legend>Phone numbers</legend>
				<span>
					<label for="mobile">Mobile</label>
					<input type="text" id="mobile" placeholder="+1 555 123-4567" value="{$details.mobile}" />
				</span>
				<span>
					<label for="telephonenumber">Office</label>
					<input type="text" id="telephonenumber" placeholder="+1 555 987-6543" value="{$details.telephonenumber}" />
				</span>
			</fieldset>
			<fieldset>
				<legend>Login credentials</legend>
				<span>
					<label for="cn">Username</label>
					<input type="text" id="cn" disabled="disabled" value="{$details.uid}" />
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
