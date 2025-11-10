<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

logout();

function logout()
{
    session_unset();
    session_destroy();
}
header('Location: login');
