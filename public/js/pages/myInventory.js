function getMyInventory(userToken) {
    let formData = new FormData();
        formData.append('token', userToken);
        fetch(baseUrl + 'api/viewer/my-inventory', {
            method: "POST",
            body: formData,
            credentials: 'omit',
            mode: 'cors'
        }).then(function(res){
            return res.json();
        }).then(function(jsonResp){
            // renderCases(jsonResp.data.cases);
            // renderPrizes(jsonResp.data.prizes);
            // renderFrames(jsonResp.data.frames);
            // renderArtworks(jsonResp.data.heroes);
            // renderAchievements(jsonResp.data.achievements);
        });
}

function getMyCases(casePage, userToken) {
    let formData = new FormData();
    formData.append('token', userToken);
    formData.append('page', casePage);
    formData.append('on_page', 6);
    fetch(baseUrl + 'api/cases/inventory', {
        method: "POST",
        body: formData,
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        let html = '';
        for (let i=0;i<jsonResp.data.cases.length;i++) {
            let box = jsonResp.data.cases[i];
            if (box.opened_at) {
                let history = ``;
                switch (box.history.type) {
                    case 'hero':
                        history = `<h3 class="mb-0 font-weight-semibold ">${box.history.name}</h3>
                        <h6 class="text-green-800 font-weight-bold">${box.history.rarity_class} Artwork</h6>`;
                        break;
                    case 'frame':
                        history = `<h3 class="mb-0 font-weight-semibold ">${box.history.name}</h3>
                        <h6 class="text-purple-800 font-weight-bold">${box.history.rarity_class} Frame</h6>`;
                        break;
                    case 'prize':
                        history = `<h3 class="mb-0 font-weight-semibold ">${box.history.name}</h3>
                        <h6 class="text-blue-800 font-weight-bold">${box.history.rarity_class} Prize</h6>`;
                        break;
                    case 'points':
                        history = `<h6 class="text-primary-800 font-weight-bold">${box.history.count} Points</h6>`;
                        break;
                    case 'diamonds':
                        history = `<h6 class="text-primary-800 font-weight-bold">${box.history.count} Diamonds</h6>`;
                        break;
                    default:
                        break;
                }
                html += `
                <div class="col-xl-2 col-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title text-muted text-center">${box.origin}</div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <img src="${baseUrl + 'storage/' + box.image}" height="64" data-toggle="modal" data-target="#modal_iconified">
                            </div>
                        </div>
                        <div class="card-body bg-light text-center">
                            <div class="mb-2">
                                <h6 class="font-weight-semibold mb-0">
                                    <a href="#" class="text-default">${box.name} StreamCase</a>
                                </h6>
                                <hr>
                            </div>
                            ${history}
                            <button type="button" class="btn bg-teal-400 mt-1" data-toggle="modal" data-target="#modal_price_1847782873">Details</button>
                        </div>
                    </div>
                </div>
                `;

            } else {
                html += `
                <div class="col-xl-2 col-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title text-muted text-center">${box.origin}</div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <img src="${baseUrl + 'storage/' + box.image}" height="64" data-toggle="modal" data-target="#modal_iconified">
                            </div>
                        </div>
                        <div class="card-body bg-light text-center">
                            <div class="mb-2">
                                <h6 class="font-weight-semibold mb-0">
                                    <a href="#" onclick="openBoxStart(${box.id})" class="text-default">${box.name} StreamCase</a>
                                </h6>
                                <hr>
                            </div>
                            <button type="button" class="btn bg-danger-400">Open</button>
                        </div>
                    </div>
                </div>
                `;
            }
        }
        document.getElementById('streamcases-list').innerHTML = html;
        document.getElementById('streamcases-pagination').innerHTML = paginationAuth(jsonResp.data.page, jsonResp.data.pages, 'getMyCases', userToken);
    });
}

window.onload = function() {
    generateMainMenu();
    const token = localStorage.getItem('userToken') ? localStorage.getItem('userToken') : false;
    if (!token) {
        location = baseUrl;
    }
    getMyCases(1, token);
};






