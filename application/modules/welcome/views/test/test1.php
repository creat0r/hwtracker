<form action="http://localhost:8888/hwezemail2/index.php/welcome/welcome/formtest" method="post" accept-charset="utf-8" id="myform3" class="horizontal" data-ajax="false">


<div data-role="fieldcontain">
<label for='username'><em>* </em> Username</label>
<input type="text" name="username" value="" id="username" class="required"  />
</div>

<div data-role="fieldcontain">
<label for='email'><em>* </em> Email</label>
<input type="text" name="email" value="" id="email" class="required"  />
</div>

<div data-role="fieldcontain">
<label for='first_name'><em>* </em> First Name</label>
<input type="text" name="first_name" value="" id="first_name" class="required"  />
</div>

<div data-role="fieldcontain">
<label for='last_name'><em>* </em> Last Name</label>
<input type="text" name="last_name" value="" id="last_name" class="required"  />
</div>

<div data-role="fieldcontain">
<fieldset data-role="controlgroup">
<legend for='school'><em>* </em> School</legend>
<input type="checkbox" name="school[]" value="es" id="es"  /><label for="es">Elementary School</label>
<input type="checkbox" name="school[]" value="ms" id="ms"  /><label for="ms">Middle School</label>
<input type="checkbox" name="school[]" value="hs" id="hs"  /><label for="hs">High School</label>
</fieldset>
</div>

<div data-role="fieldcontain">
<fieldset data-role="controlgroup">
<legend for='gender'><em>* </em> Gender</legend>
<input type="radio" name="gender" value="male" checked="checked" id="male"  /><label for="male">Male</label>
<input type="radio" name="gender" value="female" id="female"  /><label for="female">Female</label>
</fieldset>
</div>


<input type="submit" name="submit" value="Submit" data-icon="gear" data-inline="true" data-mini="true" id="submit" />
</form>

<?php

var_dump($profile);
$profile = implode(",", $profile);
print_r($profile);
?>