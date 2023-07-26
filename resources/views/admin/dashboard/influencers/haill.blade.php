 $('.social_media').on('change',function(){
              var  slectedvalue = $(this).val()
                 $('.inputsocial').attr('name',slectedvalue+'_uname')
                 $('.inputsocial').attr('placeholder','Enter '+slectedvalue+' username')
            });



            $('.social_media').append(html);
            $('.add_social_input').on('click',function(){

                var removeItem = $("select[name='platforms[]']" ).find(':selected').val()
                console.log(removeItem);
                platforms = jQuery.grep(platforms, function(value) {
                    html =''
                    return value != removeItem;
                    });

                    $.each(platforms, function(index, value) {
                    html += '<option value=' + value + '>' + value + '</option>'
                      });
                      var myselect = $(`<div class="form-group">
                              <label class="form-label">Social Media <span class="text-danger">*</span></label>
                                <div class="form formgroupsocialMedia" style=" display: flex; align-items: stretch; " id="formgroupsocialMedia">
                                    <select name="platforms" class="form-control parsley-error selectappend"  onchange="newfunc(this)" id="social_media" name="social_media" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2">
                                        <option value="" selected disabled>Select</option>
                                        ${html}
                                    </select>
                                        @error('social_media')
                                        <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                    <input type="text" style=" flex: 1 1 auto; min-width: 70%; background: aliceblue; " id="inputselect"  class="form-control inputselect">
                                    </div>
                                </div>
                            `)
                          $('.allSocails').prepend(myselect)
                        });



                    function newfunc(ele){
                        var inputval = $(ele).val();
                       $('#inputselect').attr('name',inputval+'_uname')
                       $('#inputselect').attr('placeholder','Enter '+inputval+' username')

                    }
