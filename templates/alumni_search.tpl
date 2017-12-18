<fieldset>
    <{if $search}>
        <legend><{translate key="SEARCH_RESULTS"}></legend>
        <div>
            <{translate key="KEYWORDS"}>&nbsp;:&nbsp;
            <span class="bold">
            <{foreach from=$queries item=query name=foo}>
                <{$query}><{if !$smarty.foreach.foo.last}>,<{/if}>
            <{/foreach}>
            </span>
            <{if $sr_showing}>
                <br/>
                <{$sr_showing}>&nbsp;<{$showing_of}>
                <br/>
                <br/>
                <{$in_category}> <{$cat_name}>
            <{/if}>

        </div>
        <{if count($ignored_queries) != 0}>
            <div>
                <{$ignored_words}>&nbsp;:&nbsp;
                <span class="bold">
                <{foreach from=$ignored_queries item=query name=foo}>
                    <{$query}><{if !$smarty.foreach.foo.last}>,<{/if}>
                <{/foreach}>
                </span>
            </div>
        <{/if}>
    <{/if}>

    <{if count($modules) > 0}>
        <{foreach from=$modules item=module name=foo}>
            <div class="searchModule">
                <div class="searchIcon floatleft">
                    <img src="<{$module.image}>" alt="<{$module.name}>">
                </div>
                <div class="searchTitle floatleft">
                    <{$module.name}>
                </div>
                <{if $module.search_url|default:false}>
                    <div class="floatright">
                        <a href="<{$module.search_url}>" title="<{translate key="SHOW_ALL_RESULTS"}>"><{translate key="SHOW_ALL_RESULTS"}></a>
                    </div>
                <{/if}>

                <{if $module.showall_link|default:false}>
                    <div class="floatright">
                        <{$module.showall_link}>
                    </div>
                <{/if}>
                <div class="clear"></div>

                <{foreach from=$module.result item=result}>
                    <div class="searchItem">
                        <div class="bold"><a href="<{$result.link}>" title="<{$result.title}>"><{$result.title_highligh}></a></div>
                        <div><{$result.content}></div>
                        <span class='x-small'>
                            <{if $result.uid}>
                                <a href="<{$xoops_url}>/userinfo.php?uid=<{$result.uid}>" title="<{$result.uname}>"><{$result.uname}></a>
                            <{/if}>
                            <{if $result.time}>
                                &nbsp;(<{$result.time}>)
                            <{/if}>
                        </span>
                    </div>
                <{/foreach}>
            </div>
            <!-- prev / next -->
            <{if $module.prev|default:false || $module.next|default:false}>
                <div>
                    <{if $module.prev|default:false}>
                        <div class="floatleft">
                            <a href="<{$module.prev}>" title="<{translate key="PREVIOUS"}>"><{translate key="PREVIOUS"}></a>
                        </div>
                    <{/if}>
                    <{if $module.next|default:false}>
                        <div class="floatright">
                            <a href="<{$module.next}>" title="<{translate key="NEXT"}>"><{translate key="NEXT"}></a>
                        </div>
                    <{/if}>
                </div>
            <{/if}>
        <{/foreach}>
    <{else}>
        <div class="searchModule bold">
            <{translate key="NO_MATCH_FOUND_FOR_QUERY"}>
        </div>
    <{/if}>
</fieldset>
