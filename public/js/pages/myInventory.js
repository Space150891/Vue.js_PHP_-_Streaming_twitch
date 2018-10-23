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

function getMyPrizes(page, userToken) {
    let formData = new FormData();
    formData.append('token', userToken);
    formData.append('page', page);
    formData.append('on_page', 6);
    fetch(baseUrl + 'api/prizes/inventory', {
        method: "POST",
        body: formData,
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        let html = '';
        for (let i=0;i<jsonResp.data.prizes.length;i++) {
            let prize = jsonResp.data.prizes[i];
            html += `
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-img-actions">
                        <img class="card-img-top img-fluid" src="${baseUrl + 'storage/' + prize.image}" alt="prize">
                        <div class="card-img-actions-overlay card-img-top">
                            <a href="#" class="btn btn-outline bg-white text-white border-white border-2 ml-2" data-toggle="modal" data-target="#modal_price_0000000002">
                                Details
                            </a>
                        </div>
                    </div>
                    <div class="card-body  bg-dark">
                        <h5 class="card-title font-weight-semibold">${prize.name}</h5>
                        <p class="card-text">${prize.description}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-dark">
                        <span>
                            <a href="${baseUrl + 'redeem/' + prize.id}" target="_self" class="btn bg-green-800 btn-labeled btn-labeled-left"><b><i class="icon-cart"></i></b>Redeem</a>
                        </span>
                        <span class="justify-content-center pt-2">
                            <span class="badge badge-danger badge-pill">${prize.cost} $</span>
                        </span>
                    </div>
                </div>
            </div>
            `;
        }
        document.getElementById('prizes-list').innerHTML = html;
        document.getElementById('prizes-pagination').innerHTML = paginationAuth(jsonResp.data.page, jsonResp.data.pages, 'getMyPrizes', userToken);
    });
}

