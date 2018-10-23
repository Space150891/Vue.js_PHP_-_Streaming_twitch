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