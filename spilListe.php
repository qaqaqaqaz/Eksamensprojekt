<?php 
	require_once('util.php');
	require_once('connect.php');
	if(!isset($_GET['redirect'])){
		$_GET['redirect'] = '/eksamensprojekt/index.php';
	}
	top();
	echo "<div class='mulighedsboks'>";
	echo "<b>Valgmuligheder:</b>";

?>
<!-- s�geliste efter kategori-->
<form action="spilListeQuery.php">
S�g efter kategori:
<select name="spilkategori">
  <option value="action">Action</option>
  <option value="adventure">Adventure</option>
  <option value="fps">FPS</option>
  <option value="racing">Racing</option>
</select>
<input type="submit" value="S�g" />
</form>
<?PHP
	echo "</div>";
	bund();
?>