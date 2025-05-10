<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="generator" content="Mobirise v5.2.0, mobirise.com">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
        <link rel="shortcut icon" href="assets/images/thrive_logo_small.png" type="image/x-icon">
        <meta name="description" content="">
        
        <title><?php echo isset($page_title) ? $page_title : 'Thrive - Health & Wellness'; ?></title>
        
        <!-- Core styles -->
        <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
        <link rel="stylesheet" href="assets/tether/tether.min.css">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
        <link rel="stylesheet" href="assets/dropdown/css/style.css">
        <link rel="stylesheet" href="assets/socicon/css/styles.css">
        <link rel="stylesheet" href="assets/theme/css/style.css">
        <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
        <link rel="stylesheet" href="styles/common.css">
        
        <?php if (isset($page_specific_css)): ?>
        <!-- Page specific styles -->
        <link rel="stylesheet" href="<?php echo $page_specific_css; ?>">
        <?php endif; ?>

        <style>
            /* Global font styles */
            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                font-size: 16px;
                line-height: 1.5;
                color: #333;
            }

            h1, h2, h3, h4, h5, h6 {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                font-weight: 600;
                line-height: 1.2;
            }

            /* Navbar specific styles */
            .navbar {
                background-color: white !important;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                padding: 0.5rem 1rem;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            }

            .navbar-brand img {
                height: 5rem;
            }

            .nav-link {
                color: #333 !important;
                font-weight: 500;
                font-size: 1.1rem;
                padding: 0.5rem 1rem !important;
                transition: color 0.3s ease;
            }

            .nav-link:hover {
                color: #ea0faa !important;
            }

            .nav-link.active {
                color: #ea0faa !important;
                font-weight: 600;
            }

            .navbar-buttons .btn-primary {
                background-color: #ea0faa !important;
                border-color: #ea0faa !important;
                color: white !important;
                font-weight: 500;
                font-size: 1rem;
                padding: 0.5rem 1.5rem;
                border-radius: 4px;
                transition: all 0.3s ease;
            }

            .navbar-buttons .btn-primary:hover {
                background-color: #c80d8d !important;
                border-color: #c80d8d !important;
                transform: translateY(-1px);
            }

            .dropdown-menu {
                border: none;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                font-size: 1rem;
            }

            .dropdown-item {
                color: #333;
                padding: 0.5rem 1rem;
                transition: all 0.3s ease;
            }

            .dropdown-item:hover {
                background-color: #f8f9fa;
                color: #ea0faa;
            }

            .hamburger {
                padding: 0.5rem;
            }

            .hamburger span {
                background-color: #333;
                height: 2px;
                margin: 4px 0;
                transition: all 0.3s ease;
            }

            /* Section title styles */
            .section-title {
                font-size: 2.5rem;
                font-weight: 700;
                color: #333;
                margin-bottom: 2rem;
                text-align: center;
            }

            /* Card styles */
            .card-title {
                font-size: 1.5rem;
                font-weight: 600;
                color: #333;
            }

            .card-text {
                font-size: 1rem;
                color: #666;
            }

            /* Button styles */
            .btn {
                font-weight: 500;
                font-size: 1rem;
                padding: 0.5rem 1.5rem;
                border-radius: 4px;
                transition: all 0.3s ease;
            }

            .btn-primary {
                background-color: #ea0faa !important;
                border-color: #ea0faa !important;
                color: white !important;
            }

            .btn-primary:hover {
                background-color: #c80d8d !important;
                border-color: #c80d8d !important;
                transform: translateY(-1px);
            }
        </style>
    </head>
    <body> 