<{if $show_new == '1'}>
<table cellspacing="1" class="outer" style="width:100%;">
  <tr>
    <th align="center"><{$last_head}></th>
  </tr>
  <tr>
    <td style="padding:0;">
   	  <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
        <tr>
		  <{if $xoops_isadmin}><td class="head"></td><{/if}>
          <td class="head"><{$last_head_name}></td>
	  <td class="head"><{$last_head_school}></td>
          <td class="head"><{$class_of}></td>
          <td class="head"><{$last_head_photo}></td>
        </tr>
        <{foreach item=item from=$items}>
		<tr class="<{cycle values="odd,even"}>">
		  <{if $xoops_isadmin}><td><{$item.admin}></td><{/if}>
          <td><b><{$item.name}></b><br /></td>
	  <td><{$item.school}></td>
	   <td><{$item.year}></td>
          <td><{$item.photo}></td>
        </tr>
		<{/foreach}>
      </table>
	</td>
  </tr>
</table>
<{/if}>