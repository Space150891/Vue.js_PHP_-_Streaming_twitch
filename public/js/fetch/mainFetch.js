/**
 * LEFT Main navigation fetch data
 *
 */

// Promoted streamer list

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


//Following list online

{
    let formData = new FormData();
    let userToken = localStorage.getItem('userToken');
    formData.append('token', userToken);
    fetch('api/myfollowed', {
        method: "POST",
        body: formData,
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        const followingOnlineData = jsonResp.data.online;
        let elemFollowingOnline = document.getElementsByClassName('following-online-data')[0];
        let childrenElFollowingOnline = '';
        for (let i = 0; i < 3; i++) {
            childrenElFollowingOnline += '<li class="nav-item">' +
                '<a href="/watch-streams/' + (followingOnlineData.id || i) + '" class="nav-link">' +
                '<i>' +
                '<img src="https://static-cdn.jtvnw.net/jtv_user_pictures/6d942669-203f-464d-8623-db376ff971e0-profile_image-70x70.png " width="32 " height="32 " class="rounded-circle " alt=" ">' +
                '</i>' +
                '<span class="truncate">' +
                (followingOnlineData.name || "James Sunderland") +
                '<span class="d-block font-weight-normal opacity-50 truncate">' + (followingOnlineData.game || "Silent Hill 2")+ '</span>' +
                '</span>' +
                '<span class="ml-3 align-self-center ">' +
                '<span class="badge bg-success text-default badge-pill ml-auto ">' + (followingOnlineData.viewers || 0) + '</span>\n' +
                '</span>' +
                '</a>' +
                '</li>';
        }
        elemFollowingOnline.innerHTML = childrenElFollowingOnline;
    });
}


//Following list offline

{
    let formData = new FormData();
    let userToken = localStorage.getItem('userToken');
    formData.append('token', userToken);
    fetch('api/myfollowed', {
        method: "POST",
        body: formData,
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
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
                '<span class="d-block font-weight-normal opacity-50 truncate">' + (followingOfflineData.game || "UNTIL DAWN")+ '</span>' +
                '</span>' +
                '<span class="ml-3 align-self-center ">' +
                '<span class="badge bg-success text-default badge-pill ml-auto ">' + (followingOfflineData.viewers || 0) + '</span>\n' +
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

{
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
    let formData = new FormData();
    let userToken = localStorage.getItem('userToken');
    formData.append('token', userToken);
    fetch('api/history/boxes/list', {
        method: "POST",
        credentials: 'omit',
        body: formData,
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
        let num = Math.floor(parentElementHeight/64);

        for (let i = 0; i < num-1; i++) {
            let newElement = document.createElement('li');
            newElement.classList.add('feedcontainer-item');
            let childrenfeedcontainer = `
                <img src="assets/images/` + feedcontainerData[i].box_image + `" height="64" alt="">
                <div class="description">
                    <div class="description-up">
                        <img style="height: 32px" src="https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg" alt="">
                        <p>` + feedcontainerData[i].viewer + `</p>
                        <div class="description-triangle"></div>
                    </div>
                    <div class="description-down">
                        <p><b>Won</b> a Headset worth <b>` + feedcontainerData[i].count + `$</b></p>
                    </div>
                </div>`;
            newElement.innerHTML= childrenfeedcontainer;
            elemFeedcontainer.appendChild(newElement);

        }


    })

}


// Next element

{

    setInterval(function () {
        let formData = new FormData();
        let userToken = localStorage.getItem('userToken');
        formData.append('token', userToken);
        fetch('api/history/boxes/last', {
            method: "POST",
            credentials: 'omit',
            body: formData,
            mode: 'cors',
        }).then(function(res){
            return res.json();
        }).then(function(jsonResp){
            let feedcontainerDataNew = jsonResp.data.cases;
            let elemContent = '';

            let newElement = document.createElement('li');
            newElement.classList.add('feedcontainer-item');

            let elemFeedcontainer = document.getElementsByClassName('feedcontainer')[0];
            console.log(elemFeedcontainer);

            if (feedcontainerDataNew) {

                elemContent = `
                    <img src="assets/images/` + feedcontainerDataNew.box_image + `" height="64" alt="">
                    <div class="description">
                        <div class="description-up">
                            <img style="height: 32px" src="https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg" alt="">
                            <p>` + feedcontainerDataNew.viewer + `</p>
                            <div class="description-triangle"></div>
                        </div>
                        <div class="description-down">
                            <p><b>Won</b> a Headset worth <b> 3030303$</b></p>
                        </div>
                    </div>`;
                newElement.innerHTML= elemContent;
                elemFeedcontainer.removeChild(elemFeedcontainer.firstChild);
                elemFeedcontainer.appendChild(newElement);
                // elemFeedcontainer.appendChild(newElement);
            }
        })
    },5000)
}
