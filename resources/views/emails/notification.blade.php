<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	@include('subs::emails.style')
</head>
<body>
	<table class="container">
		<tbody>
			<tr>
				<td>
					<div class="clearfix">&nbsp;</div>
					<div class="responsive-body">
						<div class="content"> 
							<p>Hello <strong>{{ $data['user']['name'] }}</strong></p>
							<p>{!!$data['description']!!}</p>
							<p>Thank you for your business.</p>
							<div class="clearfix">&nbsp;</div>
							<p>Have a nice day!</p>
							@include('subs::emails.footer')
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>