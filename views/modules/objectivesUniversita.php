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
?>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Gestione Obiettivi Università
            </h1>
            <ol class="breadcrumb">
                <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addObjective">Aggiungi Obiettivo
                    </button>
                </div>
                <div class="box-body">
                    <table class="table-hover table table-bordered table-striped dt-responsive objectivesUniversitaTable"
                           width="100%">
                        <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Piano Annuale</th>
                            <th>Obiettivo</th>
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
                        <h4 class="modal-title">Aggiungi Obiettivo</h4>
                    </div>
                    <!--=====================================
                    BODY
                    ======================================-->
                    <div class="modal-body">
                        <div class="box-body">
                            <!--Input Title -->
                            <div style="font-size: large">Titolo</div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-inbox"
                                                                       aria-hidden="true"></i></span>
                                    <input class="form-control input-lg" type="text" id="newTitle" name="newTitle"
                                           placeholder="Aggiungi Titolo" required>
                                </div>
                            </div>
                            <!-- input Plan -->
                            <div style="font-size: large">Piano Annuale</div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <select class="form-control input-lg" id="newPlan" name="newPlan">
                                        <option id="newPlan" disabled selected>Seleziona Piano</option>
                                        <?php
                                        $item = null;
                                        $value1 = null;
                                        $plans = ControllerPlans::ctrShowPlans($item, $value1);
                                        foreach ($plans as $key => $value) {
                                            echo '<option value="' . $value["id"] . '">' . $value["title"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- input description -->
                            <div style="font-size: large">Descrizione</div>
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
                        <button type="submit" class="btn btn-primary">Salva Obiettivo</button>
                    </div>
                </form>
                <?php
                $createObjective = new ControllerObjectivesUniversita();
                $createObjective->ctrCreateObjectiveUniversita();
                ?>
            </div>
        </div>
    </div>
    <!--=====================================
    =            module edit Objective          =
    ======================================-->
    <!-- Modal -->
    <div id="modalEditObjectiveUniversita" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" method="POST" enctype="multipart/form-data">
                    <!--=====================================
                    HEADER
                    ======================================-->
                    <div class="modal-header" style="background: #3c8dbc; color: #fff">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Obiettivo</h4>
                    </div>
                    <!--=====================================
                    BODY
                    ======================================-->
                    <div class="modal-body">
                        <div class="box-body">
                            <!--Input Title -->
                            <div style="font-size: large">Titolo</div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-inbox"
                                                                       aria-hidden="true"></i></span>
                                    <input class="form-control input-lg" type="text" id="editTitleUniversita"
                                           name="editTitle"
                                           placeholder="Aggiungi Titolo" required>
                                </div>
                            </div>
                            <!-- input Plan -->
                            <div style="font-size: large">Piano Annuale</div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <select class="form-control input-lg" id="editPlansUniversita" name="editPlan">
                                        <?php
                                        $item = null;
                                        $value1 = null;
                                        $plans = ControllerPlans::ctrShowPlans($item, $value1);
                                        foreach ($plans as $key => $value) {
                                            echo '<option value="' . $value["id"] . '">' . $value["title"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- input description -->
                            <div style="font-size: large">Descrizione</div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    <input class="form-control input-lg" type="text" id="editDescriptionUniversita"
                                           name="editDescription" placeholder="Descrizione" required>
                                </div>
                            </div>
                            <div style="font-size: large">Inserisci Peso</div>
                            <!-- INPUT PESO -->
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <div class="col-xs-6" style="padding:0">
                                        <div class="input-group">
                                            <input type="number" class="form-control input-lg" id="editWeightUniversita"
                                                   name="editWeight" min="0" max="100" value="10" required>
                                            <input type="hidden" id="idObjectiveUniversita" name="idObjectiveUniversita"
                                                   required>
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
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Chiudi</button>
                        <button type="submit" class="btn btn-primary">Salva Obiettivo</button>
                    </div>
                    <?php
                    $editObjective = new ControllerObjectivesUniversita();
                    $editObjective->ctrEditObjectiveUniversita();
                    ?>
                </form>
            </div>
        </div>
    </div>
<?php
$deleteObjective = new ControllerObjectivesUniversita();
$deleteObjective->ctrDeleteObjectiveUniversita();
?>