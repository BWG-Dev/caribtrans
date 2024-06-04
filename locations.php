<?php
/* Template Name: Locations */

get_header();

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

while ( have_posts() ) :
	the_post();
	?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

	<main id="content" <?php post_class( 'site-main' ); ?>>
		<div id="map"></div>

        <div class="container ct-filters">
            <div class="row my-5">
                <div class="col-12 text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input location-filter" type="checkbox" id="destinations-filter" value="destination">
                        <label class="form-check-label" for="destinations"><i class="fas fa-map-marker-alt"></i> Destinations</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input location-filter" type="checkbox" id="receiving-filter" value="receiving">
                        <label class="form-check-label" for="receiving"><i class="fas fa-map-marker-alt"></i> Receiving</label>
                    </div>

                </div>
            </div>

            <hr>

            <!-- Corporate -->
            <div class="row corporate my-5">
                <div class="col-12">
                    <h4 class="location-type">Corporate Office.</h4>
                </div>
                <div class="col-12 pl-5 ml-5 location-listing">
                    <?php
					$args = array(
                                'post_type' => 'location',
								'meta_key'      => 'ct_type',
								'meta_value'    => 'corporate'

                            );

					$corporate_locations = get_posts( $args );

					foreach ( $corporate_locations as $location ){
                        $image = $location->ct_flag_image = get_field( 'ct_flag_image', $location->ID );
                        ?><br><?php
						$content = get_field( 'ct_location_content', $location->ID );
						$phone = get_field( 'ct_phone', $location->ID );
						$info = get_field( 'ct_address', $location->ID );
						$email = get_field( 'ct_email', $location->ID );
						$toll_free = get_field( 'ct_phone_toll_free', $location->ID );
                        ?>
                        <div class="location-single" id="location--<?php echo $location->ID; ?>">
                            <h3 class="location-name"><?php echo $location->post_title; ?></h3>
                        <?php
                        if( $image && ! empty( $image ) ){
                        ?>
                            <p><img src="<?php echo $image; ?>" alt=""></p>
                        <?php
						}

                        if( $content && ! empty( $content ) ){
                            echo $content;
                        }
                        ?>
                            <p><i class="fas fa-map-marker-alt"></i> <?php echo $info['address']; ?></p>
                            <p><i class="fa fa-phone"></i> <a href="te:<?php echo $phone; ?>"><?php echo $phone; ?></a></p>
                            <p><i class="fa fa-envelope"></i> <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
                            <p>Toll Free: <a href="tel:<?php echo $toll_free; ?>"><?php echo $toll_free; ?></a></p>
                            <br>
                            <p><a class="btn-primary" target="_blank" href="http://maps.google.com/maps/dir/<?php echo $info['address']; ?>">Print Driving Instructions</a></p>
                            <br>
                            <p><a class="btn-primary" target="_blank" href="http://maps.google.com/?q=<?php echo $info['address']; ?>">Map of the Area</a></p>
                        </div>
						<?php


					}

                    ?>
                </div>
            </div>

            <hr>

            <!-- Destinations -->
            <div class="row destination my-5">
                <div class="col-12">
                    <h4 class="location-type">Destinations</h4>
                </div>
                <div class="col-12 pl-5 ml-5 location-listing">
					<?php
					$args = array(
						'post_type' => 'location',
						'meta_key'      => 'ct_type',
						'numberposts'=> -1,
						'meta_value'    => 'destination'

					);

					$corporate_locations = get_posts( $args );

					foreach ( $corporate_locations as $location ){
						$image = $location->ct_flag_image = get_field( 'ct_flag_image', $location->ID );
						?><br><?php
						$content = get_field( 'ct_location_content', $location->ID );
						$phone = get_field( 'ct_phone', $location->ID );
						$info = get_field( 'ct_address', $location->ID );
						$email = get_field( 'ct_email', $location->ID );
						$toll_free = get_field( 'ct_phone_toll_free', $location->ID );
						?>
                        <div class="location-single" id="location--<?php echo $location->ID; ?>">
                            <div class="ct_accordion_header" data-id="<?php echo $location->ID; ?>">
                                <h3 class="location-name"><?php echo $location->post_title; ?></h3>
                                <i class="fa fa-angle-down"></i>
                            </div>
                            <hr>
							<div class="data">
								<?php
								if( $image && ! empty( $image ) ){
									?>
                                    <p><img src="<?php echo $image; ?>" alt=""> </p>
									<?php
								}

								if( $content && ! empty( $content ) ){
									echo $content;
								}
								?>
                                <p><i class="fas fa-map-marker-alt"></i> <?php echo $info['address']; ?></p>
								<?php if ( $phone ) { ?>
                                    <p><i class="fa fa-phone"></i> <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></p>
								<?php } ?>
								<?php if ( ! empty( $email ) ) { ?>
                                    <p><i class="fa fa-envelope"></i> <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
								<?php } ?>
								<?php if ( ! empty( $toll_free ) ) { ?>
                                    <p>Toll Free: <a href="tel:<?php echo $toll_free; ?>"><?php echo $toll_free; ?></a></p>
								<?php } ?>
                            </div>
                        </div>
						<?php


					}

					?>
                </div>
            </div>

            <hr>

            <!-- Receiving -->
            <div class="row destination my-5">
                <div class="col-12">
                    <h4 class="location-type">Receiving</h4>
                </div>
                <div class="col-12 pl-5 ml-5 location-listing">
					<?php
					$args = array(
						'post_type' => 'location',
						'meta_key'      => 'ct_type',
                        'numberposts'=> -1,
						'meta_value'    => 'receiving'

					);

					$corporate_locations = get_posts( $args );

					foreach ( $corporate_locations as $location ){
						$image = $location->ct_flag_image = get_field( 'ct_flag_image', $location->ID );
						?><br><?php
						$content = get_field( 'ct_location_content', $location->ID );
						$phone = get_field( 'ct_phone', $location->ID );
						$info = get_field( 'ct_address', $location->ID );
						$email = get_field( 'ct_email', $location->ID );
						$toll_free = get_field( 'ct_phone_toll_free', $location->ID );
						?>
                        <div class="location-single" id="location--<?php echo $location->ID; ?>">
                            <div class="ct_accordion_header" data-id="<?php echo $location->ID; ?>">
                                <h3 class="location-name"><?php echo $location->post_title; ?></h3>
                                <i class="fa fa-angle-down"></i>
                            </div>
                            <hr>
                            <div class="data">
								<?php
								if( $image && ! empty( $image ) ){
									?>
                                    <p><img src="<?php echo $image; ?>" alt=""> </p>
									<?php
								}

								if( $content && ! empty( $content ) ){
									echo $content;
								}
								?>
                                <p><i class="fas fa-map-marker-alt"></i> <?php echo $info['address']; ?></p>
								<?php if ( $phone ) { ?>
                                    <p><i class="fa fa-phone"></i> <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></p>
								<?php } ?>
								<?php if ( ! empty( $email ) ) { ?>
                                    <p><i class="fa fa-envelope"></i> <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
								<?php } ?>
								<?php if ( ! empty( $toll_free ) ) { ?>
                                    <p>Toll Free: <a href="tel:<?php echo $toll_free; ?>"><?php echo $toll_free; ?></a></p>
								<?php } ?>
                            </div>
                        </div>
						<?php


					}

					?>
                </div>
            </div>
        </div>




		<!--<div class="page-content">
			<?php /*the_content(); */?>
			<div class="post-tags">
				<?php /*the_tags( '<span class="tag-links">' . esc_html__( 'Tagged ', 'hello-elementor' ), null, '</span>' ); */?>
			</div>
			<?php /*wp_link_pages(); */?>
		</div>-->


	</main>

<?php
endwhile;

get_footer();
