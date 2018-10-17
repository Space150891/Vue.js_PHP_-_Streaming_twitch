window.onload = function() {
    generateMainMenu();
    fetch('api/games/list', {
        method: "POST",
        credentials: 'omit',
        mode: 'cors',
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        console.log('games', jsonResp.data.games);
        let gamesHtml = '';
        for (let i=0;i<jsonResp.data.games.length;i++) {
            let game = jsonResp.data.games[i];
            gamesHtml += `
            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
                <div class="card">
                    <a href="#">
                    <img class="card-img-top img-fluid" src="${game.avatar}" alt="">
                    </a>
                    <h5 class=" mt-2 ml-1">${game.name}</h5>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <span>	<i class="icon-screen3"></i>
                                <span class="badge badge-pill bg-teal-800 ml-1">${game.streamers}</span>
                            </span>
                            <span class="justify-content-center">
                                <i class="icon-user"></i>
                                <span class="badge badge-pill bg-teal-800 ml-1">${game.viewers}</span>
                            </span>
                        </div>

                    </div>
                </div>
            </div>
            `;
        }
        document.getElementById('games-list').innerHTML = gamesHtml;
    });

};






