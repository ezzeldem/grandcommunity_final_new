
<div class="row gutters d-none">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body tabs-camp text-center">
                <button type="button" class="btn status_type active">
                    All <span class="badge badge-white"> ({{\App\Models\Campaign::count()}}) </span>
                </button>
                @foreach(\App\Models\Status::where('type','campaign')->get() as $status)

                    <button id="hellobutton" type="button" class="btn status_type"  data-value="{{$status->value}}">
                        {{$status->name}}  <span class="badge badge-white"> ({{\App\Models\Campaign::where('status',$status->value)->count()}}) </span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</div>
@if(\App\Models\Campaign::count())
    <div class="btn_sec d-none" style="background: var(--main-bg-color);margin-top: -20px;">
        @can('delete campaigns')
        <button type="button" class="global_btn danger" id="btn_delete_all">
            <i class="fas fa-trash-alt"></i>
        </button>
        @endcan
        @can('read campaigns')
        <a href="{{route('dashboard.campaigns.export')}}" class="global_btn export">
            <i class="fas fa-file-download"></i>
        </a>
        @endcan
    </div>
@endif
