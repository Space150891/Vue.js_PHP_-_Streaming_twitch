let caseId = 0;

function getCases() {
    fetch(baseUrl + 'api/cases/types/list', {
        method: "POST",
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        console.log('CASES', jsonResp);
        let html = `<div class="row">`;
        for (let i=0; i<jsonResp.data.caseTypes.length; i++) {
            html += generateCase(jsonResp.data.caseTypes[i]);
        }
        html += `</div>`;
        document.getElementById('streamcases').innerHTML = html;
    });
}

function generateCase(box) {
    return  `
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <li class="media">
                        <div class="mr-3 position-relative">
                            <img src="${baseUrl + 'storage/' + box.image}" height="64"  alt="">
                                        </div>
                            <div class="media-body">
                                <div class="media-title">

                                    <span class="font-weight-semibold">${box.rarity_class} StreamCase</span>

                                </div>
                                <span class="text-muted">${box.description}</span>
                            </div>
                    </li>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-xl-6 col-sm-12">
                            <span class="text-muted">Sold: ${box.sold}</span>
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <div class="list-icons float-right">
                                <button class="btn bg-green-800 btn-labeled btn-labeled-left" onclick="modalBuy('${box.rarity_class}', ${box.id})"><b><i class="icon-cart"></i></b>
                                    <span class="font-weight-semibold pr-1">${box.price}</span> <i class="icon-cube3"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

}

function modalBuy(rarityClass, id) {
    caseId = id;
    document.getElementById('buy-case-name').innerHTML = rarityClass;
    document.getElementById('buy-case-body').innerHTML = '';
    $('#modal_buy_case').modal();
}

function buyCase() {
    // console.log('buying case' + caseId);
    var formData = new FormData();
    const token = localStorage.getItem('userToken') ? localStorage.getItem('userToken') : false;
    formData.append('id', caseId);
    formData.append('token', token);
    formData.append('valute', 'coins');
    
    fetch(baseUrl + 'api/cases/buy', {
        method: "POST",
        credentials: 'omit',
        mode: 'cors',
        body: formData,
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        if (jsonResp.errors && jsonResp.errors[0] == 'Unauthenticated.') {
            document.getElementById('buy-case-body').innerHTML = '<p style="color:#f00">Only users can Buy cases</p>';
        } else {
            if (jsonResp.errors) {
                let html = '<p style="color:#f00">Error!</p>';
                for (let i = 0; i < jsonResp.errors.length; i++) {
                    html += `<p style="color:#f00">${jsonResp.errors[i]}</p>`;
                }
                document.getElementById('buy-case-body').innerHTML = html;
            } else {
                let html = `<p style="color:#0f0">${jsonResp.message}</p>`;
                document.getElementById('buy-case-body').innerHTML = html;
            }
        }
    });
}

window.onload = function() {
    generateMainMenu();
    getCases();

};






