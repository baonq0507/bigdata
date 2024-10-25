<div class="row">
    <div class="col-md-8 col-sm-12">

    </div>
    <div class="col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">{{__('Visitors by page')}}</h3>
                <table class="table table-sm table-borderless">
                    <thead>
                    <tr>
                        <th>{{__('Page')}}</th>
                        <th class="text-end">{{__('Visitors')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($menu as $page)
                        <tr>
                            <td>
                                <div class="progressbg">
                                    <div class="progress progressbg-progress">
                                        <div class="progress-bar bg-primary-lt" style="width: {{$page['progress']}}%" role="progressbar" aria-valuenow="82.54" aria-valuemin="0" aria-valuemax="100" aria-label="82.54% Complete">
                                            <span class="visually-hidden">{{$page['progress']}}% Complete</span>
                                        </div>
                                    </div>
                                    <div class="progressbg-text">/{{$page['url']}}</div>
                                </div>
                            </td>
                            <td class="w-1 fw-bold text-end">{{$page['visitor']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
