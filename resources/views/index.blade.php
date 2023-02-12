<x-app-layout>
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add <b>sync</b>
                </div>
                <div class="panel-body">
                    <form action="/news/add" id="form-sync" method="POST">
                        <div class="input-group form-group">
                            <span class="input-group-addon">Title</span>
                            <input type="text" class="form-control" placeholder="type title here" maxlength="255" name="new-title">
                        </div>
                        <div class="input-group form-group">
                            <span class="input-group-addon">Announce</span>
                            <input type="text" class="form-control" placeholder="type smalltext here" maxlength="255" name="new-announce">
                        </div>
                        <div class="input-group form-group">
                            <span class="input-group-addon">Content</span>
                            <textarea class="form-control" placeholder="type fulltext here" name="new-content"></textarea>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="submit" class="btn btn-primary">Add with reload page</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add <b>async</b>
                </div>
                <div class="panel-body">
                    <form action="/news/add" id="form-async" method="POST">
                        <div class="input-group form-group">
                            <span class="input-group-addon">Title</span>
                            <input type="text" class="form-control" placeholder="type title here" maxlength="255" name="new-title">
                        </div>
                        <div class="input-group form-group">
                            <span class="input-group-addon">Announce</span>
                            <input type="text" class="form-control" placeholder="type smalltext here" maxlength="255" name="new-announce">
                        </div>
                        <div class="input-group form-group">
                            <span class="input-group-addon">Content</span>
                            <textarea class="form-control" placeholder="type fulltext here" name="new-content"></textarea>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="submit" class="btn btn-primary">Add with reload page</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-12">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="input-group form-group">
                        <span class="input-group-addon">Search</span>
                        <input type="text" class="form-control" placeholder="enter the search phrase" maxlength="255" name="search" id="search">
                        <span class="input-group-btn">
                            <button id="search-button" class="btn btn-primary" type="button">Apply</button>
                        </span>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <p>Total result: <span id="total">-</span>
                </div>
                <div class="col-md-6 col-xs-12 text-right">
                    <div class="btn-group" role="group">
                        <button type="button" disabled id="page-prev" class="btn btn-primary">< prev</button>
                        <button type="button" id="page-next" class="btn btn-primary">next ></button>
                    </div>
                    <hr>
                </div>
                <div class="col-md-12 col-xs-12" id="loader">
                    Loading...
                </div>
                <div class="col-md-12 col-xs-12" id="news"></div>
        </div>
    </div>
</x-app-layout>