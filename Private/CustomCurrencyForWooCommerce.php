<?php

namespace IamProgrammerLK\CustomCurrencyForWooCommerce;

use IamProgrammerLK\CustomCurrencyForWooCommerce\PluginOptions\PluginOptions;
use IamProgrammerLK\CustomCurrencyForWooCommerce\Wordpress\PluginPageSettings;

// If this file is called directly, abort. for the security purpose.
if ( ! defined( 'WPINC' ) ) { die; }

class CustomCurrencyForWooCommerce
{

    Private $PluginOptions;

    public function __construct()
    {

        $this->PluginOptions = PluginOptions::getInstance()->getPluginOptions();

    }

    // Add filters to the wp.
    public function init()
    {

        $pluginPageSettings = new PluginPageSettings( $this->PluginOptions );
        $pluginPageSettings->init();

        add_action( 'plugins_loaded', array( $this, 'isWooCommerceActive'), 11 );

        add_filter( 'woocommerce_currencies', array( $this, 'addCustomCurrency' ) );
        add_filter( 'woocommerce_currency_symbol', array( $this, 'setCustomCurrencySymbol' ) , 10, 2 );
        add_filter( 'woocommerce_general_settings', array( $this, 'addCustomCurrencySettings' ) );

    }

    // Print an admin notice if WooCommerce is deactivated
    public function isWooCommerceActive()
    {

        if ( ! function_exists( 'WC' ) )
        {

            add_action( 'admin_notices', function()
            {
                ?>
                    <div class="notice notice-error">
                        <p>
                            <?php
                                echo __(
                                    "Alert :: Custom Currency For WooCommerce is enabled but not effective. It requires WooCommerce in order to work.",
                                    $this->PluginOptions[ 'text_domain' ]
                                );
                            ?>
                        </p>
                    </div>
                <?php
            } );

        }

    }

    // Adding a custom currency to the WooCommerce that saved in wp-settings.
    public function addCustomCurrency( $wooCurrency )
    {

        $customCurrency = get_option( 'custom_currency' );
        $customCurrencyLabel = get_option( 'custom_currency_label' );

        if ( $customCurrency != '' XOR $customCurrencyLabel != '' )
        {

            add_action( 'admin_notices', function()
            {

                printf(
                    '<div class="%1$s"><p>%2$s</p></div>',
                    esc_attr( 'notice notice-error' ),
                    esc_html( '!!! ERROR: When you add a new custom currency to the WooCommerce, "Custom Currency" and "Custom Currency Label" is required. or Leave both empty to use original Woo Currency with a custom currency symbol.' )
                );

            } );
    
        }
    
        if ( $customCurrency != '' && $customCurrencyLabel != '' )
        {
    
            $wooCurrency[ $customCurrency ] = $customCurrencyLabel;
    
        }
        return $wooCurrency;
    
    }

    // Adding a custom currency symbol to the WooCommerce that saved in wp-settings.
    public function setCustomCurrencySymbol( $customCurrencySymbol, $wooCurrency )
    {

        $currencySymbol = get_option( 'custom_currency_symbol' );

        if ( $currencySymbol != '' )
        {

            switch( $wooCurrency )
            {

                case get_woocommerce_currency():
                    $customCurrencySymbol = $currencySymbol;
                break;

            }

        }
        return $customCurrencySymbol;

    }

    // Creating settings elements on the WooCommerce setting page, so the user can change the settings.
    public function addCustomCurrencySettings( $wooSettings )
    {

        $newSettings = array();

        foreach ( $wooSettings as $section )
        {

            if ( isset( $section[ 'id' ] ) && $section[ 'id' ] == 'pricing_options' && isset( $section[ 'type' ] ) && $section[ 'type' ] == 'sectionend' )
            {

                $newSettings[] = array(
                    'name'     => 'Custom Currency',
                    'desc'     => __( 'IMPORTANT: Make sure this currency type supports your payment gateway. otherwise, payments will NOT be processed. leave empty to use the original currency type. or use the international currency code. ex. "USD" for the United States Dollar or "LKR" for the Sri Lankan Rupees.', $this->PluginOptions[ 'text_domain' ] ),
                    'desc_tip' => __( 'Enter a custom currency name here. If you set make sure you set the custom symbol for this currency type. If empty, the default for the selected currency will be used instead.', $this->PluginOptions[ 'text_domain' ] ),
                    'id'       => 'custom_currency',
                    'type'     => 'text',
                    'css'      => 'width:400px;',
                    'default'  => '',
                );

                $newSettings[] = array(
                    'name'     => 'Custom Currency Label',
                    'desc'     => __( 'Set a label for the custom currency. this will NOT change default currency labels that came with wooCommerce. leave empty to use the original currency label.', $this->PluginOptions[ 'text_domain' ] ),
                    'desc_tip' => __( 'Label for the custom currency type', $this->PluginOptions[ 'text_domain' ] ),
                    'id'       => 'custom_currency_label',
                    'type'     => 'text',
                    'css'      => 'width:400px;',
                    'default'  => '',
                );

                $newSettings[] = array(
                    'name'     => 'Custom Currency Symbol',
                    'desc'     => __( 'Set a symbol for the currency, this symbol will display on your site. leave empty to use the original currency symbol', $this->PluginOptions[ 'text_domain' ] ),
                    'desc_tip' => __( 'Enter a currency symbol here. If empty, the default for the selected currency will be used instead.', $this->PluginOptions[ 'text_domain' ] ),
                    'id'       => 'custom_currency_symbol',
                    'type'     => 'text',
                    'css'      => 'width:400px;',
                    'default'  => '',
                );

            }
            $newSettings[] = $section;

        }
        return $newSettings;

    }

}

