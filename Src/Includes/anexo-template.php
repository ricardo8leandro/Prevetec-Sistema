<style type="text/css">
	.anx-header{
		vertical-align: top;
		font-size:23px;
		text-align: justify;
		word-wrap: break-all;
		/*border: 1px solid red;*/
	}

	.anx-img{
		text-align: center;
		vertical-align: middle;
		height:400px;
		width:100%;
	}

	.anx-img img{
		margin:auto;
		position: relative;
	}

	.anx-footer{
		text-align: justify;
		vertical-align: bottom;
		font-size:23px;
		word-wrap: break-all;
	}
</style>
<table style="width:100%;">
	<tr>
		<td class="anx-header" valign="top">
			{{ANX.HEADER}}
		</td>
	</tr>
	<tr>
		<td class="anx-img">
			<img src="{{ANX.IMG}}"style="width:90%;max-height:400px;">
		</td>
	</tr>
	<tr>
		<td class="anx-footer">
			{{ANX.FOOTER}}
		</td>
	</tr>
</table>