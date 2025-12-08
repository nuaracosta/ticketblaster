		</section>
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script>
			
			$(document).ready( function() {
				$('nav ul li').click(function(e) { 
					//$(this).find("a").trigger('click');
					window.location = $(this).find("a").attr('href');
				});
			});
			
		</script>
	</body>
</html>
