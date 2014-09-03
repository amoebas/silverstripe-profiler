<!DOCTYPE html>
<html>
<head><title>GET /dev/</title>
    <link rel="stylesheet" type="text/css" href="http://sandbox.dev/framework/css/debug.css"/>
</head>
<body>
<div class="info">
    <h1>SilverStripe Development DBProfiler</h1>
    <h3>$AbsoluteBaseURL</h3><a href="$Link">DBProfile</a>
    <div>$List.Count queries took $List.TotalTime ms and $List.DuplicateCount duplicates stole $List.DuplicateTime ms</div>
</div>

<div class="options">
    <table id="listview">
        <thead>
        <tr>
            <th>Ms</th>
            <th>Dupes</th>
            <th>sha1</th>
            <th>Query</th>
            <th>Trace</th>
        </tr>
        </thead>

        <tbody>
	        <% loop $List %>
            <tr>
                <td>$Time</td>
                <td class="center">
	                <div <% if $Duplicates %>class="duplicates" style="background-color: #$BackgroundColor; color: #$Color"<% else %><% end_if %>>$Duplicates</div>
                </td>
                <td class="type-$Type">$Sha1</td>
                <td class="type-$Type query">
	                <% if $QuerySummary %>
                        <span class="display cursor">$QuerySummary</span>
                        <span class="hide cursor">$Query</span></td>
	                <% else %>
                        <span class="display">$Query</span>
	                <% end_if %>
                <td>
                    <span class="display cursor">show</span>
                    <span class="hide cursor">$Stacktrace.Trace</span>
                </td>
            </tr>
	        <% end_loop %>
        </tbody>

    </table>
</div>
</div>
<script>
    $(document).ready( function () {
        $('#listview').DataTable({
            "paging": false,
            "order": []
        });
    });
</script>
</body>
</html>