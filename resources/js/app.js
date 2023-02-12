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

        // Async form
        document.async = $('#form-async:first');
        document.async.title = document.async.find('[name=new-title]:first');
        document.async.announce = document.async.find('[name=new-announce]:first');
        document.async.content = document.async.find('[name=new-content]:first');
        document.async.rubrics = document.async.find('[name^=rubrics]:first');

        document.async.submit((e) => {
            e.preventDefault(true);

            let data = {
                'new-title': document.async.title.val(),
                'new-announce': document.async.announce.val(),
                'new-content': document.async.content.val(),
                'rubrics_ids': document.async.rubrics.val(),
            };

            $.ajax({
                'url': '/news/add',
                'cache': false,
                'data': data,
                'method': 'POST',
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'error': (jqXHR, textStatus, errorThrown) => {
                    $('meta[name="csrf-token"]').attr('content', jqXHR.getResponseHeader("X-CSRF-TOKEN"));
                    console.log(textStatus, errorThrown, jqXHR);
                },
                'success': (data, textStatus, jqXHR) => {
                    $('meta[name="csrf-token"]').attr('content', jqXHR.getResponseHeader("X-CSRF-TOKEN"));
                    console.log(textStatus, data, jqXHR);
                },
                'complete': (data, textStatus) => {
                    document.async.title.val('');
                    document.async.announce.val('');
                    document.async.content.val('');
                    document.search.val('');
                    document.page = 0;
                    loadNews();
                }
            });

            return false;
        });
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
            let r = e.rubrics.map((rubric) => { return rubric.name; });
            if (r.length < 1) {
                r.push('-');
            };
            document.news.append($(`<div class="panel panel-default news-item"><div class="panel-heading news-item-title">#${n} <a href="/news/${e.id}">${e.title}</a></div><div class="panel-body news-item-announce">${e.announce}<hr>Rubrics: ${r.join(', ')}</div><div class="panel-footer text-right">Updated at: ${d.toDateString()}</div></div>`));
        });
    } else {
        document.news.append('No results!')
    }
}