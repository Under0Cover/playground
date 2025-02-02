<?php
session_start();

unset($_SESSION['USER_ID']);
unset($_SESSION['LOGIN']);
unset($_SESSION['PERMISSION']);

session_destroy();

header('Location: /');
exit;