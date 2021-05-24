<?php
    session_start();
    session_destroy();
    header("Location: index.php?sort=all&type=all&choice=51");



