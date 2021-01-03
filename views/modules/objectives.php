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
            Gestione Azioni Organizzative
        </h1>
        <ol class="breadcrumb">
            <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addObjective">Aggiungi Azione
                    Organizzativa
                </button>
            </div>
            <div class="box-body">
                <table id="objTable" class="table-hover table table-bordered table-striped dt-responsive objectivesTable" width="100%">
                    <thead>
                    <tr>
                        <th style="width:10px">#</th>
                        <th>Piano Annuale</th>
                        <th>Azione Organizzativa</th>
                        <th>Area Amministrativa</th>
                        <th>Descrizione</th>
                        <th>Peso</th>
                        <th>Budget</th>
                        <th>% Completamento</th>
                        <th>Azioni</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
</div>
<!--=====================================
=            module add Objective           =
======================================-->
<!-- Modal -->
<div id="addObjective" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="POST" enctype="multipart/form-data">
                <!--=====================================
                HEADER
                ======================================-->
                <div class="modal-header" style="background: #3c8dbc; color: #fff">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Aggiungi Azione Organizzativa</h4>
                </div>
                <!--=====================================
                BODY
                ======================================-->
                <div class="modal-body">
                    <div class="box-body">
                        <!--Input Title -->
                        <div class="form-group">
                            <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-inbox"
                                                                       aria-hidden="true"></i></span>
                                <input class="form-control input-lg" type="text" id="newTitle" name="newTitle"
                                       placeholder="Aggiungi Titolo" required>
                                <input type="hidden" value="<?php $_SESSION["idArea"] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-bookmark" aria-hidden="true"></i></span>
                                <select name="objectiveIdPlan" id="objectivesPlanSelect" class="form-control input-lg">
                                    <option disabled selected>Seleziona Piano</option>
                                    <?php
                                    $plans = ControllerPlans::ctrShowPlans(null, null);
                                    foreach ($plans as $plan) {
                                        ?>
                                        <option value="<?php echo $plan['id'] ?>">
                                            <?php echo $plan["title"] ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- input Area -->
                        <div class="form-group">
                            <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"
                                                                       aria-hidden="true"></i></span>
                                <select class="form-control input-lg" id="newArea" name="newArea">
                                    <option disabled selected>Seleziona Area</option>
                                </select>
                            </div>
                        </div>
                        <!-- input Obiettivo -->
                        <div class="form-group">
                            <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrows"
                                                                       aria-hidden="true"></i></span>
                                <select multiple="multiple" class="form-control input-lg"
                                        style="width: 100%;"
                                        name="newObjectiveUniversita[]">
                                </select>
                            </div>
                        </div>
                        <!-- input description -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-book" aria-hidden="true"></i></span>
                                <input class="form-control input-lg" type="text" id="newDescription"
                                       name="newDescription" placeholder="Descrizione" required>
                            </div>
                        </div>
                        <div style="font-size: large">Inserisci Peso</div>
                        <!-- INPUT PESO -->
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <div class="col-xs-6" style="padding:0">
                                    <div class="input-group">
                                        <input type="number" class="form-control input-lg" id="newWeight"
                                               name="newWeight" min="0" max="100" value="10" required>
                                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--=====================================
                FOOTER
                ======================================-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Salva Azione</button>
                </div>
            </form>
            <?php
            $createObjective = new ControllerObjectives();
            $createObjective->ctrCreateObjective();
            ?>
        </div>
    </div>
</div>
<?php
$deleteObjective = new ControllerObjectives();
$deleteObjective->ctrDeleteObjective();
?>
<script>
    $(function () {
        const $select = $('select[name="newObjectiveUniversita[]"]');
        $select.select2({
            placeholder: "   Seleziona Obiettivi"
        });
        $('input[class="select2-search__field"]').css("width", "100%");
        $("#objectivesPlanSelect").change(function (e) {
            const idPlan = e.target.value
            $.post('ajax/objectivesUniversitaByPlan.php', {idPlan}, function (data, status) {
                if (status === 'success') {
                    $('select[name="newObjectiveUniversita[]"]').html(data);
                    $select.select2({
                        placeholder: "   Seleziona Obiettivi"
                    });
                }
            })
            $.post('ajax/areasByPlan.php', {idPlan}, function (data, status) {
                if (status === 'success') {
                    $('#newArea').html(" <option disabled selected>Seleziona Area</option>" + data);
                }
            })
        });
    });
</script>
