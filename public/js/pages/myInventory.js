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
                            <button type="button" class="btn bg-teal-400 mt-1" onclick="getBoxDetails('${userToken}',${box.id})">Details</button>
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
                                    <a href="#"  class="text-default">${box.name} StreamCase</a>
                                </h6>
                                <hr>
                            </div>
                            <button type="button" class="btn bg-danger-400" onclick="getBoxWin('${userToken}', ${box.id})">Open</button>
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
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">
                                            <span class="font-weight-semibold">${achievement.description}</span>
                                        </div>
                                    </div>
                            </li>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-xl-6 col-sm-12">
                                    <span class="text-muted">Unlocked: ${achievement.unlocked_at}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
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

function getBoxWin(userToken, boxId) {
    let formData = new FormData();
    formData.append('token', userToken);
    formData.append('viewer_case_id', boxId);
    fetch(baseUrl + 'api/cases/get', {
        method: "POST",
        body: formData,
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        
        document.getElementById('will-box-points').innerHTML = goodInt(jsonResp.data.all.points);
        document.getElementById('will-box-diamonds').innerHTML = goodInt(jsonResp.data.all.diamonds);
        document.getElementById('will-box-prize').innerHTML = goodInt(jsonResp.data.all.prize);
        document.getElementById('will-box-hero').innerHTML = goodInt(jsonResp.data.all.hero);
        document.getElementById('will-box-frame').innerHTML = goodInt(jsonResp.data.all.frame);
        document.getElementById('will-box-name').innerHTML = goodInt(jsonResp.data.all.box);
        document.getElementById('will-box-image').innerHTML = `<img src="${baseUrl + 'storage/' + jsonResp.data.all.box_image}" style="width: 42%;"><div class="ew-center-empty" style="width:42%; height:42%">`;
        document.getElementById('will-spin-but').style.cssText = `display:block`;
        $('#modal_weel').modal();
        document.getElementById('will-spin-but').onclick = function() {
            document.getElementById('will-spin-but').style.cssText = `display:none`;
            spinWill(userToken, boxId);
        }
    });
}

function spinWill(userToken, boxId) {
    
    let formData = new FormData();
    formData.append('token', userToken);
    formData.append('viewer_case_id', boxId);
    fetch(baseUrl + 'api/cases/open', {
        method: "POST",
        body: formData,
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        getMyCases(1, userToken);
        let win = jsonResp.data.win;
        let deg = 149;
        let step = 60;
        switch (win.type) {
            case 'prize':
                deg -= step;
                break;
            case 'nothing':
                deg -= step * 2;
                break;
            case 'points':
                deg -= step * 3;
                break;
            case 'diamonds':
                deg -= step * 4;
                break;
            case 'hero':
                deg -= step * 5;
                break;
            case 'frame':
                deg -= step * 6;
                break;
        }
        deg = deg < 0 ? deg + 360 : deg;
        let i = 0;
        let loops = 1;
        let timer = setInterval( () => {
            if (i > 360) {
                i = 0;
                loops -= 1;
            }
            if (i > deg && loops == 0) {
                clearInterval(timer);
            }
            document.getElementById('main-weel').style.cssText = `transform: rotate(${i}deg)`;
            i += 1;
        }, 5);
    });
}

function getBoxDetails(userToken, boxId) {
    let formData = new FormData();
    formData.append('token', userToken);
    formData.append('viewer_case_id', boxId);
    fetch(baseUrl + 'api/case/history', {
        method: "POST",
        body: formData,
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        let history = jsonResp.data.history;
        document.getElementById('box-history-name').innerHTML = history.box_rarity;
        let html = '';
        switch (history.type) {
            case 'nothing':
                html = '<h2 class="text-center">nothing<h2>';
                break;
            case 'hero':
                html = `
                    <div>
                        <h3 class="text-center">${history.rarity_class} Artwork</h3>
                        <h3 class="text-center">${history.description || ''}</h3>
                        <img src="${baseUrl + 'storage/' + history.image}" alt="artwork" style="display:block;margin:0 auto;width: 300px;">
                    </div>
                `;
                break;
            case 'frame':
                html = `
                    <div>
                        <h3 class="text-center">${history.rarity_class} Frame</h3>
                        <h3 class="text-center">${history.description || ''}</h3>
                        <img src="${baseUrl + 'storage/' + history.image}" alt="frame" style="display:block;margin:0 auto;width: 300px;">
                    </div>
                `;
                break;
            case 'prize':
                html = `
                    <div>
                        <h3 class="text-center">${history.rarity_class} Frame</h3>
                        <h3 class="text-center">${history.description || ''}</h3>
                        <img src="${baseUrl + 'storage/' + history.image}" alt="frame" style="display:block;margin:0 auto;width: 300px;">
                        <h2 class="text-center">${history.cost} $</h2>
                    </div>
                `;
                break;
            case 'diamonds':
                html = `<h2 class="text-center text-success">${history.count} <i class="icon-diamond"></i></h2>`;
                break;
            case 'points':
                html = `<h2 class="text-center text-success">${history.count} <i class="icon-cube3"></i></h2>`;
                break;
        }
        document.getElementById('box-history-details').innerHTML = html;
        $('#modal-box-details').modal();
    });
}

window.onload = function() {
    generateMainMenu();
    const token = localStorage.getItem('userToken') ? localStorage.getItem('userToken') : false;
    if (!token) {
        location = baseUrl;
    }
    getMyCases(1, token);
    document.getElementById('prizes-but').onclick = function() {getMyPrizes(1, token)};
    document.getElementById('frames-but').onclick = function() {getMyFrames(1, token)};
    document.getElementById('heroes-but').onclick = function() {getMyHeroes(1, token)};
    document.getElementById('achievements-but').onclick = function() {getMyAchievements(1, token)};
};






