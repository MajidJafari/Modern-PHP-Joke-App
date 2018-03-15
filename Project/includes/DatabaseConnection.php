<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 2/28/2018
 * Time: 2:44 PM
 */

$pdo = new PDO('mysql:host=localhost;dbname=ijdb_sample;charset=utf8', 'ijdb_sample', 'mypassword');
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);