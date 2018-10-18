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
    });
}

window.onload = function() {
    console.log('main js');
    generateMainMenu();
    getMainContent();
    $('#modal_welcome').modal();
};






