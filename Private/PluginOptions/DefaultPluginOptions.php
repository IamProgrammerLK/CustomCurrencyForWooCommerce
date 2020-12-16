<?php

    // If this file is called directly, abort. for the security purpose.
    if ( ! defined( 'WPINC' ) ) { die; }

    return array(

        // Plugin name.
        'name' => 'Custom Currency For WooCommerce',

        // Plugin Short name. Max 20 Char
        'shortname' => 'CCForWC',

        // Plugin text domain. Max 20 Char
        'text_domain' => 'CCForWC',

        // Plugin description
        'description' => 'Custom Currency For WooCommerce allows you to change the currency symbol used in WooCommerce and you can add a new custom currency type to the WooCommerce.',

        // Plugin namespace. sanitize_key( 'namespace' )
        'namespace' => 'IamProgrammerLK\CustomCurrencyForWooCommerce',

        // Plugin prefix/slug name. case sensitive and no spaces. Max 20 char
        'slug' => 'ccforwc',

        // Plugin basename. sanitize_key( 'basename' )
        'basename' => 'custom-currency-for-woocommerce/custom-currency-for-woocommerce.php',

        // Plugin dir url
        'dir_url' => str_replace( 'Private/PluginOptions/', '', plugin_dir_url( __FILE__ ) ) ,

        // Current plugin version. update it as you release new versions.
        'version' => '1.2.0',

        // Plugin DIR path
        'path' => str_replace( 'Private/PluginOptions/', '', str_replace( '\\', '/', plugin_dir_path( __FILE__ ) ) ),

        // Plugin author name
        'author_name' => 'IamProgrammerLK',

        // Plugin author url
        'author_url' => 'https://iamprogrammer.lk',

         // Plugin url
        'url' => 'https://iamprogrammer.lk/custom-currency-for-woocommerce/',

        // Plugin settings page url
        'settings_url' => 'admin.php?page=wc-settings&tab=general',

        // Plugin feedback url
        'feedback_url' => 'https://wordpress.org/plugins/custom-currency-for-woocommerce/#reviews',

        // Plugin support url
        'support_url' => 'https://wordpress.org/support/plugin/custom-currency-for-woocommerce/',

        // Plugin donate url
        'donate_url' => 'https://buymeacoffee.iamprogrammer.lk/',

        // Plugin upgrade url
        'upgrade_url' => '',

        // Plugin auto update enable/disable
        'auto_update' => true,

        '' => '',

    );
