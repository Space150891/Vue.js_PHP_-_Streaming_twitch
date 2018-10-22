function getCabinetData(userToken) {
    let formData = new FormData();
    formData.append('token', userToken);
    fetch(baseUrl + 'api/profile/current', {
        method: "POST",
        body: formData,
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        accauntInfo(jsonResp.data.subscription);
    });
}

function accauntInfo(subscription) {
    if (!subscription) {
        return `
            <div class="card-body">
                <h5 class="card-title">
                    <a href="#" class="text-default">
                        Account overview
                    </a>
                </h5>
                <p class="mb-3">You have a Free account. To become a Streamer you have to upgrade your Account!</p>
            </div>

            <div class="card-footer text-center">
                <a href="${baseUrl + 'upgrade'}" class="btn bg-danger">
                    Upgrade to Streamer
                </a>
            </div>
        `;
    }
    let html = `
        <div class="card-body">
            <h5 class="card-title">
                <a href="#" class="text-default">
                    Account overview
                </a>
            </h5>
            <p class="mb-3">You have a ${subscription} account. You are able to upgrade your Account to gain more features!</p>
            <ul class="list list-unstyled mb-0">
    `;
    switch (subscription) {
        case 'basic':
            html += `
            <li>
                <i class="icon-circle text-danger mr-2"></i> 5 Credits per Minute
            </li>
            <li>
                <i class="icon-circle text-danger mr-2"></i> 10 Credits per Minute
            </li>
            <li>
                <i class="icon-checkmark-circle text-success mr-2"></i> 55 Credits per Minute
            </li>
            <li>
                <i class="icon-checkmark-circle text-success mr-2"></i> Custom Donation Page
            </li>
            <li>
                <i class="icon-checkmark-circle text-success mr-2"></i> Own Achievement
            </li>
            <li>
                <i class="icon-checkmark-circle text-success mr-2"></i> Own Rare Artwork
            </li>
            <li>
                <i class="icon-circle text-danger mr-2"></i> Own Epic Artwork
            </li>
            <li>
                <i class="icon-circle text-danger mr-2"></i> Own Legendary Artwork
            </li>
            `;
            break;
        case 'advanced':
            html += `
            <li>
                <i class="icon-circle text-danger mr-2"></i> 5 Credits per Minute
            </li>
            <li>
                <i class="icon-checkmark-circle text-success mr-2"></i> 10 Credits per Minute
            </li>
            <li>
                <i class="icon-circle text-danger mr-2"></i> 55 Credits per Minute
            </li>
            <li>
                <i class="icon-checkmark-circle text-success mr-2"></i> Custom Donation Page
            </li>
            <li>
                <i class="icon-checkmark-circle text-success mr-2"></i> Own Achievement
            </li>
            <li>
                <i class="icon-circle text-danger mr-2"></i> Own Rare Artwork
            </li>
            <li>
                <i class="icon-checkmark-circle text-success mr-2"></i> Own Epic Artwork
            </li>
            <li>
                <i class="icon-circle text-danger mr-2"></i> Own Legendary Artwork
            </li>
            `;
            break;
        case 'gold':
            html += `
            <li>
                <i class="icon-circle text-danger mr-2"></i> 5 Credits per Minute
            </li>
            <li>
                <i class="icon-circle text-danger mr-2"></i> 10 Credits per Minute
            </li>
            <li>
                <i class="icon-checkmark-circle text-success mr-2"></i> 55 Credits per Minute
            </li>
            <li>
                <i class="icon-checkmark-circle text-success mr-2"></i> Custom Donation Page
            </li>
            <li>
                <i class="icon-checkmark-circle text-success mr-2"></i> Own Achievement
            </li>
            <li>
                <i class="icon-circle text-danger mr-2"></i> Own Rare Artwork
            </li>
            <li>
                <i class="icon-circle text-danger mr-2"></i> Own Epic Artwork
            </li>
            <li>
                <i class="icon-checkmark-circle text-success mr-2"></i> Own Legendary Artwork
            </li>
            `;
            break;
    }
    html += `
        </ul>
    </div>
    <div class="card-footer text-center">
        <a href="${baseUrl + 'upgrade'}" class="btn bg-danger">
            Upgrade
        </a>
    </div>
    `;
    document.getElementById('accaunt-abilities-list').innerHTML = html;
}

