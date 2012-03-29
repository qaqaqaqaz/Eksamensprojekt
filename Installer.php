<!--For at kunne installere databasen kræves det at man conecter til phpmyadmin med brugernavn og password-->

<span style="color:red">Skriv brugernavn og password for at installere databasen i systemet</span><br /><br />

<form method="post" action="config.php">
MySQL Username<br />
<input type="text" name="mysql_username" /><br />
MySQL Password<br />
<input type="password" name="mysql_pw" /><br />
<input type="submit" value="Installer" name="submitted" />
</form>
