<?php require "view_begin.php"; ?>

<h1> <?= e($name) ?> </h1>


<ul>
    <li> Year and place of birth : <?= is_null($birthdate) ? '???' : e($birthdate) ?> 
            at <?= is_null($birthplace) ? '???' : e($birthplace) ?> </li>
    <li> County : <?= is_null($county) ? '???' : e($county) ?> </li>
</ul>

<h2>
    Nobel Prize in <?= e($year) ?> in the field of <?= e($category) ?>
</h2>


<p>     
    <?= e($motivation) ?>
</p>

<?php require "view_end.php"; ?>