function getMyFrames(page, userToken) {
    let formData = new FormData();
    formData.append('token', userToken);
    formData.append('page', page);
    formData.append('on_page', 4);
    fetch(baseUrl + 'api/frames/inventory', {
        method: "POST",
        body: formData,
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        let html = '';
        for (let i=0;i<jsonResp.data.frames.length;i++) {
            let frame = jsonResp.data.frames[i];
            html += `
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="mb-0 font-weight-semibold ">${frame.title}</h3>
                        <div class="mb-0 font-weight-semibold">${frame.description || ''}</div>
                        <hr>
                    </div>
                    <div class="text-center">
                        <img class="img-fluid" src="${baseUrl + 'storage/' + frame.image}">
                            </div>
                            <div class="card-body bg-light text-center">
                                <hr>
                                <h6 class="font-weight-semibold mb-0">
                                <h6 class="font-weight-bold">${frame.class} Frame</h6>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
        }
        document.getElementById('frames-list').innerHTML = html;
        document.getElementById('frames-pagination').innerHTML = paginationAuth(jsonResp.data.page, jsonResp.data.pages, 'getMyFrames', userToken);
    });
}

function getMyHeroes(page, userToken) {
    let formData = new FormData();
    formData.append('token', userToken);
    formData.append('page', page);
    formData.append('on_page', 4);
    fetch(baseUrl + 'api/heroes/inventory', {
        method: "POST",
        body: formData,
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        let html = '';
        for (let i=0;i<jsonResp.data.heroes.length;i++) {
            let hero = jsonResp.data.heroes[i];
            html += `
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="mb-0 font-weight-semibold ">${hero.title}</h3>
                        <div class="mb-0 font-weight-semibold">${hero.description || ''}</div>
                        <hr>
                    </div>
                    <div class="text-center">
                        <img class="img-fluid" src="${baseUrl + 'storage/' + hero.image}">
                    </div>
                    <div class="card-body bg-light text-center">
                        <hr>
                        <h6 class="font-weight-bold ${getColorByRarity(hero.class)}">${hero.class} Artwork</h6>
                    </div>
                </div>
            </div>
            `;
        }
        document.getElementById('heroes-list').innerHTML = html;
        document.getElementById('heroes-pagination').innerHTML = paginationAuth(jsonResp.data.page, jsonResp.data.pages, 'getMyHeroes', userToken);
    });
}

function getMyAchievements(page, userToken) {
    let formData = new FormData();
    formData.append('token', userToken);
    formData.append('page', page);
    formData.append('on_page', 4);
    fetch(baseUrl + 'api/achievements/inventory', {
        method: "POST",
        body: formData,
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        let html = '';
        for (let i=0;i<jsonResp.data.achievements.length;i++) {
            let achievement = jsonResp.data.achievements[i];
            if (achievement.type == 'basic' && achievement.unlocked_at) {
                const image = achievement.image ? baseUrl + 'storage/' + achievement.image : baseUrl + 'images/tvitch-question.png';
                html += `
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <li class="media">
                                <div class="mr-3 position-relative">
                                    <img src="${image}" width="36" height="36" class="rounded-circle" alt="achievemet">
                                </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <span class="font-weight-semibold">${achievement.name}</span>
                                        </div>
                                        <span class="text-muted">${achievement.description}</span>
                                    </div>
                            </li>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-xl-6 col-sm-12">
                                    <span class="text-muted">Unlocked: ${achievement.unlocked_at}</span>
                                </div>
                                <div class="col-xl-6 col-sm-12">
                                    <div class="list-icons float-right">
                                        <i class="icon-cube3 ml-0"></i> <span class="badge badge-pill bg-teal-800 position-static">${achievement.points}</span>
                                        <i class="icon-diamond ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">${achievement.diamonds}</span>
                                        <i class="icon-stack-empty ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">${achievement.frame_rarity}</span>
                                        <i class="icon-stack4 ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">${achievement.hero_rarity}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
                `;
            }
            if (achievement.type == 'basic' && !achievement.unlocked_at) {
                let progres = Math.round(achievement.total_steps / achievement.done_steps);
                const image = achievement.image ? baseUrl + 'storage/' + achievement.image : baseUrl + 'images/tvitch-question.png';
                html += `
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <li class="media">
                                <div class="mr-3 position-relative">
                                    <img src="${image}" width="36" height="36" class="rounded-circle" alt="achievemet">
                                </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <span class="font-weight-semibold">${achievement.name}</span>
                                        </div>
                                        <span class="text-muted">${achievement.description}</span>
                                    </div>
                            </li>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-xl-6 col-sm-12">
                                    <div class="progress" id="h-fill-basic">
                                        <div class="progress-bar progress-bar-striped" data-transitiongoal-backup="${progres}" data-transitiongoal="${progres}" style="width: ${progres}%">
                                            <span class="text-white font-weight-semibold">${progres}%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-sm-12">
                                    <div class="list-icons float-right">
                                        <i class="icon-cube3 ml-0"></i> <span class="badge badge-pill bg-teal-800 position-static">${achievement.points}</span>
                                        <i class="icon-diamond ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">${achievement.diamonds}</span>
                                        <i class="icon-stack-empty ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">${achievement.frame_rarity}</span>
                                        <i class="icon-stack4 ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">${achievement.hero_rarity}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            }
            if (achievement.type == 'custom') {
                html += `
                
                `;
            }
        }
        document.getElementById('achievements-list').innerHTML = html;
        document.getElementById('achievements-pagination').innerHTML = paginationAuth(jsonResp.data.page, jsonResp.data.pages, 'getMyAchievements', userToken);
    });
}

function getColorByRarity(rarity) {
    switch (rarity) {
        case 'Uncommon':
            return 'text-green-800';
        case 'Legendary':
            return 'text-orange-800';
        case 'Rare':
            return 'text-blue-800';
        case 'Epic':
            return 'text-purple-800';
        default:
            return '';
    }
}

window.onload = function() {
    generateMainMenu();
    const token = localStorage.getItem('userToken') ? localStorage.getItem('userToken') : false;
    if (!token) {
        location = baseUrl;
    }
    getMyCases(1, token);
    document.getElementById('prizes-but').onclick = getMyPrizes(1, token);
    document.getElementById('frames-but').onclick = getMyFrames(1, token);
    document.getElementById('heroes-but').onclick = getMyHeroes(1, token);
    document.getElementById('achievemets-but').onclick = getMyAchievements(1, token);
};






