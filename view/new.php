<?php require_once __SITE_PATH . '/view/_header_out.php'; ?>

<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=register'?>">
	Odaberite korisničko ime:
	<input type="text" name="username" />
	<br />
	Unesite ime:
	<input type="text" name="name" />
	<br />
	Unesite prezime:
	<input type="text" name="surname" />
	<br />
	Odaberite lozinku:
	<input type="password" name="password" />
	<br />
	Vaša mail-adresa:
	<input type="text" name="email" />
	<br />
	Uloga:
	<select name="role" id="role">
		<option value="admin">Admin</option>
		<option value="profesor">Profesor</option>
		<option value="glavni_demos">Glavni demonstrator</option>
		<option value="demos">Demonstrator</option>
		<option value="student">Student</option>
    </select>
	<br />
	<button type="submit">Stvori korisnički račun!</button>
	
</form>

<p>
	Povratak na <a href="<?php echo __SITE_URL . '/index.php?rt=login'?>">login</a>.
</p>



<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
