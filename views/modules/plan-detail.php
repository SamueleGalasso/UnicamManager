<?php
if ($_SESSION["profile"] != "Admin") {
    if ($_SESSION["profile"] != "Amministratore") {
        ?>
        <script>
            window.location = "401";
        </script>
        <?php
        return;
    }
}
$idPlan = $_GET["id"];
$plan = ControllerPlans::ctrShowPlans("id", $idPlan);
$participations = ControllerPlans::ctrShowParticipants($idPlan);
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
                    <h3>Dettagli Piano Annuale</h3>
                </span>
                    <div class="box-header with-border"></div>
                    <form role="form" method="post">
                        <input type="hidden" name="idPlan" value="<?php echo $plan['id'] ?>">
                        <div class="box-body">
                            <div class="box">
                                <!--=====================================
                                =            title INPUT           =
                                ======================================-->
                                <div style="font-size: large">Nome Piano</div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"
                                                                           aria-hidden="true"></i></span>
                                        <input value="<?php echo $plan["title"]; ?>" type="text"
                                               class="form-control input-lg" name="editTitle" id="editTitle"
                                               placeholder="  Titolo" required>
                                    </div>
                                </div>
                                <!--=====================================
                               areas INPUT
                               ======================================-->
                                <div style="font-size: large">Aree Amministrative</div>
                                <div class="form-group" style="width: 100%">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                        <select multiple="multiple" class="form-control" name="newAreasList[]">
                                            <?php
                                            $item = null;
                                            $value = null;
                                            $areas = ControllerAreas::ctrShowAreas($item, $value);
                                            $selected = "";
                                            $idPartecipanti = array_map(function ($a) {
                                                return $a["idArea"];
                                            }, $participations);
                                            foreach ($areas as $key => $value) {
                                                if (in_array($value["id"], $idPartecipanti)) $selected = "selected"; else $selected = "";
                                                echo "<option $selected value=\"$value[id]\">$value[name]</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div style="font-size: large">Anno</div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input readonly placeholder="Budget" class="form-control input-lg"
                                               type="number" value="<?php echo $plan['date']; ?>">
                                    </div>
                                </div>
                                <div style="font-size: large">Descrizione</div>
                                <!-- input description -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-book"
                                                                           aria-hidden="true"></i></span>
                                        <input class="form-control input-lg" type="text" name="editDescription"
                                               value="<?php echo $plan['description']; ?>"
                                               placeholder=" Descrizione" required>
                                    </div>
                                </div>
                                <div style="font-size: large">Budget</div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eur"></i>
                                        </span>
                                        <input min="0" required placeholder="Budget" class="form-control input-lg"
                                               type="number"
                                               name="editBudget" value="<?php echo $plan['budget']; ?>">
                                    </div>
                                </div>
                                <div class="box-body">
                                    <h3>Tabella Aree Coinvolte</h3>
                                    <table class="table table-bordered table-striped dt-responsive">
                                        <thead>
                                        <tr>
                                            <th style="width:10px">#</th>
                                            <th>Area Amministrativa</th>
                                            <th>Budget €</th>
                                            <th>Azioni</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($participations as $key => $value) {
                                            $area = ControllerAreas::ctrShowAreas("id", $value["idArea"]);
                                            ?>
                                            <tr>
                                                <td><?php echo $key + 1 ?></td>
                                                <td class="text-uppercase"><?php echo $area["name"] ?></td>
                                                <td>
                                                    <div class="form-group row">
                                                        <div>
                                                            <div class="col-xs-6" style="padding:0">
                                                                <div class="input-group">
                                                                    <input type="number"
                                                                           class="form-control input-lg" min="0"
                                                                           value="<?php echo $value['budget'] ?>"
                                                                           required readonly>
                                                                    <span class="input-group-addon"><i
                                                                                class="fa fa-percent"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button onclick="showParticipationAreasEditModal(<?php echo $value["id"]; ?>)"
                                                            class="btn btn-warning"
                                                            type="button"><i class='fa fa-pencil'></i> Modifica
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Salva Piano</button>
                        </div>
                    </form>
                    <?php
                    $updatePlan = new ControllerPlans();
                    $updatePlan->ctrEditPlan();
                    ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!--MODAL BOX EDIT CONTRIBUTO -->
<div class="modal fade" role="dialog" id="modalEditBudget">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header" style="background: #3c8dbc; color: #fff">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modifica Budget</h4>
                    <input type="hidden" name="idParticipationEdit" id="editId" required>
                    <input type="hidden" name="idPlanParticipationEdit" id="editIdPlan" required>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div style="font-size: large">Budget €</div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-eur"></i></span>
                                <input type="number" name="editBudget" id="editBudget"
                                       class="form-control input-lg" min="0" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Chiudi</button>
                    <button type="submit" class="btn btn-primary">Salva modifiche</button>
                </div>
                <?php
                $editBudget = new ControllerPlans();
                $editBudget::ctrUpdateBudget();
                ?>
            </form>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('select[name="newAreasList[]"]').select2({
            placeholder: "    Seleziona Aree"
        });
    })
</script>