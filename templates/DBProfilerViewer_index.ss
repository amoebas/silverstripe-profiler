<!DOCTYPE html>
<html>
<head><title>GET /dev/</title>
    <link rel="stylesheet" type="text/css" href="http://sandbox.dev/framework/css/debug.css"/>
</head>
<body>
<div class="info">
	<h1>SilverStripe Development DBProfiler</h1>
    <h3>$AbsoluteBaseURL</h3><a href="$Link">DBProfile</a></div>
	<div class="options">
	    <table id="listview">
	        <thead>
	        <tr>
	            <th>Total time</th>
	            <th>Queries</th>
	            <th>Url</th>
	            <th>When</th>
	        </tr>
	        </thead>
            <tbody>
				<% loop $List %>
	            <tr>
	                <td>$TotalTime</td>
	                <td>$Count</td>
	                <td>$Url</td>
	                <td><a href="$Link">$DateTime</a></td>
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
    } );
</script>
</body>
</html>
