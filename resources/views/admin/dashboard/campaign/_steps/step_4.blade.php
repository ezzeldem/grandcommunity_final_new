<div class="col-12">
    <div class="row setup-content" id="step-4">
        <div class="col-md-12">
            <div class="form-group mg-b-0">
                <div class="container-fluid">
                    <div class="row">
                        @forelse ($chick_lists as $chicklist)

                            <div class="col-md-4">
                                <label
                                    style="font-size: 15px;display: flex;align-items: center;justify-content: flex-start;gap: 9px;padding: 1rem 0.4rem;box-shadow: 0px 1px 4px 2px #111111;border-radius: 4px;margin: 0.7rem 0rem;border-left: 2px solid #d7af3269;">
                                    <input name="chicklist[]" class="check_list" type="checkbox"
                                           value="{{ $chicklist->id }}"
                                           style=" accent-color: #d7af32; transform: scale(1.1); "
                                    @if(isset($campaign) && !is_null($campaign->campaign_check_list))
                                        @forelse($campaign->campaign_check_list as $list)
                                            {{$chicklist->id == $list ? 'checked':null}}
                                            @empty
                                            @endforelse
                                        @endif
                                    >
                                    {{ $chicklist->name }}
                                </label>

                            </div>
                        @empty
                    </div>
                </div>
                <p>Empty</p>
                @endforelse
                @error('chicklist.*')
                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror

            </div>
        </div>
        <div class="col-12">
            <button type="button" class="btn btn-primary previous-btn-step btn-lg pull-right" data-step="4">Previous</button>
            <button type="button" class="btn btn-primary next-btn-step btn-lg pull-right" data-step="4"><i class="far fa-save"></i>Save Campaign</button>
        </div>
    </div>
</div>
