<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class GeopluginPlugin
 * @package Grav\Plugin
 */
class GeopluginPlugin extends Plugin
{
    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        //Load the custom PHP for generating the lists
        require_once __DIR__ . '/classes/geoplugin.class.php';

        // Enable the main event we are interested in
        $geoplugin = new geoPlugin();
        $geoplugin->locate($this->grav['cache']);
        $this->config->set('plugins.geoplugin.city', $geoplugin->city);
        $this->config->set('plugins.geoplugin.region', $geoplugin->region);
        $this->config->set('plugins.geoplugin.areaCode', $geoplugin->areaCode);
        $this->config->set('plugins.geoplugin.dmaCode', $geoplugin->dmaCode);
        $this->config->set('plugins.geoplugin.countryName', $geoplugin->countryName);
        $this->config->set('plugins.geoplugin.countryCode', $geoplugin->countryCode);
        $this->config->set('plugins.geoplugin.longitude', $geoplugin->longitude);
        $this->config->set('plugins.geoplugin.latitude', $geoplugin->latitude);
    }
}
