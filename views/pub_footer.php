		</main>
		<!-- ======= Footer ======= ->
		<footer id="footer_area" class="footer">
			<div class="copyright">
				&copy;  <strong><span> <?php echo session::get("TITLE");?> </span></strong> Copyright
			</div>
		</footer><!-- End Footer -->

		<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

		<!--Target Progress Bar-->
		<div id="targetProgress" class="modal">
			<div class="modal-body" style="max-width:200px">
				<div class="progress">
					<div id="progress_area" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
		</div>
		<div class="d-none" id="targetLayer"></div>
		<script type="text/javascript">
			//var URL 	= "<?php echo URL?>";
			var MAIN_URL= "<?php echo URL?>";
			var E_HIDE 	= "d-none";
			var js_page = <?php echo session::get('PAGING'); ?>;
	
		</script>
			
		<!-- Js Plugins -->
		<script src="<?php echo URL?>public/JS/vue.min.js"></script>	
		<script src="<?php echo URL?>public/JS/jquery/jquery-3.3.1.min.js"></script>
		<script src="<?php echo URL?>public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo URL?>public/JS/jquery/jquery-ui.min.js"></script>
		
		<script src="<?php echo URL?>public/JS/jquery/jquery.form.js"></script>
		<script src="<?php echo URL?>public/JS/main.js"></script>		
		<script src="<?php echo URL?>public/JS/default.js"></script>
		<script src="<?php echo URL?>public/JS/piker/bootstrap.js"></script>
		
	<?php
		if(session::get('user_id'))
		{
			echo '<script src="'.URL.'public/JS/notifications.js"></script>';
		}
	?>
		
		<script type="text/javascript">
			vm_page_permission = new Vue({
				el: '#sidebar',
				data: {
					public_page			: <?php echo json_encode(session::get('public_pages')); ?>,
					public_login_page	: <?php echo json_encode(session::get('public_login_pages')); ?>,
					user_page			: <?php echo json_encode(session::get('user_pages')); ?>,
					
				},
				created: function() {
					
				},
				methods: {
					h_access($cls,$clas = "index")
					{
						if(this.public_page.includes($cls))
						{
							return true;
						}
						if(this.public_login_page.includes($cls))
						{
							return true;
						}
						if(Object.keys(this.user_page).includes($cls) && this.user_page[$cls].includes($clas))
						{
							return true;
						}
						//console.log($cls+" Not In permission");
						return false;
					},
					
				}
			});
			
		</script>
		
	<?php
		if(isset($this->JS))
		{
			foreach($this->JS as $v)
			{
				echo '<script src="'.URL.$v.'"></script>';
			}
		}
	?>
	</body>

</html>
