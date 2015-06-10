<{if $listing_exists|default:false}>
    <table class="outer" width='100%' cellspacing='1'>
        <tr>
            <td class="odd" align="left"><{$category_path}></td>
        </tr>
        <tr>


            <th><{$admin|default:false}>&nbsp;&nbsp;<b><{$name}>&nbsp;<{$mname}>&nbsp;<{$lname}><br/><{$school}>&nbsp;&nbsp;<{$class_of}>&nbsp;&nbsp;<{$year}></b></th>
        </tr>
    </table>
    <table class="outer" width='100%' cellspacing='1'>
        <tr>

            <td class="even" align='center'>
                <table width='100%' cellspacing='0' cellpadding='5'>
                    <{if $studies != ""}>
                        <tr>
                            <td class="odd"><b><{$studies_head}></b>&nbsp;&nbsp;<{$studies}><br/></td>
                        </tr>
                    <{/if}>
                    <{if $activities != ""}>
                        <tr>
                            <td class="odd"><b><{$activities_head}></b><br/><{$activities}><br/>&nbsp;&nbsp;</td>
                        </tr>
                    <{/if}>
                    <{if $extrainfo != ""}>
                        <tr>
                            <td class="odd"><b><{$extrainfo_head}></b><br/><{$extrainfo}><br/>&nbsp;&nbsp;</td>
                        </tr>
                    <{/if}>
                    <{if $contact_occ != ""}>
                        <tr>
                            <td class="odd"><b><{$contact_occ_head}></b>&nbsp;&nbsp;<{$contact_occ}><br/></td>
                        </tr>
                    <{/if}>
                    <{if $local_town != ""}>
                        <tr>
                            <td class="odd"><b><{$local_head}></b>&nbsp;&nbsp;<{$local_town}></td>
                        </tr>
                    <{/if}>
                    <{if $contact_email != ""}>
                        <{if $xoops_isuser}>
                            <tr>
                                <td class="odd"><b><{$contact_head}></b> <{$contact_email}>
                                </td>
                            </tr>
                        <{else}>
                            <tr>
                                <td class="odd"><{$alumni_mustlogin}>&nbsp;<{$name}></td>
                            </tr>
                        <{/if}><{/if}>
                </table>
            </td>
            <td class="odd" align='right' width='30%'>
                <table>
                    <{if $photo != ""}>
                        <tr>
                        <td class="odd" colspan='2' align='center'><b><{$photo_head}></b><br/><br/><{$photo}><br/></td></tr><{/if}>
                    <{if $photo2 != ""}>
                        <tr>
                        <td class="odd" colspan='2' align='center'><br/><b><{$photo2_head}></b><br/><br/><{$photo2}>
                        </td></tr><{/if}>
                </table>
            </td>
        </tr>
    </table>
    <table width='100%' cellspacing='0' cellpadding='5'>
        <tr>
            <td class="even" align="center"><{$modify|default:false}></td>
        </tr>
        <tr>
            <td class="foot" align="center"><{$date}>&nbsp;&nbsp;(<{$read}>)&nbsp;&nbsp;&nbsp;&nbsp;<{$print}>&nbsp;&nbsp;&nbsp;&nbsp;<{if $xoops_isuser}>&nbsp;&nbsp;&nbsp;&nbsp;<{$sfriend}><{/if}></td>
        </tr>
    </table>
<{else}>
    <div align="center"><b><{$no_listing|default:false}></b></div>
<{/if}>



