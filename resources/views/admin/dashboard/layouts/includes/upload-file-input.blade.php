<input id="{{'deleted_'.($inputId??'multiplefileupload') }}" name="{{str_replace('[]', '', 'deleted_'.($inputName??'files'))}}" type="hidden" value="" data-exists-keys="{{implode("||", array_keys($oldValues??[]))}}" data-exists-urls="{{implode("||", array_values($oldValues??[]))}}">
<section class="bg-diffrent custom-upload-files-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="verify-sub-box">
                    <div class="file-loading">
                        <input class="custom-upload-files-input" id="{{($inputId??'multiplefileupload') }}" type="file" accept="image/*,video/*" name="{{$inputName??'files[]'}}" multiple>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if(!isset($disableInputFileCss))
@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.8/css/fileinput.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap');

        button:focus,
        input:focus{
            outline: none;
            box-shadow: none;
        }
        a,
        a:hover{
            text-decoration: none;
        }

        body{
            font-family: 'Roboto', sans-serif;
        }

        /*----------multiple-file-upload-----------*/

        .btn-danger {
            background: linear-gradient(to bottom, #ffffff 0%, #ffffff 100%) !important;
        }

        .input-group.file-caption-main{
            display: none;
        }
        .close.fileinput-remove{
            display: none;
        }
        .file-drop-zone{
            margin: 0px;
            border: 1px solid #fff;
            background-color: #fff;
            padding: 0px;
            display: contents;
        }
        .file-drop-zone.clickable:hover{
            border-color: #fff;
        }
        .file-drop-zone .file-preview-thumbnails{
            display: inline;
        }
        .file-drop-zone-title{
            padding: 15px;
            height: 120px;
            width: 120px;
            font-size: 12px;
        }
        .file-input-ajax-new{
            display: inline-block;
        }
        .file-input.theme-fas{
            display: inline-block;
            width: 100%;
        }
        .file-preview{
            padding: 0px;
            border: none;
            display: inline;

        }
        .file-drop-zone-title{
            display: none;
        }
        .file-footer-caption{
            display: none !important;
        }
        .kv-file-upload{
            display: none;
        }
        .file-upload-indicator{
            display: none;
        }
        .file-drag-handle.drag-handle-init.text-info{
            display: none;
        }
        .krajee-default.file-preview-frame .kv-file-content{
            width: 90px;
            height: 90px;
            display: flex;
            text-align: center;
            align-items: center;
        }
        .krajee-default.file-preview-frame{
            background-color: #fff;
            margin: 3px;
            border-radius: 15px;
            overflow: hidden;
        }
        .krajee-default.file-preview-frame:not(.file-preview-error):hover{
            box-shadow: none;
            border-color: #ed3237;
        }
        .krajee-default.file-preview-frame:not(.file-preview-error):hover .file-preview-image{
            transform: scale(1.1);
        }
        .krajee-default.file-preview-frame{
            box-shadow: none;
            border-color: #fff;
            max-width: 150px;
            margin: 5px;
            padding: 0px;
            transition: 0.5s;
        }
        .file-thumbnail-footer,
        .file-actions{
            width: 20px;
            height: 20px !important;
            position: absolute !important;
            top: 3px;
            right: 3px;
        }
        .kv-file-download:focus,
        .kv-file-download:active{
            outline: none !important;
            box-shadow: none !important;
        }
        .kv-file-download{
            border-radius: 50%;
            z-index: 1;
            right: 52px;
            position: absolute;
            top: 53px;
            text-align: center;
            color: #fff;
            background-color: #3a3232;
            border: 1px solid #ed3237;
            padding: 2px 6px;
            font-size: 11px;
            transition: 0.5s;
        }
        .kv-file-download:hover{
            border-color: #fdeff0;
            background-color: #3a3232;
            color: #fff;
        }
        .kv-file-remove:focus,
        .kv-file-remove:active{
            outline: none !important;
            box-shadow: none !important;
        }
        .kv-file-remove{
            border-radius: 50%;
            z-index: 1;
            right: 0;
            position: absolute;
            top: 53px;
            text-align: center;
            color: #fff;
            background-color: #ed3237;
            border: 1px solid #ed3237;
            padding: 2px 6px;
            font-size: 11px;
            transition: 0.5s;
        }
        .kv-file-remove:hover{
            border-color: #fdeff0;
            background-color: #fdeff0;
            color: #ed1924;
        }
        .kv-preview-data.file-preview-video{
            width: 100% !important;
            height: 100% !important;
        }
        .btn-outline-secondary.focus, .btn-outline-secondary:focus{
            box-shadow: none;
        }
        .btn-toggleheader,
        .btn-fullscreen,
        .btn-borderless{
            display: none;
        }
        .btn-kv.btn-close{
            color: #fff;
            border: none;
            background-color: #ed3237;
            font-size: 11px;
            width: 18px;
            height: 18px;
            text-align: center;
            padding: 0px;
        }
        .btn-outline-secondary:not(:disabled):not(.disabled).active:focus,
        .btn-outline-secondary:not(:disabled):not(.disabled):active:focus,
        .show>.btn-outline-secondary.dropdown-toggle:focus{
            background-color: rgba(255,255,255,0.8);
            color: #000;
            box-shadow: none;
            color: #ed3237;
        }
        .kv-file-content .file-preview-image{
            width: 90px !important;
            height: 90px !important;
            max-width: 90px !important;
            max-height: 90px !important;
            transition: 0.5s;
        }
        .btn-danger.btn-file{
            padding: 0px;
            height: 95px;
            width: 95px;
            display: inline-block;
            margin: 5px;
            border-color: #fdeff0;
            background-color: var(--secoundry);
            color: #997c26;
            border-radius: 15px;
            padding-top: 30px;
            transition: 0.5s;
        }
        .btn-danger.btn-file:active,
        .btn-danger.btn-file:hover{
            background-color: var(--secoundry);
            color: #997c26;
            border-color: #ffff;
            box-shadow: none;
        }
        .btn-danger.btn-file i{
            font-size: 30px;
        }

        .kv-file-download i {
            margin: 0 !important;
        }

        .kv-file-remove i {
            margin: 0 !important;
        }


        @media (max-width: 350px){
            .krajee-default.file-preview-frame:not([data-template=audio]) .kv-file-content{
                width: 90px;
            }
        }
    </style>
@endpush
@endif

@if(!isset($disableInputFileJs))
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.8/js/fileinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.8/js/plugins/sortable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.8/themes/fas/theme.min.js"></script>

    <script>
        //krajee Plugin
        $(document).ready(function() {
            let oldFileInput = $("{{'#deleted_'.($inputId??'multiplefileupload') }}");
            let oldKeys = oldFileInput.attr('data-exists-keys').length > 0?oldFileInput.attr('data-exists-keys').split("||"):[];
            let oldUrls = oldFileInput.attr('data-exists-urls').length > 0?oldFileInput.attr('data-exists-urls').split("||"):[];
            let initialPreviewData = [];
            let initialPreviewConfigData = [];
                for (let i=0; i < oldKeys.length; i++){
                    let type = "image";
                    let caption = "Image";
                    let filetype = "";
                    if(checkIfImage(oldUrls[i]) === false){
                        type = "video";
                        caption = "Video";
                    }
                    initialPreviewData.push( "{{$uploadPath??""}}"+oldUrls[i]);
                    initialPreviewConfigData.push({type: type, filetype: filetype, caption: caption, downloadUrl: "{{$uploadPath??""}}"+oldUrls[i], description: "Accept HTML", size: 930321, width: "120px", key: oldKeys[i]});
                }

            // ----------multiplefile-upload---------
        $("{{'#'.($inputId??'multiplefileupload')}}").fileinput({
            initialPreview: initialPreviewData,
            initialPreviewConfig: initialPreviewConfigData,
            'theme': 'fa',
            'uploadUrl': '#',
            showRemove: false,
            showUpload: false,
            showZoom: false,
            showCaption: false,
            allowedPreviewTypes: ['image', 'video'],
            browseClass: "btn btn-danger",
            browseLabel: "",
            browseIcon: "<i class='fa fa-image'></i>",
            overwriteInitial: false,
            initialPreviewAsData: true,
            removeIcon: "<i class='fa fa-times'></i>",
            previewFileIconSettings: { // configure your icon file extensions
                'mov': '<i class="fas fa-file-video text-warning"></i>' //https://plugins.krajee.com/file-preview-management-demo
            },
            previewFileExtSettings: {
                'mov': function(ext) {
                    return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
                }
            },
            fileActionSettings :{
                showUpload: false,
                showZoom: false,
                removeIcon: "<i class='fa fa-times'></i>",
                downloadIcon: "<i class='fa fa-download'></i>",
            }
        });

        $('body').on('click', '.kv-file-remove', function (){
            let imageRemoveBtn = $(this);
            let oldFileInputValues = oldFileInput.val().length > 0?oldFileInput.val().split("||"):[];
            oldFileInputValues.push(imageRemoveBtn.data('key'));
            oldFileInput.val(oldFileInputValues.join('||'));
            imageRemoveBtn.parents('.file-preview-frame').remove();
        });
        });

        function checkIfImage(url) {
            return(url.match(/\.(jpeg|jpg|gif|png)$/) != null);
        }
    </script>
@endpush
@endif
