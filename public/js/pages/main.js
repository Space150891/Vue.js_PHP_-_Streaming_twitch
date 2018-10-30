function getMainContent() {
    fetch(baseUrl + 'api/streamers/main/show', {
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
        document.getElementById('main-stream-name').innerHTML = `Stream of ${iframeData.name}`;
        document.getElementById('main-twitch-link').innerHTML = `
                                            <a href="http://twitch.tv/${iframeData.name}" target="_blank">
                                                <i class="mr-1"></i>
                                                <img src="assets/images/SuperTinyIcons/svg/twitch.svg" height="20" title="Twitch">
                                            </a>
        `;
        document.getElementById('main-twitch-subscribe').innerHTML = `
        <a href="http://www.twitch.tv/${iframeData.name}/subscribe" target="_blank" type="button" class="btn btn-success bg-success-800 btn-labeled btn-labeled-left"><b><i class="icon-play"></i></b> Subscribe</a>
        `;
        document.getElementById('main-twitch-donate').innerHTML = `
        <a href="${baseUrl + 'dotate/' + iframeData.name}" target="_blank" type="button" class="btn btn-success bg-success-800 btn-labeled btn-labeled-left"><b><i class="icon-cash2"></i></b> Donate</a>
        `;
        document.getElementById('main-twitch-follow').innerHTML = `
        <a href="${baseUrl + 'follow/' + iframeData.name}" target="_blank" type="button" class="btn btn-success bg-success-800 btn-labeled btn-labeled-left"><b><i class="icon-heart5"></i></b> Follow</a>
        `;
    });
}

function getLastPrizes() {
    fetch(baseUrl + 'api/prizes/last', {
        method: "POST",
        credentials: 'omit',
        mode: 'cors',
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        let html = '';
        for (let i=0; i<jsonResp.data.prizes.length; i++) {
            let prize = jsonResp.data.prizes[i];
            html += `
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-img-actions mx-1 mt-1">
                            <img class="card-img img-fluid" src="${baseUrl + 'storage/' + prize.image}" alt="prize">
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-start flex-nowrap">
                                <div>
                                    <h6 class="font-weight-semibold mr-2">Winner: ${prize.viewer}</h6>
                                    <h6 class="font-weight-semibold mr-2">${prize.description}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-start flex-nowrap">
                                <div>
                                    <h6 class="font-weight-semibold mr-2">Worth ${prize.cost}$</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        document.getElementById('winned-prizes').innerHTML = html;
    });
}

function getNewPrizes() {
    fetch(baseUrl + 'api/prizes/new', {
        method: "POST",
        credentials: 'omit',
        mode: 'cors',
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        let html = '';
        for (let i=0; i<jsonResp.data.prizes.length; i++) {
            let prize = jsonResp.data.prizes[i];
            html += `
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-img-actions mx-1 mt-1">
                            <img class="card-img img-fluid" src="${baseUrl + 'storage/' + prize.image}" alt="">
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-start flex-nowrap">
                                <div>
                                    <h6 class="font-weight-semibold mr-2">${prize.name}</h6>
                                    <span>${prize.description}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        document.getElementById('new-prizes').innerHTML = html;
    });
}

window.onload = function() {
    generateMainMenu();
    getMainContent();
    getLastPrizes();
    getNewPrizes();
    $('#modal_welcome').modal();
};






