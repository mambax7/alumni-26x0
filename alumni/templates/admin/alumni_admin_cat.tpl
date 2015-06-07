
<{include file="admin:system/admin_navigation.tpl"}>
<{include file="admin:system/admin_tips.tpl"}>
<{include file="admin:system/admin_buttons.tpl"}>

<!--Page content-->
<{if $numrows == true}>

    <{if $nav_menu}>
        <{$nav_menu}>
    <{/if}>

 <div class="pager"><span class="pagedisplay"></span>
    <table id='mytable' class="tablesorter">
        <thead>
        <tr>
            <th class="txtcenter" width="5%"><{translate key="ID"}></th>
            <th class="txtleft" width="20%"><{translate key="NAME"}></th>
            <th class="txtcenter" width="5%"><{translate key="ORDER"}></th>
            <th class="txtcenter" width="15%"><{translate key="ACTION"}></th>
        </tr>
        </thead>
        <tbody>
        <{foreach item=a_cat from=$category}>
        <tr class="<{cycle values='even,odd'}> alignmiddle">

            <td class="txtleft width35"><{$a_cat.cid}></td>
            <td class="txtcenter width5"><{$a_cat.title}></td>
            <td class="txtcenter width5"><{$a_cat.ordre}></td>


            <td class="xo-actions txtcenter width10">

                <a href="alumni_categories.php?op=edit_category&amp;cid=<{$a_cat.cid}>" title="<{translate key="A_EDIT"}>">
                    <img src="<{xoAdminIcons 'edit.png'}>" alt="<{translate key="A_EDIT"}>">
                </a>
                <a href="alumni_categories.php?op=delete_category&amp;cid=<{$a_cat.cid}>" title="<{translate key="A_DELETE"}>">
                    <img src="<{xoAdminIcons 'delete.png'}>" alt="<{translate key="A_DELETE"}>">
                </a>
            </td>
        </tr>
        <{/foreach}>
        </tbody>
    </table>

    
    
    
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
              <img src="../media/jquery/addons/pager/icons/prev.png" /> Prev&nbsp;
            </span>
            <span class="pagecount"></span>
            &nbsp;<span class="next">Next
              <img src="../media/jquery/addons/pager/icons/next.png" />
            </span>
          </nav>
        </div>  
    
    
    
    
    
    
    <div class="clear spacer"></div>

    <{if $nav_menu}>
        <{$nav_menu}>
    <{/if}>
<{/if}>

<!-- Display form (add,edit) -->
<{if $error_message}>
    <div class="alert alert-error">
        <strong><{$error_message}></strong>
    </div>
<{/if}>

<{$form}>
