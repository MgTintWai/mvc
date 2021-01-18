<?php

function setMessage($name, $description)
{
    if (session_id() == '') {
        session_start();
    }
    $_SESSION[$name] = $description;
}

function unsetMessage($name)
{
    unset($_SESSION[$name]);
}

function set($name,$value)
{
    session_start();
    $_SESSION[$name] = $value;
}