<?php
$prefix = $lazyclass = '';
if ( ! empty($settings['lazyload']) ) {
	$prefix    = 'data-';
	$lazyclass = ' lazyload' . ( is_string($settings['lazyload']) ? ' ' . $settings['lazyload'] : '' );
}
?><figure<?php echo $attr; ?>><img
	class="image-img<?php echo $lazyclass; ?>"
	alt="<?php echo esc_attr( $settings['alt'] ); ?>"
	<?php echo $prefix; ?>src="<?php echo esc_url( $settings['src'] ); ?>"
	<?php if ( ! empty($settings['srcset']) ) : ?>
		<?php echo $prefix; ?>srcset="<?php
			$output = '';
			foreach ( $settings['srcset'] as $size => $url ) :
				$output .= esc_url( $url ) . ' ' . esc_attr( $size ) . ',';
			endforeach;
			echo rtrim( $output, ',' );
			?>"<?php
	endif;
	if ( ! empty($settings['sizes']) ) : ?>
		<?php echo $prefix; ?>sizes="<?php
			$output = '';
			foreach ( $settings['sizes'] as $size ) :
				$output .= esc_attr( $size ) . ',';
			endforeach;
			echo rtrim( $output, ',' );
			?>"<?php
	endif;
	if ( ! empty($settings['role']) ) : ?>
	role="<?php echo ( is_string($settings['role']) ? $settings['role'] : 'presentation' ); ?>"
	<?php endif;
	?>><?php
	if ( ! empty($settings['caption']) ) :
		?><figcaption class="image-caption"><?php echo esc_html( $settings['caption'] ); ?></figcaption><?php
	endif;
?></figure><?php
