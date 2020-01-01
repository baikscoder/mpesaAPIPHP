<?php

/* Database config */
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_database = 'betting';

/* End config */
try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_database", $db_user, $db_pass);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "<center><fieldset><legend>Database Error:</legend>";
    echo "Sorry.Database error has occurred. Kindly share the text below(in red) with system admin.<br><br><br>";
    echo "<span style='color:#e60000'/>" . $e->getMessage() . "</span>";
    echo "</fieldset></center>";
    die();
}
?>
