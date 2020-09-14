<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Basic Page Needs
	================================================== -->
	<meta charset="utf-8">
    <title>INVEF | WEB</title>
    <meta name="description" content="">	
	<meta name="author" content="">

	<!-- Mobile Specific Metas
	================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Favicons
	================================================== -->
	<link rel="icon" href="{{asset('web/images/invefLogoMini.png')}}" type="image/x-icon" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('web/images/invefLogoMini.png')}}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('web/images/invefLogoMini.png')}}">
	<link rel="apple-touch-icon-precomposed" href="{{asset('web/images/invefLogoMini.png')}}">
	
	<!-- CSS
	================================================== -->
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="{{asset('web/css/bootstrap.min.css')}}">
	<!-- Template styles-->
	<link rel="stylesheet" href="{{asset('web/css/style.css')}}">
	<!-- Responsive styles-->
	<link rel="stylesheet" href="{{asset('web/css/responsive.css')}}">
	<!-- FontAwesome -->
	<link rel="stylesheet" href="{{asset('web/css/font-awesome.min.css')}}">
	<!-- Animation -->
	<link rel="stylesheet" href="{{asset('web/css/animate.css')}}">
	<!-- Prettyphoto -->
	<link rel="stylesheet" href="{{asset('web/css/prettyPhoto.css')}}">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="{{asset('web/css/owl.carousel.css')}}">
	<link rel="stylesheet" href="{{asset('web/css/owl.theme.css')}}">
	<!-- Flexslider -->
	<link rel="stylesheet" href="{{asset('web/css/flexslider.css')}}">
	<!-- Flexslider -->
	<link rel="stylesheet" href="{{asset('web/css/cd-hero.css')}}">
	<!-- Style Swicther -->
	<link id="style-switch" href="{{asset('web/css/presets/preset1.css')}}" media="screen" rel="stylesheet" type="text/css">

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

</head>
	
