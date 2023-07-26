<script src="{{asset('assets/vendor/datatables/dataTables.min.js')}}"></script>
<script src="{{asset('assets/vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/vendor/full-screen-helper.min.js')}}"></script>
{{--<script src="{{asset('assets/vendor/datatables/custom/custom-datatables.js')}}"></script>--}}
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>

<script src="{{asset('assets/js/editor_datatable.js')}}" ></script>

<script src="{{asset('assets/vendor/datatables/custom/fixedHeader.js')}}"></script>

<script src="{{asset('assets/vendor/slimscroll/custom-scrollbar.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/daterangepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.all.min.js"></script>
{{--<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>--}}
<script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
<script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script>

@if(session()->has('successful_message'))
    <script>
        Swal.fire("Good job!", "{{session()->get('successful_message')}}", "success");
    </script>
@elseif(session()->has('error_message'))
    <script>
        Swal.fire("Good job!", "{{session()->get('error_message')}}", "error");
    </script>
@endif

<script>
    $('.dropify').dropify();

</script>


<script>
    var tables = document.getElementsByClassName('resizable');
    for (var i = 0; i < tables.length; i++) {
        resizableGrid(tables[i]);
    }

    function resizableGrid(table) {
        var row = table.getElementsByTagName('tr')[0],
            cols = row ? row.children : undefined;
        if (!cols) return;

        table.style.overflow = 'hidden';

        var tableHeight = table.offsetHeight;

        for (var i = 0; i < cols.length; i++) {
            var div = createDiv(tableHeight);
            cols[i].appendChild(div);
            cols[i].style.position = 'relative';
            setListeners(div);
        }

        function setListeners(div) {
            var pageX, curCol, nxtCol, curColWidth, nxtColWidth, tableWidth;

            div.addEventListener('mousedown', function(e) {

                tableWidth = document.getElementById('influe').offsetWidth;
                curCol = e.target.parentElement;
                nxtCol = curCol.nextElementSibling;
                pageX = e.pageX;

                var padding = paddingDiff(curCol);

                curColWidth = curCol.offsetWidth - padding;
                //  if (nxtCol)
                //nxtColWidth = nxtCol.offsetWidth - padding;
            });

            div.addEventListener('mouseover', function(e) {
                e.target.style.borderRight = '2px solid #0000ff';
            })

            div.addEventListener('mouseout', function(e) {
                e.target.style.borderRight = '';
            })

            document.addEventListener('mousemove', function(e) {
                if (curCol) {
                    var diffX = e.pageX - pageX;

                    // if (nxtCol)
                    //nxtCol.style.width = (nxtColWidth - (diffX)) + 'px';

                    curCol.style.width = (curColWidth + diffX) + 'px';

                    document.getElementById('influe').style.width = tableWidth + diffX + "px"
                }
            });

            document.addEventListener('mouseup', function(e) {
                curCol = undefined;
                nxtCol = undefined;
                pageX = undefined;
                nxtColWidth = undefined;
                curColWidth = undefined
            });
        }

        function createDiv(height) {
            var div = document.createElement('div');
            div.style.top = 0;
            div.style.right = 0;
            div.style.width = '5px';
            div.style.position = 'absolute';
            div.style.cursor = 'col-resize';
            div.style.userSelect = 'none';
            div.style.height = height + 'px';
            return div;
        }

        function paddingDiff(col) {

            if (getStyleVal(col, 'box-sizing') == 'border-box') {
                return 0;
            }

            var padLeft = getStyleVal(col, 'padding-left');
            var padRight = getStyleVal(col, 'padding-right');
            return (parseInt(padLeft) + parseInt(padRight));

        }

        function getStyleVal(elm, css) {
            return (window.getComputedStyle(elm, null).getPropertyValue(css))
        }
    };
</script>

