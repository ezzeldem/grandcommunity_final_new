 <div class="row row-sm">
    @if(!isset($article))
        <ul class="nav justify-content-center nav-pills">
            <li class="nav-item ml-4">
                <div class="row">
                    <div class="col-md-1 col-sm-1">
                        {!! Form::radio('page_type', 0,!is_null(old('page_type')) ? (old('page_type') == 0 ? 'checked' : '') : true, ['class' => 'form-check-input', 'id' => 'singleContent' ]) !!}
                    </div>
                    <div class="col-md-11 col-sm-11">
                        {!! Form::label('singleContent', 'Single Section Article', ['class' => 'form-label']) !!}
                    </div>
                </div>
            </li>
            <li class="nav-item ml-4">
                <div class="row">
                    <div class="col-md-1 col-sm-1">
                        {!! Form::radio('page_type', 1, !is_null(old('page_type')) ? (old('page_type') == 1 ? 'checked' : '') : false, ['class' => 'form-check-input', 'id'=> 'multipleContent' ]) !!}
                    </div>
                    <div class="col-md-11 col-sm-11">
                        {!! Form::label('multipleContent', 'Multiple Section Page', ['class' => 'form-label']) !!}
                    </div>
                </div>
            </li>
        </ul>
    @endif
    <div class="col-12 create_form">
        <div class="row">
            <div  class="row col-md-12 col-sm-12 mt-3">
                <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                    <div class="form-group mg-b-0">
                        <label class="form-label">Main Title (En): <span class="tx-danger">*</span></label>
                        {!! Form::text('title[0]',(isset($article))?$article->getTranslation('title','en'):old('title.0'),['class' =>'form-control mt-2'.($errors->has('title.0') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
                        @error('title.en')
                            <ul class="parsley-errors-list filled" id="parsley-id-1">
                                <li class="parsley-required text-danger">
                                    {{$message}}
                                </li>
                            </ul>
                        @enderror
                        @error('slug')
                            <ul class="parsley-errors-list filled" id="parsley-id-2">
                                <li class="parsley-required text-danger">
                                    {{$message}}
                                </li>
                            </ul>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                    <div class="form-group mg-b-0">
                        <label class="form-label">Main Title (Ar): <span class="tx-danger">*</span></label>
                        {!! Form::text('title[1]',(isset($article))?$article->getTranslation('title','ar'):old('title.1'),['class' =>'form-control mt-2'.($errors->has('title.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
                        @error('title.ar')
                            <ul class="parsley-errors-list filled" id="parsley-id-3">
                                <li class="parsley-required text-danger">
                                    {{$message}}
                                </li>
                            </ul>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group mg-b-0" style= "width: 50%; margin-left: 25%;" >
                    <label class="form-label">Image :</label>
                    <input type="file" class="dropify" data-height="200" name="image"  data-default-file="{{ (isset($article))? asset($article->image):'' }}"  />
                    @error('image')
                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required text-danger">{{$message}}</li></ul>
                    @enderror
                </div>
            </div>
            <div id="sections" class="col-md-12 col-sm-12 mt-3">
                @if(isset($article) && $article->page_type == 1)
                    <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                        <span id="append_section" onclick="append_section()" class="btn pd-x-20 mg-t-10" style="background: #1e1e1e;color: #fff;">
                            <i class="icon-plus-circle"></i>
                            Add Section
                        </span>
                    </div>
                    @forelse($article->sections as $key => $section)
                        <div class="row" id="section_{{ $section->id }}">
                            @if($key != 0)
                                <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                                    <button onclick="delete_section({{ $section->id }})" class="btn pd-x-20 mg-t-10">
                                        <i class="icon-trash"></i>
                                        Remove Section
                                    </button>
                                </div>
                            @endif
                            {!! Form::hidden('section_id[]', $section->id) !!}
                            <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Title (En): <span class="tx-danger">*</span></label>
                                    {!! Form::text('sub_title['.$key.'][0]',(isset($section))?$section->getTranslation('title','en'):old('sub_title.'.$key.'.1'),['class' =>'form-control '.($errors->has('sub_title.'.$key.'.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
                                    @error('title.'.$key.'.0')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required text-danger">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Title (Ar): <span class="tx-danger">*</span></label>
                                    {!! Form::text('sub_title['.$key.'][1]',(isset($section))?$section->getTranslation('title','ar'):old('sub_title.'.$key.'.1'),['class' =>'form-control '.($errors->has('sub_title.'.$key.'.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
                                    @error('sub_title.'.$key.'.1')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required text-danger">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Description (En): <span class="tx-danger">*</span></label>
                                    {!! Form::textarea('sub_description['.$key.'][0]',(isset($section))?$section->getTranslation('description','en'):old('sub_description.'.$key.'.1')??NULL,['class' =>'form-control summernote '.($errors->has('sub_description.'.$key.'.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Description']) !!}
                                    @error('sub_description.'.$key.'.0')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required text-danger">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Description (Ar): <span class="tx-danger">*</span></label>
                                    {!! Form::textarea('sub_description['.$key.'][1]',(isset($section))?$section->getTranslation('description','ar'):old('sub_description.'.$key.'.1')??NULL,['class' =>'form-control summernote '.($errors->has('sub_description.'.$key.'.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Description']) !!}
                                    @error('sub_description.'.$key.'.1')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required text-danger">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Title (En): <span class="tx-danger">*</span></label>
                                    {!! Form::text('title[0][0]',old('title.0.0'),['class' =>'form-control '.($errors->has('title.0.0') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
                                    @error('title.0.0')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required text-danger">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Title (Ar): <span class="tx-danger">*</span></label>
                                    {!! Form::text('title[0][1]',old('title.0.1'),['class' =>'form-control '.($errors->has('title.0.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
                                    @error('title.0.1')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required text-danger">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Description (En): <span class="tx-danger">*</span></label>
                                    {!! Form::textarea('sub_description[0][0]',old('sub_description.0.1')??NULL,['class' =>'form-control summernote '.($errors->has('sub_description.0.0') ? 'parsley-error' : null),'placeholder'=> 'Enter Description']) !!}
                                    @error('sub_description.0.0')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required text-danger">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Description (Ar): <span class="tx-danger">*</span></label>
                                    {!! Form::textarea('sub_description[0][1]',old('sub_description.0.1')??NULL,['class' =>'form-control summernote '.($errors->has('sub_description.0.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Description']) !!}
                                    @error('sub_description.0.1')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required text-danger">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforelse
                @else
                    @if(isset($article))
                        {!! Form::hidden('section_id[]',  $article->sections->first()->id) !!}
                    @endif
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Title (En): <span class="tx-danger">*</span></label>
                                {!! Form::text('sub_title[0][0]',(isset($article))? $article->sections->first()->getTranslation('title','en'):old('sub_title.0.0'),['class' =>'form-control '.($errors->has('sub_title.0.0') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
                                @error('sub_title.0.0')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required text-danger">{{$message}}</li></ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Title (Ar): <span class="tx-danger">*</span></label>
                                {!! Form::text('sub_title[0][1]',(isset($article))? $article->sections->first()->getTranslation('title','ar'):old('sub_title.0.1'),['class' =>'form-control '.($errors->has('sub_title.0.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
                                @error('sub_title.0.1')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required text-danger">{{$message}}</li></ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Description (En): <span class="tx-danger">*</span></label>
                                {!! Form::textarea('sub_description[0][0]',(isset($article))? $article->sections->first()->getTranslation('description','en'):old('sub_description.0.0')??NULL,['class' =>'form-control summernote '.($errors->has('sub_description.0.0') ? 'parsley-error' : null),'placeholder'=> 'Enter Description']) !!}
                                @error('sub_description.0.0')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required text-danger">{{$message}}</li></ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Description (Ar): <span class="tx-danger">*</span></label>
                                {!! Form::textarea('sub_description[0][1]',(isset($article))? $article->sections->first()->getTranslation('description','ar'):old('sub_description.0.1')??NULL,['class' =>'form-control summernote '.($errors->has('sub_description.0.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Description']) !!}
                                @error('sub_description.0.1')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required text-danger">{{$message}}</li></ul>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-6 col-sm-12 mt-3">
                <div class="form-group">
                    <label class="form-label">Status: <span class="tx-danger">*</span></label>
                    {!! Form::select("status",status(),(isset($article))?$article->status:old('status'),['class' =>'form-control '.($errors->has('status') ? 'parsley-error' : null),
                               'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'status','placeholder'=>'Select'])!!}
                    @error('status')
                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                        <li class="parsley-required text-danger">{{$message}}</li>
                    </ul>
                    @enderror
                </div>
            </div>

        </div>
    </div>

    <div class="col-12">
        <div class="row">
                <div class="col-md-6 col-sm-12 mt-3">
                    <div class="form-group">
                        <label class="form-label">Tags (En): <span class="tx-danger">*</span></label>
                        {!! Form::select("tags[0][]",(isset($article))?$article->tags_en:(!is_null(old('tags.0'))?selectTags(old('tags.0')):[]),(isset($article))?$article->tags_en:(!is_null(old('tags.1')) ?selectTags(old('tags.0')):[]),['class' =>'form-control select2 insert_tag_en'.($errors->has('tags.en') ? 'parsley-error' : null),'id' => 'insert_tag_en','multiple'])!!}
                        @error('tags')
                        <ul class="parsley-errors-list filled" id="parsley-id-11">
                            <li class="parsley-required text-danger">{{$message}}</li>
                        </ul>
                        @enderror
                        @error('tags.en')
                        <ul class="parsley-errors-list filled" id="parsley-id-11">
                            <li class="parsley-required text-danger">{{$message}}</li>
                        </ul>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mt-3">
                    <div class="form-group">
                        <label class="form-label">Tags (Ar): <span class="tx-danger">*</span></label>
                        {!! Form::select("tags[1][]",(isset($article))?$article->tags_ar:(!is_null(old('tags.1'))?selectTags(old('tags.1')):[]),(isset($article))?$article->tags_ar:(!is_null(old('tags.1')) ?selectTags(old('tags.1')):[]),['class' =>'form-control select2 insert_tag_ars'.($errors->has('tags.ar') ? 'parsley-error' : null),'id' => 'insert_tag_ar','multiple'])!!}
                        @error('tags')
                        <ul class="parsley-errors-list filled" id="parsley-id-11">
                            <li class="parsley-required text-danger">{{$message}}</li>
                        </ul>
                        @enderror
                        @error('tags.ar')
                        <ul class="parsley-errors-list filled" id="parsley-id-11">
                            <li class="parsley-required text-danger">{{$message}}</li>
                        </ul>
                        @enderror
                    </div>
                </div>
            </div>
    </div>

    <div class="col-12 text-right">
        <button style="width: 150px;" class="btn pd-x-20 mg-t-10" type="submit">
            <i class="far fa-save"></i> Save
        </button>
    </div>
</div>
