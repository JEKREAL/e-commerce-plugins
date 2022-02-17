<?php

// Set variables for our request
$shop = $_GET['shop'];

$api_key = "2df0da2b9a6bdbe564a4a2f559e9e73f";
$scopes = "read_orders,write_orders,read_products,write_products,write_script_tags";
$redirect_uri = "https://feeltrify.000webhostapp.com/token.php";

// Build install/approval URL to redirect to
$install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();