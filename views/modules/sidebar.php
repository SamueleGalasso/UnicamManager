<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <?php

            echo '
					<li class="active">
						<a href="home">
							<i class="fa fa-home"></i>
							<span>Home</span>
						</a>
					</li>';
            if ($_SESSION["profile"] == "Admin") {
                echo '
					<li>
						<a href="users">
							<i class="fa fa-user"></i>
							<span>Gestione Utenti</span>
						</a>
					</li>
				';
            }
            if ($_SESSION["profile"] == "Admin" || $_SESSION["profile"] == "Amministratore") {
                echo '
                <li class="active">
						<a href="tree">
							<i class="fa fa-tree" aria-hidden="true"></i>
							<span>Tree View</span>
						</a>
					</li>
				';
                echo '
					<li class="active">
						<a href="plans">
							<i class="fa fa-bookmark" aria-hidden="true"></i>
							<span>Piani Annuali</span>
						</a>
					</li>
				';

                echo '
					<li class="active">
						<a href="objectivesUniversita">
							<i class="fa fa-arrows" aria-hidden="true"></i>
							<span>Obiettivi Università</span>
						</a>
					</li>
				';
                echo '
					<li class="active">
						<a href="targetsUniversita">
							<i class="fa fa-bell" aria-hidden="true"></i>
							<span>Targets Università</span>
						</a>
					</li>
				';
                echo '
					<li class="active">
						<a href="indicatorsUniversita">
							<i class="fa fa-gamepad" aria-hidden="true"></i>
							<span>Indicatori Università</span>
						</a>
					</li>
				';
            }
            if ($_SESSION["profile"] == "Admin" || $_SESSION["profile"] == "Amministratore") {
                echo '
					<li>
						<a href="areas">
							<i class="fa fa-th"></i>
							<span>Aree Amministrative</span>
						</a>
					</li>';
            }
            if ($_SESSION["profile"] == "Admin" || $_SESSION["profile"] == "Responsabile Area" || $_SESSION["profile"] == "Amministratore") {
                echo '<li>
						<a href="objectives">
							<i class="fa fa-thumb-tack" aria-hidden="true""></i>
							<span>Azioni Organizzative</span>
						</a>
					</li>
				';
            }
            if ($_SESSION["profile"] == "Admin" || $_SESSION["profile"] == "Responsabile Area" || $_SESSION["profile"] == "Amministratore") {
                echo '
					<li class="treeview">
				<a href="#">
					<i class="fa fa-list-ul"></i>
					<span>Targets</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li>
						<a href="create-targets">
							<i class="fa fa-circle"></i>
							<span>Crea Target</span>
						</a>
					</li>
				';
            }
            if ($_SESSION["profile"] == "Admin" || $_SESSION["profile"] == "Responsabile Area" || $_SESSION["profile"] == "Amministratore") {
                echo '
					<li>
						<a href="targets">
							<i i class="fa fa-hand-pointer-o" aria-hidden="true"></i>
							<span>Gestisci Targets</span>
						</a>
					</li>
				';
            }
            if ($_SESSION["profile"] == "Admin" || $_SESSION["profile"] == "Responsabile Area" || $_SESSION["profile"] == "Amministratore") {
                echo '
					<li>
						<a href="indicators">
							<i i class="fa fa-beer" aria-hidden="true"></i>
							<span>Gestisci Indicatori</span>
						</a>
					</li>
				';
            }
            if ($_SESSION["profile"] == "Dipendente") {
                echo '
					<li>
						<a href="dipendente-info">
							<i class="fa fa-user-secret" aria-hidden="true"></i>
							<span>Info Dipendente</span>
						</a>
					</li>
				';
            }
            echo '</ul>
			</li>';
            ?>
        </ul>
    </section>
</aside>