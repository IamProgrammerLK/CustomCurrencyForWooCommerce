<?php

namespace IamProgrammerLK\CustomCurrencyForWooCommerce\Wordpress;

// If this file is called directly, abort. for the security purpose.
if ( ! defined( 'WPINC' ) ) { die; }

class PluginPageSettings
{

    private $PluginOptions;

    public function __construct( $PluginOptions )
    {

        $this->PluginOptions = $PluginOptions;

    }

    // Add filters to the wp.
    public function init()
    {

        ( $this->PluginOptions[ 'auto_update' ] == true) ? add_filter( 'auto_update_plugin', array( $this, 'setPluginAutoUpdateTrue' ), 10, 2 ) : null;
        add_filter( 'plugin_action_links_' . $this->PluginOptions[ 'basename' ], array( $this , 'renderPluginsPageLinks' ) );
        add_filter( 'plugin_row_meta', array( $this , 'renderPluginRowMetaLinks'), 10, 2 );

    }

    // Enable plugin auto update
    public function setPluginAutoUpdateTrue ( $update, $item )
    {

        $plugins = array( $this->PluginOptions[ 'basename' ] );

        if( in_array( $item->plugin, $plugins ) )
        {

            return true;

        }
        else
        {

            return $update; 

        }

    }

    public function renderPluginsPageLinks( $links )
    {

        $settingsLink = '<a href="' . $this->PluginOptions[ 'settings_url' ] . '"><span class="dashicons-before dashicons-admin-generic"></span>Settings</a>';
        $supportLink = '<a href="' . $this->PluginOptions[ 'support_url' ] . '" target="_blank" style="color:#2B8C69;"><span class="dashicons-before dashicons-sos"></span>Support</a>';
        $leaveFeedbackLink = '<a href="' . $this->PluginOptions[ 'feedback_url' ] . '" target="_blank" style="color:#D97D0D;"><span class="dashicons-before dashicons-star-half"></span>Feedback</a>';

        array_push( $links, $settingsLink, $supportLink, $leaveFeedbackLink );
        return $links;

    }

    public function renderPluginRowMetaLinks( $links, $file )
    {

        if ( $this->PluginOptions[ 'basename' ] == $file )
        {

            $rowMetaLinks = array(
                'settingslink' => '<a href="' . $this->PluginOptions[ 'settings_url' ] . '"><span class="dashicons-before dashicons-admin-generic"></span>Settings</a>',
                'supportLink' => '<a href="' . $this->PluginOptions[ 'support_url' ] . '" target="_blank" style="color:#2B8C69;"><span class="dashicons-before dashicons-sos"></span>Support</a>',
                'leaveFeedbackLink' => '<a href="' . $this->PluginOptions[ 'feedback_url' ] . '" target="_blank" style="color:#D97D0D;"><span class="dashicons-before dashicons-star-half"></span>Feedback</a>',
            );

            if( isset( $this->PluginOptions[ 'donate_url' ] ) && !( $this->PluginOptions[ 'donate_url' ] == '' ) )
            {

                $rowMetaLinks = array_merge( $rowMetaLinks,
                    array(
                        'donateLink' => '<a href="' . $this->PluginOptions[ 'donate_url' ] . '" target="_blank" style="color:#BF8069;"><span class="dashicons-before dashicons-heart"></span>Donate</a>',
                    )
                );

            }

            if( isset( $this->PluginOptions[ 'upgrade_url' ] ) && !( $this->PluginOptions[ 'upgrade_url' ] == '' ) )
            {

                $rowMetaLinks = array_merge( $rowMetaLinks,
                    array(
                        'upgradeLink' => '<a href="' . $this->PluginOptions[ 'upgrade_url' ] . '" target="_blank" style="color:#A66D97;"><span class="dashicons-before dashicons-awards"></span>Upgrade</a>',
                    )
                );

            }

            return array_merge( $links, $rowMetaLinks );

        }
        return (array) $links;

    }

}