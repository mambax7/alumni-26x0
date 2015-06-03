
<table cellspacing="1" class="outer" style="width:100%;">
  
<tr>
    <td class="newstitle" height="18"><{$category_path}></td>
  </tr>
  
  <tr>
  
    <th align="center"><{$school_name}> <{$add_from_title}><br /></th>
    
  </tr>
  



  <{if $scaddress != ""}>
  <tr>
    <td class="head" align="center" style="padding:10px 10px 10px 10px;">
    <{if $top_scphoto != ""}>
    <{$top_scphoto}><br /><{/if}><br />
    <{if $scmotto != ""}>
    <b><i>"<{$scmotto}>"</i></b><{/if}></td>
  </tr>
  <tr>
    <td class="odd" align="left"><{$scaddress}> 
     <{if $scaddress2 != ""}><br />
     <{$scaddress2}>
     <{/if}>
     <br /> <{$sccity}>,&nbsp;<{$scstate}>&nbsp;<{$sczip}><br />
    <{if $scphone != ""}>
    <{$head_scphone}> <{$scphone}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <{if $scfax != ""}>
    <{$head_scfax}> <{$scfax}><{/if}><{/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <{if $scurl != ""}><br />
    <a href='http://<{$scurl}>' target='_blank'><{$web}></a><{/if}></td>   
  </tr>
  <{/if}>
  <{if $subcats == "0"}>
  <tr>
    <td class="head" align="center" style="padding:10px 10px 10px 10px;"><{$add_listing}></td>
  </tr>
   <{/if}>

  <{if $moderated|default:false}>
	  <{if $xoops_isadmin}>
	  <tr>
	    <td align="center" class="even">
	    <table class="outer" cellspacing="0" style="width:50%;">
		  <tr>
		    <td class="head" align="center"><{$admin_block}></td>
		  </tr>
		  <tr>
		    <td class="odd" align="center"><{$confirm_ads}></td>
		  </tr>
		</td>
		</table>
	  </tr>
	  <{/if}>
  <{/if}>
  </table>
  <br />
  <{if $showsubcat == true && $subcats}>
  
      <table border="1" style="width:100%;">
<tr><{if $lang_subcat}>
<td>
<{$lang_subcat}></td>
<{/if}>
  </tr>
        <tr>
          <{foreach item=subcat from=$subcategories}>
          <td align="left"><b><a href="categories.php?cid=<{$subcat.id}>" ><{$subcat.title}></a></b> (<{$subcat.totallinks}>)<br /></td>
            <{if $subcat.count is div by 4}>
        </tr><tr>
            <{/if}>
          <{/foreach}>
        </tr>
      </table>
    
 <br />
  <{/if}>
        <table border="0" style="width:100%;" class="outer">

</table>

<!--  <{if $show_nav == true}><{assign var='imgstyle' value='border:0; '}>

      <div align="center"><{$lang_sortby}>  <{$lang_name}> (<a href="categories.php?cid=<{$cat}>&orderby=nameA"><img title="<{$lang_nameatoz}>" style="<{$imgstyle}>" src=
        <{if $sort_active == 'nameA'}>"images/up_active.gif"" /><{else}>"images/up.gif" /><{/if}></a><a href="categories.php?cid=<{$cat}>&orderby=nameD"><img title="<{$lang_nameztoa}>" style="<{$imgstyle}>" src=
        <{if $sort_active == 'nameD'}>"images/down_active.gif"" /><{else}>"images/down.gif" /><{/if}>
<{$lang_date}> (<a href="categories.php?cid=<{$cat}>&orderby=dateA"><img title="<{$lang_dateold}>" style="<{$imgstyle}>" src=
        <{if $sort_active == 'dateA' || $show_active == 'dateA'}>"images/up_active.gif"" /><{else}>"images/up.gif" /><{/if}></a><a href="catview.php?cid=<{$cat}>&orderby=dateD"><img title="<{$lang_datenew}>" style="<{$imgstyle}>" src=
        <{if $sort_active == 'dateD' || $show_active == 'dateD'}>"images/down_active.gif"" /><{else}>"images/down.gif" /><{/if}></a>
      <br /><b><{$lang_cursortedby}></b>
      <hr / width="97%">
      </div>
      <{/if}> -->
    
    
    
    <{if $trows > 0}>
    
    
    
    
              	 <{if $use_extra_code|default:false}>

	<{if $use_banner|default:false}>
     <table><tr><td align='center'><{$cat_banner}></td></tr></table>
<{else}>
<table><tr><td align="center"><{$cat_extra_code}></td></tr></table>
  <{/if}><{/if}>
       
 <div class="pager"><span class="pagedisplay"></span></div>

  	  <table id='mytable' class="tablesorter">

        <thead> 
<tr>


		  <{if $xoops_isadmin}><th class="head" width="5%"></th><{/if}>
          <th class="head" align="center" width="30%"><{$last_head_name}>
</th>

 	<th class="head" align="center" width="25%"><{$last_head_studies}>
</th>


  <th class="head" align="center" width="15%">
    <{$class_of}>
</th>


  <th class="head" align="center" width="15%">
    <{$last_head_date}>
</th>
  <th class="head" align="center" width="5%">
    <{$last_head_views}>
</th>

          <th class="head" align="center" width="5%"><{$last_head_photo}></th>
        </tr>
	</thead>

 <tbody>
<{foreach from=$items item=item name=items}>



 
	<tr class="<{cycle values="odd,even"}>">
	<{if $xoops_isadmin}><td width="5%"><{$item.admin}></td><{/if}>
        <td width="30%" align="center"><b><{$item.name}>&nbsp;<{$item.new}></b></td>
        <td align="center" width="25%"><{$item.studies}><br /></td>
        <td align="center" width="15%"><{$item.year}></td>
        <td align="center" width="15%"><{$item.date}></td>
        <td align="center" width="5%"><{$item.views}></td>
        <td align="center" width="5%"><{$item.photo}></td>

	<{/foreach}>
	 <br /><br />

        </tr></tbody>
        
</table>
        
  <table><tr><td>      

<div class="clear"></div>


        <div class="pager">
          <nav class="left">
            # per page:
            <a href="#" class="current">10</a> |
            <a href="#">25</a> |
            <a href="#">50</a> |
            <a href="#">100</a>
          </nav>
          <nav class="right">
            <span class="prev">
              <img src="media/jquery/addons/pager/icons/prev.png" /> Prev&nbsp;
            </span>
            <span class="pagecount"></span>
            &nbsp;<span class="next">Next
              <img src="media/jquery/addons/pager/icons/next.png" />
            </span>
          </nav>
        </div>

<div class="clear"></div>
</td></tr></table>

<{else}>
<br /><br />
<br /><br />

<table><tr><td>

<{$no_listings}>
<{/if}>
</td></tr></table>
<{include file='module:notifications|select.tpl'}>





