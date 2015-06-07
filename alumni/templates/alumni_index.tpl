<script language="JavaScript" type="text/JavaScript">
<!--
	function CLA(CLA) { var MainWindow = window.open (CLA, "_blank","width=500,height=300,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no");}
//-->
</script>
<table cellspacing="1" class="outer" style="width:100%;">
  <tr>
    <th align="center"><{$add_from_sitename}> <{$add_from_title}></th>
  </tr>
  <tr><td class="odd">
      <table border="1" style="width:100%;">
		  <tr>
		    <td class="head" align="center"><{$front_intro}></td></tr>
		</table></td></tr>
  <{if $moderated}>
	  <{if $user_admin}>
	  <tr>
	    <td align="center" class="even">
	    <table border="1" class="outer" cellspacing="0" style="width:50%;">
		  <tr>
		    <td class="head" align="center"><{$admin_block}></td>
		  </tr>
		  <tr>
		    <td class="odd" align="center"><{$confirm_ads}></td>
		  </tr>
		</table>
		</td>
	  </tr>
	  <{/if}>
  <{/if}>
  </table>

<{if $offer_search}>
<table border="1" style="width:75%;" align="center">
	<tr>
		<td class="even" align="center">
		<table border="0" style="width:100%;" align="center">
		<form name='search' id='search' action='search.php' method='post' onsubmit='return xoopsFormValidate_search();'>
		<input type='hidden' name='mids[]' value='<{$xmid}>' />
		<td width='15%' align="center"><br /><b><{$search_listings}></b></td></tr><tr>
		<td align="center"><br /><{$keywords}><br /><input type='text' name='query' id='query' size='15' maxlength='255' value='' /></td>

	<!--	<td><br /><select  size='1' name='andor' id='andor'>
		<option value='AND' selected='selected'><{$all_words}></option>
		<option value='OR'><{$any_words}></option>
		<option value='exact'><{$exact_match}></option>
		</select></td>   -->
	</tr><tr>
		
		
		<td align="center"> <{$bycategory}><br /><{$category_select}><br /></td></tr>

		<td align="center"><input type='submit' class='formButton' name='submit'  id='submit' value='Search' /></td></tr>
		<input type='hidden' name='issearch' value='1' />
		
		<input type='hidden' name='action' id='action' value='results' />

		</form>
		</table>
		</td>
	</tr>
</table>
<script type='text/javascript'>
		<!--
		function xoopsFormValidate_search(){}
		//-->
		</script>
	<{/if}>
<table cellspacing="1" class="outer" style="width:100%;">
<tr>
  	<td class="odd">
      <table border="0" style="width:100%;">
      
      
      <br />
 
      
<{if count($categories) gt 0}>

	<table border="0" cellspacing="5" cellpadding="0" align="center">
		<tr>
			<!-- Start category loop -->
			<{foreach item=category from=$categories}>
			
					
    		
    		<td valign="top" width="33%" align="center">
    		
    		
    		<a href="<{$xoops_url}>/modules/<{$moduleDirName}>/categories.php?cid=<{$category.id}>"><img src="<{$category.image}>" /></a><br /><br />
    		
						<a href="<{$xoops_url}>/modules/<{$moduleDirName}>/categories.php?cid=<{$category.id}>"><b><{$category.title}></b></a><br />(<{$category.totalcats}>)<br />
			
						<{if $category.subcategories}>
							<{foreach item=subcat from=$category.subcategories}>
								<div style="margin-bottom: 3px; margin-left: 16px;">
									<small><a href="<{$xoops_url}>/modules/<{$moduleDirName}>/categories.php?cid=<{$subcat.id}>"><{$subcat.title}>&nbsp;(<{$subcat.count}>)</a></small>
								</div><br />
							<{/foreach}>
    					<{/if}>
			</td>
    		<{if $category.count is div by 3}>
	  </tr><tr>
    		<{/if}>
		<{/foreach}>
  	<!-- End category loop -->
</tr>
</table> 

<{/if}>
 <tr><td><tr>
 <td class="even" align="center"><br /><{$total_listings}><br /><{$total_confirm}></td></tr></table></td></tr></table>
<br />
 <table cellspacing="1" class="outer" style="width:100%;">
  <tr>
    <th align="center"><{$last_head}></th>
  </tr>
  <tr>
    <td style="padding:0;">
   	  <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
        <tr>
		  <{if $xoops_isadmin}><td class="head" width="5%"></td><{/if}>
          <td class="head" align="center" width="30%"><{$last_head_name}></td>
	  <td class="head" align="center" width="15%"><{$last_head_school}></td>
	  <td class="head" align="center" width="15%"><{$last_head_studies}></td>
          <td class="head" align="center" width="30%"><{$class_of}></td>
          <td class="head" align="center" width="5%"><{$last_head_photo}></td>
        </tr></table></td>
        </tr></table>





<{foreach from=$items item=item name=items}>
 <{if $use_extra_code == 1}>
  <{if ($smarty.foreach.items.index % $index_code_place == 0) && !($smarty.foreach.items.first)}>
	<{if $use_banner == 1}>
  <table><tr><td align="center"><br /><{$index_banner}></td></tr></table>
<{else}>
 <table border="0" cellpadding="0" cellspacing="0" style="width:100%;"><tr><td align="center"><{$index_extra_code}></td></tr></table>
  <{/if}><{/if}><{/if}>

<table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
	<tr class=<{cycle values="odd,even"}>>
	<{if $xoops_isadmin}><td width="5%"><{$item.admin}></td><{/if}>
        <td width="30%" align="center"><b><{$item.name}>&nbsp;<{$item.new}></b><br /></td>
        <td align="center" width="15%"><{$item.school}><br /></td>
        <td align="center" width="15%"><{$item.studies}></td>
        <td width="30%" align="center"><{$item.year}></td>
        <td align="center" width="5%"><{$item.photo}></td><br />
        </tr>
    <{/foreach}>
    
    </td></tr></table>
  


<br /><br />
<{include file='module:notifications/select.tpl'}>
<br /><br />

