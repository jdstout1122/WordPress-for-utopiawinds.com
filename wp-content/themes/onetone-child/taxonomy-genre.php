<?php
/**
* The Repertoire archive template file.
*
*/
get_header(); 

$left_sidebar   = onetone_option('left_sidebar_blog_archive','');
$right_sidebar  = onetone_option('right_sidebar_blog_archive','');
$aside          = 'no-aside';
if( $left_sidebar !='' )
$aside          = 'left-aside';
if( $right_sidebar !='' )
$aside          = 'right-aside';
if(  $left_sidebar !='' && $right_sidebar !='' )
$aside          = 'both-aside';

?>

  <section class="page-title-bar title-left no-subtitle">
    <div class="container">
      <h2 class="page-title">Repertoire</h2>
      <?php onetone_get_breadcrumb(array("before"=>"<div class=''>","after"=>"</div>","show_browse"=>false,"separator"=>'','container'=>'div'));?>
      <div class="clearfix"></div>
    </div>
  </section>

<div class="post-wrap">
            <div class="container-fullwidth">
                <div class="post-inner row <?php echo $aside; ?>">
                    <div class="col-main">
			<section class="genres">
<span>View By Genre:</span>
<?php $terms = get_terms( array(
    'taxonomy' => 'genre',
    'hide_empty' => 'false',
) );
	foreach ( $terms as $term ) {
		$term_link = get_term_link( $term, 'genre' );
		if( is_wp_error( $term_link ) )
		continue;
	echo '<a href="' . $term_link . '" class="button">' . $term->name . '</a>';
        } 
?>
			</section>

                        <section class="post-main" role="main" id="content">
				<article class="page type-page">
<table id="rep">
	<tr class="table-title">
		<th>Composer</th>
		<th>Composition</th>
		<th>Sample</th>
	</tr>
<?php $the_query = new WP_Query( array(
	'post_type' => 'song',
	'tax_query' => array(
		array(
        		'taxonomy' => 'genre',
		),
	),
		
)
);?>

<?php while ( have_posts() ) : the_post(); ?>
	<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<td><strong><?php the_field('composer'); ?></strong></td>
		<td><?php the_title(); ?></td>
		<td><?php
$value = get_post_meta( $post->ID, 'media_link', true );

if ( $value ) {
    // Returns an empty string for invalid URLs
    $url = esc_url( $value );
        print "<a href='$url' target='_blank'><img class='play' src='http://www.utopiawinds.com/wp/wp-content/uploads/2016/07/play.png' /></a>";
}
?>
		</td>
	</tr><!-- #post -->
			<?php endwhile; ?>

</table>
				</article>
                            
                            
                            <div class="post-attributes"></div>
                        </section>
                    </div>
                </div>
            </div>  
        </div>
</div>
<?php get_footer(); ?>