
<div class="modal fade modal-attach" id="show_to_brand_modal" tabindex="-1" role="dialog" aria-labelledby="show_to_brand_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 100%;width: 100%;text-align: center;display: flex;align-items: center;justify-content: center;">
        <div class="modal-content" style="width: 100%">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Company Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">





<!-- Expiration date Modal -->
<!-- <div class="modal fade" id="add_expiration_date" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
{{--                <h5 class="modal-title" id="exampleModalLabel">Add Expiration Date</h5>--}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="parent_of_expiration">
                    <label>Expiration Date</label>
                    <input type="date" class="form-control" min="{{date('Y-m-d')}}" id="expire_date_input" />
                    <small class="text-danger" id="expre_date_err"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Close</button>
                <button type="button" id="active_user" class="btn">Active</button>
            </div>
        </div>
    </div>
</div> -->





<div class="container">
<div class="row">
                    <div class="col-md-4">
                        <div class="well imageuserdetail">
                        </div>
                    </div>

                    <div class="col-md-8" style="display: flex;text-align: left;border-radius: 10px;padding: 1rem 1.1rem;margin: 1rem 0rem;">
                        <div class="well float-left">
                            <ul>
                                <li class="item">
                                    <span class="badge badge-primary">
                                        Name :-
                                    </span>
                                    <span class="text name">

                                    </span>
                                </li>


                                <li class="item">
                                    <span class="badge badge-primary">
                                        Active Groups :-
                                    </span>
                                    <span class="text active_groups">
                                    </span>
                                </li>


                                <li class="item">
                                    <span class="badge badge-primary">
                                        Countreis :-
                                    </span>
                                    <span class="text countries">

                                    </span>
                                </li>

                               <li class="item">
                                    <span class="badge badge-primary">
                                        INActive Groups :-
                                    </span>
                                    <span class="text inactive_groups">
                                    </span>
                                </li>



                                <li class="item">
                                    <span class="badge badge-primary">
                                        Phone :-
                                    </span>
                                    <span class="text phone">

                                    </span>
                                </li>
                                <li class="item">
                                    <span class="badge badge-primary">
                                        Instagram :-
                                    </span>
                                    <span class="text insta">

                                    </span>
                                </li>

                                <li class="item">
                                    <span class="badge badge-primary">
                                        WhatsApp :-
                                    </span>
                                    <span class="text whatsapp">

                                    </span>
                                </li>
                                <li class="item">
                                    <span class="badge badge-primary">
                                        TikTok :-
                                    </span>
                                    <span class="text tiktok">

                                    </span>
                                </li>

                                <li class="item">
                                    <span class="badge badge-primary">
                                        Gender :-
                                    </span>
                                    <span class="text gender">

                                    </span>
                                </li>

                                <li class="item">
                                    <span class="badge badge-primary">
                                        SnapChat :-
                                    </span>
                                    <span class="text snapchat">

                                    </span>
                                </li>


                                 <li class="item">
                                    <span class="badge badge-primary">
                                        Groups Count :-
                                    </span>
                                    <span class="text groups_count">
                                    </span>
                                </li>





                            </ul>
                            <div class="show_icon" style="margin: left auto;"></div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
            <div class="modal-footer">

                <div class="divshow">

               </div>
            </div>
        </div>
    </div>

</div>
@push('js')
<script>
    $(document).ready(function() {

    })
</script>

@endpush
