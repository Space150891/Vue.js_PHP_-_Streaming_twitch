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

function streamInfo(streamName) {
    var formData = new FormData();
    formData.append('channel', streamName);
    fetch(baseUrl + 'api/stream/info', {
        method: "POST",
        credentials: 'omit',
        mode: 'cors',
        body: formData,
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        document.getElementById('view-stream-points').innerHTML = jsonResp.data.points;
        document.getElementById('view-stream-viewers').innerHTML = jsonResp.data.viewers;
    });
}

window.onload = function() {
    const token = localStorage.getItem('userToken') ? localStorage.getItem('userToken') : false;
    for (i=0;i<watchingStreamers.length;i++) {
        streamInfo(watchingStreamers[i]);
    }
    if (token) {
        this.timer = setInterval(function() {
            for (i=0;i<watchingStreamers.length;i++) {
                watchStream(token, watchingStreamers[i]);
            }
            }, 1000 * 60); // one minute 
    }
    generateMainMenu();
};






