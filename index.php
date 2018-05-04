<?php
/*
*This file is the index of the website
*
*
**/
session_start();
include('controller/includes/constants.php');
require("controller/includes/functions.php");
require("views/index.view.php");
require('controller/frontend.php');
