<?php

session_start();

require_once -__DIR__  .  '../config/conexao.php';

if (isset($_SESSION['user_id']) || issse($_SESSION['user_role']) || isset($_SESSION['user_name'])){

if ($_SESSION['user_role'] === 'admin') {
    
}
} 