function getViewerDetails(userToken) {
    let formData = new FormData();
    formData.append('token', userToken);
    fetch(baseUrl + 'api/viewers/current', {
        method: "POST",
        body: formData,
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        getCities(jsonResp.data.contacts.country_id);
        document.getElementById('contact-name').value = jsonResp.data.name;
        document.getElementById('viewer-name').innerHTML = jsonResp.data.name;
        document.getElementById('viewer-bio').innerHTML = jsonResp.data.bio || '';
        document.getElementById('contact-address-1').value = jsonResp.data.contacts.local_address || '';
        document.getElementById('contact-address-2').value = jsonResp.data.contacts.adress_details || '';
        document.getElementById('contact-full-name').value = jsonResp.data.contacts.full_name || '';
        document.getElementById('contact-city').value = jsonResp.data.contacts.city || '';
        document.getElementById('contact-zip').value = jsonResp.data.contacts.zip_code || '';
        document.getElementById('contact-phone').value = jsonResp.data.contacts.phone || '';
        document.getElementById('contact-state').value = jsonResp.data.contacts.state || '';
        document.getElementById('social-twitch').value = jsonResp.data.social.twitch || '';
        document.getElementById('social-instagram').value = jsonResp.data.social.instagram || '';
        document.getElementById('social-twitter').value = jsonResp.data.social.twitter || '';
        document.getElementById('social-youtube').value = jsonResp.data.social.youtube || '';
        document.getElementById('follower-count').innerHTML = jsonResp.data.follower.length;
        document.getElementById('following-count').innerHTML = jsonResp.data.following.length;
        console.log(jsonResp.data.back);
        if (jsonResp.data.back) {
            $('#profile-cover > div:first-of-type').remove();
            $('#profile-cover').prepend(
                `<div class="profile-cover-img" style="background-image: url(${baseUrl + 'storage/' + jsonResp.data.back})">
                </div>`
            );
        }
        renderFollower(jsonResp.data.follower);
        renderFollowing(jsonResp.data.following);
        addSaveContactsButton(userToken);
        if (jsonResp.data.contacts.verified) {
            verifiedRender()
        } else {
            setVerifyGetBut(userToken);
        }
        document.getElementById('change-cover').onclick = function() {
            $('#file-upload').click();
        }
        document.getElementById('file-upload').onchange = function(event) {
            const file = document.getElementById('file-upload').files[0];
            var formData = new FormData();
            formData.append('token', userToken);
            formData.append('type', 'back');
            formData.append('image', file);
            fetch(baseUrl + 'api/streamers/custom/donate/upload',
            {
                method: "POST",
                credentials: 'omit',
                mode: 'cors',
                body: formData,
            })
            .then(function(res){
                return res.json();
            })
            .then(function(jsonResp){
                if (jsonResp.errors) {
                    $('#modal-body-info').html(renderErrors(jsonResp.errors));
                    $('#modal_saved').modal();
                } else {
                    $('#profile-cover > div:first-of-type').remove();
                    $('#profile-cover').prepend(
                        `<div class="profile-cover-img" style="background-image: url(${baseUrl + 'storage/' + jsonResp.data.file})">
                        </div>`
                    );
                }
            });
        }
    });
}

function getCities(selectedId) {
    fetch(baseUrl + 'api/countries/get', {
        method: "GET",
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        renderCountries(jsonResp.data.countries, selectedId);
        
    });
}

function renderCountries(countries, defaulCountryId = 0) {
    let html = defaulCountryId > 0 ? '<option value=0 disabled>Select country</option>' : '<option value="0">Select country</option>';
    for (let i=0; i<countries.length; i++) {
        html += `<option value=${countries[i].id} `;
        html += countries[i].id == defaulCountryId ? 'selected' : '';
        html += `>${countries[i].name}</option>`;
    }
    document.getElementById('countries-select').innerHTML = html;
}

function addSaveContactsButton(userToken) {
    document.getElementById('save-contacts').onclick = function() {
        saveContacts(userToken);
    }
    document.getElementById('save-social').onclick = function() {
        saveContacts(userToken);
    }
}

function saveContacts(userToken) {
    let formData = new FormData();
        formData.append('token', userToken);
        formData.append('name', document.getElementById('contact-name').value);
        formData.append('local_address', document.getElementById('contact-address-1').value);
        formData.append('adress_details', document.getElementById('contact-address-2').value);
        formData.append('full_name', document.getElementById('contact-full-name').value);
        formData.append('city', document.getElementById('contact-city').value);
        formData.append('zip_code', document.getElementById('contact-zip').value);
        formData.append('phone', document.getElementById('contact-phone').value);
        formData.append('state', document.getElementById('contact-state').value);
        formData.append('country_id', document.getElementById('countries-select').value);
        formData.append('social_twitch', document.getElementById('social-twitch').value);
        formData.append('social_youtube', document.getElementById('social-youtube').value);
        formData.append('social_twitter', document.getElementById('social-twitter').value);
        formData.append('social_instagram', document.getElementById('social-instagram').value);
        fetch(baseUrl + 'api/viewer/contacts/update', {
            method: "POST",
            body: formData,
            credentials: 'omit',
            mode: 'cors'
        }).then(function(res){
            return res.json();
        }).then(function(jsonResp){
            if (jsonResp.errors) {
                $('#modal-body-info').html(renderErrors(jsonResp.errors));
                $('#modal_saved').modal();
            } else {
                $('#modal-body-info').html('<p class="text-success">Viewer contact info saved</p>');
                $('#modal_saved').modal();
            }
        });
}

