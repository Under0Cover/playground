<?php
session_start();

unset($_SESSION['USER_ID']);
unset($_SESSION['LOGIN']);
unset($_SESSION['PERMISSION']);

session_destroy();

echo json_encode(['success' => true]);
exit;
