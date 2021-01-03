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

<?php
$idTarget = $_GET["id"];
$target = ControllerTarget::ctrShowTargets("id", $idTarget);
$objective = ControllerObjectives::ctrShowObjectives("id", $target["idObjective"]);
$participations = ControllerTarget::ctrShowParticipants("idTarget", $idTarget);
$completion = ControllerIndicators::ctrTargetCompletion($target["id"])[0];
$budget = ControllerTarget::ctrBudgetTarget($objective, $idTarget);
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
                    <h3>Dettagli Target</h3>
                </span>
                    <div class="box-header with-border"></div>
                    <form role="form" method="post" class="saleForm">
                        <input type="hidden" name="id" value="<?php echo $target['id'] ?>">
                        <div class="box-body">
                            <div class="box">
                                <!--=====================================
                                =            title INPUT           =
                                ======================================-->
                                <div style="font-size: large">Nome Target</div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"
                                                                           aria-hidden="true"></i></span>
                                        <input value="<?php echo $target["name"]; ?>" type="text"
                                               class="form-control input-lg" name="newName" id="newName"
                                               placeholder="  Nome" required>
                                    </div>
                                </div>
                                <!--=====================================
                                objective INPUT
                                ======================================-->
                                <div style="font-size: large">Azione Organizzativa</div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        <select class="form-control input-lg" name="newObjective">
                                            <option value="<?php echo $objective["id"]; ?>"
                                                    selected><?php echo $objective["title"]; ?></option>
                                            <?php
                                            if (is_null($_SESSION["idArea"])) {
                                                $obj = ControllerObjectives::ctrShowObjectives(null, null);
                                            } else {
                                                $obj = ControllerObjectives::ctrShowObjectivesByArea($_SESSION["idArea"]);
                                            }
                                            foreach ($obj as $key => $value) {
                                                if ($value["id"] == $objective["id"])
                                                    continue;
                                                echo '<option value="' . $value["id"] . '">' . $value["title"] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!--=====================================
                               users INPUT
                               ======================================-->
                                <div style="font-size: large">Dipendenti</div>
                                <div class="form-group" style="width: 100%">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                        <select multiple="multiple" class="form-control" name="newUsersList[]" required>
                                            <?php
                                            $item = null;
                                            $value = null;
                                            $users = ControllerUsers::ctrShowUsers($item, $value);
                                            $selected = "";
                                            $idPartecipanti = array_map(function ($a) {
                                                return $a["idDipendente"];
                                            }, $participations);
                                            foreach ($users as $key => $value) {
                                                if ($value["idArea"] != null) {
                                                    if (in_array($value["id"], $idPartecipanti)) $selected = "selected"; else $selected = "";
                                                    echo "<option $selected value=\"$value[id]\">$value[name]</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div style="font-size: large">Descrizione</div>
                                <!-- input description -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-book"
                                                                           aria-hidden="true"></i></span>
                                        <input class="form-control input-lg" type="text" id="newDescription"
                                               value="<?php echo $target['description']; ?>"
                                               name="newDescription" placeholder=" Descrizione" required>
                                    </div>
                                    <div class="box-body">
                                        <h3>Tabella partecipanti al target</h3>
                                        <table class="table table-bordered table-striped dt-responsive">
                                            <thead>
                                            <tr>
                                                <th style="width:10px">#</th>
                                                <th>Nome e Cognome</th>
                                                <th>Area Amministrativa</th>
                                                <th>% Contributo</th>
                                                <th>Premialità €</th>
                                                <th>Azioni</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($participations as $key => $value) {
                                                $users = ControllerUsers::ctrShowUsers("id", $value["idDipendente"]);
                                                $area = ControllerAreas::ctrShowAreas("id", $users["idArea"]);
                                                $premialita = ControllerIndicators::ctrTargetPremialita($target["id"], $value["idDipendente"], $objective);
                                                ?>
                                                <tr>
                                                    <td><?php echo $key + 1 ?></td>
                                                    <td><?php echo $users["name"] ?></td>
                                                    <td class="text-uppercase"><?php echo $area["name"] ?></td>
                                                    <td>
                                                        <div class="form-group row">
                                                            <div>
                                                                <div class="col-xs-6" style="padding:0">
                                                                    <div class="input-group">
                                                                        <input type="number"
                                                                               class="form-control input-lg" min="0"
                                                                               value="<?php echo $value['contributo'] ?>"
                                                                               required readonly>
                                                                        <span class="input-group-addon"><i
                                                                                    class="fa fa-percent"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-xs-6">
                                                            <div style="padding:0">
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control input-lg"
                                                                           min="0"
                                                                           value="<?php if ($premialita != null) {
                                                                               echo $premialita;
                                                                           } else {
                                                                               echo '0';
                                                                           }
                                                                           ?>"
                                                                           required readonly>
                                                                    <span class="input-group-addon"><i
                                                                                class="fa fa-eur"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button onclick="showParticipationEditModal(<?php echo $value["id"]; ?>)"
                                                                class="btn btn-warning btnEditParticipation"
                                                                type="button"><i class='fa fa-pencil'></i> Modifica
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div style="font-size: large">Budget</div>
                                <!-- INPUT budget -->
                                <div class="form-group row">
                                    <div class="col-xs-6">
                                        <div class="col-xs-6" style="padding:0">
                                            <div class="input-group">
                                                <input type="number" class="form-control input-lg" id="newBudget"
                                                       name="newBudget" min="0" value="<?php echo $budget; ?>"
                                                       required readonly>
                                                <span class="input-group-addon"><i class="fa fa-eur"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="font-size: large">Peso Target</div>
                                <!-- INPUT PESO -->
                                <div class="form-group row">
                                    <div class="col-xs-6">
                                        <div class="col-xs-6" style="padding:0">
                                            <div class="input-group">
                                                <input type="number" class="form-control input-lg" id="newWeight"
                                                       name="newWeight" min="0" value="<?php echo $target['weight']; ?>"
                                                       required>
                                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="font-size: large">Percentuale di Completamento</div>
                                <!-- INPUT completamento -->
                                <div class="form-group row">
                                    <div class="col-xs-6">
                                        <div class="col-xs-6" style="padding:0">
                                            <div class="input-group">
                                                <input type="number" class="form-control input-lg" id="newCompletion"
                                                       name="newCompletion" min="0"
                                                       value="<?php if ($completion != null) {
                                                           echo $completion;
                                                       } else {
                                                           echo '0';
                                                       }
                                                       ?>" required readonly>
                                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row newUsers"></div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Salva Target</button>
                        </div>
                    </form>
                    <?php
                    $updateTarget = new ControllerTarget();
                    $updateTarget::ctrUpdateTarget();
                    ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!--MODAL BOX EDIT CONTRIBUTO -->
<div class="modal fade" role="dialog" id="modalEditContributo">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header" style="background: #3c8dbc; color: #fff">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modifica contributo</h4>
                    <input type="hidden" name="idParticipationEdit" id="editId" required>
                    <input type="hidden" name="idTargetParticipationEdit" id="editIdTarget" required>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div style="font-size: large">% Contributo</div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                <input type="number" name="editContributo" id="editContributo"
                                       class="form-control input-lg" max="100" min="0" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Chiudi</button>
                    <button type="submit" class="btn btn-primary">Salva modifiche</button>
                </div>
                <?php

                $editContributo = new ControllerTarget();
                $editContributo::ctrUpdateContributo()
                ?>
            </form>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('select[name="newUsersList[]"]').select2({
            placeholder: "    Seleziona utenti"
        });
    })
</script>

