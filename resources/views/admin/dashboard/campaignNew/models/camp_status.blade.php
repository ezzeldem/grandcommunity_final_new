
<div class="modal fade effect-newspaper show " id="camp_status" tabindex="-1" role="dialog" aria-labelledby="camp_status"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="camp_status">
                   Coverage Status
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              

            </div>
            <div class="modal-footer" style="justify-content: space-between !important;">
                <div class="btn">

                    <button type="button" id="action_camp_status" class="btn btn-success">Save</button>

                    <button type="button" class="btn btn-secondary" id="closeModal"
                        data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
</div>
@push('js')

    <script>
        $(document).ready( function () {



                $(document).on('click','.camp-status-visit-modal', function (event){

                event.preventDefault();
                localStorage.setItem("ModalStatus", 'visit');
                $('#camp_status .modal-body').text('');
                selectedIds = $("#exampleTbl td input[class='check-box1']:checkbox:checked").map(function(){
                    return $(this).val();
                }).toArray();


                if(localStorage.getItem('ModalStatus')=='visit'){
                    if(localStorage.getItem('TapType')=='all' || localStorage.getItem('TapType')=='confirmed' ){
                        $('#camp_status .modal-body').append(
                            `<form style="align-items :center ; gap :20px" id="camp_status">
                          <div class="row mb-4">
                            <div class="col-sm-12 col-md-12" >
                           <label> Status</label>
                                <select class="form-control" id='status_camp'>
                                    <option value="2">Visit</option>
                                    <option value="3">Not Visit</option>
                                    <option value="4">Cancel</option>
                                </select>
                            </div>
         
                            <div id="dataAppend">
                            <div class="col-sm-12 col-md-12" >
                           <label> Visit Date</label>
                                <input type="date" class="form-control" id="checkindate" >
                            </div>
                            <div class="col-sm-12 col-md-12"  >
                                <label> Branch </label>
                                <select class="form-control" name="branch_id" id="branch_id">
                                <option>Select Branch</option>
                                    @foreach($allBranches as $branch)
                                    <option value='{{$branch->id}}'>{{$branch->name}}</option>
                                    @endforeach
                                    </select>
                            </div>
                    </div>
                    </div>
                </form>`
                        );
                    }else if(localStorage.getItem('TapType')=='not-visit'){
                        selectedIds = $(this).closest("tr").find("input").val();

                        $('#camp_status .modal-body').append(
                            `<form id="camp_status">
                          <div class="row mb-4">
                            <div class="col-sm-12 col-md-12" >
                           <label> Status</label>
                                <div style="display: inline-flex;">
                                    <label for="status_confirm" style=" margin-right: 151px; "> <input type="radio" id="status_confirm" name="coverage" value="1">
                                        &nbsp;Confirm</label><br>
                                    &nbsp;<label for="status_pending"><input type="radio" id="status_pending" name="coverage" value="Done">
                                        Pending</label><br>
                                </div>
                            </div>
                           
                            <div id="dataAppend">

                            </div>
                    </div>
                </form>`
                        );
                    }else{
                        $('#camp_status .modal-body').append(
                            `<form id="camp_status">
                          <div class="row mb-4">
                            <div class="col-sm-12 col-md-12" >
                          
                                <div style="display: inline-flex;">
                                    <label for="status_confirm" style=" margin-right: 151px; "> <input type="radio" id="status_confirm" name="change_stats" value="1">
                                        &nbsp;Miss Coverage</label><br>
                                    &nbsp;<label for="status_pending"><input type="radio" id="status_pending" name="change_stats" value="2">
                                        Done</label><br>
                                </div>
                                <div class="col-sm-12 col-md-12 mb-2" >
                                        <label> Coverage Date</label>
                                        <input name="coverage_date" type="date" class="form-control" id="coverage_date" >
                                  </div>
                                
                         
                            <div id="dataAppend">



                            </div>
                            <div class="error"></div>
                    </div>
                </form>`
                        );
                    }
                }
                if(localStorage.getItem('TapType')=='not-visit' ){
                    $('#camp_status').modal('show')
                }
                if(selectedIds.length){
                    $('#camp_status').modal('show')
                }else{
                    if(localStorage.getItem('TapType')=='not-visit' ){

                    }else{
                        Swal.fire("warning", "Please select influencer first", "warning");
                    }
                }



            })





           
                $('.select2').select2({
                    multiple:true,
                });
            

            $(document).on('click','.camp-status-confirm-modal', function (event){
                event.preventDefault();
                localStorage.setItem("ModalStatus", 'confirm');
                $('#camp_status .modal-body').text('');
                selectedIds = $("#exampleTbl td input[class='check-box1']:checkbox:checked").map(function(){
                    return $(this).val();
                }).toArray();
                if(localStorage.getItem('ModalStatus')=='confirm'){

                    $('#camp_status .modal-body').append(
                        `<form style="display:flex;align-items :center ; gap :20px" id="camp_status">

                        <div class="row mb-4">
                            <div class="col-sm-12 col-md-12" >
                                 <div class="form-group">
                                     <label> Confirmation Date</label>
                                     <input type="date"  class="form-control" id="confirm_date" >
                                 </div>
                            </div>
                          <div class="col-sm-12 col-md-12"  >
                                <label> Branch </label>
                                <select class="form-control" name="branch_id" id="branch_id">
                                <option>Select Branch</option>
                                    @foreach($allBranches as $branch)
                                <option value='{{$branch->id}}'>{{$branch->name}}</option>
                                            @endforeach
                                </select>
                       </div>

                        <div class="col-sm-12 col-md-12 mt-2" >
                                <div class="form-group">
                                        <label class="control-label col-md-4">Invetaion</label>
                                        <div style="display: inline-flex;">
                                            <label for="brief_no" style=" margin-right: 151px; "> <input type="radio" id="brief_no" name="invetaion" value="0">
                                                &nbsp;Not sent</label><br>
                                            &nbsp;<label for="brief_yes"><input type="radio" id="brief_yes" name="invetaion" value="1">
                                                sent</label><br>
                                        </div>
                                </div>

                                <div class="form-group">
                                        <label class="control-label col-md-4">Brief</label>
                                        <div style="display: inline-flex;">
                                            <label for="brief_no" style=" margin-right: 151px; "> <input type="radio" id="brief_no" name="brief_stats" value="0">
                                                &nbsp;Not sent</label><br>
                                            &nbsp;<label for="brief_yes"><input type="radio" id="brief_yes" name="brief_stats" value="1">
                                                sent</label><br>
                                        </div>
                                </div>
                        </div>
           
          </div>

        </form>`
                    )
                }
                if(selectedIds.length){
                    $('#camp_status').modal('show')
                }else{
                    Swal.fire("warning", "Please select influencer first", "warning");
                }



            })

            $(document).on('click','.camp-status-missed_visit-modal', function (event){
               
                event.preventDefault();
                localStorage.setItem("ModalStatus", 'Missed_Visit');
                $('#camp_status .modal-body').text('');
                selectedIds = $("#exampleTbl td input[class='check-box1']:checkbox:checked").map(function(){
                    return $(this).val();
                }).toArray();
                if(localStorage.getItem('ModalStatus')=='Missed_Visit'){

                    $('#camp_status .modal-body').append(
                        `<form style="align-items :center ; gap :20px" id="camp_status">
                            <div class="row mb-4">
                                       <div class="col-sm-12 col-md-12" >
                                               <label> Reason</label>
                                               <input type="textarea" name="reason" class="form-control" id="reason" >
                                           </div>    
                                       </div>
                            </form>`
                    )
                }
                if(selectedIds.length){
                    $('#camp_status').modal('show')
                }else{
                    Swal.fire("warning", "Please select influencer first", "warning");
                }



            })

            $(document).on('click','.camp-status-reject-modal', function (event){
               
               event.preventDefault();
               localStorage.setItem("ModalStatus", 'reject');
               $('#camp_status .modal-body').text('');
               selectedIds = $("#exampleTbl td input[class='check-box1']:checkbox:checked").map(function(){
                   return $(this).val();
               }).toArray();
               if(localStorage.getItem('ModalStatus')=='reject'){

                   $('#camp_status .modal-body').append(
                       `<form style="align-items :center ; gap :20px" id="camp_status">
                              
                                       <div class="row mb-4">
                                       <div class="col-sm-12 col-md-12" >
                                               <label> Reason</label>
                                               <input type="textarea"  name="reason" class="form-control" id="reason" >
                                           </div>    
                                       </div>
                           </form>`
                   )
               }
               if(selectedIds.length){
                   $('#camp_status').modal('show')
               }else{
                   Swal.fire("warning", "Please select influencer first", "warning");
               }
           })












           //btn close in modal
            $('#closeModal').on('click',function (){
                $('#camp_status .modal-body').text('');
            })

            $(document).on("change","#status_camp",function() {
                
                if(this.value ==3 || this.value==4){
                    $('#camp_status .modal-body #dataAppend').text('');
                    $('#camp_status .modal-body #dataAppend').append( `
                    <div class="col-sm-12 col-md-12" >
                        <label> Not Visit Reason </label>
                        <textarea id="reason" type="date" class="form-control" >

                        </textarea>
                     </div>
                `)
                }else{
                    $('#camp_status .modal-body #dataAppend').text('');
                    $('#camp_status .modal-body #dataAppend').append(`
                    <div class="col-sm-12 col-md-12" >
                           <label>Visit Date</label>
                                <input type="date" class="form-control" >
                            </div>
                            <div class="col-sm-12 col-md-12" >
                           <label> Branch </label>
                                <select class="form-control" name="branch_id" id="branch_id">
                                     <option>Select Branch</option>
                                        @foreach($allBranches as $branch)
                                    <option value='{{$branch->id}}'>{{$branch->name}}</option>
                                        @endforeach
                                </select>
                </div>
`)
                }

            });

            $(document).on("change","[name='coverage_stats']",function() {
                    if(this.value==1){
                        $('#camp_status .modal-body .row').append(`
                          <div class="col-sm-12 col-md-12 " id="coverageDate" >
                                 <div class="form-group">
                                     <label> Coverage Date</label>
                                     <input type="date" class="form-control" id="coverage_date" >
                                 </div>
                            </div>
                        `);
                    }else{
                        $('#camp_status .modal-body .row #coverageDate').text('');
                    }
            });

            $('#action_camp_status').on('click',function (){


                let reqUrl=''
                let data='';
                let camp_id={{$campaign->id}};

                if(localStorage.getItem('ModalStatus')=='visit'){
                    if(localStorage.getItem('TapType')=='visit'){
                        let visit_status_change  =$('[name="change_stats"]').val();
                        if(visit_status_change==1){
                            let selectedcoverage =  $("select[name='coverage'] option:selected").length;
                            if(selectedcoverage == 0){
                             $('.error').text('');
                            $('.error').append(`
                            <span style="color:red;margin-left:20px">you should select data</span>
                            
                            `);
                        
                           }else{
                            reqUrl = `/dashboard/campaign-influ/confirm_status`;
                            let confirm_date  =$('#confirm_date').val();
                            let brief=$("[name='brief_stats']").val();
                            let invetaion=$("[name='invetaion']").val();
                            let coverage_status=$("[name='coverage']").val();
                            let coverage_date=$('#coverage_date').val();
                            data ={users_list:selectedIds,confirm_date:confirm_date,brief:brief,coverage_status:coverage_status,coverage_date:coverage_date,camp_id:camp_id};
                           }
                        
                        }else{
                            
                            reqUrl = `/dashboard/campaign-influ/updateInflueStatusPending`;
                            data ={users_list:selectedIds,status:0};
                        }
                       }else if(localStorage.getItem('TapType')=='not-visit'){
                         
                        reqUrl = `/dashboard/campaign-influ/influe_status`;
                        let branch_id  =$('#branch_id').val();
                        let checkindate=$('#checkindate').val();
                        let status_camp=$('#status_camp').val();
                        let reason=$('#reason').val();
                        selectedIds = $('#statusdone').attr('data-id');
                        
                        data ={users_list:selectedIds,branch_id:branch_id,checkindate:checkindate,status_camp:status_camp,reason:reason,camp_id:camp_id};
                    }else{

                        reqUrl = `/dashboard/campaign-influ/influe_status`;
                        let branch_id  =$('[name="branch_id"]').val();
                        let checkindate=$('#checkindate').val();
                        let status_camp=$('#status_camp').val();
                        let reason=$('#reason').val();
                        data ={users_list:selectedIds,branch_id:branch_id,checkindate:checkindate,status_camp:status_camp,reason:reason,camp_id:camp_id};
                    }

                }else if(localStorage.getItem('ModalStatus')=='Missed_Visit'){
                    reqUrl = `/dashboard/campaign-influ/reject`;
                    let confirm_date  =$($('[name="confirm_date"]')).val();
                    let branch  =$("[name='branch_id']").val();
                    let brief=$("[name='brief_stats']").val();
                    let coverage_status=$("[name='coverage']").val();
                    let coverage_date=$('#coverage_date').val();
                    let reason=$('#reason').val();
                    let missed_visit_date=$("[name='missed_visit_date']").val();
                    let status = 3;
                    data ={users_list:selectedIds,reason:reason,branch:branch,status:status,missed_visit_date:missed_visit_date,confirm_date:confirm_date,brief:brief,coverage_status:coverage_status,coverage_date:coverage_date,camp_id:camp_id};
                }else if(localStorage.getItem('ModalStatus')=='reject'){
                    reqUrl = `/dashboard/campaign-influ/reject`;
                    let confirm_date  =$($('[name="confirm_date"]')).val();
                    let branch  =$("[name='branch_id']").val();
                    let brief=$("[name='brief_stats']").val();
                    let coverage_status=$("[name='coverage']").val();
                    let coverage_date=$('#coverage_date').val();
                    let reason=$("[name='reason']").val();
                    let status = 4;
                    data ={users_list:selectedIds,branch:branch,status:status,reason:reason,confirm_date:confirm_date,brief:brief,coverage_status:coverage_status,coverage_date:coverage_date,camp_id:camp_id};

                
                }else{
                    reqUrl = `/dashboard/campaign-influ/confirm_status`;
                    let confirm_date  =$($('[name="confirm_date"]')).val();
                    let branch  =$("[name='branch_id']").val();
                    let brief=$("[name='brief_stats']").val();
                    let invetaion=$("[name='invetaion']").val();
                    let coverage_status=$("[name='coverage']").val();
                    let coverage_date=$('#coverage_date').val();
                    
                    data ={users_list:selectedIds,branch:branch,invetaion:invetaion,confirm_date:confirm_date,brief:brief,coverage_status:coverage_status,coverage_date:coverage_date,camp_id:camp_id};

                }

                $.ajax({
                    url:reqUrl,
                    type:'post',
                    data:data,
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success:(response)=>{
                        console.log(data)
                        //window.location.reload();
                        let item=''
                        console.log('the url abdullah'+reqUrl)
                   
                        let countSuccess=0
                        let countFaild=0
                        if(response.data){
                            let name=[];
                            response.data.map((msg)=> (msg.message=='success')?(countSuccess = countSuccess+1):(countFaild=countFaild+1 ,name.push(msg.visitDate)));
                            if(name[0]!=null){
                                item='Sorry... But The Code Already Used Try Again After 10 Minute';
                            }else{
                                item=name.map((i,key)=> `<li>${key+1} - ${i}</li>`).join('');
                            }
                            Swal.fire("Done", `<ul><li class="m-b2">Success : <span class="badge badge-pill badge-success ">${countSuccess}</span></li> <li class="m-b-2">Faild : <span class="badge badge-pill badge-danger">${countFaild}</span></li> Influencers Failed <div class="mb-2 mt-2 styled-scrollbars" style="overflow-y: scroll; max-height: 99px"> ${item}</div></ul>`, "success");

                        }else{
                         Swal.fire("Done", "Successfully!", "success");
                        }


                        exampleTbl.ajax.reload();

                        $('#camp_status').modal('hide')
                    },
                    error:()=>{
                        Swal.fire("error", "something went wrong please reload page", "error");
                    }
                })
            })



//action for one influncer



$('#action_camp_one_influncer_status').on('click',function (){
               let reqUrl=''
               let data='';
               let camp_id={{$campaign->id}};
               if(localStorage.getItem('ModalStatus')=='visit'){
                   if(localStorage.getItem('TapType')=='visit'){
                       let visit_status_change  =$('[name="change_stats"]').val();
                       if(visit_status_change==1){
                          
                       
                           reqUrl = `/dashboard/campaign-influ/confirm_status`;
                           let confirm_date  =$('#confirm_date').val();
                           let brief=$("[name='brief_stats']").val();
                           let coverage_status=$("[name='coverage']").val();
                           let coverage_date=$('#coverage_date').val();
                           data ={users_list:selectedIds,confirm_date:confirm_date,brief:brief,coverage_status:coverage_status,coverage_date:coverage_date,camp_id:camp_id};
                     
                       }else{
                           reqUrl = `/dashboard/campaign-influ/updateInflueStatusPending`;
                           data ={users_list:selectedIds,status:0};
                       }
                   }else{

                       reqUrl = `/dashboard/campaign-one-influncer/influe_status`;
                       let branch_id  =$('#branch_id').val();
                       let checkindate=$('#checkindate').val();
                       let status_camp=$('#status_camp').val();
                       let reason=$('#reason').val();
                       data ={users_list:selectedIds,branch_id:branch_id,checkindate:checkindate,status_camp:status_camp,reason:reason,camp_id:camp_id};
                   }

               }else{
                   reqUrl = `dashboard/campaign-one-influncer/influe_status`;
                   let confirm_date  =$('#confirm_date').val();
                   let brief=$("[name='brief_stats']").val();
                   let coverage_status=$("[name='coverage_stats']").val();
                   let coverage_date=$('#coverage_date').val();
                   data ={users_list:selectedIds,confirm_date:confirm_date,brief:brief,coverage_status:coverage_status,coverage_date:coverage_date,camp_id:camp_id};

               }
               $.ajax({
                   url:reqUrl,
                   type:'post',
                   data:data,
                   headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                   success:()=>{
                       //window.location.reload();
                       exampleTbl.ajax.reload();
                       Swal.fire("Codes Generated", "Update Successfully!", "success");
                       $('#camp_status').modal('hide')
                   },
                   error:()=>{
                       Swal.fire("error", "something went wrong please reload page", "error");
                   }
               })
           })








            $(document).on('change','[name="change_stats"]',function (){
                if(this.value==1){
                
                         
                    $('#camp_status .modal-body #dataAppend').text('');
                    $('#camp_status .modal-body #dataAppend').append(
                        `
                                 <div class="col-sm-12 col-md-12" >
                                    <select class="form-control select2" name="coverage" multiple="multiple" id="multicoverage">
                                            <option value="2">Need Brief</option>
                                            <option value="3">Need Mention</option>
                                            <option value="4">Need Snapchat</option>
                                            <option value="5">Need Swip</option>
                                            <option value="6">Need Tiktok</option>
                                            <option value="7">Wrong Mention</option>
                                     </select>
                                 </div>
                               
                    `)
                    $('#multicoverage').select2({
                        placeholder:'Select Coverage',
                        closeOnSelect: false,
                        tags:true,
                    });
                
                }else{
                    $('#camp_status .modal-body #dataAppend').text('');
                    $('#camp_status .modal-body #dataAppend').append(
                        `
                                 <div class="col-sm-12 col-md-12" style="display:none">
                                    <select class="form-control select2" name="coverage" multiple id="">
                                            <option value="1" selected>Done</option>    
                                    </select>
                                 </div>
                                
                    `

                    );
                    
                }
            })
        })
       $(window).on('load',function (){
           localStorage.setItem("TapType", 'all');
           localStorage.setItem("ModalStatus", 'visit');

       });

$('.select2').select2({
    dropdownParent: $('#camp_status')
});
    </script>
@endpush
