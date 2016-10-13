<div class="btn-toolbar pull-left" role="toolbar">
  <?php if( !get_option( 'proud_subsite_primary_menu' ) ): ?>
    <a title="Main Site" alt="<?php echo get_option( 'proud_subsite_parent_site' ) ?>" href="<?php echo get_option( 'proud_subsite_parent_site' ) ?>" class="same-window btn btn-primary navbar-btn-normal">Main Site</a>
  <?php endif; ?>
  <a href="<?php echo get_option( 'proud_subsite_parent_site' ) ?>/answers" class="same-window btn navbar-btn faq-button"><i class="fa fa-question-circle"></i> Answers</a>
  <a href="<?php echo get_option( 'proud_subsite_parent_site' ) ?>/payments" class="same-window btn navbar-btn payments-button"><i class="fa fa-credit-card"></i> Payments</a>
  <?php if(get_option('311_service', 'link') !== 'link'): ?>
    <a href="<?php echo get_option( 'proud_subsite_parent_site' ) ?>/issues" class="same-window btn navbar-btn issue-button"><i class="fa fa-wrench"></i> Issues</a>
  <?php elseif(!empty(get_option('311_link_create'))): ?>
    <a data-proud-navbar="report" data-click-external="true" href="<?php echo get_option('311_link_create') ?>" class="btn navbar-btn issue-button"><i class="fa fa-wrench"></i> Issues</a>
  <?php endif; ?>
</div>
<div class="btn-toolbar pull-right" role="toolbar">
  <a id="menu-button" href="#" class="btn navbar-btn menu-button"><span class="hamburger">
    <span>toggle menu</span>
  </span></a>
  <a href="<?php echo get_option( 'proud_subsite_parent_site' ) ?>/search-site" class="same-window btn navbar-btn search-btn"><i class="fa fa-search"></i> <span class="text sr-only">Search</span></a>
</div>