<?php
    session_start ();
    session_unset ();
    session_destroy ();
    header ('Location:/mpb_web/index.php');
?>