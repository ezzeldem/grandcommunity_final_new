$(document).ready(function () {

  // function format(item, state) {
  //   if (!item.id) {
  //     return item.text;
  //   }
  //   var flag = item.element.attributes[1];
  //
  //   var countryUrl = (item.id!=-1)? "https://hatscripts.github.io/circle-flags/flags/":'';
  //   var url = state ? stateUrl : countryUrl;
  //   var img = $("<img>", {
  //     class: "img-flag",
  //     width: 20,
  //     src: url + flag.value.toLowerCase(),
  //   });
  //   var span = $("<span>", {
  //     text: " " + item.text,
  //     class: "span_countries",
  //   });
  //   if(item.id!=-1)
  //       span.prepend(img);
  //   return span;
  // }
  //
  // function formatState(state) {
  //   if (!state.id) {
  //     return state.text;
  //   }
  //   var flag = state.element.attributes[1].value;
  //   var baseUrl = (state.id!='-1')? "https://hatscripts.github.io/circle-flags/flags/":'';
  //   var $state = $(
  //     '<span class="img_span"><img class="img-flag"  width="25" height="25"/><span>'+state.text+'</span> </span>'
  //   );
  //   $state.find("img").attr("src", baseUrl + "/" + flag.toLowerCase());
  //   if(state.id == '-1'){
  //       $state.find('img').remove();
  //   }
  //   return $state;
  // }

    function format(item, state) {
        if (!item.id) {
            return item.text;
        }
        var flag = item.element.attributes[1];
        var link = item.element.attributes[2];



        var countryUrl = (item.id!=-1)? "https://hatscripts.github.io/circle-flags/flags/":'';
        var url = state ? stateUrl : countryUrl;
        var img = $("<img>", {
            class: "img-flag",
            width: 20,
            src: url + flag.value.toLowerCase(),
        });
        var links=$("<a>",{
            href: link.value,
        })
        var span = $("<span>", {
            text: " " + item.text,
            class: "span_countries"
        });
        if(item.id!=-1)
            span.prepend(img);
            links.append(span)
        span.css('color','rgb(12 23 29)')
        links.css('text-decoration','none')
        return links;
    }

    function formatState(state) {
        if (!state.id) {
            return state.text;
        }
        var flag = state.element.attributes[1].value;
        var baseUrl = (state.id!='-1')? "https://hatscripts.github.io/circle-flags/flags/":'';
        var $state = $(
            '<span class="img_span"><img class="img-flag"  width="25" height="25"/><span>'+state.text+'</span> </span>'
        );
        $state.find("img").attr("src", baseUrl + "/" + flag.toLowerCase());
        if(state.id == '-1'){
            $state.find('img').remove();
        }
        return $state;
    }

  var s = $("#country_select").select2({
    placeholder: "Select Country ....",
    allowClear: false,
    maximumSelectionLength: 4,

    templateResult: function (item) {
      return format(item, false);
    },
    templateSelection: function (state) {
      return formatState(state, false);

    },

  });
    $('#country_select').change(function (){
        window.location = $(this).find(":selected").attr('data-src')
    });
  s.data("select2").$container.addClass("mains");
  var check1 = false;
  $(".one h1").click(function () {
    if (check1 == false) {
      $(".one p").show(300);
      if ($("html").attr("dir") == "rtl") {
        $(".one h1").append(
          "<style>.one h1:before{transform:rotate(-90deg) !important;}</style>"
        ); // before
      } else {
        $(".one h1").append(
          "<style>.one h1:before{transform:rotate(90deg) !important;}</style>"
        ); // before
      }
      check1 = true;
    } else {
      $(".one p").hide(300);
      $(".one h1").append(
        "<style>.one h1:before{transform:rotate(0deg) !important;}</style>"
      ); // before
      check1 = false;
    }
  });
  var check2 = false;
  $(".two h1").click(function () {
    if (check2 == false) {
      $(".two p").show(300);
      if ($("html").attr("dir") == "rtl") {
        $(".two h1").append(
          "<style>.two h1:before{transform:rotate(-90deg) !important;}</style>"
        ); // before
      } else {
        $(".two h1").append(
          "<style>.two h1:before{transform:rotate(90deg) !important;}</style>"
        ); // before
      }
      check2 = true;
    } else {
      $(".two p").hide(300);
      $(".two h1").append(
        "<style>.two h1:before{transform:rotate(0deg) !important;}</style>"
      ); // before
      check2 = false;
    }
  });
  var check3 = false;
  $(".three h1").click(function () {
    if (check3 == false) {
      $(".three p").show(300);
      if ($("html").attr("dir") == "rtl") {
        $(".three h1").append(
          "<style>.three h1:before{transform:rotate(-90deg) !important;}</style>"
        ); // before
      } else {
        $(".three h1").append(
          "<style>.three h1:before{transform:rotate(90deg) !important;}</style>"
        ); // before
      }
      check3 = true;
    } else {
      $(".three p").hide(300);
      $(".three h1").append(
        "<style>.three h1:before{transform:rotate(0deg) !important;}</style>"
      ); // before
      check3 = false;
    }
  });
  var check4 = false;
  $(".four h1").click(function () {
    if (check4 == false) {
      $(".four p").show(300);
      if ($("html").attr("dir") == "rtl") {
        $(".four h1").append(
          "<style>.four h1:before{transform:rotate(-90deg) !important;}</style>"
        ); // before
      } else {
        $(".four h1").append(
          "<style>.four h1:before{transform:rotate(90deg) !important;}</style>"
        ); // before
      }
      check4 = true;
    } else {
      $(".four p").hide(300);
      $(".four h1").append(
        "<style>.four h1:before{transform:rotate(0deg) !important;}</style>"
      ); // before
      check4 = false;
    }
  });
  var check5 = false;
  $(".five h1").click(function () {
    if (check5 == false) {
      $(".five p").show(300);
      if ($("html").attr("dir") == "rtl") {
        $(".five h1").append(
          "<style>.five h1:before{transform:rotate(-90deg) !important;}</style>"
        ); // before
      } else {
        $(".five h1").append(
          "<style>.five h1:before{transform:rotate(90deg) !important;}</style>"
        ); // before
      }
      check5 = true;
    } else {
      $(".five p").hide(300);
      $(".five h1").append(
        "<style>.five h1:before{transform:rotate(0deg) !important;}</style>"
      ); // before
      check5 = false;
    }
  });



  $(".show_dilog_brand").click(function () {
    $(".brand_dialog").css("display", "block");
  });
  $(".show_dilog_infulencer").click(function () {
    $(".influencer_dialog").css("display", "block");
  });
  $(".close_dilog_brand").click(function () {
    $(".brand_dialog").css("display", "none");
  });
  $(".close_dilog_infu").click(function () {
    $(".influencer_dialog").css("display", "none");
  });



  // start wizard
  var current_fs, next_fs, previous_fs; //fieldsets
  var opacity;

  // $(".next").click(function () {
  //   current_fs = $(this).parent();
  //   next_fs = $(this).parent().next();
  //   //Add Class Active
  //   $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
  //   //show the next fieldset
  //   next_fs.show();
  //   //hide the current fieldset with style
  //   current_fs.animate(
  //     { opacity: 0 },
  //     {
  //       step: function (now) {
  //         // for making fielset appear animation
  //         opacity = 1 - now;
  //         current_fs.css({
  //           display: "none",
  //           position: "relative",
  //         });
  //         next_fs.css({ opacity: opacity });
  //       },
  //       duration: 600,
  //     }
  //   );
  // });
  $(".previous").click(function () {
    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();
    //Remove class active
    $("#progressbar li")
      .eq($("fieldset").index(current_fs))
      .removeClass("active");
    //show the previous fieldset
    previous_fs.show();
    //hide the current fieldset with style
    current_fs.animate(
      { opacity: 0 },
      {
        step: function (now) {
          // for making fielset appear animation
          opacity = 1 - now;
          current_fs.css({
            display: "none",
            position: "relative",
          });
          previous_fs.css({ opacity: opacity });
        },
        duration: 600,
      }
    );
  });

  $(".radio-group .radio").click(function () {
    $(this).parent().find(".radio").removeClass("selected");
    $(this).addClass("selected");
  });

  $(".submit").click(function () {
    return false;
  });
  // end wizard
  $(".close_dilog").click(function (e) {
    e.preventDefault();
    $(".newbranchdilog").hide(300);
  });
  $(".addBranch").click(function (e) {
    e.preventDefault();
    $(".newbranchdilog").show(300);
  });

  // start enter code
  const inputElements = [...document.querySelectorAll('input.code-input')]

inputElements.forEach((ele,index)=>{
  ele.addEventListener('keydown',(e)=>{
    if(e.keyCode === 8 && e.target.value==='') inputElements[Math.max(0,index-1)].focus()
  })
  ele.addEventListener('input',(e)=>{
    const [first,...rest] = e.target.value
    e.target.value = first ?? ''
    if(index!==inputElements.length-1 && first!==undefined) {
      inputElements[index+1].focus()
      inputElements[index+1].value = rest.join('')
      inputElements[index+1].dispatchEvent(new Event('input'))
    }
  })
})
  function onSubmit(e) {
  e.preventDefault()
    const code = [...document.getElementsByTagName('input')]
      .filter(({ name }) => name)
      .map(({ value }) => value)
      .join('');
    console.log(code);
  }
  // start enter code
  // start flip card
  var check_flip_brand = 0;
  var check_flip_infu = 0;
  $(".influencer_card .reg_influ_btn").click(function () {
    if (check_flip_brand == 1) {
      $(".brand_card .inner").css("transform", "rotateY(0deg)");
    }
    $(this).parent().parent().css("transform", "rotateY(180deg)");
    check_flip_infu = 1;
  });
  $(".brand_card .reg_influ_btn").click(function () {
    if (check_flip_infu == 1) {
      $(".influencer_card .inner").css("transform", "rotateY(0deg)");
    }
    $(this).parent().parent().css("transform", "rotateY(180deg)");
    check_flip_brand = 1;
  });
  //end  flip card
  // start carousel
  if ($('.brands_slider').length) {
    var brandsSlider = $('.brands_slider');
    brandsSlider.owlCarousel({
      loop:true,
      autoplay:true,
      autoplayTimeout:3000,
      nav:false,
      dots:true,
      autoWidth:true,
      items:4,
      margin:42
    });
    if($('.brands_prev').length){
      var prev = $('.brands_prev');
      prev.on('click', function(){
        brandsSlider.trigger('prev.owl.carousel');
      });
    }
    if($('.brands_next').length){
      var next = $('.brands_next');
      next.on('click', function(){
        brandsSlider.trigger('next.owl.carousel');
      });
    }
  }
  $(".owl-prev").html('');
  $(".owl-prev").append('<i class="fas fa-chevron-left arrow_left"></i>');
  $(".owl-next").html('');
  $(".owl-next").append('<i class="fas fa-chevron-right arrow_right"></i>');
  // end carousel
  $(".photo").change(function () {
    let x = $(this);
    const file = this.files[0];
    if (file) {
      let reader = new FileReader();
      reader.onload = function (event) {
        x.parent().children().children(".imgPreview").attr("src", event.target.result);
      };
      reader.readAsDataURL(file);
    }
  });
  $("#have_brand").click(function () {
    if($(this).is(":checked")){
      $(".rest_card").show(200);
    }
  });




});
