function paginationAuth(page, pages, func, token) {
    const buttons = 5;
    let html = '<ul class="pagination">';
    html += page > 1 ? `<li class="page-item"><a href="#" onclick="${func}(${page-1},'${token}')" class="page-link"><i class="icon-arrow-small-left"></i></a></li>` : `<li class="page-item"><span class="page-link"><i class="icon-arrow-small-left"></i></span></li>`;
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
        html += list[i] == page ? `<li class="page-item active"><a href="#" onclick="${func}(${list[i]},'${token}')" class="page-link">${list[i]}</a></li>` :`<li class="page-item"><a href="#" onclick="${func}(${list[i]},'${token}')" class="page-link">${list[i]}</a></li>`;
    }
    html += page < pages ? `<li class="page-item"><a href="#" onclick="${func}(${page +1},'${token}')" class="page-link"><i class="icon-arrow-small-right"></i></a></li>` : `<li class="page-item"><span class="page-link"><i class="icon-arrow-small-right"></i></span></li>`;
    html += '</ul>';
    return html;
}

function goodInt(nStr)
{
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function commonAlert(textHeader, textBody) {
    document.getElementById('total-alert-header').innerHTML = textHeader;
    document.getElementById('total-alert-body').innerHTML = textBody;
    $('#total-alert').modal();
}

function renderPrize(prize, redeem=false) {
    console.log('REDEEM', redeem);
    let redeemHtml = ``;
    if (redeem) {
        redeemHtml = `
        <span><a href="${baseUrl + 'redeem/' + prize.id}" target="_self" class="btn bg-green-800 btn-labeled btn-labeled-left"><b><i class="icon-cart"></i></b>Redeem</a>
        `;
    }
    let modalLink='';
    if (redeem) {
        modalLink = `modalPrize(${prize.id}, ${redeem})`;
    } else {
        modalLink = `modalPrize(${prize.id})`;
    }
    return `
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-img-actions">
                <img class="card-img-top img-fluid" src="${baseUrl + 'storage/' + prize.image}" style="width:380px;height:380px" alt="ppize">
                <div class="card-img-actions-overlay card-img-top">
                    <a href="#" class="btn btn-outline bg-white text-white border-white border-2 ml-2" data-toggle="modal" data-target="#modal_prize" onclick="${modalLink}">
                        Details
                    </a>
                </div>
            </div>
            <div class="card-body  bg-dark">

                <h5 class="card-title font-weight-semibold">${prize.name}</h5>
                <p class="card-text">Type: <b>${prize.type}</b></p>
                <p class="card-text">${prize.manufacturer ? 'Brand: <b>' + prize.manufacturer + '</b>' : ''} </p>
            </div>

            <div class="card-footer d-flex justify-content-between bg-dark">
                ${redeemHtml}
                </span>
                <span class="justify-content-center pt-2">
                    <span class="badge badge-danger badge-pill">${prize.cost}$</span>

                </span>
            </div>
        </div>
    </div>
    `;
}

function modalPrize(prizeId, redeem = false){
    
    let formData = new FormData();
    formData.append('id', prizeId);
    fetch(baseUrl + 'api/store/prizes/get', {
        method: "POST",
        credentials: 'omit',
        mode: 'cors',
        body: formData,
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        prize = jsonResp.data.prize;
        document.getElementById('prize-modal-title').innerHTML = prize.name;
        let videoHtml = '';
        if (prize.video_url) {
            videoHtml = `<div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="${prize.video_url}" frameborder="0" allowfullscreen=""></iframe>
            </div><hr>`;
        }
        let webHtml = '';
        if (prize.website_url) {
            webHtml = `
            <a href="${prize.website_url}" target="_blank" class="btn bg-teal-400 btn-labeled btn-labeled-left">
                <b><i class="icon-link"></i></b>Website
            </a>
            `;
        }
        let manufacturerHtml = ``;
        if (prize.type == 'CD-Key') {
            if (prize.store_url && prize.manufacturer) {
                manufacturerHtml = `
                <a href="${prize.store_url}" target="_blank" class="btn bg-teal-400 btn-labeled btn-labeled-left">
                    <b><i class="icon-link"></i></b>${prize.manufacturer}
                </a>
                `;
            }
        }
        let html = `
            ${videoHtml}
            ${webHtml}
            ${manufacturerHtml}
        `;
        document.getElementById('prize-modal-body').innerHTML = html;
        if (redeem) {
            const redeemHtml = `
            <a href="${baseUrl + 'redeem/' + redeem}" target="_self" class="btn bg-green-800 btn-labeled btn-labeled-left"><b><i class="icon-cart"></i></b>Redeem</a>
            `;
            document.getElementById('prize-modal-redeem').innerHTML = redeemHtml;
        }
    });
}