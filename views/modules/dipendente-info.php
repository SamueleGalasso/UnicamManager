<?php
if ($_SESSION["profile"] != "Dipendente") {
    ?>
    <script>
        window.location = "401";
    </script>
    <?php
    return;
}
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Info Dipendente: <?php echo $_SESSION["name"]; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-success">
            <div class="box-body">
                <table class="table-hover table table-bordered table-striped dt-responsive dipendente-infoTable" width="100%">
                    <thead>
                    <tr>
                        <th style="width:10px">#</th>
                        <th>Titolo Target</th>
                        <th>Area Amministrativa</th>
                        <th>Azione Organizzativa</th>
                        <th>Descrizione</th>
                        <th>Premialità</th>
                        <th>% Completamento</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
</div>




