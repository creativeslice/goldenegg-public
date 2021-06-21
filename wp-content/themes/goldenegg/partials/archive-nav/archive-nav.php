<?php
/**
 * Page Navigation for Archives
 */
 ?>

<nav class="pageNavi">
<?php global $wp_query;
	$bignum = 999999;
    if ( $wp_query->max_num_pages <= 1 ) return;
    
    echo paginate_links( array(
        'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
        'format'       => '',
        'current'      => max( 1, get_query_var('paged') ),
        'total'        => $wp_query->max_num_pages,
        'prev_text'    => '&larr;',
        'next_text'    => '&rarr;',
        'type'         => 'list',
        'end_size'     => 3,
        'mid_size'     => 3
    ) );
?>
</nav>