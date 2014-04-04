<?php
if(!isset($_GET['key'])) exit;
$key = $_GET['key'];
?>
<!doctype html>
<html>
<body>
<a href="spotify:app:project-03:record:<?php print $key; ?>">back to spotify!</a>
</body>
</html>