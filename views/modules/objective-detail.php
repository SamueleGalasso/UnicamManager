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
$idObjective = $_GET["id"];
$objective = ControllerObjectives::ctrShowObjectives("id", $idObjective);
$participations = ControllerPlans::ctrShowParticipantByArea($objective["idPlan"], $objective["idArea"]);
$participationsObj = ControllerObjectives::ctrShowParticipations($objective["id"])[0];
$budget = ControllerObjectives::ctrBudgetObjective($objective["idPlan"], $objective["idArea"], $objective["id"]);
$completion = ControllerTarget::ctrUpdateObjectiveCompletion($objective["id"])[0] ?: 0;
?>
<div class="content-wrapper">
    <section class="content">
        <div>
            <!--=============================================
            THE FORM
            =============================================-->
            <div>
                <div class="box box-warning">
                <span>
                    <h3>Dettagli Azione Organizzativa</h3>
                </span>
                    <div class="box-header with-border"></div>
                    <form role="form" method="post">
                        <input type="hidden" name="idObjective" value="<?php echo $objective['id'] ?>">
                        <div class="box-body">
                            <div class="box">
                                <!--=====================================
                                =            title INPUT           =
                                ======================================-->
                                <div style="font-size: large">Nome Azione Organizzativa</div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"
                                                                           aria-hidden="true"></i></span>
                                        <input value="<?php echo $objective["title"]; ?>" type="text"
                                               class="form-control input-lg" name="editTitle" id="editTitle"
                                               placeholder="  Titolo" required>
                                    </div>
                                </div>
                                <!--=====================================
                               plan INPUT
                               ======================================-->
                                <div style="font-size: large">Piano Annuale</div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-bookmark"></i>
                                        </span>
                                        <select class="form-control input-lg" id="editPlan" name="editPlan">
                                            <option disabled>Seleziona Piano</option>
                                            <?php
                                            $plans = ControllerPlans::ctrShowPlans(null, null);
                                            $selected = "";
                                            foreach ($plans as $plan) {
                                                $selected = $plan["id"] === $objective["idPlan"] ? "selected" : "";
                                                echo "<option $selected value='$plan[id]'>$plan[title]</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!--=====================================
                               areas INPUT
                               ======================================-->
                                <div style="font-size: large">Aree Amministrative</div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-users"></i>
                                        </span>
                                        <select id="editArea" class="form-control input-lg" name="editArea">
                                            <option disabled>Seleziona Area</option>
                                            <?php
                                            require __DIR__ . "/../../ajax/areasByPlan.php";
                                            AreaAjax::areasByPlan($objective["idPlan"], $objective["idArea"]);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div style="font-size: large">Obiettivi</div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                        <select required multiple="multiple" class="form-control"
                                                name="editObjectiveUniversita[]">
                                            <?php
                                            $objUni = ControllerObjectivesUniversita::ctrShowObjUniByObjective($objective["id"]);
                                            $objUniIds = array_map(function ($row) {
                                                return $row["id"];
                                            }, $objUni);
                                            require __DIR__ . "/../../ajax/objectivesUniversitaByPlan.php";
                                            ObjUniAjax::getObjUniByPlan($objective["idPlan"], $objUniIds);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- input description -->
                                <div style="font-size: large">Descrizione</div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-book"
                                                                           aria-hidden="true"></i></span>
                                        <input class="form-control input-lg" type="text" name="editDescription"
                                               value="<?php echo $objective['description']; ?>"
                                               placeholder=" Descrizione" required>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <h3>Tabella Obiettivi</h3>
                                    <table class="table table-bordered table-striped dt-responsive">
                                        <thead>
                                        <tr>
                                            <th style="width:10px">#</th>
                                            <th>Obiettivo</th>
                                            <th>Description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($objUni as $i => $value) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i + 1; ?></td>
                                                <td><?php echo $value["title"]; ?></td>
                                                <td><?php echo $value["description"]; ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="font-size: large">Budget</div>
                                <div class="form-group row">
                                    <div class="col-xs-6">
                                        <div class="col-xs-6" style="padding:0">
                                            <div class="input-group">
                                                <input readonly min="0" required placeholder="Budget"
                                                       class="form-control input-lg" type="number" name="editBudget"
                                                       value="<?php echo $budget; ?>">
                                                <span class="input-group-addon"><i class="fa fa-eur"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="font-size: large">Peso</div>
                                <div class="form-group row">
                                    <div class="col-xs-6">
                                        <div class="col-xs-6" style="padding:0">
                                            <div class="input-group">
                                                <input min="0" max="100" required placeholder="Peso"
                                                       class="form-control input-lg"
                                                       type="number"
                                                       name="editWeight" value="<?php echo $objective['weight']; ?>">
                                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="font-size: large">Completamento</div>
                                <div class="form-group row">
                                    <div class="col-xs-6">
                                        <div class="col-xs-6" style="padding:0">
                                            <div class="input-group">
                                                <input readonly min="0" max="100" required placeholder="Completamento"
                                                       class="form-control input-lg"
                                                       type="number"
                                                       value="<?php echo $completion; ?>">
                                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary pull-right">Salva Azione
                                        Organizzativa
                                    </button>
                                </div>
                    </form>
                    <?php
                    ControllerObjectives::ctrEditObjective();
                    ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(function () {
        const $select = $('select[name="editObjectiveUniversita[]"]');
        $select.select2({
            placeholder: "    Seleziona Obiettivi"
        });
        $('input[class="select2-search__field"]').css("width", "100%");
        $("#editPlan").change(function (e) {
            const idPlan = e.target.value
            $.post('ajax/objectivesUniversitaByPlan.php', {idPlan}, function (data, status) {
                if (status === 'success') {
                    $select.html(data);
                    $select.select2({
                        placeholder: "   Seleziona Obiettivi"
                    });
                }
            })
            $.post('ajax/areasByPlan.php', {idPlan}, function (data, status) {
                if (status === 'success') {
                    $('#editArea').html("<option disabled>Seleziona Area</option>" + data);
                }
            })
        });
    })
</script>