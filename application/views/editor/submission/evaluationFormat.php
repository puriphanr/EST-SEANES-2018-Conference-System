<!DOCTYPE html>
<html>
<head>
<title>Title of the document</title>
</head>

<body>
<p></p>
<div id="page-title" style=" margin-bottom:20px">
	<table class="table table-top-campaign" width="100%" cellspacing="0" cellpadding="10">
        <tbody>
			 <tr>
                <td width="20%" style="font-weight:bold">Article ID</td>
                <td width="80%"><?php echo $paper['paper_code']?></td>
             </tr>
             <tr>
                  <td width="20%" style="font-weight:bold">Article Title</td>
                  <td width="80%"><?php echo $paper['title']?></td>
               </tr>
                                          
         </tbody>
    </table>
</div>

<div class="page-content" >
	<table  width="100%" cellspacing="0" cellpadding="10" border="1">
        <tbody>
			 <tr>
				<td colspan="2" bgcolor="#E8E8E8">U<?php echo str_pad($reviewers['users_id'],4,0,STR_PAD_LEFT)?> - <?php echo $paper['paper_code']?></td>
			 </tr>
			 <tr>
				<td colspan="2" bgcolor="#E8E8E8"><h2>Evaluation</h2></td>
			 </tr>
             <tr>
                <td width="20%">Reviewer Status</td>
                 <td width="80%" class="text-left">
													<?php 
													  if($reviewers['review_status'] == 1){
														  echo 'Waiting';
													  }
													  elseif($reviewers['review_status'] == 2){
														   echo 'Accept';
													  }
													  elseif($reviewers['review_status'] == 3){
														   echo 'Reject';
													  }
													  else{
															 echo 'Evaluated';	
													  }
													 
													  ?>
				 </td>
                </tr>                     
         </tbody>
    </table>
	
	<table width="100%" cellspacing="0" cellpadding="10" border="1">
							 
								<tr>
								  <th bgcolor="#f4d4c1" width="50%" rowspan="2" class="text-center"></th>
								  <th bgcolor="#f4d4c1" align="center" >Quality Rating</th>
								 
								</tr>
								<tr>
									<th bgcolor="#f4d4c1" scope="col" width="10%" align="center"><font size="8"><div><strong>Very Poor</strong></div><div><strong>1</strong></div></font></th>
									<th bgcolor="#f4d4c1" scope="col" width="10%" align="center"><font size="8"><div><strong>Poor</strong></div><div><strong>2</strong></div></font></th>
									<th bgcolor="#f4d4c1" scope="col" width="10%" align="center"><font size="8"><div><strong>Adequate</strong></div><div><strong>3</strong></div></font></th>
									<th bgcolor="#f4d4c1" scope="col" width="10%" align="center"><font size="8"><div><strong>Good</strong></div><div><strong>4</strong></div></font></th>
									<th bgcolor="#f4d4c1" scope="col" width="10%" align="center"><font size="8"><div><strong>Excellent</strong></div><div><strong>5</strong></div></font></th>
								</tr>
							  
							  
								<?php 
								$total = 0;
								$checkSign = html_entity_decode('&#x2713;', ENT_XHTML,"ISO-8859-1");
								
								foreach($evalution as $key=>$row){ ?>
								<tr>
									<td width="50%">
										<font size="11"><strong><?php echo $row ?></strong></font><br>
										<font size="10"><strong>Comment :</strong></font><br>
										
										<font color="#1d1db7" size="10"><?php echo $evaluation_row && $evaluation_row[$key.'_comment'] != "" ? $evaluation_row[$key.'_comment'] : '-' ?></font>
										
									</td>
									<td  align="center" width="10%" valign="middle"><font color="#1d1db7" size="20"><?php echo $evaluation_row && $evaluation_row[$key] == 1 ? $checkSign : '-' ?></font></td>
									<td align="center" width="10%" valign="middle"><font color="#1d1db7" size="20"><?php echo $evaluation_row && $evaluation_row[$key] == 2 ? $checkSign : '-' ?></font></td>
									<td align="center" width="10%" valign="middle"><font color="#1d1db7" size="20"><?php echo $evaluation_row && $evaluation_row[$key] == 3 ? $checkSign : '-' ?></font></td>
									<td align="center" width="10%" valign="middle"><font color="#1d1db7" size="20"><?php echo $evaluation_row && $evaluation_row[$key] == 4 ? $checkSign : '-' ?></font></td>
									<td align="center" width="10%" valign="middle"><font color="#1d1db7" size="20"><?php echo $evaluation_row && $evaluation_row[$key] == 5 ? $checkSign : '-' ?></font></td>
								</tr>
								<?php
								$total = $total+$evaluation_row[$key];
								} ?>
								<tr>
									<td align="right"><font size="12"><strong>Total Score :</strong></font></td>
									<td align="right" colspan="5"><font size="12"><strong><?php echo number_format($total,0) ?></strong></font></td>
									
								</tr>
		
	</table>
							
							
	<table class="table table-bordered evaluation-result-table" style="margin-top:20px" cellspacing="0" cellpadding="10" border="1">
							
							  <tbody>
								
								<tr>
									<td colspan="2">
										<strong>Evaluation</strong> : Based on the above points please indicate your recommendation for Conference Proceedings Publication and Journal Publication
									</td>	
								</tr>
								<tr>
									<td>
										<strong>Conference Proceedings Publication</strong>
									</td>
									<td>
										<strong>Journal Publication (selected paper)</strong>
									</td>
								</tr>
								<tr>
									<td>
										<font color="#1d1db7" size="10">	<?php echo $evaluation_row ? $evaluation_conference[$evaluation_row['conference_public']] : '-' ?></font>
									</td>
										<td>
										<font color="#1d1db7" size="10">	<?php echo $evaluation_row ? $evaluation_journal[$evaluation_row['journal_public']] : '-' ?> </font>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										If the article requires any revision please give details of the suggested changes in the following reviewer’s comment section. If the article was unacceptable please indicate your reasons so that we may inform the authors.
									</td>	
								</tr>
								<tr>
									<td>
											<div><strong>Reason and more comments :</strong></div>
											<div><?php echo $evaluation_row && $evaluation_row['conference_comment'] != "" ? $evaluation_row['conference_comment'] : '-' ?></div>
									</td>
									<td>
											<div><strong>Reason and more comments : </strong></div>
											<div><?php echo $evaluation_row && $evaluation_row['journal_comment'] != "" ? $evaluation_row['journal_comment'] : '-' ?></div>
									</td>
								</tr>
								
							  </tbody>
							</table>

</div>
<div>
	<div><strong>Note :</strong></div>
	<p><font color="#1d1db7" size="10"><?php echo $evaluation_row && $evaluation_row['editor_comment'] != "" ? $evaluation_row['editor_comment'] : '-' ?></font></p>
</div>								
	
							
	</body>
</html>