<?php
session_start();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Unicam Manager</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="views/img/template/logoUnicam.png">

    <!--=================================
    =            Plugins CSS            =
    ==================================-->
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="views/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link href="views/bower_components/select2/dist/css/select2.min.css" rel="stylesheet"/>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="views/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="views/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="views/dist/css/AdminLTE.css">
    <!-- AdminLTE Skins -->
    <link rel="stylesheet" href="views/dist/css/skins/_all-skins.min.css">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- DataTables -->
    <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="views/plugins/iCheck/all.css">
    <!--====  End of Plugins CSS  ====-->
    <!--========================================
    =            plugins javascript            =
    =========================================-->
    <!-- jQuery 3 -->
    <script src="views/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="views/bower_components/select2/dist/js/select2.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="views/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="views/dist/js/adminlte.min.js"></script>
    <!-- DataTables -->
    <script src="views/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="views/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="views/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
    <script src="views/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
    <!-- sweet alert -->
    <script src="views/plugins/sweetalert2/sweetalert2.all.js"></script>
    <!-- By default sweetalert2 doesn't support IE. To enable IE 11 support, include Promise polyfill -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="views/plugins/iCheck/icheck.min.js"></script>
    <!-- InputMask -->
    <script src="views/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="views/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="views/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- jQuery Number -->
    <script src="views/plugins/jqueryNumber/jquerynumber.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">
<!-- Site wrapper -->
<?php
if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == "ok") {
    echo '<div class="wrapper">';
    /*=============================================
    =            header          =
    =============================================*/
    include "modules/header.php";
    /*=============================================
    =            sidebar          =
    =============================================*/
    include "modules/sidebar.php";
    /*=============================================
    =            Content          =
    =============================================*/
    if (isset($_GET["route"])) {
        if ($_GET["route"] == 'home' ||
            $_GET["route"] == 'users' ||
            $_GET["route"] == 'create-targets' ||
            $_GET["route"] == 'logout' ||
            $_GET["route"] == 'indicators' ||
            $_GET["route"] == 'indicatorsUniversita' ||
            $_GET["route"] == 'objectivesUniversita' ||
            $_GET["route"] == 'targetsUniversita' ||
            $_GET["route"] == 'dipendente-info' ||
            $_GET["route"] == '401' ||
            $_GET["route"] == 'tree' ||
            $_GET["route"] == 'areas') {
            include "modules/" . $_GET["route"] . ".php";
        } elseif ($_GET["route"] == "targets") {
            if (empty($_GET["id"]))
                include "modules/" . $_GET["route"] . ".php";
            else
                include "modules/target-detail.php";
        }elseif ($_GET["route"] == "plans"){
            if (empty($_GET["id"]))
                include "modules/" . $_GET["route"] . ".php";
            else
                include "modules/plan-detail.php";
        }elseif ($_GET["route"] == "objectives"){
            if (empty($_GET["id"]))
                include "modules/" . $_GET["route"] . ".php";
            else
                include "modules/objective-detail.php";
        } else {
            include "modules/404.php";
        }
    } else {
        include "modules/home.php";
    }
    /*=============================================
    =            Footer          =
    ============================================*/
    include "modules/footer.php";
    echo '</div>';
} else {
    /*=============================================
   =            login          =
   =============================================*/
    include "modules/login.php";
}
?>
<!-- ./wrapper -->
<script src="views/js/template.js"></script>
<script src="views/js/indicators.js"></script>
<script src="views/js/indicatorsUniversita.js"></script>
<script src="views/js/users.js"></script>
<script src="views/js/plans.js"></script>
<script src="views/js/objectives.js"></script>
<script src="views/js/objectivesUniversita.js"></script>
<script src="views/js/participation.js"></script>
<script src="views/js/participationAreas.js"></script>
<script src="views/js/targets.js"></script>
<script src="views/js/targetsUniversita.js"></script>
<script src="views/js/dipendente-info.js"></script>
<script src="views/js/areas.js"></script>
</body>
</html>
