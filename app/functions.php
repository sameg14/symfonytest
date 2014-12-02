<?php

/**
 * Pretty print an object to browser
 *
 * @param mixed  $pre  Object to print
 * @param string $name Name to print on object
 *
 * @return void
 */
function pre($pre, $name = null)
{
    echo $name ? '<h3>' . $name . '</h3>' : null;
    echo '<pre>';
    print_r($pre);
    echo '</pre>';
}