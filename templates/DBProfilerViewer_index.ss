<!DOCTYPE html>
<html>
	<head>
		<title>DBProfiler</title>
		<style type="text/css">
			body { background-color:#eee; margin:0; padding:0; font-family:Helvetica,Arial,sans-serif; }
			.info { border-bottom:1px dotted #333; background-color:#ccdef3; margin:0; padding:6px 12px; }
			.info h1 { margin:0; padding:0; color:#333; letter-spacing:-2px; }
			.header { margin:0; border-bottom:6px solid #ccdef3; height:23px; background-color:#666673;
					 padding:4px 0 2px 6px; }
			.trace { padding:6px 12px; }.trace li { font-size:14px; margin:6px 0; }pre { margin-left:18px; }
			pre span { color:#999;}
			pre .error { color:#f00; }.pass { margin-top:18px; padding:2px 20px 2px 40px; color:#006600; background:#E2F9E3; border:1px solid #8DD38D; }
			.fail { margin-top:18px; padding:2px 20px 2px 40px; color:#C80700; background:#FFE9E9; border:1px solid #C80700; }
			.failure span { color:#C80700; font-weight:bold; }
			.list {padding:6px 12px; }
			.list table {font-size:14px;}
			.summary {font-size: 14px;}
			.type-show {color: #888;}
			.type-select {color: #000;}
			.type-update {color:#900;}
			.duplicates{ border: 1px solid #000; text-align: center;}
			.hide {
				display: none;
			}
		</style>
	</head>
	<body>
		<div class="info">
			<h1>DBProfiler</h1>
		</div>
		<div class="list">
			<table>
				<thead>
					<tr>
						<th>Total time</th>
						<th>Queries</th>
						<th>Url</th>
						<th>When</th>
					</tr>
					<% loop List %>	  
					<tr>
						<td>$TotalTime</td>
						<td>$Count</td>
						<td>$Url</td>
						<td><a href="$Link">$DateTime</a></td>
					</tr>
					<% end_loop %>
				</thead>
			</table>
		</div>
	</body>
</html>