<?php
/**
 * Copyright © 2018 Simon Leblanc <contact@leblanc-simon.eu>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the COPYING file for more details.
 */
use Shaarli\Config\ConfigManager;

/**
 * Plugin init function.
 *
 * @param ConfigManager $conf instance
 */
function mattermost_publish_init(ConfigManager $conf)
{
    $hook_url = $conf->get('plugins.MATTERMOST_HOOK_URL');
    $errors = [];

    if (true === empty($hook_url)) {
        $errors[] = 'MATTERMOST_HOOK_URL can\'t be empty.';
    }

    if (false === function_exists('curl_init')) {
        $errors[] = 'mattermost_publish require curl extension.';
    }

    return $errors;
}

/**
 * Save link hook.
 * Publish to Mattermost when a link is saved.
 *
 * @param array         $data template data
 * @param ConfigManager $conf instance
 *
 * @return array unaltered data
 */
function hook_mattermost_publish_save_link(array $data, ConfigManager $conf)
{
    if (null !== $data['updated']) {
        // publish only new link !
        return $data;
    }

    $hook_url = $conf->get('plugins.MATTERMOST_HOOK_URL');
    $channel = $conf->get('plugins.MATTERMOST_CHANNEL');
    $username = $conf->get('plugins.MATTERMOST_USER');

    $payload = array(
        'text' => $data['title'].' : '.$data['url']."\n".$data['description'],
    );

    if (false === empty($channel)) {
        $payload['channel'] = $channel;
    }

    if (false === empty($username)) {
        $payload['username'] = $username;
    }

    $curl = curl_init($hook_url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_POSTFIELDS, 'payload='.json_encode($payload));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($curl);

    return $data;
}
