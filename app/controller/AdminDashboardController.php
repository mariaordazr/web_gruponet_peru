<?php
// app/controller/AdminDashboardController.php

class AdminDashboardController {
    public function __construct($connection) {
        // No necesita modelos para esta página estática, pero recibe la conexión
    }

    public function index() {
        // Simplemente carga la vista del dashboard
        include ROOT_PATH . 'app/views/admin/dashboard.php';
    }
}
?>