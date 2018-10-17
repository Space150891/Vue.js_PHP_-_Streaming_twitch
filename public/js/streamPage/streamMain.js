
window.onload = function() {

    // MAIN NAVBAR
    const elemAuthUser = document.getElementsByClassName('auth-user')[0];
    let noToken = `<li class="nav-item">
                  <a href="twitch/redirect" class="navbar-nav-link log-in">LogIn</a>
                  </li>`;
    let isToken = `<li class="nav-item dropdown">
                   <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                   <i class="icon-stats-growth"></i>
                   <span class="badge badge-pill bg-danger-800 position-static ml-auto ml-md-1"> </span>
                    </a>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                        <div class="dropdown-content-header">
                            <span class="font-weight-semibold">You currenctly earn 630 Credits per Minute!</span>
                        </div>
                        <!-- <div class="dropdown-content-body dropdown-scrollable custom-scrollbar"> -->
                        <div class="dropdown-content-body dropdown-scrollable">
                            <ul class="media-list">
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">
                                            <span class="font-weight-semibold">Viewcount: </span>
                                            <span class="text-muted font-size-sm">200</span>

                                        </div>
                                        <span class="text-muted">Based on the viewer count of this Channel.</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">
                                            <span class="font-weight-semibold">Type: </span>
                                            <span class="text-muted font-size-sm">20</span>
                                        </div>
                                        <span class="text-muted">Based on the account Type of this Channel.</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">
                                            <span class="font-weight-semibold">Subscribe: </span>
                                            <span class="text-muted font-size-sm">10</span>
                                        </div>
                                        <span class="text-muted">Subscribed with a "Tier 2 Sub" to this channel.</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">
                                            <span class="font-weight-semibold">Donation: </span>
                                            <span class="text-muted font-size-sm">50</span>
                                        </div>
                                        <span class="text-muted">Because you donated 50$ to this channel.<p><b>INFO FOR DEV: You get direct 10 Credits per CENT when donating as reward so like 10 euro = 10000 credits!</b></p></span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">
                                            <span class="font-weight-semibold">Promoted: </span>
                                            <span class="text-muted font-size-sm">100</span>
                                        </div>
                                        <span class="text-muted">This channel is currenctly in promoted state.</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">
                                            <span class="font-weight-semibold">Affiliate: </span>
                                            <span class="text-muted font-size-sm">250</span>
                                        </div>
                                        <span class="text-muted">You earn extra Credits for your refered Viewers that are currenctly farming Credits.</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                        <i class="icon-cube3"></i>
                        <span class="badge badge-pill bg-teal-800 position-static ml-auto ml-md-1"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                        <div class="dropdown-content-header">
                            <span class="font-weight-semibold">Buy StreamCases</span>
                            <i class="icon-cube3"></i>
                        </div>
                        <div class="dropdown-content-body dropdown-scrollable">
                            <ul class="media-list">
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="assets/images/case_types/common.png" height="64" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="" data-toggle="modal" data-target="#modal_iconified">
                                                <span class="font-weight-semibold">Common StreamCase</span>
                                                <span class="text-muted float-right font-size-sm">5000</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">The most cool Case ever. Can make you damn rich!</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="assets/images/case_types/uncommon.png" height="64" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Uncommon StreamCase</span>
                                                <span class="text-muted float-right font-size-sm">5000</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">The most cool Case ever. Can make you damn rich!</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="assets/images/case_types/rare.png" height="64" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Rare StreamCase</span>
                                                <span class="text-muted float-right font-size-sm">5000</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">The most cool Case ever. Can make you damn rich!</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="assets/images/case_types/epic.png" height="64" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Epic StreamCase</span>
                                                <span class="text-muted float-right font-size-sm">5000</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">The most cool Case ever. Can make you damn rich!</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="assets/images/case_types/legendary.png" height="64" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Legendary StreamCase</span>
                                                <span class="text-muted float-right font-size-sm">5000</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">The most cool Case ever. Can make you damn rich!</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown-content-footer justify-content-center p-0">
                            <a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Store"><i class="icon-store d-block top-0"></i></a>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                        <i class="icon-diamond"></i>
                        <span class="badge badge-pill bg-teal-800 position-static ml-auto ml-md-1"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                        <div class="dropdown-content-header">
                            <span class="font-weight-semibold">Buy Diamonds</span>
                            <i class="icon-diamond"></i>
                        </div>
                        <!-- <div class="dropdown-content-body dropdown-scrollable custom-scrollbar"> -->
                        <div class="dropdown-content-body dropdown-scrollable">
                            <ul class="media-list">
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="assets/images/case_types/gold_xxx.png" height="64" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Gold Pack</span>
                                                <span class="text-muted float-right font-size-sm">5000</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">The most cool Case ever. Can make you damn rich!</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="assets/images/case_types/gold_xxx.png" height="64" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Gold Pack</span>
                                                <span class="text-muted float-right font-size-sm">5000</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">The most cool Case ever. Can make you damn rich!</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown-content-footer justify-content-center p-0">
                            <a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Store"><i class="icon-store d-block top-0"></i></a>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                        <i class="icon-bubbles4"></i>
                        <span class="d-md-none ml-2">Notifications</span>
                        <span class="badge badge-pill bg-warning-400 ml-auto ml-md-0"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                        <div class="dropdown-content-header">
                            <span class="font-weight-semibold">Notifications</span>
                            <a href="#" class="text-default"><i class="icon-compose"></i></a>
                        </div>
                        <div class="dropdown-content-body dropdown-scrollable">
                            <ul class="media-list">
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Achievement Unlocked</span>
                                                <span class="text-muted float-right font-size-sm">04:58</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">Speak about StreamCases.tv</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Level up!</span>
                                                <span class="text-muted float-right font-size-sm">12:16</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">You reached Level 12</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3">
                                        <img src="global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Jeremy Victorino</span>
                                                <span class="text-muted float-right font-size-sm">22:48</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">But that would be extremely strained and suspicious...</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3">
                                        <img src="global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Beatrix Diaz</span>
                                                <span class="text-muted float-right font-size-sm">Tue</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">What a strenuous career it is that I've chosen...</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3">
                                        <img src="global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Richard Vango</span>
                                                <span class="text-muted float-right font-size-sm">Mon</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">Other travelling salesmen live a life of luxury...</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown-content-footer justify-content-center p-0">
                            <a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Load more"><i class="icon-menu7 d-block top-0"></i></a>
                            <a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="All notifications"><i class="icon-newspaper d-block top-0"></i></a>
                        </div>
                    </div>
                </li>
                <!-- If User is logged in -->
                <li class="nav-item dropdown dropdown-user">
                    <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg" height="32" class="rounded-circle" alt="">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="/profile/dlausch/index.html" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a>
                        <a href="/profile/dlausch/inventory.html" class="dropdown-item"><i class="icon-file-text2"></i> Inventory</a>
                        <!-- If User is Viewer (FREE) -->
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">Account Type:	&nbsp;	</i> <span class="badge bg-danger font-size-sm font-weight-bold position-static ml-auto"> Viewer </span></a>
                        <a href="#" class="dropdown-item">Level:	&nbsp;	</i> <span class="badge bg-success font-size-sm font-weight-bold position-static ml-auto "> 12 </span></a>
                        <div class="dropdown-divider"></div>
                        <a href="upgrade" class="row justify-content-center p-0 text-center"><span class="badge bg-danger font-size-sm font-weight-bold">Upgrade to Streamer</span></a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="row justify-content-center p-0 text-center" ><span class="badge bg-success-800 font-size-sm font-weight-bold" data-toggle="modal" data-target="#modal_ref">Referal Link</span></a>
                        <div class="dropdown-divider"></div>
                        <a href="profile/dlausch/index.html" class="dropdown-item "><i class="icon-cog5 "></i> Account</a>
                        <a href="logout" class="dropdown-item "><i class="icon-switch2 "></i> Logout</a>
                    </div>
                </li>
                <li class="nav-item">
                    &nbsp;
                </li>
    
    `;

    let elemFollowingItems = document.getElementsByClassName('following-items-part')[0];
    const token = localStorage.getItem('userToken') ? localStorage.getItem('userToken') : false;
    if (token) {
        getFollowed(token);
        elemFollowingItems.style.display = 'block';
        // elemAuthUser.innerHTML = isToken;
        getMainMenuContent(token);
    } else {
        elemFollowingItems.style.display = 'none';
        elemAuthUser.innerHTML = noToken;
    }

};






