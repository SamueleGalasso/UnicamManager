<?php
if ($_SESSION["profile"] != "Admin") {
    if ($_SESSION["profile"] != "Responsabile Area") {
        if ($_SESSION["profile"] != "Amministratore") {
            ?>
            <script>
                window.location = "401";
            </script>
            <?php
            return;
        }
    }
}
if (is_null($_SESSION["idArea"]) && $_SESSION["profile"] != "Admin") {
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
                Gestione Target
            </h1>
            <ol class="breadcrumb">
                <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <a href="create-targets">
                        <button class="btn btn-primary">
                            Aggiungi Target
                        </button>
                    </a>
                </div>
                <div class="box-body">
                    <table class="table-hover table table-bordered table-striped dt-responsive targetsTable" width="100%">
                        <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Piano Annuale</th>
                            <th>Azione Organizzativa</th>
                            <th>Target</th>
                            <th>Peso</th>
                            <th>Budget Target</th>
                            <th>% Completamento</th>
                            <th>Azioni</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
<?php
$deleteTarget = new ControllerTarget();
$deleteTarget->ctrDeleteTarget();
?>