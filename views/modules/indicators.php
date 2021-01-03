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
            Gestione Indicatori
        </h1>
        <ol class="breadcrumb">
            <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addIndicator">Aggiungi Indicatore
                </button>
            </div>
            <div class="box-body">
                <table class="table-hover table table-bordered table-striped dt-responsive indicatorsTable" width="100%">
                    <thead>
                    <tr>
                        <th style="width:10px">#</th>
                        <th>Piano Annuale</th>
                        <th>Azione Organizzativa</th>
                        <th>Target</th>
                        <th>Indicatore</th>
                        <th>Peso</th>
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
=            module add indicator          =
======================================-->
<!-- Modal -->
<div id="addIndicator" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="POST" enctype="multipart/form-data">
                <!--=====================================
                HEADER
                ======================================-->
                <div class="modal-header" style="background: #3c8dbc; color: #fff">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Aggiungi Indicatore</h4>
                </div>
                <!--=====================================
                BODY
                ======================================-->
                <div class="modal-body">
                    <div class="box-body">
                        <!--Input name -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-inbox" aria-hidden="true"></i></span>
                                <input class="form-control input-lg" type="text" id="newName" name="newName"
                                       placeholder="Aggiungi Nome" required>
                            </div>
                        </div>
                        <!-- input Target -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <select class="form-control input-lg" id="newTarget" name="newTarget">
                                    <option disabled selected>Seleziona Target</option>
                                    <?php
                                    $item = null;
                                    $value1 = null;
                                    if (is_null($_SESSION["idArea"])) $targets = ControllerTarget::ctrShowTargets($item, $value1);
                                    else $targets = ControllerTarget::ctrShowTargetsByArea($_SESSION["idArea"]);
                                    foreach ($targets as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["name"] . '</option>';
                                    }
                                    ?>
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
                    <button type="submit" class="btn btn-primary">Salva Indicatore</button>
                </div>
            </form>
            <?php
            $createIndicator = new ControllerIndicators();
            $createIndicator->ctrCreateIndicator();
            ?>
        </div>
    </div>
</div>


<!--=====================================
=            module edit indicator         =
======================================-->

<!-- Modal -->
<div id="modalEditIndicator" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="POST" enctype="multipart/form-data">
                <!--=====================================
                HEADER
                ======================================-->
                <div class="modal-header" style="background: #3c8dbc; color: #fff">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Indicatore</h4>
                </div>
                <!--====================================
                BODY
                ======================================-->
                <div class="modal-body">
                    <div class="box-body">
                        <!--Input name -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-inbox" aria-hidden="true"></i></span>
                                <input class="form-control input-lg" type="text" id="editName" name="editName"
                                       placeholder="Aggiungi Nome" required>
                            </div>
                        </div>
                        <!-- input Target -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <select class="form-control input-lg" id="editTargets" name="editTargets">
                                    <option disabled selected>Seleziona Target</option>
                                    <?php
                                    $item = null;
                                    $value1 = null;
                                    if (is_null($_SESSION["idArea"])) $targets = ControllerTarget::ctrShowTargets($item, $value1);
                                    else $targets = ControllerTarget::ctrShowTargetsByArea($_SESSION["idArea"]);
                                    foreach ($targets as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["name"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- input description -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-book" aria-hidden="true"></i></span>
                                <input class="form-control input-lg" type="text" id="editDescription"
                                       name="editDescription" placeholder="Descrizione" required>
                            </div>
                        </div>
                        <div style="font-size: large">Inserisci Peso</div>
                        <!-- INPUT PESO -->
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <div class="col-xs-6" style="padding:0">
                                    <div class="input-group">
                                        <input type="number" class="form-control input-lg" id="editWeight"
                                               name="editWeight" min="0" max="100" required>
                                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="font-size: large">Completamento</div>
                        <!-- INPUT completamento -->
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <div class="col-xs-6" style="padding:0">
                                    <div class="input-group">
                                        <input type="number" class="form-control input-lg" id="editCompletion"
                                               name="editCompletion" min="0" max="100" required>
                                        <input type="hidden" id="idIndicator" name="idIndicator" required>
                                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--====================================
                FOOTER
                ======================================-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Chiudi</button>
                    <button type="submit" class="btn btn-primary">Salva Indicatore</button>
                </div>
        </div>
    </div>
    <?php
    $editIndicator = new ControllerIndicators();
    $editIndicator->ctrEditIndicator();
    ?>
    </form>
</div>
</div>
</div>
<?php
$deleteIndicator = new ControllerIndicators();
$deleteIndicator->ctrDeleteIndicator();
?>
