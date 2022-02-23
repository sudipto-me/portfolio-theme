<?php
/**
 * Template Name: Home Page
 *
 **/
?>

<?php
defined( 'ABSPATH' ) || exit();
get_header();
?>
    <!--Hello-->
    <section id="hello" class="container section">
        <div class="row">
            <div class="col-md-10">
                <h2 id="hello_header" class="section__title"><?php echo get_field( 'hello_intro' ) ? get_field( 'hello_intro' ) : __( 'Hi_', 'portfolio' ); ?></h2>
                <?php echo 'hello world';?>
                <p class="section__description"><?php echo get_field( 'hello_description' ); ?></p>
				<?php $cv = get_field( 'download_cv' ); ?>
                <a href="<?php echo esc_url( $cv['url'] ); ?>" class="section_btn site-btn"><img src="<?php echo get_template_directory_uri() . '/assets/img/img_btn_icon.png' ?>" alt=""><?php echo esc_attr__( 'Download CV', 'portfolio' ); ?></a>
            </div>
        </div>
    </section>
    <!--Hello-->
    <hr>
    <!--Resume-->
    <section id="resume" class="container section">
        <div class="row">
            <div class="col-md-10">
                <h2 id="resume_header" class="section__title"><?php echo esc_html__( 'Resume_', 'portfolio' ); ?></h2>
                <p class="section__description"><?php echo get_field( 'resume_intro' ); ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 section__resume resume-list">
                <h3 class="resume-list_title"><?php echo esc_html__( 'Education', 'portfolio' ); ?></h3>
				<?php
				$educations = get_field( 'education' );
				if ( is_array( $educations ) && ! empty( $educations ) ):
					foreach ( $educations as $education ):
						?>

                        <div class="resume-list__block">
                            <p class="resume-list__block-title"><?php echo $education['degree_institution']; ?></p>
                            <p class="resume-list__block-date"><?php echo $education['degree_timeline']; ?></p>
                            <p><?php echo $education['degree_summary']; ?></p>
                        </div>
					<?php endforeach;endif; ?>

            </div>
        </div>
        <div class="row">
            <div class="col-md-8 section__resume resume-list">
                <h3 class="resume-list_title"><?php echo esc_html__( 'Employment', 'portfolio' ); ?></h3>
				<?php $employments = get_field( 'employment' );
				if ( is_array( $employments ) && ! empty( $employments ) ):
					foreach ( $employments as $employment ) :
						?>
                        <div class="resume-list__block">
                            <p class="resume-list__block-title"><?php echo $employment['employer'] ?></p>
                            <p class="resume-list__block-date"><?php echo $employment['employment_timeline'] ?></p>
                            <p><?php echo $employment['job_description'] ?></p>
                        </div>
					<?php endforeach;endif; ?>
            </div>
        </div>
        <div class="row section__resume progress-list js-progress-list">
            <div class="col-md-12">
                <h3 class="progress-list__title"><?php echo esc_html__( 'General skills', 'portfolio' ); ?></h3>
            </div>
			<?php $skills = get_field( 'skills' );
			if ( is_array( $skills ) && ! empty( $skills ) ):
				foreach ( $skills as $skill ):?>
                    <div class="col-md-5 mr-auto">
                        <div class="progress-list__skill">
                            <p>
                                <span class="progress-list__skill-title"><?php echo $skill['skill_name'] ?></span>
                                <span class="progress-list__skill-value"><?php echo $skill['skill_percentage'] ?>%</span>
                            </p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $skill['skill_percentage'] ?>" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    </div>
				<?php endforeach;endif; ?>
        </div>
    </section>
    <!--Resume-->

    <!--Portfolio-->
    <section id="portfolio" class="container section">
        <div class="row">
            <div class="col-md-12">
                <h2 id="portfolio_header" class="section__title"><?php echo esc_html__( 'My projects_', 'portfolio' ); ?></h2>
            </div>
        </div>
        <div class="row portfolio-menu">
            <div class="col-md-12">
				<?php
				$project_categories = get_terms( array( 'taxonomy' => 'project_cat', 'hide_empty' => false ) );
				?>
                <nav>
                    <ul>
                        <li><a href="" data-portfolio-target-tag="all">all</a></li>
						<?php if ( is_array( $project_categories ) && count( $project_categories ) ): ?>
							<?php foreach ( $project_categories as $project_cat ): ?>
                                <li><a href="" data-portfolio-target-tag="<?php echo esc_attr( $project_cat->slug ); ?>"><?php echo esc_attr( $project_cat->name ); ?></a></li>
							<?php endforeach;endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
		<?php
		$projects = get_posts(
			array(
				'post_type'      => 'portfolio-projects',
				'posts_per_page' => 5,
				'post_status'    => 'publish'
			)
		);
		if ( is_array( $projects ) && count( $projects ) ):
		foreach ( $projects

		as $project ) : ?>
        <div class="portfolio-cards">
			<?php
			$project_category = get_the_terms( $project, 'project_cat' );
			?>
            <div class="row project-card" data-toggle="modal" data-target="#portfolioModal" data-portfolio-tag="<?php echo isset( $project_category[0] ) ? esc_attr( $project_category[0]->slug ) : ''; ?>">
                <div class="col-md-6 col-lg-5 project-card__img">
                    <a href="<?php echo get_the_permalink( $project ); ?>"><img class="" src="<?php echo get_the_post_thumbnail_url( $project, 'full' ) ?>" alt="project-img"></a>
                </div>
                <div class="col-md-6 col-lg-7 project-card__info">
                    <a href="<?php echo get_the_permalink( $project ); ?>" class="project-card__title_link"><h3 class="project-card__title"><?php echo esc_html( get_the_title( $project ) ); ?></h3></a>
                    <p class="project-card__description"><?php echo get_the_excerpt( $project ); ?></p>
                    <p class="project-card__stack"><?php echo esc_html__( 'Used stack:', 'portfolio' ); ?></p>
					<?php
					$used_stacks = get_field( 'used_stacks', $project->ID ); ?>
					<?php if ( ! empty( $used_stacks ) ): ?>
                        <ul class="tags">
							<?php foreach ( $used_stacks as $stack ): ?>
                                <li><?php echo $stack['stack_name']; ?></li>
							<?php endforeach; ?>
                        </ul>
					<?php endif; ?>
                    <a href="<?php echo esc_url( get_field( 'project_live_link', $project->ID ) ) ?>" class="project-card__link"><?php echo esc_url( get_field( 'project_live_link', $project->ID ) ) ?></a>
                </div>
            </div>

			<?php endforeach;
			endif; ?>
    </section>
    <!--Portfolio-->

    <!--Testimonials-->
    <div id="testimonials" class="section">
        <div class="background slider-carousel" style="">
            <div class="container">
                <div id="carouselTestimonials" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselTestimonials" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselTestimonials" data-slide-to="1"></li>
                        <li data-target="#carouselTestimonials" data-slide-to="2"></li>
                        <li data-target="#carouselTestimonials" data-slide-to="3"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
						<?php
						$testimonials = get_posts(
							array(
								'post_type'      => 'testimonials',
								'posts_per_page' => 4,
								'post_status'    => 'publish'
							)
						);
						if ( is_array( $testimonials ) && count( $testimonials ) ):
							for ( $i = 0; $i < count( $testimonials ); $i ++ ):
								?>
                                <div class="carousel-item <?php echo ( 0 === $i ) ? 'active' : '' ?>">
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-10 mr-auto ml-auto">
                                            <p class="slider-carousel__title"><?php echo esc_attr( $testimonials[ $i ]->post_title ); ?></p>
                                            <p class="slider-carousel__caption"><?php echo 'Project: ' . get_field( 'project_name', $testimonials[ $i ]->ID ); ?></p>
                                            <hr>
                                            <p class="slider-carousel__description"><?php echo $testimonials[ $i ]->post_content; ?></p>
                                        </div>
                                    </div>
                                </div>
							<?php endfor;endif; ?>
                    </div>
                    <a class="carousel-control-prev" href="#testimonials" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#testimonials" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    <div class="slider-carousel__circle">
                        <p><i class="fa fa-quote-right" aria-hidden="true"></i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Testimonials-->
    <!--Blog-->
    <section id="blog" class="container section">
        <div class="row">
            <div class="col-md-12">
                <h2 id="blog_header" class="section__title"><?php echo esc_html__( 'Latest Posts_', 'portfolio' ); ?></h2>
            </div>
        </div>

		<?php
		$posts = get_posts(
			array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => 3
			)
		);
		if ( is_array( $posts ) && ! empty( $posts ) ): ?>
        <div class="row post-cards">
			<?php foreach ( $posts as $post ): ?>
                <div class="col-md-4">
                    <a href="<?php echo get_the_permalink( $post->ID ); ?>">
                        <div class="post-cards__card">
                            <div class="post-cards__img">
                                <img src="<?php echo ! empty( get_the_post_thumbnail_url( $post->ID, 'full' ) ) ? get_the_post_thumbnail_url( $post->ID, 'full' ) : get_template_directory_uri() . '/assets/img/post.png' ?>" alt="blog_img">
                            </div>
                            <div class="post-cards__info">
                                <p class="post-cards__date"><?php echo get_the_date( "F j, Y", $post->ID ); ?></p>
                                <h3 class="post-cards_title"><?php echo get_the_title( $post->ID ); ?></h3>
                                <p class="post-cards_description"><?php echo get_the_excerpt( $post->ID ); ?></p>
                            </div>
                        </div>
                    </a>
                </div>
			<?php endforeach;
			endif; ?>
        </div>
    </section>
    <!--Blog-->

<?php
get_footer();
