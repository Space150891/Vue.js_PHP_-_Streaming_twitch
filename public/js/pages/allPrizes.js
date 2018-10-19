const onPage = 20;

function getPrizePage(page, rarity, targetId) {
    console.log('try get page', page);
    let formData = new FormData();
    formData.append('on_page', onPage);
    formData.append('page', page);
    formData.append('rarity_class', rarity);
    fetch(baseUrl + 'api/prizes/all', {
        method: "POST",
        credentials: 'omit',
        mode: 'cors',
        body: formData,
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        let html = `<div class="w-100 overflow-hidden"><div class="row">`;
        for (let i=0; i<jsonResp.data.prizes.length; i++) {
            let prize = jsonResp.data.prizes[i];
            html += `
            <div class="card">
                <div class="card-img-actions">
                    <img class="card-img-top img-fluid" src="${baseUrl + 'storage/' + prize.image}" alt="">
                    <div class="card-img-actions-overlay card-img-top">
                    </div>
                </div>
                <div class="card-body bg-dark">
                    <h5 class="card-title font-weight-semibold">${prize.name}</h5>
                    <p class="card-text">${prize.description}</p>
                </div>
                <div class="card-footer d-flex justify-content-between bg-dark">
                    <span class="badge badge-success badge-pill">${prize.winned}</span>
                    <span>
                        <span class="badge badge-danger badge-pill ">${prize.cost} $</span>
                    </span>
                </div>
            </div>
            `;
        }
        html +=`</div>`;
        html += pagination(page, jsonResp.data.pages);
        html +=`</div>`;
        document.getElementById(targetId).innerHTML = html;
    });
}

function pagination(page, pages) {
    const buttons = 5;
    let html = '<ul class="pagination">';
    html += page > 1 ? `<li class="page-item"><a href="#" onclick="getPrizePage(${page-1})" class="page-link"><i class="icon-arrow-small-left"></i></a></li>` : `<li class="page-item"><span class="page-link"><i class="icon-arrow-small-left"></i></span></li>`;
    let list = [];
    const totalButtons = parseInt(buttons > pages ? pages : buttons);
    const middle = parseInt(Math.ceil(totalButtons / 2) - 1);
    if (page <= middle) {
        for (let i = 1; i <= totalButtons; i++) {
            list.push(i);
        }
    } else {
        if (page >= pages - middle) {
            for (let i = pages; i > pages - totalButtons; i--) {
                list.push(i);
            }
            list.reverse();
        } else {
            for (let i = page - middle; i < page - middle + totalButtons; i++) {
                list.push(i);
            }
        }
    }
    for (let i=0; i<list.length; i++) {
        html += list[i] == page ? `<li class="page-item active"><a href="#" onclick="getPrizePage(${list[i]})" class="page-link">${list[i]}</a></li>` :`<li class="page-item"><a href="#" onclick="getPrizePage(${list[i]})" class="page-link">${list[i]}</a></li>`;
    }
    html += page < pages ? `<li class="page-item"><a href="#" onclick="getPrizePage(${page +1})" class="page-link"><i class="icon-arrow-small-left"></i></a></li>` : `<li class="page-item"><span class="page-link"><i class="icon-arrow-small-right"></i></span></li>`;
    html += '</ul>';
    return html;
}

let currentPage = 1;

function setRarity(rarity, targetId) {
    getPrizePage(currentPage, rarity, targetId);
}

window.onload = function() {
    generateMainMenu();
    getPrizePage(1, 'common', 'prices-tier-1');
};
