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
								<iframe class="embed-responsive-item" src="http://player.twitch.tv/?channel={{ $streamName }}&autoplay=false"></iframe>
							</div>
						</div>
						<div class="card-footer bg-dark d-sm-flex justify-content-sm-between align-items-sm-center py-sm-2">
							<h4 class="font-weight-semibold">Stream of {{ $streamName }}</h4>
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
									<a href="http://twitch.tv/{{$streamName}}" target="_blank">
										<i class="mr-1"></i>
										<img src="{{asset('assets/images/SuperTinyIcons/svg/twitch.svg')}}" height="20" title="Twitch">
									</a>
								</li>
								<li class="list-inline-item">
									<a href="http://youtube.com/" target="_blank">
										<i class="mr-1"></i>
										<img src="{{asset('assets/images/SuperTinyIcons/svg/youtube.svg')}}" height="20" title="YouTube">
									</a>
								</li>
								<li class="list-inline-item">
									<a href="https://twitter.com/{{$streamName}}" target="_blank">
										<i class="mr-1"></i>
										<img src="{{asset('assets/images/SuperTinyIcons/svg/twitter.svg')}}" height="20" title="Twitter">
									</a>
								</li>
								<li class="list-inline-item">
									<a href="http://instagram.com/" target="_blank">
										<i class="mr-0"></i>
										<img src="{{asset('assets/images/SuperTinyIcons/svg/instagram.svg')}}" height="20" title="Instagram">
									</a>
								</li>
							</ul>

							<ul class="list-inline list-inline-condensed-margin mb-0 mt-2 mt-sm-0 d-none d-md-block">

								<li class="list-inline-item">
									<button type="button" class="btn btn-success bg-success-800 btn-labeled btn-labeled-left">
										<b><i class="icon-heart5"></i></b> Follow</button>
								</li>
								<li class="list-inline-item">
									<a href="http://www.twitch.tv/{{$streamName}}/subscribe" target="_blank" type="button" class="btn btn-success bg-success-800 btn-labeled btn-labeled-left"><b><i class="icon-play"></i></b> Subscribe</a>
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
									<a href="http://www.twitch.tv/{{$streamName}}/subscribe" target="_blank" type="button" class="btn btn-success bg-success-800">Subscribe</a>
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
								<iframe id="chat" src="https://www.twitch.tv/embed/{{$streamName}}/chat" frameBorder="0"></iframe>
							</div>
						</div>
						<!-- /sidebar search -->
					</div>
					<!-- /sidebar content -->
				</div>
				<!-- /right sidebar component -->
			</div>
			<!-- /inner container -->
		</div>
		<!-- /content area -->
	</div>


@endsection

@section('footer_scripts')
	<script>
		const watchingStreamers = ["{{$streamName}}"];
	</script>
    <script src="{{asset('js/pages/watchStream.js')}}"></script>
@endsection