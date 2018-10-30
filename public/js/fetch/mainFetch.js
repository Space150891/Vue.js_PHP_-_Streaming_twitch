/**
 * LEFT Main navigation fetch data
 *
 */

// Promoted streamer list
let Profile = false;
{
    fetch('api/streamers/promoted/list', {
    method: "POST",
    credentials: 'omit',
    mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        const promotedData = jsonResp.data.promoted;
        let elemPromoted = document.getElementsByClassName('promoted-data')[0];
        let childrenElPromoted = '';
        for (let i = 0; i < promotedData.length; i++) {
            childrenElPromoted += '<li class="nav-item">' +
                '<a href="/watch-streams/' + promotedData[i].twitch_id + '" class="nav-link">' +
                '<i>' +
                '<img src="https://static-cdn.jtvnw.net/jtv_user_pictures/6d942669-203f-464d-8623-db376ff971e0-profile_image-70x70.png " width="32 " height="32 " class="rounded-circle " alt=" ">' +
                '</i>' +
                '<span class="truncate">' +
                promotedData[i].name +
                '<span class="d-block font-weight-normal opacity-50 truncate">' + promotedData[i].game + '</span>' +
                '</span>' +
                '<span class="ml-3 align-self-center ">' +
                '<span class="badge bg-success text-default badge-pill ml-auto ">' + promotedData[i].viewers + '</span>\n' +
                '</span>' +
                '</a>' +
                '</li>';
        }
        elemPromoted.innerHTML = childrenElPromoted;
    });
}


//Following list

function getFollowed(userToken) {
    let formData = new FormData();
    formData.append('token', userToken);
    fetch('api/myfollowed', {
        method: "POST",
        body: formData,
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        // online
        const followingOnlineData = jsonResp.data.online;
        let elemFollowingOnline = document.getElementsByClassName('following-online-data')[0];
        let childrenElFollowingOnline = '';
        for (let i = 0; i < followingOnlineData.length; i++) {
            childrenElFollowingOnline += '<li class="nav-item">' +
                '<a href="/watch-streams/' + (followingOnlineData.id || i) + '" class="nav-link">' +
                '<i>' +
                '<img src="https://static-cdn.jtvnw.net/jtv_user_pictures/6d942669-203f-464d-8623-db376ff971e0-profile_image-70x70.png " width="32 " height="32 " class="rounded-circle " alt=" ">' +
                '</i>' +
                '<span class="truncate">' +
                (followingOnlineData.name || "James Sunderland") +
                '<span class="d-block font-weight-normal opacity-50 truncate">' + followingOnlineData[i].game + '</span>' +
                '</span>' +
                '<span class="ml-3 align-self-center ">' +
                '<span class="badge bg-success text-default badge-pill ml-auto ">' + followingOnlineData[i].viewers + '</span>\n' +
                '</span>' +
                '</a>' +
                '</li>';
        }
        elemFollowingOnline.innerHTML = childrenElFollowingOnline;
        // offline
        const followingOfflineData = jsonResp.data.offline;
        let elemFollowingOffline = document.getElementsByClassName('following-offline-data')[0];
        let childrenElFollowingOffline = '';
        for (let i = 0; i < followingOfflineData.length; i++) {
            childrenElFollowingOffline += '<li class="nav-item">' +
                '<a href="/watch-streams/' + (followingOfflineData.id || i) + '" class="nav-link">' +
                '<i>' +
                '<img src="https://static-cdn.jtvnw.net/jtv_user_pictures/6d942669-203f-464d-8623-db376ff971e0-profile_image-70x70.png " width="32 " height="32 " class="rounded-circle " alt=" ">' +
                '</i>' +
                '<span class="truncate">' +
                (followingOfflineData.name || "Dr. Hill") +
                '<span class="d-block font-weight-normal opacity-50 truncate">' + followingOfflineData[i].game + '</span>' +
                '</span>' +
                '<span class="ml-3 align-self-center ">' +
                '</span>' +
                '</a>' +
                '</li>';
        }
        elemFollowingOffline.innerHTML = childrenElFollowingOffline;
    });
}