function setVerifyGetBut(userToken) {
    document.getElementById('verify-block').innerHTML = `
        <button class="btn btn-danger"  id="verify-get-but">Verify</button>
    `;
    document.getElementById('verify-get-but').onclick = function() {
        let formData = new FormData();
        formData.append('token', userToken);
        formData.append('phone', document.getElementById('contact-phone').value);
        fetch(baseUrl + 'api/sms/code/get', {
            method: "POST",
            body: formData,
            credentials: 'omit',
            mode: 'cors'
        }).then(function(res){
            return res.json();
        }).then(function(jsonResp){
            if (jsonResp.errors) {
                $('#modal-body-info').html(renderErrors(jsonResp.errors));
                $('#modal_saved').modal();
            } else {
                setVerifySendBut(userToken);
            }
        });
    }
}

function setVerifySendBut(userToken) {
    document.getElementById('verify-block').innerHTML = `
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="code from sms..." aria-label="code from sms..." aria-describedby="check-sms-but" id="sms-code" style="width:150px;">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" id="check-sms-but">SEND</button>
                </div>
            </div>
    `;
    document.getElementById('check-sms-but').onclick = function () {
        let formData = new FormData();
        formData.append('token', userToken);
        formData.append('code', document.getElementById('sms-code').value);
        fetch(baseUrl + 'api/sms/code/check', {
            method: "POST",
            body: formData,
            credentials: 'omit',
            mode: 'cors'
        }).then(function(res){
            return res.json();
        }).then(function(jsonResp){
            if (jsonResp.errors) {
                $('#modal-body-info').html(renderErrors(jsonResp.errors));
                $('#modal_saved').modal();
            } else {
                verifiedRender();
            }
        });
    }
}

function verifiedRender() {
    document.getElementById('verify-block').innerHTML = `
    <h3 class="text-success">
        Accaunt verified
    </h3>
`;
}

function renderErrors(errors) {
    let html = '';
    for (let i=0;i<errors.length;i++) {
        html += `<p class="text-danger">${errors[i]}</p>`;
    }
    return html;
}

function renderFollower(data) {
    let html = '';
    for (let i=0;i<data.length;i++) {
        html += `
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="card-img-actions d-inline-block mb-3">
                            <img class="img-fluid rounded-circle" src="${data[i].avatar || 'https://static-cdn.jtvnw.net/jtv_user_pictures/086a13ac-9237-4605-bcd1-41ce1f79e764-profile_image-70x70.png'}" width="70" height="70" alt="">
                            <div class="card-img-actions-overlay card-img rounded-circle">
                                <a href="${baseUrl + 'profile/' + data[i].name}" class="btn btn-outline bg-white text-white border-white btn-icon rounded-round ">
                                    <i class="icon-link"></i>
                                </a>
                            </div>
                        </div>
                        <h6 class="font-weight-semibold mb-0">${data[i].name}</h6>
                        <span class="d-block text-muted">${data[i].subscription ? 'Streamer':'Viewer'}</span>
                    </div>
                </div>
            </div>
        `;
    }
    document.getElementById('follower-list').innerHTML = html;
}

function renderFollowing(data) {
    let html = '';
    for (let i=0;i<data.length;i++) {
        html += `
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="card-img-actions d-inline-block mb-3">
                            <img class="img-fluid rounded-circle" src="${data[i].avatar || 'https://static-cdn.jtvnw.net/jtv_user_pictures/086a13ac-9237-4605-bcd1-41ce1f79e764-profile_image-70x70.png'}" width="70" height="70" alt="">
                            <div class="card-img-actions-overlay card-img rounded-circle">
                                <a href="${baseUrl + 'profile/' + data[i].name}" class="btn btn-outline bg-white text-white border-white btn-icon rounded-round ">
                                    <i class="icon-link"></i>
                                </a>
                            </div>
                        </div>
                        <h6 class="font-weight-semibold mb-0">${data[i].name}</h6>
                        <span class="d-block text-muted">${data[i].subscription ? 'Streamer':'Viewer'}</span>
                    </div>
                </div>
            </div>
        `;
    }
    document.getElementById('following-list').innerHTML = html;
}

window.onload = function() {
    generateMainMenu();
    const token = localStorage.getItem('userToken') ? localStorage.getItem('userToken') : false;
    if (!token) {
        location = baseUrl;
    }
    getCabinetData(token);
    getViewerDetails(token);
    
};






