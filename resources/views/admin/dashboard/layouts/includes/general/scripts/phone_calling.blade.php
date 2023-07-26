<script>
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
        }  selectCountry()


		$('.fa-eye').on('click', function(e) {
        input = $(this).parent().children('.form-control');
        inputType = input.attr('type');
        if (inputType == "password") {
            input.attr('type', 'text');
        } else {
            input.attr('type', 'password');
        }
     });
</script>