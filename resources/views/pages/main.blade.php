@extends('layouts.app')

@section('content')

	<!-- Main content -->
	<div class="content-wrapper">
		<!-- Content area -->
		<div class="content">
			<!-- Inner container -->
			<div class="d-flex align-items-start flex-column flex-md-row">
				<!-- Left content -->
				<div class="w-100 order-2 order-md-1">
					<!-- Basic card -->
					<div class="card stream">
						<div class="card-body-no-padding">
							<div class="embed-responsive embed-responsive-16by9 iframe-wrap">
								<iframe class="embed-responsive-item" src="http://player.twitch.tv/?channel=ur2eztv&autoplay=false"></iframe>
							</div>
						</div>
						<div class="card-footer bg-dark d-sm-flex justify-content-sm-between align-items-sm-center py-sm-2">
							<h4 class="font-weight-semibold">Stream of Ur2EzTv</h4>
							<ul class="list-inline list-inline-condensed-margin mb-0 mt-2 mt-sm-0">
								<!-- DEV INFO VIEWER COUNT -->
								<li class="list-inline-item pl-2">
									<i class="icon-users users-count"></i>

								</li>
								<!-- DEV INFO REWARD COUNT -->
								<li class="list-inline-item pl-2">
									<i class="icon-cube3 cube-count"></i>

								</li>
								<li class="list-inline-item pl-2 d-none d-md-inline">
									<a class="navbar-toggler sidebar-main-toggle">
										<i class="icon-enlarge6"></i>
									</a>
								</li>
							</ul>
						</div>
						<div class="card-footer bg-dark d-sm-flex justify-content-sm-between align-items-sm-center py-sm-2">
							<ul class="list-inline list-inline-condensed-margin-social mb-0">
								<li class="list-inline-item">
									<a href="http://twitch.tv/ur2eztv" target="_blank">
										<i class="mr-1"></i>
										<img src="assets/images/SuperTinyIcons/svg/twitch.svg" height="20" title="Twitch">
									</a>
								</li>
								<li class="list-inline-item">
									<a href="http://youtube.com/" target="_blank">
										<i class="mr-1"></i>
										<img src="assets/images/SuperTinyIcons/svg/youtube.svg" height="20" title="YouTube">
									</a>
								</li>
								<li class="list-inline-item">
									<a href="https://twitter.com/ur2eztv" target="_blank">
										<i class="mr-1"></i>
										<img src="assets/images/SuperTinyIcons/svg/twitter.svg" height="20" title="Twitter">
									</a>
								</li>
								<li class="list-inline-item">
									<a href="http://instagram.com/" target="_blank">
										<i class="mr-0"></i>
										<img src="assets/images/SuperTinyIcons/svg/instagram.svg" height="20" title="Instagram">
									</a>
								</li>
							</ul>

							<ul class="list-inline list-inline-condensed-margin mb-0 mt-2 mt-sm-0 d-none d-md-block">

								<li class="list-inline-item">
									<button type="button" class="btn btn-success bg-success-800 btn-labeled btn-labeled-left">
										<b><i class="icon-heart5"></i></b> Follow</button>
								</li>
								<li class="list-inline-item">
									<a href="http://www.twitch.tv/ur2eztv/subscribe" target="_blank" type="button" class="btn btn-success bg-success-800 btn-labeled btn-labeled-left"><b><i class="icon-play"></i></b> Subscribe</a>
								</li>
								<li class="list-inline-item ">
									<button type="button" class="btn btn-success bg-success-800 btn-labeled btn-labeled-left"><b><i class="icon-cash2"></i></b> Donate</button>
								</li>
							</ul>
							<ul class="list-inline list-inline-condensed-margin mb-0 mt-2 mt-sm-0 d-md-none">
								<li class="list-inline-item">
									<button type="button" class="btn btn-success bg-success-800">Follow</button>
								</li>
								<li class="list-inline-item">
									<a href="http://www.twitch.tv/ur2eztv/subscribe" target="_blank" type="button" class="btn btn-success bg-success-800">Subscribe</a>
								</li>
								<li class="list-inline-item ">
									<button type="button" class="btn btn-success bg-success-800">Donate</button>
								</li>
							</ul>
						</div>
					</div>
					<!-- /basic card -->
				</div>
				<!-- /left content -->
				<!-- bg-transparent -->
				<!-- Right sidebar component -->
				<div class="sidebar sidebar-light sidebar-component sidebar-component-right order-1 order-md-2 sidebar-expand-md border-0 shadow-0 chat-main-wrap">
					<!-- Sidebar content -->
					<div class="sidebar-content">
						<!-- Sidebar search -->
						<div class="card">
							<div class="card-body-no-padding iframe-chat">
								{{--<iframe id="chat" src="https://www.twitch.tv/embed/ur2eztv/chat" frameBorder="0"></iframe>--}}
							</div>
						</div>
						<!-- /sidebar search -->
					</div>
					<!-- /sidebar content -->
				</div>
				<!-- /right sidebar component -->
			</div>
			<!-- /inner container -->

			<div class="card">
				<div class="card-header bg-white">
					<h6 class="card-title">
						Recent Loots
					</h6>
				</div>
				<div class="card-body">
					<div class="row"  id="winned-prizes">

					</div>
				</div>
			</div>


			<div class="card">
				<div class="card-header bg-white">
					<h6 class="card-title">
						Recently added Prices
				</h6>
			</div>
			<div class="card-body">
				<div class="row" id="new-prizes">

					
				</div>
			</div>
		</div>
		</div>
		<!-- /content area -->
	</div>

	<!-- welcome modal -->
	<div id="modal_welcome" class="modal fade " tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content bg-dark">
				<div class="modal-header bg-teal">
					<h5 class="modal-title">Welcome to StreamCases.tv!</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<h6 class="font-weight-semibold">What is StreamCases.tv?</h6>
					<p>StreamCases.tv is a Streamer promotion platform that helps Streamers to grow.</p>
					<p>Users that watch Streams on StreamCases.tv get rewarded by Credits and other stuff. </p>
					<p>Credits can be used to buy StreamCases.</p>
					<hr>
					<p>StreamCases can contain Credits, Diamonds, Frames, Artwork or Prices worth up to around <b>$2000!</b></p>
					<p>Farming Credits and other stuff as a Viewer is completely free!</p>
					<hr>
					<p>To use this Platform as a Streamer, you have to make a subscription on StreamCases.tv!</p>
					<hr>
					<b>
						<p>StreamCases.tv is in "Public Test Stage", incomplete and under heavy development!</p>
						<p>Viewers and Streamers that try our Platform now and help us therefore in any way with testing, by reporting bugs, making suggestions etc., will get rewarded when the platform goes live!</p>
						<hr>
						<p>Winning of Prices is possible before the platform goes live but they are not real. It´s enabled just for demonstration and testing purpose. You can´t win prices for real and therefore also not redeeming them yet!</p>
					</b>
					<button type="button" class="btn bg-teal-800">More information about Testing</button>
				</div>
				<div class="modal-footer">

					<!-- <button type="button" class="btn bg-danger-800">Learn more about Streaming</button>
					<button type="button" class="btn bg-success-800">Learn more about Viewing</button> -->
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				</div>


			</div>
		</div>
	</div>
	<!-- /welcome modal -->

@endsection

@section('footer_scripts')
    <script src="js/pages/main.js"></script>
@endsection