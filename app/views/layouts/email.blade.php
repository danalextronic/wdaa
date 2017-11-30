<html>
	<head>
		<title>@yield('subject')</title>
		
		<style type="text/css">
				#outlook a{
					padding:0;
				}
				body{
				background-color: white;
				}
				.ReadMsgBody{
				}
				.ExternalClass{
				}
				body{
					-webkit-text-size-adjust:none;
				}
				body{
					margin:0;
					padding:0;
				}
				img{
					border:0;
					height:auto;
					line-height:100%;
					outline:none;
					text-decoration:none;
				}
				
				.photo{
					text-align: center;
					margin-bottom: 10px;
					border: 1px solid #cbcbcb;
					width: 558px;
					height: 225px;
				}

				table td{
					border-collapse:collapse;
				}
				#backgroundTable{
					height:100% !important;
					margin:0;
					padding:0;
						}
				body,#backgroundTable{
					background-color:#FAFAFA;
				}
				#templateContainer{
					border:1px solid #DDDDDD;
				}
				h1,.h1{
					color:#202020;
					display:block;
					font-family:Arial;
					font-size:22px;
					font-weight:bold;
					line-height:100%;
					margin-top:0;
					margin-right:10px;
					margin-bottom:10px;
					margin-left:10px;
					text-align:left;
				}
				h2,.h2{
			color:#006699;
			display:block;
			font-family:Arial;
			font-size:20px;
			font-weight:bold;
			line-height:100%;
			margin-top:0;
			margin-right:10px;
			margin-bottom:10px;
			margin-left:10px;
			text-align:left;
				}
				h3,.h3{
			color:#006699;
			display:block;
			font-family:Arial;
			font-size:16px;
			font-weight:bold;
			line-height:100%;
			margin-top:0;
			margin-right:10px;
			margin-bottom:10px;
			margin-left:10px;
			text-align:left;
				}
				p, .p {
					margin:10px;
					line-height: 1.4em;
					font-family: Arial, Helvetica, sans-serif;
					font-size: 14px;
				}
				#templatePreheader{
					background-color:#FAFAFA;
				}
				.preheaderContent div{
					color:#505050;
					font-family:Arial;
					font-size:10px;
					line-height:100%;
					text-align:left;
				}
				.preheaderContent div a:link,.preheaderContent div a:visited,.preheaderContent div a .yshortcuts {
					color:#336699;
					font-weight:normal;
					text-decoration:underline;
				}
				#templateHeader{
					border-bottom:0;
					padding:0px;
				}
				.headerContent{
					color:#202020;
					font-family:Arial;
					font-size:34px;
					font-weight:bold;
					line-height:100%;
					padding:0;
					text-align:center;
					vertical-align:middle;
				}
				.headerContent a:link,.headerContent a:visited,.headerContent a .yshortcuts {
					color:#336699;
					font-weight:normal;
					text-decoration:underline;
				}
				#headerImage{
					height:auto;
					max-width:600px !important;
				}
				#templateContainer,.bodyContent{
					background-color:#FFFFFF;
				}
				.bodyContent div{
			color:#505050;
			font-family:Arial;
			font-size:14px;
			line-height:150%;
			text-align:justify;
				}
				.bodyContent div a:link,.bodyContent div a:visited,.bodyContent div a .yshortcuts {
					color:#336699;
					font-weight:normal;
					text-decoration:underline;
				}
				.bodyContent img{
					display:inline;
					height:auto;
				}

				.itemlist {
					width:400px;
					margin:20px 0 0 100px;
				}

				.itemlist tr td {
					border-bottom:1px solid #CCC;
					padding:10px;
				}

				.itemlist tr td.label {
					border-right:1px solid #CCC;
				}

				.itemlist tr td.content {
					font-weight:bold;
				}

		</style>
	</head>
	<body style="background-color:#FAFAFA">
		<br />
		<br />
		<br />
		<br />
		<table id="backgroundTable" style="margin: 0; padding: 0; background-color: #fafafa; height: 100% !important;" border="0" cellspacing="0" cellpadding="0" width="100%" height="100%">
			<tbody>
				<tr>
					<td style="border-collapse: collapse;" align="center" valign="top">
						<table id="templateContainer" style="border: 1px solid #DDDDDD; background-color: #ffffff;" border="0" cellspacing="0" cellpadding="0" width="600">
							<tbody>
								<tr>
									<td style="border-collapse: collapse;" align="center" valign="top"><!-- // Begin Template Header \\ --> 
										<table id="templateHeader" style="border-bottom: 0; padding: 0px;" border="0" cellspacing="0" cellpadding="0" width="600">
											<tbody>
												<tr>
													<td>
														<a href="{{URL::route('home')}}" target="_blank">
															<img style="vertical-align: middle; display: block; margin-left: auto; margin-right: auto;" src="/assets/images/logo.png" alt="" width="352" height="80" />
														</a>
													</td>
												</tr>
											</tbody>
										</table>
									</td>

								</tr>
								
								<tr>
									<td style="border-collapse: collapse;" align="center" valign="top"><!-- // Begin Template Body \\ --> 
										<table id="templateBody" border="0" cellspacing="0" cellpadding="0" width="600">
											<tbody>
												<tr>
													<td class="bodyContent" style="border-collapse: collapse; background-color: #ffffff;" valign="top"><!-- // Begin Module: Standard Content \\ --> 
														<br /><br />
														<!-- START CONTENT -->
														<div style="color: #505050; font-family: Arial; font-size: 14px; line-height: 150%;">
															<h1 style="color:gray; display: block; font-family: Arial; font-size: 18px; font-weight: bold; line-height: 100%; margin-bottom: 10px; text-align: center;">@yield('subject')</h1>
														</div>

														@yield('content')
														
														<br /><br />
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		<br />
		<br />
		<br />
	</body>
</html>
