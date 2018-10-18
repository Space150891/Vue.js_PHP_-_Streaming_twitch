window.onload = function() {
    generateMainMenu();
    let formData = new FormData();
    formData.append('game_name', gameName);
    fetch(baseUrl + 'api/streamers/bygamename', {
        method: "POST",
        credentials: 'omit',
        mode: 'cors',
        body: formData,
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        let html = '';
        for (let i=0; i<jsonResp.data.streamers.length; i++) {
            let streamer = jsonResp.data.streamers[i];
            let avatar = streamer.image ? streamer.image : baseUrl + 'images/tvitch-question.png';
            html += `
                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
                    <div class="card">
                        <a href="${baseUrl + 'stream-watch/' + streamer.name}">
                            <img class="card-img-top img-fluid" src="${avatar}" alt="avatar">
                        </a>
                        <h5 class=" mt-2 ml-1">${streamer.name}</h5>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <span>	<i class="icon-screen3"></i>
                                    <span class="badge badge-pill bg-teal-800 ml-1">${streamer.viewers_count}</span>
                                </span>
                                <span class="justify-content-center">
                                    <i class="icon-cube3"></i>
                                    <span class="badge badge-pill bg-teal-800 ml-1">${streamer.points || 0}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        document.getElementById('streamers-by-game').innerHTML = html;
        // streamers-by-game
    });

};






