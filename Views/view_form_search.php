<?php require "view_begin.php"; ?>


<h1> Find among Nobel Prizes </h1>

<form action = "index.php" method="get">
	<p> <label> Name contains : <input type="text" name="Name"/> </label> 
		<input type="hidden" name="controller" value="search"/>     <input type="hidden" name="action" value="results"/>
		<input type="hidden" name="submit" value="on" /> 
	</p>
	<p> <label> Year: </label>  
	<select name="Sign">
		<option> &lt;= </option>
		<option> &gt;= </option>
		<option> = </option>
	</select><input type="text" name="Year"/> </p>
	<p>
	<?php foreach ($Categories as $v) : ?>
		<label> <input type="checkbox" name="Categories[]" value="<?= e($v) ?>" /> <?= e(ucfirst($v)) ?> </label>
	<?php endforeach ?>

	</p>


	<p>  <input type="submit" value="Search"/> </p>
</form>





<?php require "view_end.php"; ?>
