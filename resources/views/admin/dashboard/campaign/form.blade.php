<style>
.__addCampaign-container .stepwizard .stepwizard-row .stepwizard-step{
    padding: 24px 0 !important;
    flex-basis: unset !important;
}
</style>
<div class="__addCampaign-container create_form">
    <div class="row justify-content-center">
    <div class="col-lg-10 col-md-12" >
        <!-- <h5><i class="fas fa-link"></i> Campaign</h5> -->
        <div class="row">
            <div class="stepwizard">
                <div class="stepwizard-row setup-panel" style="box-shadow:none;">
                    <div class="stepwizard-step">
                        <a href="javascript:(0);" id="heading-step-1" type="button" class="btn btn-primary btn-circle">1</a>
                        <p class="step-name">Step 1</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="javascript:(0);" id="heading-step-2" type="button" class="btn btn-default btn-circle">2</a>
                        <p  class="step-name">Step 2</p>
                    </div>
{{--                    <div class="stepwizard-step">--}}
{{--                        <a href="javascript:(0);" id="heading-step-3" type="button" class="btn btn-default btn-circle">3</a>--}}
{{--                        <p  class="step-name"> Step 3</p>--}}
{{--                    </div>--}}
{{--                    <div class="stepwizard-step">--}}
{{--                        <a href="javascript:(0);" id="heading-step-4" type="button" class="btn btn-default btn-circle">4</a>--}}
{{--                        <p  class="step-name">Step 4</p>--}}
{{--                    </div>--}}

                </div>
            </div>

            <div class="form-container container-fluid" style="background-color: #232323; ">
                @include('admin.dashboard.campaign.steps.step_1')
                @include('admin.dashboard.campaign.steps.step_2')
            </div>
        </div>
    </div>
</div>
</div>