<?php
class ProudSubsitePage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
      add_action( 'admin_menu', array($this, 'create_menu') );
      $this->key = 'subsite';
      $this->fields = null;
    }

    // create custom plugin settings menu
    

    public function create_menu() {

      add_submenu_page( 
          'proudsettings',
          'Subsite Settings',
          'Subsite Settings',
          'edit_proud_options',
          $this->key,
          array($this, 'settings_page')
      );

      $this->options = [
        'proud_subsite_parent_site',
        'proud_subsite_primary_menu'
      ];
    }

    private function build_fields(  ) {
      $this->fields = [
       'proud_subsite_parent_site' => [
          '#type' => 'text',
          '#title' => __pcHelp('Parent site url'),
          '#description' => __pcHelp('Enter the parent site URL of this subsite without traling slash ex: https://example.proudcity.com'),
          '#name' => 'proud_subsite_parent_site',
          '#value' => get_option('proud_subsite_parent_site')
        ],
        'alert_message' => [
          '#type' => 'textarea',
          '#title' => __pcHelp('Primary navigation code'),
          '#description' => __(sprintf('HTML code for the primary menu items.  Should look like %s. <strong>Leave blank to use this site\'s primary menu.</strong>', htmlentities( '<li><a>Title</a></li>' ) ), 'proud_subsite' ),
          '#name' => 'proud_subsite_primary_menu',
          '#value' => get_option('proud_subsite_primary_menu')
        ],

      ];
    }

    public function settings_page() {
      $this->build_fields();

      // Do we have post?
      if(isset($_POST['_wpnonce'])) {
        if( wp_verify_nonce( $_POST['_wpnonce'], $this->key ) ) {
          $this->save($_POST);
          $this->build_fields();
        }
      }
      
      $form = new \Proud\Core\FormHelper( $this->key, $this->fields );
      $form->printForm ([
        'button_text' => __pcHelp('Save'),
        'method' => 'post',
        'action' => '',
        'name' => $this->key,
        'id' => $this->key,
      ]);

    }

    public function save($values) {
      foreach ($this->options as $key) {
        if (isset($values[$key]) || $this->fields[$key]['#type'] == 'checkbox') {
          // $value = $key === 'alert_message' ? wp_kses_post( $values[$key] ) : esc_attr( $values[$key] );
          $value = wp_kses_post( $values[$key] );
          update_option( $key, $value );
        }
      }
    }
}

if( is_admin() )
    $proud_subsite_page = new ProudSubsitePage();