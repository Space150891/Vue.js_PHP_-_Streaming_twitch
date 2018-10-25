function getViewerDetails(token) {
    let formData = new FormData();
    formData.append('viewer_name', viewerName);
    fetch(baseUrl + 'api/viewers/get', {
        method: "POST",
        body: formData,
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        if (jsonResp.errors) {
            location = baseUrl;
        }
        document.getElementById('viewer-name').innerHTML = jsonResp.data.name;
        document.getElementById('viewer-bio').innerHTML = jsonResp.data.bio || '';
        let social = '';
        if (jsonResp.data.social.twitch) {
            social += `
            <li class="list-inline-item">
                <a href="${jsonResp.data.social.twitch}" target="_blank"><i class="mr-2"></i> <img src="${baseUrl + 'assets/images/SuperTinyIcons/svg/twitch.svg'}" height="20" title="Twitch"></a>
            </li>
            `;
        }
        if (jsonResp.data.social.youtube) {
            social += `
            <li class="list-inline-item">
                <a href="${jsonResp.data.social.youtube}" target="_blank"><i class="mr-2"></i> <img src="${baseUrl + 'assets/images/SuperTinyIcons/svg/youtube.svg'}" height="20" title="YouTube"></a>
            </li>
            `;
        }
        if (jsonResp.data.social.twitter) {
            social += `
            <li class="list-inline-item">
                <a href="${jsonResp.data.social.twitter}" target="_blank"><i class="mr-2"></i> <img src="${baseUrl + 'assets/images/SuperTinyIcons/svg/twitter.svg'}" height="20" title="Twitter"></a>
            </li>
            `;
        }
        if (jsonResp.data.social.instagram) {
            social += `
            <li class="list-inline-item">
                <a href="${jsonResp.data.social.instagram}" target="_blank"><i class="mr-2"></i> <img src="${baseUrl + 'assets/images/SuperTinyIcons/svg/instagram.svg'}" height="20" title="Instagram"></a>
            </li>
            `;
        }
        document.getElementById('social-list').innerHTML = social;
        document.getElementById('follower-count').innerHTML = jsonResp.data.follower.length;
        document.getElementById('following-count').innerHTML = jsonResp.data.following.length;
        if (jsonResp.data.back) {
            $('#profile-cover > div:first-of-type').remove();
            $('#profile-cover').prepend(
                `<div class="profile-cover-img" style="background-image: url(${baseUrl + 'storage/' + jsonResp.data.back})">
                </div>`
            );
        }
        if (token) {
            document.getElementById('profile-buttons').innerHTML = `
                <li class="nav-item">
                    <a href="${baseUrl + 'follow/' + viewerName}" class="btn btn-success bg-success-800 btn-labeled btn-labeled-left"><b><i class="icon-heart5"></i></b> Follow</a>
                </li>
                <li class="nav-item">
                    <a href="${baseUrl + 'subscribe/' + viewerName}" type="button" class="btn btn-success bg-success-800 btn-labeled btn-labeled-left ml-1"><b><i class="icon-play"></i></b> Subscribe</a>
                </li>
                <li class="nav-item">
                    <a href="${baseUrl + 'donate/' + viewerName}" class="btn btn-success bg-success-800 btn-labeled btn-labeled-left ml-1"><b><i class="icon-cash2"></i></b> Donate</a>
                </li>
            `;
        }
        renderFollower(jsonResp.data.follower);
        renderFollowing(jsonResp.data.following);
    });
}

function renderFollower(data) {
    let html = '';
    for (let i=0;i<data.length;i++) {
        html += `
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="card-img-actions d-inline-block mb-3">
                            <img class="img-fluid rounded-circle" src="${data[i].avatar || 'https://static-cdn.jtvnw.net/jtv_user_pictures/086a13ac-9237-4605-bcd1-41ce1f79e764-profile_image-70x70.png'}" width="70" height="70" alt="">
                            <div class="card-img-actions-overlay card-img rounded-circle">
                                <a href="${baseUrl + 'profile/' + data[i].name}" class="btn btn-outline bg-white text-white border-white btn-icon rounded-round ">
                                    <i class="icon-link"></i>
                                </a>
                            </div>
                        </div>
                        <h6 class="font-weight-semibold mb-0">${data[i].name}</h6>
                        <span class="d-block text-muted">${data[i].subscription ? 'Streamer':'Viewer'}</span>
                    </div>
                </div>
            </div>
        `;
    }
    document.getElementById('follower-list').innerHTML = html;
}

function renderFollowing(data) {
    let html = '';
    for (let i=0;i<data.length;i++) {
        html += `
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="card-img-actions d-inline-block mb-3">
                            <img class="img-fluid rounded-circle" src="${data[i].avatar || 'https://static-cdn.jtvnw.net/jtv_user_pictures/086a13ac-9237-4605-bcd1-41ce1f79e764-profile_image-70x70.png'}" width="70" height="70" alt="">
                            <div class="card-img-actions-overlay card-img rounded-circle">
                                <a href="${baseUrl + 'profile/' + data[i].name}" class="btn btn-outline bg-white text-white border-white btn-icon rounded-round ">
                                    <i class="icon-link"></i>
                                </a>
                            </div>
                        </div>
                        <h6 class="font-weight-semibold mb-0">${data[i].name}</h6>
                        <span class="d-block text-muted">${data[i].subscription ? 'Streamer':'Viewer'}</span>
                    </div>
                </div>
            </div>
        `;
    }
    document.getElementById('following-list').innerHTML = html;
}

window.onload = function() {
    generateMainMenu();
    const token = localStorage.getItem('userToken') ? localStorage.getItem('userToken') : false;
    // if (!token) {
    //     location = baseUrl;
    // }
    getViewerDetails(token);
    
};






