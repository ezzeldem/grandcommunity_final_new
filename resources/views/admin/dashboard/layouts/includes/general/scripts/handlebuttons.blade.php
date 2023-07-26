

<script>
   $( document ).ready(function() {
       let log = console.log;

          $('#Total_Brands').on('click', function(){
            $('#status').val('');
              log('Total_Brands');

            $('#status_id_search').val('');
            brand_tabels.ajax.reload();
        });

        $('#InActive_Brands').on('click', function(){
            $('#status').val(0);
          

            $('#status_id_search').val(0);
            brand_tabels.ajax.reload();
        });

        $('#Active_Brands').on('click', function(){
            $('#status_id_search').val(1);
            brand_tabels.ajax.reload();
        });

        $('#Pending_Brands').on('click', function(){
            $('#status_id_search').val(2);
            brand_tabels.ajax.reload();
        });

        $('#Rejected_Brands').on('click', function(){
            $('#status_id_search').val(3);
            brand_tabels.ajax.reload();
        });
    });
    </script>

