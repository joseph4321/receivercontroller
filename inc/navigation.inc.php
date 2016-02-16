<CENTER>

<?php

$curScript = basename($_SERVER["PHP_SELF"]);

print ($curScript != "index.php") ? "<A HREF=\"index.php\">Summary</A>&nbsp;&nbsp;" : '';
print ($curScript != "graphs.php") ? "<A HREF=\"graphs.php\">Graphs</A>&nbsp;&nbsp;" : '';

?>

</CENTER>
