<?php
class ProudSubsitePage extends ProudSettingsPage
{
   /**
     * Start up
     */
    public function __construct()
    {
      parent::__construct(
        'subsite', // Key
        [ // Submenu settings
          'parent_slug' => 'proudsettings',
          'page_title' => 'Subsite Settings',
          'menu_title' => 'Subsite Settings',
          'capability' => 'edit_proud_options',
        ],
        '', // Option
        [ // Options
          'proud_subsite_parent_site' => '',
          'proud_subsite_primary_menu' => '',
        ] 
      );
    }

    /** 
     * Sets fields
     */
    public function set_fields( ) {
      $this->fields = [
       'proud_subsite_parent_site' => [
          '#type' => 'text',
          '#title' => __pcHelp('Parent site url'),
          '#description' => __pcHelp('Enter the parent site URL of this subsite without traling slash ex: https://example.proudcity.com'),
        ],
        'proud_subsite_primary_menu' => [
          '#type' => 'textarea',
          '#title' => __pcHelp('Primary navigation code'),
          '#description' => __(sprintf('HTML code for the primary menu items.  Should look like %s. <strong>Leave blank to use this site\'s primary menu.</strong>', htmlentities( '<li><a>Title</a></li>' ) ), 'proud_subsite' ),
        ],

      ];
    }

    /**
     * Print page content
     */
    public function settings_content() {
      $this->print_form( );
    }
}

if( is_admin() )
    $proud_subsite_page = new ProudSubsitePage();