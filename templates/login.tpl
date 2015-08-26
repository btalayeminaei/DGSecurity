<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="static/css/login.css">
		<title>Log in to DG security console</title>
	</head>
	<body>
		<h1>Log in to DG security console</h1>
		<div class="wrapper">
			<div class="error">Username or password wrong</div>
			<form action="/login">
				<table>
					<tr>
						<td><label for="username">Username</label></td>
						<td><input type="text" id="username" required="required" /></td>
					</tr>
					<tr>
						<td><label for="password">Password</label></td>
						<td><input type="password" id="password" required="required" /></td>
					</tr>
				</table>
				<button type="submit">Log in</button>
			</form>
		</div>
	</body>
	<footer>Unauthorized access is prohibited and will be prosecuted under U.S. law. All activity is logged.</footer>
</html>
