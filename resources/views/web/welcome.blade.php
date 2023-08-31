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

	<link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
	  <script src="js/respond.min.js"></script>
	  

	  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta charset="utf-8">
      <meta name="keywords" content="REGISTRATE PARA GANAR, Gana un bono de descuento y participa en el gran sorteo navideño.">
      <meta name="description" content="">
      <meta name="page_type" content="np-template-header-footer-from-plugin">
	  <link rel="stylesheet" href=" {{ asset('web/tools/nicepage.css') }}  " media="screen">
      <link rel="stylesheet" href="{{ asset('web/tools/Página-1.css') }}" media="screen">
      <script class="u-script" type="text/javascript" src="{{ asset('web/tools/jquery.js') }}" defer=""></script>
      <script class="u-script" type="text/javascript" src="{{ asset('web/tools/nicepage.js') }}" defer=""></script>
      <meta name="generator" content="Nicepage 2.29.5, nicepage.com">
	  <link id="u-theme-google-font" rel="stylesheet" href="{{ asset('https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i') }}">
	  <script type="application/ld+json">
		{
			"@context": "{{ asset('web/tools/http://schema.org') }}",
			"@type": "Organization",
			"name": "",
			"url": "{{ asset('web/tools/index.html') }}"
		}
	  </script>
	  <meta property="og:title" content="Página 1">
	  <meta property="og:type" content="website">
	  <meta name="theme-color" content="#478ac9">
	  <link rel="canonical" href="{{ asset('web/tools/index.html') }}">
	  <meta property="og:url" content="{{ asset('web/tools/index.html') }}">
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
		                            <li><a href="{{ Route('nosotros') }}">Sobre Nosotros</a></li>
		                            <li><a href="{{ Route('servicios') }}">Servicios</a></li>
		                            <li><a href="{{ Route('preguntas') }}">Preguntas Frecuentes</a></li>
		                        </ul>
	                    	</div>
	                    </li>
						<li class="dropdown">
                       		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Liquidaciones <i class="fa fa-angle-down"></i></a>
                       		<div class="dropdown-menu">
								<ul>
		                            <li><a href="{{ Route('equipos') }}">Equipos</a></li>
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
					@foreach ($banner as $b)
					<li>
						<div class="overlay2">
							<img class="" src="{{ $b->imagen }}" alt="slider">
						</div>
						
					</li>
					@endforeach
					
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
						@foreach ($resumen as $r)
						<li onclick="mostrarResumen('{{ $r->id }}')">
							<a class="animated fadeIn" href="#tab_{{ $r->id }}" data-toggle="tab">
								<span class="tab-icon"><i class="{{ $r->icono }}"></i></span>
								<div class="tab-info">
									<h3>{{ $r->titulo }}</h3>
								</div>
							</a>
						</li>	
						@endforeach
					  	
					</ul>
					<div class="tab-content col-md-9 col-sm-7" id="mostrarDetalleResumen">
						<!--
				        <div class="tab-pane active animated fadeInRight" id="tab_a">
				        	<i class="fa fa-trophy big"></i>
				            <h3>We Are Awwared Winning Company</h3> 
				            <p>Over the year we have lots of experience in our field. In sit amet massa sapien. Vestibulum diam turpis, gravida in lobortis id, ornare a eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sagittis nulla non elit dignissim suscipit. Duis lorem nulla, eleifend.</p>
						</div>
						-->
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
					@foreach ($porQueElegirnos as $pqe)
					<div class="image-block-content">
						<span class="feature-icon pull-left" ><i class="{{ $pqe->icono }}"></i></span>
						<div class="feature-content">
							<h3>{{ $pqe->titulo }}</h3>
							<p>{{ $pqe->descripcion }}</p>
						</div>
					</div>	
					@endforeach
					<!--/ End 1st block -->

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
				@foreach ($caracteristicas as $c)
				<div class="feature-box col-sm-4 wow fadeInDown" data-wow-delay=".5s">
					<span class="feature-icon pull-left" ><i class="{{ $c->icono }}"></i></span>
					<div class="feature-content">
						<h3>{{ $c->titulo }}</h3>
						<p>{{ $c->descripcion }}</p>
					</div>
				</div><!--/ End first featurebox -->
				@endforeach
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
						<a href="{{ Route('servicios') }}" class="btn btn-primary white">Joyas</a>
						<a href="{{ Route('servicios') }}" class="btn btn-primary solid">Electro</a>
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
				<div class="col-md-12 col-md-offset-3">
					<form action="#" method="post" id="newsletter-form" class="newsletter-form wow bounceIn" data-wow-duration=".8s">
						<div class="form-group">
							<a class="btn btn-primary solid" href="{{ Route('cli') }}">Registrar</a>
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
							<a title="Facebook" href="https://www.facebook.com/invef.invef/" target="_blank">
								<span class="icon-pentagon wow bounceIn"><i class="fa fa-facebook"></i></span>
							</a>
							<a title="Instagram" href="https://www.instagram.com/invefsac/?hl=es-la" target="_blank">
								<span class="icon-pentagon wow bounceIn"><i class="fa fa-instagram"></i></span>
							</a>
							<a title="Dribble" href="https://api.whatsapp.com/send?phone=51939214860" target="_blank">
								<span class="icon-pentagon wow bounceIn"><i class="fa fa-whatsapp"></i></span>
							</a>
							<a title="Youtube" href="https://youtube.com/channel/UCOP0OJG3jKevrji6OPKfL9g" target="_blank">
								<span class="icon-pentagon wow bounceIn"><i class="fa fa-youtube-play"></i></span>
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

	<div class="modal inmodal fade" id="mPublicidad" tabindex="-1" role="dialog"  aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content" style="background-color: #003961">
				<div class="modal-body" style="background: url({{ asset('web/tools/images/fondoRegistro.png') }}) no-repeat; background-position: 100% 100%; background-size: 100%;">
					<button type="button" class="close" data-dismiss="modal" style="color: #ffd800;" onclick="cerrarModal()"><span>X</span></button>
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-6">
								<form id="fformulario" name="fformulario" method="" action="" class="formFormulario" enctype="multipart/form-data">
								
								<!--
								<h6 style="text-align: center; color: #F2F4F4">Gana un bono de descuento y participa en el gran sorteo navideño</h6>
								-->
								<div class="form-group">
								    <br>
								    <br>
								    <br>
								    <br>
								    <br>
								    <br>
								    <br>
								    <br>
								    <br>
								    <!--
									<input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
									<input name="nombre" required id="nombre" type="text" placeholder="Nombres y Apellidos" class="form-control" style=" border-radius: 50px; background-color: #F2F4F4; opacity: 90%; box-shadow: 2px 2px 5px #999;">
									-->
								</div>
								<div class="form-group">
								    <!--
									<input name="correo" required id="celular" type="email" placeholder="Correo" class="form-control" style=" border-radius: 50px; background-color: #F2F4F4; opacity: 90%; box-shadow: 2px 2px 5px #999;">
									-->
								</div>
								<div class="form-group">
								    <!--
									<input name="celular" required id="correo" type="tel" placeholder="Número de Celular" class="form-control" style=" border-radius: 50px; background-color: #F2F4F4; opacity: 90%; box-shadow: 2px 2px 5px #999;">
									-->
								</div>
								<div class="form-group" style="text-align: left;">
									<button onclick="registrar()" type="submit" style="border-radius: 50px; background-color: #7f650c; border: #003961 1px solid; color: #ffffff; padding: 10px;">REGISTRATE</button>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	

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
	<script src="{{asset('web/js/snow.js')}}"></script>
	<script src="{{asset('web/js/particles.min.js')}}"></script>

	<script>

		$(document).ready(cargarVentanaFlotante);

		function cargarVentanaFlotante(){
			$('#mPublicidad').modal('show');
		}
		
		function cerrarModal(){
		    $('#mPublicidad').modal('hidden');
		}

		$(document).on("submit",".formFormulario",function(e){
        
			e.preventDefault();
			var formu = $(this);
			var nombreform = $(this).attr("id");
			
			if (nombreform == "fformulario") {
				var miurl = "{{ Route('guardarFormulario') }}";
			}
			var formData = new FormData($("#"+nombreform+"")[0]);
			
			$.ajax({ url: miurl, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
					beforeSend: function(){
					},
					success: function(data){
						$('#mPublicidad').modal('hide');
						toastr.success('Ya se encuentra participando');
					},
					error: function(data) {
					}
			});
		});

		function mostrarResumen(id){
			$.post( "{{ Route('mostrarResumen') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#mostrarDetalleResumen").empty();
                $("#mostrarDetalleResumen").html(data.view);
            });
		}
		
		function registrar(){
			window.location="{{ Route('cli') }}";
		}

	</script>
	</div><!-- Body inner end -->
</body>
</html>