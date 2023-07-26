{{-- <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet"> --}}
<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: test-field;
    }

    .form-label {
        margin-bottom: 5px;
    }

    .switch_parent input[type='checkbox'] {
        display: block;
        opacity: 0;
    }

    .switch_parent .switch {
        position: relative;
        width: 60px;
        height: 34px;
        display: inline-block;
        background: #666666;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s;
        -moz-transition: all 0.3s;
        -webkit-transition: all 0.3s;
    }

    .switch_parent .switch:after {
        content: "";
        position: absolute;
        left: 2px;
        top: 2px;
        width: 30px;
        height: 30px;
        background: #FFF;
        border-radius: 50%;
        box-shadow: 1px 3px 6px #666666;
    }

    .switch_parent input[type='checkbox']:checked+.switch {
        background: #009900;
    }

    .switch_parent input[type='checkbox']:checked+.switch:after {
        left: auto;
        right: 2px;
    }

    .select2-results__options {
        background: var(--main-bg-color) !important;
    }


    .multiselect {
        width: 200px;
    }

    .selectBox {
        position: relative;
    }

    .selectBox select {
        width: 100%;
        font-weight: bold;
    }

    .overSelect {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }

    #checkboxes {
        display: none;
        border: 1px #dadada solid;
    }

    #checkboxes label {
        display: block;
    }

    #checkboxes label:hover {
        background-color: #1e90ff;
    }





    .dropdown-check-list {
        display: inline-block;
    }

    .dropdown-check-list .anchor {
        position: relative;
        cursor: pointer;
        display: inline-block;
        padding: 5px 50px 5px 10px;
        border: 1px solid #ccc;
    }

    .dropdown-check-list .anchor:after {
        position: absolute;
        content: "";
        border-left: 2px solid black;
        border-top: 2px solid black;
        padding: 5px;
        right: 10px;
        top: 20%;
        -moz-transform: rotate(-135deg);
        -ms-transform: rotate(-135deg);
        -o-transform: rotate(-135deg);
        -webkit-transform: rotate(-135deg);
        transform: rotate(-135deg);
    }

    .dropdown-check-list .anchor:active:after {
        right: 8px;
        top: 21%;
    }

    .dropdown-check-list ul.items {
        padding: 2px;
        display: none;
        margin: 0;
        border: 1px solid #ccc;
        border-top: none;
    }

    .dropdown-check-list ul.items li {
        list-style: none;
    }

    .dropdown-check-list.visible .anchor {
        color: #0094ff;
    }

    .dropdown-check-list.visible .items {
        display: block;
    }

    .multiple_select_classification .btn-group {
        width: 100%;
        background-color: transparent !important;
    }

    .multiple_select_classification ul.multiselect-container {
        width: 100%;
        padding: 5px 10px;
        background: #111;
        border: 1px solid var(--border-color);
    }

    .multiple_select_classification li a,
    .multiple_select_classification li a:hover {
        color: #fff
    }

    .select2-container--default .select2-selection--single, .select2-container--default {
        background: #202020 !important;
    }

</style>
