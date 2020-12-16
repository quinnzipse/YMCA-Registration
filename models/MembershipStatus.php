<?php

/**
 * MembershipStatus PHP object for MembershipStatus mySQL table. 
 * 
 * @abstract
 * @package 
 * @version $id$
 * @copyright 2020
 * @author Jordan Waughtal, Quinn Zipse, Ben Boehlke 
 * @license All rights reserved.
 */
abstract class MembershipStatus
{
    const MEMBER = 1;
    const NONMEMBER = 0;
    const STAFF = 3;
}
