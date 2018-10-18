function watchStream(token, streamName) {
    var formData = new FormData();
    formData.append('token', token);
    formData.append('channels', streamName);
    fetch(baseUrl + 'api/activity/update', {
        method: "POST",
        credentials: 'omit',
        mode: 'cors',
        body: formData,
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        getMainMenuContent(token);
    });
}

window.onload = function() {
    const token = localStorage.getItem('userToken') ? localStorage.getItem('userToken') : false;
    if (token) {
        this.timer = setInterval(function() {
            for (i=0;i<watchingStreamers.length;i++) {
                watchStream(token, watchingStreamers[i]);
            }
            }, 1000 * 60); // one minute 
    }
    generateMainMenu();
};