<body>

	<div class="body-inner">
	<!-- Header start -->
	<header id="header" class="navbar-fixed-top header2" role="banner">
		<div class="container">
			<div class="row">
				<!-- Logo start -->
				<div class="navbar-header">
				    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				        <span class="sr-only">Barra de Navegación</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				    </button>
				    <div class="navbar-brand">
					    <a href="{{ Route('web') }}">
					    	<img class="img-responsive" src="{{asset('web/images/logoExtendido.png')}}" alt="logo">
					    </a> 
				    </div>                   
				</div><!--/ Logo end -->
				<nav class="collapse navbar-collapse clearfix" role="navigation">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown active">
                       		<a href="{{ Route('web') }}" class="dropdown-toggle" data-toggle="dropdown">Inicio <i class="fa fa-angle-down"></i></a>
	                    </li>
						<li class="dropdown">
                       		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Nosotros <i class="fa fa-angle-down"></i></a>
                       		<div class="dropdown-menu">
								<ul>
		                            <li><a href="about.html">Sobre Nosotros</a></li>
		                            <li><a href="service.html">Servicios</a></li>
		                            <li><a href="faq.html">Preguntas Frecuentes</a></li>
		                        </ul>
	                    	</div>
	                    </li>
						<li class="dropdown">
                       		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Liquidaciones <i class="fa fa-angle-down"></i></a>
                       		<div class="dropdown-menu">
								<ul>
		                            <li><a href="portfolio-classic.html">Equipos</a></li>
		                        </ul>
	                    	</div>
	                    </li>
						<li><a href="{{ Route('login') }}">Ingresar</a></li>
						<li><a href="{{ Route('cli') }}">Registrar</a></li>
                    </ul>
				</nav><!--/ Navigation end -->
			</div><!--/ Row end -->
		</div><!--/ Container end -->
	</header><!--/ Header end -->

	<!-- Slider start -->
	<section id="home" class="no-padding">	

    	<div id="main-slide" class="ts-flex-slider">

			<div class="flexSlideshow flexslider">
				<ul class="slides">
					<li>
						<div class="overlay2">
							<img class="" src="{{ asset('web/images/slider/principal.jpg') }}" alt="slider">
						</div>
						<div class="flex-caption slider-content">
	                        <div class="col-md-12 text-center">
								<!--
	                    		<h2 class="animated2">
	                        		Inversiones Invef
								</h2>
								
	                            <h3 class="animated3">
	                            	We Making Difference To Great Things Possible
								</h3>
								-->
	                            <p class="animated4"><a href="#" class="slider btn btn-primary white">INFORMACIÓN</a></p>
	                        </div>
	                    </div>
					</li>
					<li>
						<div class="overlay2">
							<img class="" src="{{ asset('web/images/slider/segundo.jpg') }}" alt="slider">
						</div>
						<div class="flex-caption slider-content">
	                        <div class="col-md-12 text-center">
								<!--
	                            <h2 class="animated4">
	                                How Big Can You Dream?
	                            </h2>
	                            <h3 class="animated5">
	                            	We are here to make it happen
								</h3>		
								-->
	                            <p class="animated6"><a href="#" class="slider btn btn-primary white">SOLICITAR</a></p>	     
	                        </div>
	                    </div>
					</li>
					<li>
						<div class="overlay2">
							<img class="" src="{{ asset('web/images/slider/tercero.jpg') }}" alt="slider">
						</div>
						<div class="flex-caption slider-content">
	                        <div class="col-md-12 text-center">
								<!--
	                            <h2 class="animated7">
	                                Your Challenge is Our Progress
	                            </h2>
	                            <h3 class="animated8">
	                            	So, You Dont Need to Go Anywhere Today
								</h3>		
								-->
	                            <div class="">
	                                <a class="animated4 slider btn btn-primary btn-min-block white" href="#">JOYA</a><a class="animated4 slider btn btn-primary btn-min-block solid" href="#">PRENDARIO</a>
	                            </div>     
	                        </div>
	                    </div>
					</li>
				</ul>
			</div>
		</div><!--/ Main slider end -->    	
    </section> <!--/ Slider end -->

    <!-- About tab start -->
	<section id="about" class="about angle">
		<div class="container">
			<div class="row">
				<div class="landing-tab clearfix">
					<ul class="nav nav-tabs nav-stacked col-md-3 col-sm-5">
					  	<li class="active">
					  		<a class="animated fadeIn" href="#tab_a" data-toggle="tab">
					  			<span class="tab-icon"><i class="fa fa-info"></i></span>
					  			<div class="tab-info">
						  			<h3>Quienes Somos</h3>
					  			</div>
					  		</a>
					  	</li>
					  	<li>
						  	<a class="animated fadeIn" href="#tab_b" data-toggle="tab">
						  		<span class="tab-icon"><i class="fa fa-briefcase"></i></span>
					  			<div class="tab-info">
						  			<h3>Nuestra Empresa</h3>
					  			</div>
						  	</a>
						</li>
					 	<li>
						  	<a class="animated fadeIn" href="#tab_c" data-toggle="tab">
						  		<span class="tab-icon"><i class="fa fa-android"></i></span>
					  			<div class="tab-info">
						  			<h3>Que Hacemos</h3>
					  			</div>
						  	</a>
						</li>
						<li>
						  	<a class="animated fadeIn" href="#tab_d" data-toggle="tab">
						  		<span class="tab-icon"><i class="fa fa-pagelines"></i></span>
					  			<div class="tab-info">
						  			<h3>Amigable</h3>
					  			</div>
						  	</a>
						</li>
						<li>
						  	<a class="animated fadeIn" href="#tab_e" data-toggle="tab">
						  		<span class="tab-icon"><i class="fa fa-support"></i></span>
					  			<div class="tab-info">
						  			<h3>Atención al Cliente</h3>
					  			</div>
						  	</a>
						</li>
					</ul>
					<div class="tab-content col-md-9 col-sm-7">
				        <div class="tab-pane active animated fadeInRight" id="tab_a">
				        	<i class="fa fa-trophy big"></i>
				            <h3>We Are Awwared Winning Company</h3> 
				            <p>Over the year we have lots of experience in our field. In sit amet massa sapien. Vestibulum diam turpis, gravida in lobortis id, ornare a eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sagittis nulla non elit dignissim suscipit. Duis lorem nulla, eleifend.</p>
				        </div>
				        <div class="tab-pane animated fadeInLeft" id="tab_b">
				        	<i class="fa fa-briefcase big"></i>
				            <h3>We Have Worldwide Business</h3> 
							<p>Helvetica cold-pressed lomo messenger bag ugh. Vinyl jean shorts Austin pork belly PBR retro, Etsy VHS kitsch actually messenger bag pug. Pbrb semiotics try-hard, Schlitz occupy dreamcatcher master cleanse Marfa Vice tofu. </p>							 
				        </div>
				        <div class="tab-pane animated fadeIn" id="tab_c">
				            <i class="fa fa-android big"></i>
				            <h3>We Build Readymade Applications</h3> 
				            <p>Over the year we have lots of experience in our field. In sit amet massa sapien. Vestibulum diam turpis, gravida in lobortis id, ornare a eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sagittis nulla non elit dignissim suscipit. Duis lorem nulla, eleifend.</p>
				        </div>
				        <div class="tab-pane animated fadeIn" id="tab_d">
				            <i class="fa fa-pagelines big"></i>
				            <h3>Clean and Modern Design</h3> 
				            <p>Over the year we have lots of experience in our field. In sit amet massa sapien. Vestibulum diam turpis, gravida in lobortis id, ornare a eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sagittis nulla non elit dignissim suscipit. Duis lorem nulla, eleifend.</p>
				        </div>
				        <div class="tab-pane animated fadeIn" id="tab_e">
				            <i class="fa fa-support big"></i>
				            <h3>24/7 Dedicated Support</h3> 
				            <p>Occupy selfies Tonx, +1 Truffaut beard organic normcore tilde flannel artisan squid cray single-origin coffee. Master cleanse vinyl Austin kogi, semiotics skateboard fap wayfarers health goth. Helvetica cray church-key hashtag Carles. Four dollar toast meggings seitan, Tonx pork belly VHS Bushwick. Chambray banh mi cornhole. Locavore messenger bag seitan.</p>
				        </div>
					</div><!-- tab content -->
	    		</div><!-- Overview tab end -->
			</div><!--/ Content row end -->
		</div><!-- Container end -->
    </section><!-- About end -->

    <section id="image-block" class="image-block no-padding">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 ts-padding" style="height:650px;background:url(web/images/nuestraEmpresa.jpg) 50% 50% / cover no-repeat;">
				</div>
				<div class="col-md-6 ts-padding img-block-right">
					<div class="img-block-head text-center">
						<h2>CONOZCA MÁS SOBRE NUESTRA EMPRESA</h2>
						<h3>POR QUÉ ELEGIRNOS</h3>
					</div>

					<div class="gap-30"></div>

					<div class="image-block-content">
						<span class="feature-icon pull-left" ><i class="fa fa-bicycle"></i></span>
						<div class="feature-content">
							<h3>Prestamos a Domicilio</h3>
							<p>Tenemos el personal adecuado y capacitado en todas las medidas de seguridad para realizar el prestamo en la comodidad de su hogar</p>
						</div>
					</div><!--/ End 1st block -->

					<div class="image-block-content">
						<span class="feature-icon pull-left" ><i class="fa fa-diamond"></i></span>
						<div class="feature-content">
							<h3>Prestamos de Joyas y Garantias</h3>
							<p>Le brindamos prestamos tanto con joyas como con equipos electrodomesticos y electrónicos.</p>
						</div>
					</div><!--/ End 1st block -->

					<div class="image-block-content">
						<span class="feature-icon pull-left" ><i class="fa fa-street-view"></i></span>
						<div class="feature-content">
							<h3>Atención al Cliente</h3>
							<p>Le brindamos una atención y asesoramiento de manera personalizada</p>
						</div>
					</div><!--/ End 1st block -->


				</div>
			</div>
		</div>
	</section>

	<!-- Counter Strat -->
	<section class="ts_counter no-padding">
		<div class="container-fluid">
			<div class="row facts-wrapper wow fadeInLeft text-center">
				<div class="facts one col-md-3 col-sm-6">
					<span class="facts-icon"><i class="fa fa-user"></i></span>
					<div class="facts-num">
						<span class="counter">230</span>
					</div>
					<h3>Clientes</h3> 
				</div>

				<div class="facts two col-md-3 col-sm-6">
					<span class="facts-icon"><i class="fa fa-institution"></i></span>
					<div class="facts-num">
						<span class="counter">2</span>
					</div>
					<h3>Sedes</h3> 
				</div>

				<div class="facts three col-md-3 col-sm-6">
					<span class="facts-icon"><i class="fa fa-suitcase"></i></span>
					<div class="facts-num">
						<span class="counter">39</span>
					</div>
					<h3>Prestamos</h3> 
				</div>

				<div class="facts four col-md-3 col-sm-6">
					<span class="facts-icon"><i class="fa fa-trophy"></i></span>
					<div class="facts-num">
						<span class="counter">2</span>
					</div>
					<h3>Servicios</h3> 
				</div>

			</div>
		</div><!--/ Container end -->
    </section><!--/ Counter end -->


	<!-- Service box start -->
	<section id="feature" class="feature">
		<div class="container">

			<div class="row">
				<div class="feature-box col-sm-4 wow fadeInDown" data-wow-delay=".5s">
					<span class="feature-icon pull-left" ><i class="fa fa-heart-o"></i></span>
					<div class="feature-content">
						<h3>Confiabilidad</h3>
						<p>Nuestros servicios cuentan con suma confiabilidad</p>
					</div>
				</div><!--/ End first featurebox -->

				<div class="feature-box col-sm-4 wow fadeInDown" data-wow-delay=".5s">
					<span class="feature-icon pull-left" ><i class="fa fa-codepen"></i></span>
					<div class="feature-content">
						<h3>Almacen</h3>
						<p>Nuestros almacenes cuentan con multiples medidas de seguridad</p>
					</div>
				</div><!--/ End first featurebox -->

				<div class="feature-box col-sm-4 wow fadeInDown" data-wow-delay=".5s">
					<span class="feature-icon pull-left" ><i class="fa fa-film"></i></span>
					<div class="feature-content">
						<h3>Seguridad</h3>
						<p>Contamos con video-vigilancia en todas nuestras oficinas y almacenes</p>
					</div>
				</div><!--/ End first featurebox -->
			</div><!-- Content row end -->

			<div class="gap-40"></div>

			<div class="row">
				<div class="feature-box col-sm-4 wow fadeInDown" data-wow-delay=".5s">
					<span class="feature-icon pull-left" ><i class="fa fa-newspaper-o"></i></span>
					<div class="feature-content">
						<h3>Informacíon</h3>
						<p>Brindamos toda la información que usted necesita</p>
					</div>
				</div><!--/ End first featurebox -->

				<div class="feature-box col-sm-4 wow fadeInDown" data-wow-delay=".5s">
					<span class="feature-icon pull-left" ><i class="fa fa-desktop"></i></span>
					<div class="feature-content">
						<h3>Electrodomesticos</h3>
						<p>Trabajamos con amplio rango de garantias aceptadas</p>
					</div>
				</div><!--/ End first featurebox -->

				<div class="feature-box col-sm-4 wow fadeInDown" data-wow-delay=".5s">
					<span class="feature-icon pull-left" ><i class="fa fa-pagelines"></i></span>
					<div class="feature-content">
						<h3>Rapida Atención</h3>
						<p>Nuestra atención no genera colas debido a nuestro rápido proceso de atención</p>
					</div>
				</div><!--/ End first featurebox -->

			</div><!-- Content row end -->

			<div class="gap-40"></div>

			<div class="row">
				<div class="feature-box col-sm-4 wow fadeInDown" data-wow-delay=".5s">
					<span class="feature-icon pull-left" ><i class="fa fa-recycle"></i></span>
					<div class="feature-content">
						<h3>Renovaciones</h3>
						<p>Brindamos la posibilidad de renovar las fechas de pago</p>
					</div>
				</div><!--/ End first featurebox -->

				<div class="feature-box col-sm-4 wow fadeInDown" data-wow-delay=".5s">
					<span class="feature-icon pull-left" ><i class="fa fa-diamond"></i></span>
					<div class="feature-content">
						<h3>Joyas</h3>
						<p>Aceptamos joyas como garantía</p>
					</div>
				</div><!--/ End first featurebox -->

				<div class="feature-box col-sm-4 wow fadeInDown" data-wow-delay=".5s">
					<span class="feature-icon pull-left" ><i class="fa fa-whatsapp"></i></span>
					<div class="feature-content">
						<h3>Atención al cliente</h3>
						<p>Brindamos toda la información que necesita de manera facil y rápida</p>
					</div>
				</div><!--/ End first featurebox -->
			</div><!-- Content row end -->

		</div><!--/ Container end -->
	</section><!--/ Service box end -->


	 <!-- Parallax 2 start -->
	<section class="parallax parallax2">
		<div class="parallax-overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h2>INFORMACIÓN</h2>
					<h3>Seleccione para ver más información</h3>
					<p>
						<a href="$" class="btn btn-primary white">Joyas</a>
						<a href="$" class="btn btn-primary solid">Electro</a>
					</p>
				</div>
			</div>
		</div><!-- Container end -->
    </section><!-- Parallax 2 end -->



	<!-- Team start -->
	<section id="team" class="team">
		<div class="container">
			<div class="row">
				<div class="col-md-12 heading">
					<span class="title-icon pull-left"><i class="fa fa-weixin"></i></span>
					<h2 class="title">Nuestro Equipo</h2>
				</div>
			</div><!-- Title row end -->

			<div class="row text-center">
				<!--
				<div class="col-md-3 col-sm-6">
					<div class="team wow slideInLeft">
						<div class="img-hexagon">
							<img src="images/team/team1.jpg" alt="">
							<span class="img-top"></span>
							<span class="img-bottom"></span>
						</div>
						<div class="team-content">
							<h3>Vosgi Varduhi</h3>
							<p>Web Designer</p>
							<div class="team-social">
								<a class="fb" href="#"><i class="fa fa-facebook"></i></a>
								<a class="twt" href="#"><i class="fa fa-twitter"></i></a>
								<a class="gplus" href="#"><i class="fa fa-google-plus"></i></a>
								<a class="linkdin" href="#"><i class="fa fa-linkedin"></i></a>
								<a class="dribble" href="#"><i class="fa fa-dribbble"></i></a>
							</div>
						</div>
					</div>	
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="team wow slideInLeft">
						<div class="img-hexagon">
							<img src="images/team/team2.jpg" alt="">
							<span class="img-top"></span>
							<span class="img-bottom"></span>
						</div>
						<div class="team-content">
							<h3>Robert Aleska</h3>
							<p>Web Designer</p>
							<div class="team-social">
								<a class="fb" href="#"><i class="fa fa-facebook"></i></a>
								<a class="twt" href="#"><i class="fa fa-twitter"></i></a>
								<a class="gplus" href="#"><i class="fa fa-google-plus"></i></a>
								<a class="linkdin" href="#"><i class="fa fa-linkedin"></i></a>
								<a class="dribble" href="#"><i class="fa fa-dribbble"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="team wow slideInRight">
						<div class="img-hexagon">
							<img src="images/team/team3.jpg" alt="">
							<span class="img-top"></span>
							<span class="img-bottom"></span>
						</div>
						<div class="team-content">
							<h3>Taline Voski</h3>
							<p>Web Designer</p>
							<div class="team-social">
								<a class="fb" href="#"><i class="fa fa-facebook"></i></a>
								<a class="twt" href="#"><i class="fa fa-twitter"></i></a>
								<a class="gplus" href="#"><i class="fa fa-google-plus"></i></a>
								<a class="linkdin" href="#"><i class="fa fa-linkedin"></i></a>
								<a class="dribble" href="#"><i class="fa fa-dribbble"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="team animate wow slideInRight">
						<div class="img-hexagon">
							<img src="images/team/team4.jpg" alt="">
							<span class="img-top"></span>
							<span class="img-bottom"></span>
						</div>
						<div class="team-content">
							<h3>Alban Spencer</h3>
							<p>Web Designer</p>
							<div class="team-social">
								<a class="fb" href="#"><i class="fa fa-facebook"></i></a>
								<a class="twt" href="#"><i class="fa fa-twitter"></i></a>
								<a class="gplus" href="#"><i class="fa fa-google-plus"></i></a>
								<a class="linkdin" href="#"><i class="fa fa-linkedin"></i></a>
								<a class="dribble" href="#"><i class="fa fa-dribbble"></i></a>
							</div>
						</div>
					</div>
				</div>
			-->
			</div><!--/ Content row end -->
		</div><!--/ Container end -->
    </section><!--/ Team end -->


	<!-- 
	<section class="testimonial parallax parallax3">
		<div class="parallax-overlay"></div>
	  	<div class="container">
		    <div class="row">
			    <div id="testimonial-carousel" class="owl-carousel owl-theme text-center testimonial-slide">
			        <div class="item">
			          	<div class="testimonial-thumb">
			            	<img src="images/team/testimonial1.jpg" alt="testimonial">
			          	</div>
			          	<div class="testimonial-content">
				            <p class="testimonial-text">
				              Lorem Ipsum as their default model text, and a search for ‘lorem ipsum’ will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose. Lorem Ipsum is that it as opposed to using.
				            </p>
			            	<h3 class="name">Sarah Arevik<span>Chief Executive</span></h3>
			          	</div>
			        </div>
			        <div class="item">
			          	<div class="testimonial-thumb">
			            	<img src="images/team/testimonial2.jpg" alt="testimonial">
			          	</div>
				        <div class="testimonial-content">
				            <p class="testimonial-text">
				              Lorem Ipsum as their default model text, and a search for ‘lorem ipsum’ will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose. Lorem Ipsum is that it as opposed to using.
				            </p>
				            <h3 class="name">Narek Bedros<span>Sr. Manager</span></h3>
				        </div>
			        </div>
			        <div class="item">
				        <div class="testimonial-thumb">
				            <img src="images/team/testimonial3.jpg" alt="testimonial">
				        </div>
			          	<div class="testimonial-content">
				            <p class="testimonial-text">
				              Lorem Ipsum as their default model text, and a search for ‘lorem ipsum’ will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose. Lorem Ipsum is that it as opposed to using.
				            </p>
			            	<h3 class="name">Taline Lucine<span>Sales Manager</span></h3>
			          	</div>
			        </div>
			    </div>
		    </div>
	  	</div>
	</section>-->


	<!-- Newsletter start -->
	<section id="newsletter" class="newsletter">
		<div class="container">
		  	<div class="row">
				<div class="col-md-12 heading text-center">
					<span class="icon-pentagon wow bounceIn animated"><i class="fa fa-envelope"></i></span>
					<h2 class="title2">REGISTRATE
						<span class="title-desc">Para poder realizar tus tramites en linea</span>
					</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<form action="#" method="post" id="newsletter-form" class="newsletter-form wow bounceIn" data-wow-duration=".8s">
						<div class="form-group">
							<button class="btn btn-primary solid">Registrar</button>
						</div>
					</form>
				</div>
			</div><!--/ Content row end -->
		</div><!--/ Container end -->
	</section><!-- Newsletter end -->
	

	<!-- Footer start -->
	<footer id="footer" class="footer footer2">
		<div class="container">

			<div class="row">
				<!--
				<div class="col-md-4 col-sm-12 footer-widget">
					<h3 class="widget-title">Flickr Photos</h3>

					<div class="img-gallery">
						<div class="img-container">
							<a class="thumb-holder" data-rel="prettyPhoto" href="web/images/gallery/1.jpg">
								<img src="web/images/gallery/1.jpg" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="images/gallery/2.jpg">
								<img src="web/images/gallery/2.jpg" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="images/gallery/3.jpg">
								<img src="images/gallery/3.jpg" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="images/gallery/4.jpg">
								<img src="images/gallery/4.jpg" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="images/gallery/5.jpg">
								<img src="images/gallery/5.jpg" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="images/gallery/6.jpg">
								<img src="images/gallery/6.jpg" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="images/gallery/6.jpg">
								<img src="images/gallery/7.jpg" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="images/gallery/6.jpg">
								<img src="images/gallery/8.jpg" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="images/gallery/6.jpg">
								<img src="images/gallery/9.jpg" alt="">
							</a>
						</div>
					</div>

						
				</div> -->

				<div class="col-md-4 col-sm-12 footer-widget">
					<h3 class="widget-title">Disponibles</h3>

					<ul class="unstyled arrow">
						<li><a href="#">Acerca de Nosotros</a></li>
						<li><a href="#">Como Ayudamos</a></li>
						<li><a href="#">Próximos Eventos</a></li>
						<li><a href="#">Atención al Cliente</a></li>
						<li><a href="#">Registrate</a></li>
						<li><a href="#">Ultimas Noticias</a></li>
						<li><a href="#">Servicios</a></li>
						<li><a href="#">Liquidaciones</a></li>
						<li><a href="#">Próximamente</a></li>
						<li><a href="#">Contáctenos</a></li>
					</ul>
	
				</div><!--/ End Recent Posts-->


				<div class="col-md-3 col-sm-12 footer-widget footer-about-us">
					<h3 class="widget-title">Sobre Nosotroas</h3>
					<p>Somos una empresa de prestamos por garantías.</p>
					<p><strong>Dirección: </strong>Jr. Sebastian de Aliste 209 - Independencia - Huaraz</p>
					<div class="row">
						<div class="col-md-6">
							<strong>Correo: </strong>
							<p>invef123@gmail.com</p>
						</div>
						<div class="col-md-6">
							<strong>Teléfono.</strong>
							<p>+(51) 939214860</p>
						</div>
					</div>
					<br/>
				</div><!--/ end about us -->




			</div><!-- Row end -->
		</div><!-- Container end -->
	</footer><!-- Footer end -->
	

	<!-- Footer start -->
	<section id="copyright" class="copyright angle">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<ul class="footer-social unstyled">
						<li>
							<a title="Facebook" href="#">
								<span class="icon-pentagon wow bounceIn"><i class="fa fa-facebook"></i></span>
							</a>
							<a title="Google+" href="#">
								<span class="icon-pentagon wow bounceIn"><i class="fa fa-google-plus"></i></span>
							</a>
							<a title="Dribble" href="#">
								<span class="icon-pentagon wow bounceIn"><i class="fa fa-whatsapp"></i></span>
							</a>
						</li>
					</ul>
				</div>
			</div><!--/ Row end -->
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="copyright-info">
         			 <span> <a href="https://inforad.net.pe">inforad.net.pe</a></span>
        			</div>
				</div>
			</div><!--/ Row end -->
		   <div id="back-to-top" data-spy="affix" data-offset-top="10" class="back-to-top affix">
				<button class="btn btn-primary" title="Back to Top"><i class="fa fa-angle-double-up"></i></button>
			</div>
		</div><!--/ Container end -->
	</section><!--/ Footer end -->

	<!-- Javascript Files
	================================================== -->

	<!-- initialize jQuery Library -->
	<script type="text/javascript" src="{{asset('web/js/jquery.js')}}"></script>
	<!-- Bootstrap jQuery -->
	<script type="text/javascript" src="{{asset('web/js/bootstrap.min.js')}}"></script>
	<!-- Style Switcher -->
	<script type="text/javascript" src="{{asset('web/js/style-switcher.js')}}"></script>
	<!-- Owl Carousel -->
	<script type="text/javascript" src="{{asset('web/js/owl.carousel.js')}}"></script>
	<!-- PrettyPhoto -->
	<script type="text/javascript" src="{{asset('web/js/jquery.prettyPhoto.js')}}"></script>
	<!-- Bxslider -->
	<script type="text/javascript" src="{{asset('web/js/jquery.flexslider.js')}}"></script>
	<!-- Owl Carousel -->
	<script type="text/javascript" src="{{asset('web/js/cd-hero.js')}}"></script>
	<!-- Isotope -->
	<script type="text/javascript" src="{{asset('web/js/isotope.js')}}"></script>
	<script type="text/javascript" src="{{asset('web/js/ini.isotope.js')}}"></script>
	<!-- Wow Animation -->
	<script type="text/javascript" src="{{asset('web/js/wow.min.js')}}"></script>
	<!-- SmoothScroll -->
	<script type="text/javascript" src="{{asset('web/js/smoothscroll.js')}}"></script>
	<!-- Eeasing -->
	<script type="text/javascript" src="{{asset('web/js/jquery.easing.1.3.js')}}"></script>
	<!-- Counter -->
	<script type="text/javascript" src="{{asset('web/js/jquery.counterup.min.js')}}"></script>
	<!-- Waypoints -->
	<script type="text/javascript" src="{{asset('web/js/waypoints.min.js')}}"></script>
	<!-- Template custom -->
	<script type="text/javascript" src="{{asset('web/js/custom.js')}}"></script>
	</div><!-- Body inner end -->
</body>
</html>