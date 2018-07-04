
        <footer class="panel-footer clearfix">
            <div class="pull-right">
                Developed <i class="fas fa-heart text-danger"></i> by <a href="https://github.com/MatheusRV/" target="_blank">Matheus Rocha Vieira</a>
            </div>
            <div class="pull-left">
                <?= date('Y');?> &copy; All rights reserved
            </div>
        </footer>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!--<script src="<?= PUBLIC_ROOT; ?>js/jquery.min.js"></script>-->
		<script src="<?= PUBLIC_ROOT; ?>js/bootstrap.min.js"></script>
		<script src="<?= PUBLIC_ROOT; ?>js/sb-admin-2.js"></script>
		<script src="<?= PUBLIC_ROOT; ?>js/main.js"></script>

        <!-- Assign CSRF Token to JS variable -->
		<?php Config::setJsConfig('csrfToken', Session::generateCsrfToken()); ?>
        <!-- Assign all configration variables -->
		<script>config = <?= json_encode(Config::getJsConfig()); ?>;</script>
        <!-- Run the application -->
        <script>$(document).ready(app.init());</script>

		<?php Database::closeConnection(); ?>
	</body>
</html>
