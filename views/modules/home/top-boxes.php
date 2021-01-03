<?php
$totalBudget = ControllerPlans::ctrTotalBudget()[0];
$totalObjectives = ControllerObjectives::ctrTotalObjectives()[0];
$totalParticipants = ControllerTarget::ctrTotalParticipants()[0];
$totalTargets = ControllerTarget::ctrTotalTargets()[0];
?>
<div class="col-lg-3 col-xs-6">
    <div class="small-box bg-aqua">
        <div class="inner">
            <h3><?php echo $totalBudget ?: 0 ?></h3>
            <p>Total Investments</p>
        </div>
        <div class="icon">
            <i class="ion ion-social-euro"></i>
        </div>
        <?php
        if ($_SESSION["profile"] == "Dipendente") {
            echo '<a href="dipendente-info" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>';
        } else {
            echo '<a href="plans" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>';
        }
        ?>
    </div>
</div>
<div class="col-lg-3 col-xs-6">
    <div class="small-box bg-green">
        <div class="inner">
            <h3><?php echo $totalObjectives ?></h3>
            <p>Azioni Organizzative</p>
        </div>
        <div class="icon">
            <i class="ion ion-clipboard"></i>
        </div>
        <?php
        if ($_SESSION["profile"] == "Dipendente") {
            echo '<a href="dipendente-info" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>';
        } else {
            echo '<a href="objectives" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>';
        }
        ?>
    </div>
</div>
<div class="col-lg-3 col-xs-6">
    <div class="small-box bg-red">
        <div class="inner">
            <h3><?php echo $totalTargets ?></h3>
            <p>Targets</p>
        </div>
        <div class="icon">
            <i class="ion ion-ios-location"></i>
        </div>
        <?php
        if ($_SESSION["profile"] == "Dipendente") {
            echo '<a href="dipendente-info" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>';
        } else {
            echo '<a href="targets" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>';
        }
        ?>
    </div>
</div>
<div class="col-lg-3 col-xs-6">
    <div class="small-box bg-yellow">
        <div class="inner">
            <h3><?php echo $totalParticipants ?></h3>
            <p>Dipendenti Coinvolti</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <?php
        if ($_SESSION["profile"] == "Dipendente") {
            echo '<a href="dipendente-info" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>';
        } else {
            echo '<a href="targets" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>';
        }
        ?>
    </div>
</div>
