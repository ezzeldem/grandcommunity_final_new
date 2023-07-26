<!-- Required jQuery first, then Bootstrap Bundle JS -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.js') }}"></script>
<script src="{{ asset('assets/js/multiselect.js') }}"></script>
<!-- ************************* Vendor Js Files ************************** -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<!-- ************************* Vendor Js Files ************************** -->
<!-- Slimscroll JS -->
<script src="{{ asset('assets/vendor/slimscroll/slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/vendor/slimscroll/custom-scrollbar.js') }}"></script>
<!-- Polyfill JS -->
<script src="{{ asset('assets/vendor/polyfill/polyfill.min.js') }}"></script>
<script src="{{ asset('assets/vendor/polyfill/class-list.min.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>
{{--<script src="{{ asset('assets/js/notify.js')}}"></script>--}}

<!-- SwalAlert JS -->
{{--<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>--}}

<script>
    function selectToGetOtherRequest(select, data){
        $(select.attr('data-other-to-reset')).html("<option value=''>{{__('lang.select_an_option')}}</option>");
        $.ajax({
            url: select.data('url'),
            data: data,
            success: function (data){
                let options = "<option value=''>{{__('lang.select_an_option')}}</option>";
                $.each(data.options, function(key, row){
                    options += "<option value='"+row.key+"'>"+row.value+"</option>";
                });
                $(select.attr('data-other-id')).html(options);
                $(select.attr('data-show-other')).show();
            },
            error: function(e) {
                alert('Error! Cannot process this action.');
            }});
    }

    function format(item, state) {
        if (!item.id) {
            return item.text;
        }
        var flag= item.element.attributes[1];
        var countryUrl = "https://hatscripts.github.io/circle-flags/flags/";
        var url = state ? stateUrl : countryUrl;
        var img = $("<img>", {
            class: "img-flag-all",
            width: 18,
            src: url + flag.value.toLowerCase() + ".svg"
        });
        var span = $("<span>", {
            text: " " + item.text
        });
        span.prepend(img);
        return span;
    }
    function formatState (state) {
        if (!state.id) {
            return state.text;
        }
        var flag= state.element.attributes[1].value;
        var baseUrl = "https://hatscripts.github.io/circle-flags/flags/";
        var $state = $(
            '<span><img class="img-flag" width="22"/> <span></span></span>'
        );
        $state.find("img").attr("src", baseUrl + "/" + flag.toLowerCase() + ".svg");
        return $state;
    };

    function selectCountry(){
        $('.country_code').select2({
            placeholder: "🌍 Global",
            allowClear: true,
            templateResult: function(item) {
                return format(item, false);
            },
            templateSelection:function(state) {
                return formatState(state, false);
            },
        });
    }


    $(document).ready(function() {

        $('body').on('change', '.select-to-get-other-options', function (){
            let select = $(this);
            let related = select.attr('data-other-name');
            var data = {};
            data[related] = select.val();
            selectToGetOtherRequest(select, data);
        });

        // var s =  $("#header_country_id").select2({
        //     placeholder: '🌍 Global.....',
        //     allowClear: true,
        //     maximumSelectionLength: 4,
        //     templateResult: function(item) {
        //         return format(item, false);
        //     },
        //     templateSelection:function(state) {
        //         return formatState(state, false);
        //     },
        // });
        //
        // s.data('select2').$container.addClass("mains")
        $('.select2').select2({
            placeholder: "Select",
            allowClear: true
        });
        selectCountry();
    });

    const notifiContainer = document.getElementById('_notfi-box')
    const notfiBtn = notifiContainer.querySelector("._btn")
    const notfiBox = notifiContainer.querySelector(".notifications_list")
    let notifyBoxOpened = false

    const toggleNotfi = () => {
        notifyBoxOpened = !notifyBoxOpened
        if (notifyBoxOpened) notfiBox.classList.add('active')
        else notfiBox.classList.remove('active')
    }
    notfiBtn.addEventListener('click', toggleNotfi)

    // $('.btn_bell').click(function(e) {
    //     var color = $(this).text();
    //     if (down) {
    //         $('#box').css('height', '0px');
    //         $('#box').css('opacity', '0');
    //         down = false;
    //     } else {
    //         $('#box').css('height', 'auto');
    //         $('#box').css('opacity', '1');
    //         down = true;
    //     }
    // });

    $("#clickHeaderSelect").on('click', function() {
        var country = $('#header_country_id').val();
        $.ajax({
            url: `/dashboard/session?country=${country}`,
            type: 'get',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: () => {
                window.location.reload();
            },
            error: () => {

            }
        })
    });
</script>

@yield('js')
@stack('js')
