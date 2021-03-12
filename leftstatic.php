<div id="como-menu">
    <h3><?=$ADMIN_MAIN_SITE_NAME;?></h3>
    <ul>
        <li><? if($staticvar!="terms")   {?><a href="terms_and_conditions.html"><?=$lng_termscondi;?></a><? } else {?><span><?=$lng_termscondi;?></span><? } ?>
        <li><? if($staticvar!="privacy") {?><a href="privacy_policy.html"><?=$lng_privacy;?></a><? }          else { ?><span><?=$lng_privacy;?></span><? } ?>
        <li><? if($staticvar!="about")   {?><a href="about_us.html"><?=$lng_aboutus;?></a><? }                else { ?><span><?=$lng_aboutus;?></span><? } ?>
        <li><? if($staticvar!="contact") {?><a href="contact.html"><?=$lng_aucavecontact;?></a><? }           else { ?><span><?=$lng_aucavecontact;?></span><? } ?>
        <li><? if($staticvar!="jobs")    {?><a href="jobs.html"><?=$lng_aucavejobs;?></a><? }                 else { ?><span><?=$lng_aucavejobs;?></span><? } ?>
        <li><? if($staticvar!="howit")   {?><a href="how_it_works.html"><?=$lng_howitwork;?></a><? }          else { ?><span><?=$lng_howitwork;?></span><? } ?>
        <li><? if($staticvar!="help")    {?><a href="help.html"><?=$lng_tabhelp;?></a><? }                    else { ?><span><?=$lng_tabhelp;?></span><? } ?>
    </ul>	
    <span id="como-menu-bottom"></span>
</div>