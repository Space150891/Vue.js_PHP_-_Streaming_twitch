function getRedeemDetails(token) {
    let formData = new FormData();
    formData.append('token', token);
    formData.append('id', prizeId);
    fetch(baseUrl + 'api/prize/get', {
        method: "POST",
        body: formData,
        credentials: 'omit',
        mode: 'cors'
    }).then(function(res){
        return res.json();
    }).then(function(jsonResp){
        if (jsonResp.errors) {
            location = baseUrl + 'my-inventory';
        }
        document.getElementById('prize-name').innerHTML = jsonResp.data.prize.name;
        document.getElementById('prize-class').innerHTML = jsonResp.data.prize.class;
        document.getElementById('prize-description').innerHTML = jsonResp.data.prize.description;
        document.getElementById('prize-cost').innerHTML = jsonResp.data.prize.cost;
    });
}

window.onload = function() {
    generateMainMenu();
    const token = localStorage.getItem('userToken') ? localStorage.getItem('userToken') : false;
    if (!token) {
        location = baseUrl;
    }
    getRedeemDetails(token);
    
};






