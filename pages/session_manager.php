<?php
session_start();

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['username']);
}

// Function to login user
function loginUser($username) {
    $_SESSION['username'] = $username;
}

// Function to logout user
function logoutUser() {
    unset($_SESSION['username']);
}

// Function to get current logged in username
function getUsername() {
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}
?>
