require('./bootstrap');

$(document).ready(() => {
    
    document.news = $('#news:first');
    if (document.news) {
        document.search = $('#search:first');
        document.search.last = '';
        document.searchButton = $('#search-button:first');
        document.total = $('#total:first');
        document.page = 0;
        document.pagePrev = $('#page-prev:first');
        document.pageNext = $('#page-next:first');
        document.loader = $('#loader:first');
    
        document.pagePrev.on('click', () => {
            loadNews(--document.page);
        });
        document.pageNext.on('click', () => {
            loadNews(++document.page);
        });
        document.search.on('keyup', () => {
            if (encodeURIComponent(document.search.val()) == document.search.last) {
                document.searchButton.attr('disabled', 'disabled');
            } else {
                document.searchButton.removeAttr('disabled');
            }
        });
        document.searchButton.on('click', () => {
            document.page = 0;
            loadNews();
        });
    
        loadNews();
    }

});

function loadNews(page = 0) {
    document.search.last = encodeURIComponent(document.search.val());
    document.searchButton.attr('disabled', 'disabled');
    // fetch
    document.loader.css({'display': 'block'});
    fetch(`/news?p=${page}&search=${document.search.last}`).then(response => response.json()).then((data) => {
        setListOfNews(data);
    }).catch((e) => {
        console.log('load failed', e);
    }).finally(() => {
        document.loader.css({'display': 'none'});
    });
}

function setListOfNews(data = null) {
    if (data === null) {
        return;
    }
    if (data.range[0] == 0) {
        document.pagePrev.attr('disabled', 'disabled');
    } else {
        document.pagePrev.removeAttr('disabled');
    }
    if (data.range[1] == data.total - 1) {
        document.pageNext.attr('disabled', 'disabled');
    } else {
        document.pageNext.removeAttr('disabled');
    }
    document.news.empty();
    document.total.text(data.total);
    if (data.news.length > 0) {
        data.news.forEach((e, i) => {
            let d = new Date(e.updated_at);
            let n = i + data.range[0] + 1;
            document.news.append($(`<div class="panel panel-default news-item"><div class="panel-heading news-item-title">#${n} <a href="/news/${e.id}">${e.title}</a></div><div class="panel-body news-item-announce">${e.announce}</div><div class="panel-footer text-right">Updated at: ${d.toDateString()}</div></div>`));
        });
    } else {
        document.news.append('No results!')
    }
}