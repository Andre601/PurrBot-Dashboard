		<hr>
		<div class="container">
			<p>
				Copyright &copy; <?=date('Y');?> Purr
				<span class="float-right">
					Dashboard built with <i class="fas fa-heart"></i> by <a href="https://github.com/xXAndrew28Xx">Andrew</a> and <a href="https://github.com/TonyMaster21">Tony</a>.
				</span>
			</p>
		</div>
        <script src="//code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="//unpkg.com/popper.js@1.12.6/dist/umd/popper.js"></script>
		<script src="//unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js"></script>
		<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>
        <?php
        if (isset($footerBottom)) {
            echo $footerBottom;
        }
        ?>
	</body>
</html>