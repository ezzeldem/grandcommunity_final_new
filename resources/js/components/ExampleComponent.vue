<template>
    <div class="notification p-relative">
            <button type="button" @click="notifi" class="btn btn_bell" style="">
                <i class="fas fa-bell"></i>
                <span class="badge" style="background: transparent;
                position: absolute;
                top: 2px;
                right: 52px;
                font-size: 12px;">4</span>
            </button>
            <div class="notifications_list" id="box">
                <h2>Notifications - <span>2</span></h2>
                <div class="notifications-item"> <img src="https://i.imgur.com/uIgDDDd.jpg" alt="img">
                    <div class="text">
                        <h4>Samso aliao</h4>
                        <p>Samso Nagaro Like your home work</p>
                    </div>
                </div>
                <div class="notifications-item"> <img src="https://img.icons8.com/flat_round/64/000000/vote-badge.png" alt="img">
                    <div class="text">
                        <h4>John Silvester</h4>
                        <p>+20 vista badge earned</p>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        data(){
            return{
                down : false
            }
        },
        mounted() {},
        methods:{
            notifi(){
              
            }
        }
    }
</script>