/**
 * MIDDLE main part fetch data (stream windows + chat)
 *
 */


// Stream windows

function getMainContent() {
    fetch('api/streamers/main/show', {
        method: "POST",
        credentials: 'omit',
        mode: 'cors',
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        let elemIframeWrap = document.getElementsByClassName('iframe-wrap')[0];
        let elemIframeChat = document.getElementsByClassName('iframe-chat')[0];
        let elemChatWrap = document.getElementsByClassName('chat-main-wrap')[0];
        let elemUsersCount = document.getElementsByClassName('users-count')[0];
        let elemCubeCount = document.getElementsByClassName('cube-count')[0];
        let iframeHeight = elemChatWrap.offsetHeight;
        let iframeWidth = elemChatWrap.offsetWidth;
        const iframeData = jsonResp.data;
        let childrenIframeWrap = '<iframe class="embed-responsive-item" src="http://player.twitch.tv/?channel=' + iframeData.name + '&autoplay=false"></iframe>';
        let childrenIframeChat = '<iframe id="chat" src="https://www.twitch.tv/embed/' + iframeData.name + '/chat" style="height: ' + iframeHeight + 'px; width:' +iframeWidth+ 'px;" frameBorder="0"></iframe>';
        let childrenUsersCount = '<span class="badge badge-pill bg-danger-800 position-static">' + iframeData.viewers + '</span>';
        let childrenCubeCount = '<span class="badge badge-pill bg-success-800 position-static">' + iframeData.points + '</span>';
        elemIframeWrap.innerHTML = childrenIframeWrap;
        elemIframeChat.innerHTML = childrenIframeChat;
        elemUsersCount.innerHTML = childrenUsersCount;
        elemCubeCount.innerHTML = childrenCubeCount;
    });
}

/**
 *  RIGHT sidebar part fetch data
 *
 */

// List of first elements

{
    fetch('api/history/boxes/list', {
        method: "POST",
        credentials: 'omit',
        mode: 'cors',
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        const feedcontainerData = jsonResp.data.cases;
        let elemFeedcontainer = document.getElementsByClassName('feedcontainer')[0];
        let elemSidebarWrap = document.getElementsByClassName('sidebar-wrap')[0];
        let parentElementHeight = elemSidebarWrap.clientHeight;
        elemSidebarWrap.classList.remove('ps');
        elemSidebarWrap.classList.add('sidebar-hover-wrap');
        let num = (Math.floor(parentElementHeight/64) - 1) > feedcontainerData.length ? feedcontainerData.length : Math.floor(parentElementHeight/64) - 1;
        for (let i = 0; i < num; i++) {
            let newElement = document.createElement('li');
            newElement.classList.add('feedcontainer-item');
            newElement.innerHTML= renderHistoryBox(feedcontainerData[i]);
            elemFeedcontainer.appendChild(newElement);

        }

    })

}


// Next element

{

    setInterval(function () {
        fetch('api/history/boxes/last', {
            method: "POST",
            credentials: 'omit',
            mode: 'cors',
        }).then(function(res){
            return res.json();
        }).then(function(jsonResp){
            let feedcontainerDataNew = jsonResp.data.cases;

            if (feedcontainerDataNew) {
                let newElement = document.createElement('li');
                newElement.classList.add('feedcontainer-item');
                let elemFeedcontainer = document.getElementsByClassName('feedcontainer')[0];
                newElement.innerHTML= renderHistoryBox(feedcontainerDataNew);
                elemFeedcontainer.removeChild(elemFeedcontainer.firstChild);
                elemFeedcontainer.appendChild(newElement);
                // elemFeedcontainer.appendChild(newElement);
            }
        })
    }, 5000);
}

