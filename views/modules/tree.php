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
            Tree View
        </h1>
        <ol class="breadcrumb">
            <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-success">
            <div class="box-body">
                <div id="tree">
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    function customMenu(node) {
        return {
            openItem: {
                label: "Apri",
                action: function () {
                    window.open(node.data.url, '_blank');
                }
            }
        };
    }

    $("#tree").jstree({
        plugins: ["contextmenu"],
        contextmenu: {items: customMenu},
        "core": {
            "data": {
                "url": function (node) {
                    if (node.id !== "#") {
                        if (node.original.depth === 0) {
                            return "ajax/tree.ajax.php?idPlan=" + node.parent;
                        } else if (node.original.depth === 1) {
                            return "ajax/tree.ajax.php?idPlanObj=" + node.parent;
                        } else if (node.original.depth === 2) {
                            return "ajax/tree.ajax.php?idObjUni=" + node.parent;
                        } else if (node.original.depth === 3) {
                            return "ajax/tree.ajax.php?idObj=" + node.parent;
                        } else if (node.original.depth === 4) {
                            return "ajax/tree.ajax.php?idTargetUni=" + node.parent;
                        } else if (node.original.depth === 5) {
                            return "ajax/tree.ajax.php?idTarget=" + node.parent;
                        }
                    }
                    return "ajax/tree.ajax.php?list=1";
                },
                "dataType": "json"
            },
            "themes": {
                "variant": "large"
            }
        }
    });
</script>