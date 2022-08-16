<script type="text/javascript">
        $(document).ready(function () {
            $('#date1').scroller();
            $('#date2').scroller({ preset: 'time' });
            $('#date3').scroller({ preset: 'datetime' });
            wheels = [];
            wheels[0] = { 'Hours': {} };
            wheels[1] = { 'Minutes': {} };
            for (var i = 0; i < 60; i++) {
                if (i < 16) wheels[0]['Hours'][i] = (i < 10) ? ('0' + i) : i;
                wheels[1]['Minutes'][i] = (i < 10) ? ('0' + i) : i;
            }
            $('#custom').scroller({
                width: 90,
                wheels: wheels,
                showOnFocus: false,
                formatResult: function (d) {
                    return ((d[0] - 0) + ((d[1] - 0) / 60)).toFixed(1);
                },
                parseValue: function (s) {
                    var d = s.split('.');
                    d[0] = d[0] - 0;
                    d[1] = d[1] ? ((('0.' + d[1]) - 0) * 60) : 0;
                    return d;
                }
            });
            $('#custom').click(function() { $(this).scroller('show'); });
            $('#disable').click(function() {
                if ($('#date2').scroller('isDisabled')) {
                    $('#date2').scroller('enable');
                    $(this).text('Disable');
                }
                else {
                    $('#date2').scroller('disable');
                    $(this).text('Enable');
                }
                return false;
            });

            $('#get').click(function() {
                alert($('#date2').scroller('getDate'));
                return false;
            });

            $('#set').click(function() {
                $('#date1').scroller('setDate', new Date(), true);
                return false;
            });

            $('#theme, #mode').change(function() {
                var t = $('#theme').val();
                var m = $('#mode').val();
                $('#date1').scroller('destroy').scroller({ theme: t, mode: m });
                $('#date2').scroller('destroy').scroller({ preset: 'time', theme: t, mode: m });
                $('#date3').scroller('destroy').scroller({ preset: 'datetime', theme: t, mode: m });
                $('#custom').scroller('option', { theme: t, mode: m });
            });
        });
    </script>