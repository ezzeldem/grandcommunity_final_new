<link rel="stylesheet" type="text/css" href="{{asset('assets\css\daterangepicker.css')}}" />
<!-- Data Tables -->
<link rel="stylesheet" href="{{asset('assets/vendor/datatables/dataTables.bs4.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/datatables/dataTables.bs4-custom.css')}}" />

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css" />
{{--<link href="{{asset('assets/vendor/datatables/buttons.bs.css')}}" rel="stylesheet" />--}}
{{--<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">--}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
<link rel="stylesheet" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="{{asset('assets\css\daterangepicker.css')}}" />

<style>
    /* start table style */
    #exampleTbl tbody tr td a{
        color: #bcd0f7;
    }
    table{
        width: 100% !important;
    }
    .fixedHeader-floating>thead>tr>th {
        display: inline-block !important;
        width: inherit !important;
    }
    .global_btn{
        outline: none;
        border: 1px solid transparent;
        text-transform: uppercase;
        font-weight: 600;
        padding: 7px 18px;
        border-radius: 9px;
        box-shadow: 0 3px 1px -2px #0003, 0 2px 2px #00000024, 0 1px 5px #0000001f;
        margin: 1rem 0.5rem;
        color: #fff;
        transition: all 0.2s ease-in-out;
        text-decoration:none;
    }
    .global_btn span{
        border-radius: 4px;
        font-weight: 600;
        text-align: center;
        line-height: 9px;
        background: #1a233a47;
        color: #fff;
    }
    .global_btn:hover{
        filter: brightness(0.85);
        color: #fff;

    }
    .global_btn.danger{
        background: #8d2828b3;
    }
    .global_btn.add{
        background: #0e914a8f;
    }
    .global_btn.create{
        background: #4679dceb;
    }
    .global_btn.export{
        background: #eaae1663;
    }

    div.dt-button-collection button.dt-button.active:not(.disabled){
        background: #1a233a;
        border-radius:0 !important;
    }
    div.dt-button-collection>:last-child{
        overflow:auto;
        height: 200px;
    }

    div.dt-button-collection>:last-child::-webkit-scrollbar {
        width: 2px;
    }
    div.dt-button-collection>:last-child::-webkit-scrollbar-track {
        background: #0F1C24;
    }
    div.dt-button-collection>:last-child::-webkit-scrollbar-thumb {
        background: #0F1C24;
    }
    div.dt-button-collection>:last-child::-webkit-scrollbar-thumb:hover {
        background: #3A5363;
    }

    table tr td > .img-thumbnail{
        height: 30px;
        width: 30px;
    }
    /* end table style */


    /** start switch button style **/
    .switch_parent input[type='checkbox']{
         display: block;
         opacity: 0;
     }
    .switch_parent .switch{
        position: relative;
        width: 30px;
        height: 34px;
        display: inline-block;
        background: #666666;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s;
        -moz-transition: all 0.3s;
        -webkit-transition: all 0.3s;
    }
    .switch_parent .switch:after{
        content: "";
        position: absolute;
        left: 2px;
        top: 2px;
        width: 10px;
        height: 30px;
        background: #FFF;
        border-radius: 50%;
        box-shadow: 1px 3px 6px #666666;
    }
    .switch_parent input[type='checkbox']:checked + .switch{
        background: #009900;
    }
    .switch_parent input[type='checkbox']:checked + .switch:after{
        left: auto;
        right: 2px;
    }
    /** end switch button style **/

    .buttons-colvis{
        border-radius: 2px !important;
    }
    .buttons-colvis:hover{
        transform :scale(1.05)
    }
    div.dt-button-collection{
        background: #1a233a !important;
    }
    table.dataTable.fixedHeader-floating{
        display: none;
    }

    .switch {
  position: relative;
  display: inline-block;
  width: 20px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {

    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    width: 50px;
    height: 25px;

}

.slider:before {

    position: absolute;
    content: "";
    height: 15px;
    width: 15px;
    left: 4px;
    bottom: 5px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

.table-loader{
   visibility:hidden;
}
.table-loader:before {
        visibility: visible;
        display: table-caption;
        content: " ";
        width: 100%;
        height: 600px;
        background-image: linear-gradient( #181818 1px, transparent 0 ), linear-gradient(90deg, #181818 1px, transparent 0 ), linear-gradient( 90deg, rgba(255, 255, 255, 0), rgb(126 126 126 / 16%) 15%, rgba(255, 255, 255, 0) 30% ), linear-gradient( #181818 35px, transparent 0 );
        background-repeat: repeat;
        background-size: 1px 35px, calc(100% * 0.1666666666) 1px, 30% 100%, 2px 70px;
        background-position: 0 0, 0 0, 0 0, 0 0;
        animation: shine 0.5s infinite;
        opacity: 0.4;
	}

	@keyframes shine {
		to {
			background-position:
				0 0,
        0 0,
        40% 0,
				0 0;
		}
	}
		/* This is the space for the spinner to appear, applied to the button */
		.spin {
  padding-left: 2.5em;
  display: block;
}

/* position of the spinner when it appears, you might have to change these values */
.spin .spinner {
  left: 6.4em;
  top: 0.4em;
  width: 2.5em;
  display: block;
  position: absolute;
}
@keyframes spinner {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}

/* The actual spinner element is a pseudo-element */
.spin .spinner::before {
  content: "";
  width: 1.5em; /* Size of the spinner */
  height: 1.5em; /* Change as desired */
  position: absolute;
  top: 50%;
  left: 50%;
  border-radius: 50%;
  border: solid 0.35em #999; /* Thickness/color of spinner track */
  border-bottom-color: #555; /* Color of variant spinner piece */
  animation: 0.8s linear infinite spinner; /* speed of spinner */
  transform: translate(-50%, -50%);
  will-change: transform;
}

</style>
