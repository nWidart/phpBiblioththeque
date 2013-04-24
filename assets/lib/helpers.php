<?php

/**
 * Controle si un emprunt est en retard
 *
 * @param  string  $today
 * @param  string  $due
 * @return boolean
 */
function isOverdue( $due )
{
    // On récup la date
    $date = new DateTime();
    return ( $due < $date->format('Y-m-d') ) ? true : false;
}
