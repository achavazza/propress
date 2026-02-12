		<footer id="footer">
			<div class="container">
				<div class="columns">
					<div class="column is-3">
						<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 1')) : else : endif;?>
					</div>
					<div class="column is-3">
						<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 2')) : else : endif;?>
					</div>
					<div class="column is-3">
						<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 3')) : else : endif;?>
					</div>
				</div>
			</div>
            <div id="copyright">
                <div class="container">
                    <div class="loungelogo">
                        <a href="http://www.loungemedia.com.ar" target="_blank">
                            <img src="<?php echo get_template_directory_uri().'/img/loungemedia.png' ?>" title="LoungeMedia" alt="" />
                        </a>
                        &mdash;
                        <?php echo get_bloginfo('name') .' &mdash; &copy; ' . date("Y"); ?>
                    </div>
                </div>
            </div>
		</footer>

	</div>

	<?php wp_footer(); ?>

	<!-- Don't forget analytics -->

</body>

</html>
