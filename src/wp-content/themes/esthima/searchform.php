<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <input type="submit" class="search-submit" value="<?php echo esc_attr_x( '', 'submit button' ) ?>" />
	<label>
	  <span class="screen-reader-text"><?php echo _x( 'Recherche pour :', 'label' ) ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Recherche', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Recherche pour :', 'label' ) ?>" />
	</label>
</form>