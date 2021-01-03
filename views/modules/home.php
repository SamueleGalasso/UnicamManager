<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <?php
                echo '<div class="box box-success">
           <div class="box-header">
           <h1>Welcome ' . $_SESSION["name"] . '</h1>
           </div>
           </div>';
                ?>
                <div class="row">
                    <?php
                    include "home/top-boxes.php";
                    ?>
                </div>
            </div>

        </div>
    </section>
</div>
