<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Angular-Laravel Authentication</title>
        <link rel="stylesheet" href="angular-app/node_modules/bootstrap/dist/css/bootstrap.css">
    </head>
    <body ng-app="authApp">

        <div class="container">
        	<div ui-view></div>
        </div>        
     
    </body>

    <!-- Application Dependencies -->
    <script src="angular-app/node_modules/angular/angular.js"></script>
    <script src="angular-app/node_modules/angular-ui-router/release/angular-ui-router.js"></script>
    <script src="angular-app/node_modules/satellizer/satellizer.js"></script>

    <!-- Application Scripts -->
    <script src="angular-app/scripts/app.js"></script>
    <script src="angular-app/scripts/authController.js"></script>
    <script src="angular-app/scripts/userController.js"></script>
</html>