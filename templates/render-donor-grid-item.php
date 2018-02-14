<div class="donor-item">
	<div class="donor-gravatar">
		<?php printf( get_avatar( $email ) ); ?>
	</div>
	<div class="donor-meta">
		<span class="name"><?php printf( '%1$s %2$s', esc_html( $first_name ), esc_html( $last_name[0] ) ); ?></span>
	</div>
</div>