function renderHistoryBox(box) {
    let info = '';
    switch (box.type) {
        case 'hero':
            info = `<p><b>Won</b> a ${box.rarity_class} ${box.name} artwork<p>`;
            break;
        case 'frame':
            info = `<p><b>Won</b> a ${box.rarity_class} ${box.name} frame<p>`;
            break;
        case 'diamonds':
            info = `<p><b>Won</b> ${box.count} diamonds<p>`;
            break;
        case 'points':
            info = `<p><b>Won</b> ${box.count} points<p>`;
            break;
        case 'prize':
            info = `<p><b>Won</b> a ${box.name} worth ${box.cost} USD<p>`;
            break;
        default:
            break;
    }
    return `
        <img src="storage/` + box.box_image + `" height="64" alt="">
        <div class="description">
            <div class="description-up">
                <img style="height: 32px" src="https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg" alt="">
                <p> ${box.viewer} </p>
                <div class="description-triangle"></div>
            </div>
            <div class="description-down">
                ${info}
            </div>
        </div>
    `;
}

function getMainMenuContent(userToken) {
    let formData = new FormData();
    formData.append('token', userToken);
    fetch('api/profile/current', {
        method: "POST",
        body: formData,
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        Profile = jsonResp.data;
        let notificationsHtml = '';
        for (let i = 0; i < jsonResp.data.notifications.length; i++ ) {
            notificationsHtml += `
                <li class="media">
                    <div class="mr-3">
                        <img src="global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                    </div>
                    <div class="media-body">
                        <div class="media-title">
                            <a href="#">
                                <span class="font-weight-semibold">${jsonResp.data.notifications[i].title}</span>
                                <span class="text-muted float-right font-size-sm">Mon</span>
                            </a>
                        </div>
                        <span class="text-muted">${jsonResp.data.notifications[i].message}</span>
                    </div>
                </li>
            `;
        }
        let historyPointsHtml = '';
        for (let i = 0; i < jsonResp.data.history_points.length; i++ ) {
            historyPointsHtml += `
                <li class="media">
                    <div class="media-body">
                        <div class="media-title">
                            <span class="font-weight-semibold">${jsonResp.data.history_points[i].title} :</span>
                            <span class="text-muted font-size-sm">${jsonResp.data.history_points[i].points}</span>
                        </div>
                        <span class="text-muted">${jsonResp.data.history_points[i].description}</span>
                    </div>
                </li>
            `;
        }
        let boxTypes = '';
        for (let i = 0; i < jsonResp.data.case_types.length; i++ ) {
            boxTypes += `
                <li class="media">
                    <div class="mr-3 position-relative">
                        <img src="storage/${jsonResp.data.case_types[i].image}" height="64" alt="">
                    </div>
                    <div class="media-body">
                        <div class="media-title">
                            <a href="" data-toggle="modal" data-target="#modal_iconified">
                                <span class="font-weight-semibold">${jsonResp.data.case_types[i].rarity_class} StreamCase</span>
                                <span class="text-muted float-right font-size-sm">${jsonResp.data.case_types[i].price}</span>
                            </a>
                        </div>
                        <span class="text-muted">${jsonResp.data.case_types[i].description}</span>
                    </div>
                </li>
            `;
        }
        let html = `<li class="nav-item dropdown">
                   <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                   <i class="icon-stats-growth"></i>
                   <span class="badge badge-pill bg-danger-800 position-static ml-auto ml-md-1"> ${jsonResp.data.last_points} </span>
                    </a>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                        <div class="dropdown-content-header">
                            <span class="font-weight-semibold">You currenctly earn ${jsonResp.data.last_points} Credits per Minute!</span>
                        </div>
                        <!-- <div class="dropdown-content-body dropdown-scrollable custom-scrollbar"> -->
                        <div class="dropdown-content-body dropdown-scrollable">
                            <ul class="media-list">
                                ${historyPointsHtml}
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                        <i class="icon-cube3"></i>
                        <span class="badge badge-pill bg-teal-800 position-static ml-auto ml-md-1">${jsonResp.data.points}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                        <div class="dropdown-content-header">
                            <span class="font-weight-semibold">Buy StreamCases</span>
                            <i class="icon-cube3"></i>
                        </div>
                        <div class="dropdown-content-body dropdown-scrollable">
                            <ul class="media-list">
                                ${boxTypes}
                            </ul>
                        </div>
                        <div class="dropdown-content-footer justify-content-center p-0">
                            <a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Store"><i class="icon-store d-block top-0"></i></a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="navbar-nav-link caret-0">
                        <i class="icon-diamond"></i>
                        <span class="badge badge-pill bg-teal-800 position-static ml-auto ml-md-1">${jsonResp.data.diamonds}</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    ${jsonResp.data.notifications.length == 0 ? '<a href="#" class="navbar-nav-link dropdown-toggle caret-0">' : '<a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">'}
                        <i class="icon-bubbles4"></i>
                        <span class="d-md-none ml-2">Notifications</span>
                        <span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">${jsonResp.data.notifications.length > 0 ? jsonResp.data.notifications.length : ""}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                        <div class="dropdown-content-header">
                            <span class="font-weight-semibold">Notifications</span>
                            <a href="#" class="text-default"><i class="icon-compose"></i></a>
                        </div>
                        <div class="dropdown-content-body dropdown-scrollable">
                            <ul class="media-list">
                                ${notificationsHtml}
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
                        <img src="${jsonResp.data.avatar}" height="32" class="rounded-circle" alt="avatar">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="/profile/dlausch/index.html" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a>
                        <a href="/profile/dlausch/inventory.html" class="dropdown-item"><i class="icon-file-text2"></i> Inventory</a>
                        <!-- If User is Viewer (FREE) -->
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">Account Type:	&nbsp;
                        <span class="badge bg-danger font-size-sm font-weight-bold position-static ml-auto">
                        ${jsonResp.data.subscription ? jsonResp.data.subscription : 'Viewer'}
                        </span></a>
                        <a href="#" class="dropdown-item">Level:	&nbsp;	<span class="badge bg-success font-size-sm font-weight-bold position-static ml-auto "> ${jsonResp.data.level}  </span></a>
                        ${jsonResp.data.subscription ? '' : '<div class="dropdown-divider"></div><a href="upgrade" class="row justify-content-center p-0 text-center"><span class="badge bg-danger font-size-sm font-weight-bold">Upgrade to Streamer</span></a>'}
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
        document.getElementsByClassName('auth-user')[0].innerHTML = html;
        document.getElementById('reflink').value = "http://dev.streamcases.tv/api/afiliate/" + jsonResp.data.id;
    });
}

function paginationAuth(page, pages, func, token) {
    const buttons = 5;
    let html = '<ul class="pagination">';
    html += page > 1 ? `<li class="page-item"><a href="#" onclick="${func}(${page-1},${token})" class="page-link"><i class="icon-arrow-small-left"></i></a></li>` : `<li class="page-item"><span class="page-link"><i class="icon-arrow-small-left"></i></span></li>`;
    let list = [];
    const totalButtons = parseInt(buttons > pages ? pages : buttons);
    const middle = parseInt(Math.ceil(totalButtons / 2) - 1);
    if (page <= middle) {
        for (let i = 1; i <= totalButtons; i++) {
            list.push(i);
        }
    } else {
        if (page >= pages - middle) {
            for (let i = pages; i > pages - totalButtons; i--) {
                list.push(i);
            }
            list.reverse();
        } else {
            for (let i = page - middle; i < page - middle + totalButtons; i++) {
                list.push(i);
            }
        }
    }
    for (let i=0; i<list.length; i++) {
        html += list[i] == page ? `<li class="page-item active"><a href="#" onclick="${func}(${list[i]},${token})" class="page-link">${list[i]}</a></li>` :`<li class="page-item"><a href="#" onclick="${func}(${list[i]},${token})" class="page-link">${list[i]}</a></li>`;
    }
    html += page < pages ? `<li class="page-item"><a href="#" onclick="${func}(${page +1},${token})" class="page-link"><i class="icon-arrow-small-left"></i></a></li>` : `<li class="page-item"><span class="page-link"><i class="icon-arrow-small-right"></i></span></li>`;
    html += '</ul>';
    return html;
}