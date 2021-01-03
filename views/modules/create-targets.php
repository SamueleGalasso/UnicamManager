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
            Crea Target
        </h1>
        <ol class="breadcrumb">
            <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Aggiungi Target</li>
        </ol>
    </section>
    <section class="content">
        <!--=============================================
        THE FORM
        =============================================-->
        <div>
            <form role="form" method="post" class="saleForm">
                <div class="box box-success">
                    <div class="box-header with-border"></div>

                    <div class="box-body"
                    <div class="box">
                        <!--=====================================
                        =            NAME INPUT           =
                        ======================================-->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                <input type="text" class="form-control input-lg" name="newName" id="newName"
                                       placeholder="  Nome" required>
                            </div>
                        </div>
                        <!--=====================================
                        azione INPUT
                        ======================================-->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <select class="form-control input-lg" name="newObjective">
                                    <option disabled selected>Seleziona Azione Organizzativa</option>
                                    <?php
                                    $item = null;
                                    $value = null;
                                    $obj = ControllerObjectives::ctrShowObjectives($item, $value);
                                    if (is_null($_SESSION["idArea"])) {
                                        foreach ($obj as $key => $value) {
                                            echo '<option value="' . $value["id"] . '">' . $value["title"] . '</option>';
                                        }
                                    } else {
                                        $a = [];
                                        foreach ($obj as $key => $value) {
                                            if ($_SESSION["idArea"] == $value["idArea"]) {
                                                $a[] = $value;
                                            }
                                        }
                                        foreach ($a as $v) {
                                            echo '<option value="' . $v["id"] . '">' . $v["title"] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!--=====================================
                       users INPUT
                       ======================================-->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <select multiple="multiple" class="form-control" name="newUsersList[]" required>
                                    <?php
                                    $item = null;
                                    $value = null;
                                    $users = ControllerUsers::ctrShowUsers($item, $value);
                                    foreach ($users as $key => $value) {
                                        if ($value["idArea"] != null)
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
                                       name="newDescription" placeholder=" Descrizione" required>
                            </div>
                        </div>
                        <div style="font-size: large">Inserisci Peso %</div>
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
                        <div class="form-group row newUsers">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Salva Target</button>
                    </div>
                </div>

            </form>
            <?php
            $createTarget = new ControllerTarget();
            $createTarget::ctrCreateTarget();
            ?>
        </div>
    </section>
</div>

<script>
    $(function () {
        $('select[name="newUsersList[]"]').select2({
            placeholder: "    Seleziona utenti"
        });
    })
</script>


